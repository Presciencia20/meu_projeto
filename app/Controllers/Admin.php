<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PropertyModel;
use App\Models\VerificacaoBiModel;
use CodeIgniter\Controller;

class Admin extends BaseController
{
    protected UserModel         $userModel;
    protected PropertyModel    $propModel;
    protected VerificacaoBiModel $biModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);
        
        $this->userModel = new UserModel();
        $this->propModel = new PropertyModel();
        $this->biModel   = new VerificacaoBiModel();
    }

    public function dashboard()
    {
        if (! session()->get('isLoggedIn') || session()->get('user_type') !== 'Admin') {
            // No MVP pode-se ser flexível, mas idealmente proteger
            // return redirect()->to('/login');
        }

        $data['pendingUsers']      = $this->userModel->where('is_verified_user', false)
                                                     ->where('bi_status', 'pendente')
                                                     ->findAll();
        
        $data['pendingProperties'] = $this->propModel->where('is_verified', false)->findAll();

        return view('admin/dashboard', $data);
    }

    // =========================================================================
    // VERIFICAÇÕES DE BI
    // =========================================================================

    public function verificationQueue()
    {
        // Trazer utilizadores com BI pendente + dados da tabela de submissão
        $data['submissions'] = $this->biModel->select('verificacoes_bi.*, users.full_name, users.phone')
                                             ->join('users', 'users.id = verificacoes_bi.user_id')
                                             ->where('verificacoes_bi.resultado', 'pendente')
                                             ->findAll();

        return view('admin/verifications', $data);
    }

    public function reviewVerification($id)
    {
        $submission = $this->biModel->select('verificacoes_bi.*, users.full_name, users.phone, users.bi_number')
                                    ->join('users', 'users.id = verificacoes_bi.user_id')
                                    ->find($id);

        if (! $submission) {
            return redirect()->to('/admin/verifications')->with('error', 'Submissão não encontrada.');
        }

        return view('admin/review_verification', ['s' => $submission]);
    }

    public function approveVerification($id)
    {
        $submission = $this->biModel->find($id);
        if (! $submission) return redirect()->back();

        $userId = $submission['user_id'];

        // 1. Marcar submissão como aprovada
        $this->biModel->update($id, [
            'resultado'      => 'aprovado',
            'verificado_por' => session()->get('user_id'),
        ]);

        // 2. Atualizar status do utilizador
        $this->userModel->update($userId, [
            'bi_status'        => 'aprovado',
            'is_verified_user' => true,
            'status'           => 'verificado' // Sobe para verificado (Selo ⭐)
        ]);

        return redirect()->to('/admin/verifications')->with('success', 'Utilizador verificado com sucesso! Selo ⭐ atribuído.');
    }

    public function rejectVerification($id)
    {
        $motivo = $this->request->getPost('motivo');
        $submission = $this->biModel->find($id);
        if (! $submission) return redirect()->back();

        $userId = $submission['user_id'];

        // 1. Rejeitar submissão
        $this->biModel->update($id, [
            'resultado'       => 'rejeitado',
            'motivo_rejeicao' => $motivo,
            'verificado_por'  => session()->get('user_id'),
        ]);

        // 2. Notificar utilizador (via status)
        $this->userModel->update($userId, [
            'bi_status' => 'rejeitado'
        ]);

        return redirect()->to('/admin/verifications')->with('info', 'Submissão rejeitada. O utilizador será notificado.');
    }

    // =========================================================================
    // OUTROS (Legado/Simple)
    // =========================================================================

    public function approveUser($id)
    {
        $this->userModel->update($id, ['is_verified_user' => true, 'status' => 'verificado']);
        return redirect()->to('/admin/dashboard')->with('success', 'Usuário verificado com sucesso!');
    }

    public function approveProperty($id)
    {
        $this->propModel->update($id, ['is_verified' => true]);
        return redirect()->to('/admin/dashboard')->with('success', 'Imóvel aprovado para publicação!');
    }

    public function rejectProperty($id)
    {
        $property = $this->propModel->find($id);
        if ($property) {
            $this->propModel->delete($id);
            return redirect()->to('/admin/dashboard')->with('info', 'O imóvel foi removido com sucesso do sistema por não cumprir as políticas.');
        }
        return redirect()->to('/admin/dashboard')->with('error', 'Imóvel não encontrado.');
    }

    // =========================================================================
    // SERVIR IMAGENS SEGURO (BI/Selfie)
    // =========================================================================

    public function serveImage($path)
    {
        // 1. Verificar permissões (apenas admin ou o próprio dono da imagem)
        // Por simplicidade no MVP, apenas Admin
        if (session()->get('user_type') !== 'Admin') {
            return $this->response->setStatusCode(403)->setBody('Acesso Negado');
        }

        $fullPath = WRITEPATH . 'uploads/' . $path;

        if (!file_exists($fullPath) || is_dir($fullPath)) {
            return $this->response->setStatusCode(404)->setBody('Ficheiro não encontrado');
        }

        $mime = mime_content_type($fullPath);
        
        return $this->response
            ->setHeader('Content-Type', $mime)
            ->setBody(file_get_contents($fullPath));
    }

    // =========================================================================
    // GESTÃO DE ESCROW (FUNDOS)
    // =========================================================================

    public function escrow()
    {
        $escrowModel = new \App\Models\EscrowModel();
        
        // Fetch all escrows with related data
        $data['escrows'] = $escrowModel->select('escrow_payments.*, rr.tenant_id, rr.owner_id, p.title as property_title, u_tenant.full_name as tenant_name, u_owner.full_name as owner_name')
            ->join('rental_requests rr', 'escrow_payments.rental_request_id = rr.id')
            ->join('properties p', 'rr.property_id = p.id')
            ->join('users u_tenant', 'u_tenant.id = rr.tenant_id')
            ->join('users u_owner', 'u_owner.id = rr.owner_id')
            ->orderBy('escrow_payments.created_at', 'DESC')
            ->findAll();

        return view('admin/escrow', $data);
    }

    public function refundEscrow($id)
    {
        $escrowModel = new \App\Models\EscrowModel();
        $escrowModel->update($id, [
            'status' => 'refunded',
            'released_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->to('/admin/escrow')->with('info', 'Fundos devolvidos ao inquilino com sucesso.');
    }

    // =========================================================================
    // GESTÃO DE COMPROVATIVOS IBAN
    // =========================================================================

    public function receipts()
    {
        $rentalModel = new \App\Models\RentalRequestModel();
        
        $data['requests'] = $rentalModel->select('rental_requests.*, properties.title as property_title, users.full_name as tenant')
            ->join('properties', 'properties.id = rental_requests.property_id')
            ->join('users', 'users.id = rental_requests.tenant_id')
            ->where('rental_requests.status', 'verifying_receipt')
            ->findAll();

        return view('admin/receipts', $data);
    }

    public function validateReceipt($requestId, $action)
    {
        $rentalModel = new \App\Models\RentalRequestModel();
        $request = $rentalModel->find($requestId);
        
        if (!$request) return redirect()->back()->with('error', 'Pedido não encontrado');

        if ($action === 'approve') {
            $rentalModel->update($requestId, ['status' => 'paid']);
            
            // Create escrow entry
            $escrowModel = new \App\Models\EscrowModel();
            $escrowModel->insert([
                'rental_request_id' => $requestId,
                'amount'            => $request['total_amount'],
                'status'            => 'held',
                'payment_method'    => 'Transferência Bancária',
                'transaction_id'    => 'CS-' . strtoupper(bin2hex(random_bytes(4))),
                'release_code'      => strtoupper(substr(md5(time().$requestId), 0, 8))
            ]);
            
            return redirect()->back()->with('success', 'Pagamento aprovado e guardado no Cofre Seguro.');
        }

        if ($action === 'reject') {
            $paymentData = json_decode($request['payment_intent_id'], true);
            $paymentData['status'] = 'waiting_proof';
            $rentalModel->update($requestId, [
                'status' => 'pending', 
                'payment_intent_id' => json_encode($paymentData)
            ]);
            
            return redirect()->back()->with('error', 'Comprovativo rejeitado. O inquilino terá de inserir novo ficheiro.');
        }
    }
}
