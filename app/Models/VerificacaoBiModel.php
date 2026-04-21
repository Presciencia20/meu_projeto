<?php

namespace App\Models;

use CodeIgniter\Model;

class VerificacaoBiModel extends Model
{
    protected $table      = 'verificacoes_bi';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;

    protected $allowedFields = [
        'user_id',
        'foto_frente',
        'foto_verso',
        'selfie',
        'resultado',
        'motivo_rejeicao',
        'verificado_por',
    ];

    /**
     * Retorna todas as verificações pendentes para o painel admin.
     */
    public function getPending(): array
    {
        return $this->select('verificacoes_bi.*, users.full_name, users.phone, users.user_type')
                    ->join('users', 'users.id = verificacoes_bi.user_id')
                    ->where('verificacoes_bi.resultado', 'pendente')
                    ->orderBy('verificacoes_bi.created_at', 'ASC')
                    ->findAll();
    }

    /**
     * Retorna a verificação mais recente de um utilizador.
     */
    public function getLatestForUser(int $userId): ?array
    {
        return $this->where('user_id', $userId)
                    ->orderBy('id', 'DESC')
                    ->first();
    }

    /**
     * Conta quantas vezes um utilizador foi rejeitado.
     */
    public function countRejections(int $userId): int
    {
        return $this->where('user_id', $userId)
                    ->where('resultado', 'rejeitado')
                    ->countAllResults();
    }
}
