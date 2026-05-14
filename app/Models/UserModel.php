<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'full_name',
        'email',
        'phone',
        'bi_number',
        'password',
        'user_type',
        'is_admin',
        'is_owner',
        'is_client',
        'active_role',
        'status',
        'bi_status',
        'bi_foto_frente',
        'bi_foto_verso',
        'selfie_path',
        'is_verified_user',
        'verification_data',
        'balance',
        'plan_id',
        'plan_expires_at',
        'login_attempts',
        'locked_until',
        'last_login',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Timestamps
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    // Validation — BI é opcional (só obrigatório para proprietários, validado no controller)
    protected $validationRules = [
        'full_name' => 'permit_empty|min_length[3]|max_length[255]',
        'phone'     => 'required|is_unique[users.phone,id,{id}]',
        'email'     => 'permit_empty|valid_email|is_unique[users.email,id,{id}]',
        'bi_number' => 'permit_empty|is_unique[users.bi_number,id,{id}]',
        'password'  => 'permit_empty|min_length[8]',
    ];
    protected $validationMessages   = [
        'phone' => [
            'required'  => 'O número de telemóvel é obrigatório.',
            'is_unique' => 'Este número de telemóvel já está registado.',
        ],
        'bi_number' => [
            'is_unique' => 'Este número de BI já está associado a outra conta.',
        ],
        'password' => [
            'min_length' => 'A senha deve ter pelo menos 8 caracteres.',
        ],
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    protected function hashPassword(array $data): array
    {
        if (! isset($data['data']['password']) || empty($data['data']['password'])) {
            return $data;
        }

        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);

        return $data;
    }

    // -------------------------------------------------------------------------
    // Helpers de negócio
    // -------------------------------------------------------------------------

    /**
     * Verifica se a conta está actualmente bloqueada por excesso de tentativas.
     */
    public function isLocked(array $user): bool
    {
        if (empty($user['locked_until'])) {
            return false;
        }

        return strtotime($user['locked_until']) > time();
    }

    /**
     * Incrementa o contador de falhas; bloqueia a conta durante 15 min após 5 falhas.
     */
    public function incrementLoginAttempts(int $userId, int $current): void
    {
        $attempts = $current + 1;
        $data     = ['login_attempts' => $attempts];

        if ($attempts >= 5) {
            $data['locked_until'] = date('Y-m-d H:i:s', strtotime('+15 minutes'));
        }

        $this->update($userId, $data);
    }

    /**
     * Reseta o contador de tentativas após login bem-sucedido.
     */
    public function resetLoginAttempts(int $userId): void
    {
        $this->update($userId, [
            'login_attempts' => 0,
            'locked_until'   => null,
            'last_login'     => date('Y-m-d H:i:s'),
        ]);
    }

    /**
     * Retorna o nível de confiança (0-5) baseado nas verificações e atividade.
     */
    public function getTrustLevel(array $user): int
    {
        $level = 0;

        // Nível 1: Telemóvel verificado (assumimos que se está ativo, tem telemóvel)
        if ($user['status'] !== 'pendente') {
            $level = 1;
        }

        // Nível 2: Básico (Telemóvel + Email)
        if ($level >= 1 && !empty($user['email'])) {
            $level = 2;
        }

        // Nível 3: Identidade enviada (Pendente)
        if ($user['bi_status'] === 'pendente') {
            $level = 3;
        }

        // Nível 4: Verificado (BI + Selfie aprovados)
        if ($user['bi_status'] === 'aprovado' && $user['status'] === 'verificado') {
            $level = 4;
        }

        // Nível 5: Premium (Simulado com contratos concluídos por agora)
        // No futuro, isto virá do UserStatModel
        $statsModel = new UserStatModel();
        $stats = $statsModel->find($user['id']);
        if ($level >= 4 && $stats && $stats['completed_contracts'] >= 10) {
            $level = 5;
        }

        return $level;
    }

    /**
     * Retorna informações visuais do selo baseado no nível de confiança.
     */
    public function getBadgeInfo(?array $user): array
    {
        $level = $user ? $this->getTrustLevel($user) : 0;
        $type = $user['user_type'] ?? 'Inquilino';

        $badges = [
            0 => ['icon' => '❓', 'label' => 'Não Verificado', 'class' => 'badge-none', 'color' => '#6c757d'],
            1 => ['icon' => '📱', 'label' => 'Telemóvel', 'class' => 'badge-phone', 'color' => '#17a2b8'],
            2 => ['icon' => '🟢', 'label' => 'Básico', 'class' => 'badge-basic', 'color' => '#28a745'],
            3 => ['icon' => '🔵', 'label' => 'ID em Análise', 'class' => 'badge-pending', 'color' => '#007bff'],
            4 => ['icon' => '🛡️', 'label' => 'Verificado', 'class' => 'badge-verified', 'color' => '#ffc107'],
            5 => ['icon' => '💎', 'label' => 'Premium', 'class' => 'badge-premium', 'color' => '#b921ff'],
        ];

        $badge = $badges[$level];

        // Customizações por tipo de utilizador
        if ($level >= 4) {
            if ($type === 'Proprietário') {
                $badge['label'] = 'Proprietário Verificado';
            } elseif ($type === 'Inquilino') {
                $badge['label'] = 'Inquilino Verificado';
                $badge['color'] = '#28a745'; // Verde para inquilinos
            } elseif ($type === 'Intermediário') {
                $badge['label'] = 'Intermediário Oficial';
                $badge['color'] = '#ced4da'; // Prateado
            }
        }

        return $badge;
    }
}
