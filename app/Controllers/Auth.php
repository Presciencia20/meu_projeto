<?php

namespace App\Controllers;

use App\Libraries\SmsService;
use App\Models\OtpModel;
use App\Libraries\TwilioVerifyService;
use App\Models\UserModel;
use App\Models\VerificacaoBiModel;

class Auth extends BaseController
{
    protected SmsService        $sms;
    protected \App\Libraries\EmailService $emailService;
    protected OtpModel          $otpModel;
    protected TwilioVerifyService  $twilioVerify;
    protected UserModel         $userModel;
    protected VerificacaoBiModel $biModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);

        $this->sms          = new SmsService();
        $this->emailService = new \App\Libraries\EmailService();
        $this->otpModel     = new OtpModel();
        $this->twilioVerify = new TwilioVerifyService();
        $this->userModel    = new UserModel();
        $this->biModel      = new VerificacaoBiModel();
    }

    // =========================================================================
    // REGISTO — Passo 1: Solicitar OTP por telemóvel
    // =========================================================================

    public function showRegisterStep1()
    {
        return view('auth/signup');
    }

    public function processStep1()
    {
        $identifier = $this->request->getPost('identifier'); // Pode ser email ou telefone
        $method     = $this->request->getPost('method');     // 'email' ou 'phone'

        // Permitir telemóvel para teste em desenvolvimento
        if ($method === 'phone' && ! (env('SMS_FAKE') || env('SMS_FAKE') === 'true')) {
            return redirect()->back()
                ->with('error', 'O envio por SMS real está temporariamente indisponível. Por favor use o Email.')
                ->withInput();
        }

        // Se for email, validar formato
        if ($method === 'email' && ! filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()
                ->with('error', 'Por favor introduza um email válido.')
                ->withInput();
        }

        // Verificar se já existe account
        $user = ($method === 'phone') 
                ? $this->userModel->where('phone', SmsService::normalizeAngolan($identifier))->first()
                : $this->userModel->where('email', $identifier)->first();

        if ($user) {
            return redirect()->back()
                ->with('error', 'Este contacto já tem uma conta associada. Faça login.')
                ->withInput();
        }

        // Cooldown
        $cooldown = $this->otpModel->cooldownRemaining($identifier, 'registo');
        if ($cooldown > 0) {
            return redirect()->back()
                ->with('error', "Aguarde {$cooldown} segundos para o próximo código.");
        }

        $codigo = $this->otpModel->generateAndSave($identifier, 'registo');
        
        if ($method === 'email') {
            $this->emailService->sendOtp($identifier, $codigo);
        } else {
            $this->sms->send($identifier, "CasaSegura: O seu código é {$codigo}");
        }

        // Guardar identificador em sessão
        session()->set('reg_identifier', $identifier);
        session()->set('reg_method', $method);

        // Em modo desenvolvimento
        if (env('SMS_FAKE') || env('SMS_FAKE') === 'true') {
            session()->setFlashdata('dev_otp_code', $codigo);
        }

        return redirect()->to('/auth/verify-otp')
            ->with('info', 'Código enviado! Verifique a sua caixa de entrada.');
    }

    // =========================================================================
    // REGISTO — Passo 2: Verificar OTP
    // =========================================================================

    public function showVerifyOtp()
    {
        if (! session()->get('reg_identifier')) {
            return redirect()->to('/signup');
        }

        // Calcular tempo restante para o OTP
        $identifier = session()->get('reg_identifier');
        $record = $this->otpModel->where('identifier', $identifier)
                                 ->where('tipo', 'registo')
                                 ->where('usado', 0)
                                 ->where('expira_em >', date('Y-m-d H:i:s'))
                                 ->orderBy('id', 'DESC')
                                 ->first();

        $remainingSeconds = 0;
        if ($record) {
            $remainingSeconds = max(0, strtotime($record['expira_em']) - time());
        }

        return view('auth/otp', ['remainingSeconds' => $remainingSeconds, 'identifier' => $identifier]);
    }

    public function processVerifyOtp()
    {
        $identifier = session()->get('reg_identifier');

        if (! $identifier) {
            return redirect()->to('/signup');
        }

        $codigo = $this->request->getPost('codigo');

        if (! $this->otpModel->verify($identifier, $codigo, 'registo')) {
            return redirect()->back()
                ->with('error', 'Código inválido ou expirado. Tente novamente.');
        }

        // OTP validado — avançar para criar conta
        session()->set('reg_verified', true);

        return redirect()->to('/auth/step2');
    }

    // =========================================================================
    // REGISTO — Passo 3: Dados da conta (nome, senha, tipo)
    // =========================================================================

    public function showRegisterStep2()
    {
        if (! session()->get('reg_verified')) {
            return redirect()->to('/signup');
        }

        return view('auth/register');
    }

    public function processStep2()
    {
        if (! session()->get('reg_verified')) {
            return redirect()->to('/signup');
        }

        $identifier = session()->get('reg_identifier');
        $method     = session()->get('reg_method');
        $fullName   = $this->request->getPost('full_name');
        $senha      = $this->request->getPost('password');
        $tipo       = $this->request->getPost('user_type');

        // Validações usando o serviço de validação
        if (! $this->validate([
            'full_name' => 'required|min_length[3]|max_length[255]',
            'password'  => 'required|min_length[8]',
            'user_type' => 'required|in_list[Inquilino,Proprietário,Intermediário,Admin]',
        ], [
            'full_name' => [
                'required' => 'O nome completo é obrigatório.',
                'min_length' => 'O nome deve ter pelo menos 3 caracteres.'
            ],
            'password' => [
                'required' => 'A senha é obrigatória.',
                'min_length' => 'A senha deve ter pelo menos 8 caracteres.'
            ]
        ])) {
            return redirect()->back()
                ->with('error', $this->validator->getError('password') ?: $this->validator->listErrors())
                ->withInput();
        }

        $data = [
            'full_name'   => $fullName,
            'password'    => $senha,
            'user_type'   => $tipo,
            'active_role' => $tipo,
            'status'      => 'ativo',
        ];

        if ($method === 'phone') {
            $data['phone'] = SmsService::normalizeAngolan($identifier);
        } else {
            $data['email'] = $identifier;
            // Get phone from POST if registration started via Email
            $postPhone = $this->request->getPost('phone');
            if ($postPhone) {
                $data['phone'] = SmsService::normalizeAngolan($postPhone);
            }
        }

        // Auto-assign Free Plan (Iniciação)
        $planModel = new \App\Models\PlanModel();
        $freePlan  = $planModel->where('name', 'Iniciação')->first();
        
        if ($freePlan) {
            $data['plan_id'] = $freePlan['id'];
            $data['plan_expires_at'] = date('Y-m-d H:i:s', strtotime("+{$freePlan['duration_days']} days"));
        }

        if (! $this->userModel->insert($data)) {
            $errors = $this->userModel->errors();
            $errorMsg = !empty($errors) ? implode(' ', $errors) : 'Erro desconhecido ao salvar os dados.';
            return redirect()->back()
                ->with('error', 'Falha ao criar conta: ' . $errorMsg)
                ->withInput();
        }
        
        $userId = $this->userModel->getInsertID();

        // Login automático
        $user = $this->userModel->find($userId);
        $this->startSession($user);

        // Limpar sessão temporária de registo
        session()->remove(['reg_identifier', 'reg_method', 'reg_verified']);

        // Proprietários/Intermediários → pedir BI
        if (in_array($tipo, ['Proprietário', 'Intermediário'])) {
            return redirect()->to('/auth/verify-bi')
                ->with('info', 'Conta criada! Agora faça a verificação de identidade para publicar anúncios.');
        }

        return redirect()->to('/dashboard')
            ->with('success', 'Bem-vindo à CasaSegura, ' . explode(' ', $fullName)[0] . '! 🎉');
    }

    // =========================================================================
    // REGISTO — Passo 4: Upload de BI (só para Proprietários / Intermediários)
    // =========================================================================

    public function showBiUpload()
    {
        $user = $this->userModel->find(session()->get('user_id'));

        // Se já submeteu, redirecionar
        if ($user && in_array($user['bi_status'], ['pendente', 'aprovado'])) {
            return redirect()->to('/dashboard')
                ->with('info', 'A sua verificação já está em processo de análise.');
        }

        return view('auth/bi_upload');
    }

    public function processBiUpload()
    {
        $userId = session()->get('user_id');

        // Upload das 3 imagens
        $uploads = [];
        $uploadDir = WRITEPATH . 'uploads/bi/' . $userId . '/';

        if (! is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $fields = ['bi_frente' => 'foto_frente', 'bi_verso' => 'foto_verso', 'selfie' => 'selfie'];

        foreach ($fields as $inputName => $dbField) {
            $file = $this->request->getFile($inputName);

            if (! $file || ! $file->isValid()) {
                return redirect()->back()
                    ->with('error', "O ficheiro '{$inputName}' é obrigatório e deve ser válido.");
            }

            if (! in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/webp'])) {
                return redirect()->back()
                    ->with('error', 'Apenas imagens JPEG, PNG ou WebP são aceites.');
            }

            if ($file->getSize() > 5 * 1024 * 1024) {
                return redirect()->back()
                    ->with('error', 'Cada ficheiro não pode exceder 5 MB.');
            }

            $filename = $userId . '_' . $dbField . '_' . time() . '.' . $file->getExtension();
            $file->move($uploadDir, $filename);
            $uploads[$dbField] = 'bi/' . $userId . '/' . $filename;
        }

        // Verificar rejeições anteriores (máximo 3)
        $rejeicoes = $this->biModel->countRejections($userId);
        if ($rejeicoes >= 3) {
            return redirect()->to('/dashboard')
                ->with('error', 'A sua conta foi bloqueada por múltiplas rejeições de verificação.');
        }

        // Guardar registo na tabela verificacoes_bi
        $this->biModel->insert([
            'user_id'    => $userId,
            'foto_frente'=> $uploads['foto_frente'],
            'foto_verso' => $uploads['foto_verso'],
            'selfie'     => $uploads['selfie'],
            'resultado'  => 'pendente',
        ]);

        // Actualizar user
        $this->userModel->update($userId, [
            'bi_foto_frente' => $uploads['foto_frente'],
            'bi_foto_verso'  => $uploads['foto_verso'],
            'selfie_path'    => $uploads['selfie'],
            'bi_status'      => 'pendente',
        ]);

        return redirect()->to('/dashboard')
            ->with('success', 'Documentos enviados com sucesso! A verificação demora até 24 horas. ⏳');
    }

    // =========================================================================
    // LOGIN — Com senha
    // =========================================================================

    public function showLogin()
    {
        return view('auth/login');
    }

    public function processLogin()
    {
        $identifier = $this->request->getPost('email'); // Accept email or phone input
        if (! $this->validate([
            'email'    => 'required',
            'password' => 'required',
        ])) {
            return redirect()->back()
                ->with('error', 'Por favor, preencha todos os campos.')
                ->withInput();
        }

        $password   = $this->request->getPost('password');

        // Determinar se é email ou phone
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $user = $this->userModel->where('email', $identifier)->first();
        } else {
            $phone = SmsService::normalizeAngolan((string) $identifier);
            $user = $this->userModel->where('phone', $phone)->first();
        }

        // Conta não existe
        if (! $user) {
            return redirect()->back()
                ->with('error', 'Credenciais inválidas.')
                ->withInput();
        }

        // Conta bloqueada
        if ($this->userModel->isLocked($user)) {
            $restante = ceil((strtotime($user['locked_until']) - time()) / 60);
            return redirect()->back()
                ->with('error', "Conta temporariamente bloqueada. Aguarde {$restante} minuto(s).")
                ->withInput();
        }

        // Conta suspensa
        if ($user['status'] === 'bloqueado') {
            return redirect()->back()
                ->with('error', 'A sua conta foi suspensa. Contacte o suporte.');
        }

        // Verificar senha
        if (! password_verify($password, $user['password'] ?? '')) {
            $this->userModel->incrementLoginAttempts($user['id'], (int) $user['login_attempts']);

            $restantes = max(0, 4 - (int) $user['login_attempts']);
            $msg = $restantes > 0
                ? "Senha incorrecta. Restam {$restantes} tentativa(s)."
                : 'Conta bloqueada por 15 minutos por excesso de tentativas.';

            return redirect()->back()->with('error', $msg)->withInput();
        }

        // Login bem-sucedido
        $this->userModel->resetLoginAttempts($user['id']);
        $this->trackLogin((int) $user['id']);
        $this->startSession($user);

        return redirect()->to('/dashboard');
    }

    // =========================================================================
    // LOGIN — Com código SMS (sem senha)
    // =========================================================================

    public function sendLoginOtp()
    {
        $identifier = $this->request->getPost('identifier');
        $method     = $this->request->getPost('method') ?: 'email';

        if ($method === 'phone') {
            return $this->response->setJSON(['ok' => false, 'error' => 'Envio por SMS indisponível.']);
        }

        $user = $this->userModel->where('email', $identifier)->first();
        if (! $user) {
            return $this->response->setJSON(['ok' => false, 'error' => 'Email não encontrado.']);
        }

        // Cooldown
        $cooldown = $this->otpModel->cooldownRemaining($identifier, 'login');
        if ($cooldown > 0) {
            return $this->response->setJSON(['ok' => false, 'error' => "Aguarde {$cooldown}s."]);
        }

        $codigo = $this->otpModel->generateAndSave($identifier, 'login');
        $ok     = $this->emailService->sendOtp($identifier, $codigo);

        session()->set('otp_login_identifier', $identifier);
        session()->set('otp_login_method', 'email');

        return $this->response->setJSON(['ok' => $ok]);
    }

    public function processLoginOtp()
    {
        $identifier = session()->get('otp_login_identifier');
        $codigo     = $this->request->getPost('codigo');

        if (! $identifier) {
            return redirect()->to('/login')->with('error', 'Sessão expirada. Tente novamente.');
        }

        if (! $this->otpModel->verify($identifier, $codigo, 'login')) {
            return redirect()->back()->with('error', 'Código inválido ou expirado.');
        }

        $user = $this->userModel->where('email', $identifier)->first();
        if (! $user) {
            return redirect()->to('/login')->with('error', 'Conta não encontrada.');
        }

        $this->userModel->resetLoginAttempts($user['id']);
        $this->trackLogin((int) $user['id']);
        $this->startSession($user);
        session()->remove(['otp_login_identifier', 'otp_login_method']);

        return redirect()->to('/dashboard');
    }

    // =========================================================================
    // RECUPERAÇÃO DE SENHA
    // =========================================================================

    public function showForgotPassword()
    {
        return view('auth/forgot_password');
    }

    public function processForgotPassword()
    {
        $email = $this->request->getPost('email');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->with('error', 'Por favor introduza um email válido.')->withInput();
        }

        $user = $this->userModel->where('email', $email)->first();
        if (!$user) {
            // Não revelar se o email existe (segurança)
            return redirect()->to('/auth/reset')
                ->with('info', 'Se o email estiver registado, receberá um código de recuperação.');
        }

        $cooldown = $this->otpModel->cooldownRemaining($email, 'recuperacao');
        if ($cooldown > 0) {
            return redirect()->back()
                ->with('error', "Aguarde {$cooldown} segundos antes de pedir novo código.");
        }

        $codigo = $this->otpModel->generateAndSave($email, 'recuperacao');
        $this->emailService->sendOtp($email, $codigo);

        session()->set('reset_email', $email);

        // Debug em desenvolvimento
        if (env('SMS_FAKE') || env('SMS_FAKE') === 'true') {
            session()->setFlashdata('dev_otp_code', $codigo);
        }

        return redirect()->to('/auth/reset')
            ->with('info', 'Código enviado! Verifique a sua caixa de entrada.');
    }

    public function showResetPassword()
    {
        return view('auth/reset_password');
    }

    public function processResetPassword()
    {
        $email    = session()->get('reset_email');
        $codigo   = $this->request->getPost('codigo');
        $novaSenha = $this->request->getPost('password');
        $confirmar = $this->request->getPost('password_confirm');

        if (!$email) {
            return redirect()->to('/forgot-password')
                ->with('error', 'Sessão expirada. Inicie o processo novamente.');
        }

        if ($novaSenha !== $confirmar) {
            return redirect()->back()->with('error', 'As senhas não coincidem.')->withInput();
        }

        if (strlen($novaSenha) < 8) {
            return redirect()->back()
                ->with('error', 'A senha deve ter pelo menos 8 caracteres.')->withInput();
        }

        if (!$this->otpModel->verify($email, $codigo, 'recuperacao')) {
            return redirect()->back()->with('error', 'Código inválido ou expirado.')->withInput();
        }

        $user = $this->userModel->where('email', $email)->first();
        $this->userModel->update($user['id'], [
            'password'       => $novaSenha,
            'login_attempts' => 0,
            'locked_until'   => null,
        ]);

        session()->remove('reset_email');

        return redirect()->to('/login')
            ->with('success', 'Senha alterada com sucesso! Faça login com a nova senha.');
    }

    // =========================================================================
    // LOGOUT
    // =========================================================================

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    // =========================================================================
    // Helper privado — iniciar sessão
    // =========================================================================

    private function startSession(array $user): void
    {
        $profileModel = new \App\Models\ProfileModel();
        $profile = $profileModel->where('user_id', $user['id'])->first();

        session()->set([
            'isLoggedIn'  => true,
            'user_id'     => $user['id'],
            'full_name'   => $user['full_name'],
            'user_type'   => $user['user_type'], // Legacy support
            'is_admin'    => (bool) $user['is_admin'],
            'is_owner'    => (bool) $user['is_owner'],
            'is_client'   => (bool) $user['is_client'],
            'active_role' => $user['active_role'] ?: ($user['is_admin'] ? 'admin' : ($user['is_owner'] ? 'owner' : 'client')),
            'phone'       => $user['phone'],
            'user_photo'  => $profile['photo'] ?? null,
        ]);
    }

    /**
     * Record login event for analytics.
     */
    private function trackLogin(int $userId): void
    {
        $loginModel = new \App\Models\LoginModel();
        $loginModel->insert([
            'user_id'    => $userId,
            'ip_address' => $this->request->getIPAddress()
        ]);
    }
}
