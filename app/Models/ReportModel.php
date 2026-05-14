<?php

namespace App\Models;

use CodeIgniter\Model;

class ReportModel extends Model
{
    protected $table            = 'reports';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';

    protected $allowedFields = [
        'reporter_id',
        'property_id',
        'reason',
        'details',
        'status',
        'resolved_by',
        'resolved_note',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Contagem de denúncias pendentes (para o badge do sidebar).
     */
    public function countPending(): int
    {
        return $this->where('status', 'pendente')->countAllResults();
    }

    /**
     * Lista de denúncias com informações do imóvel e do utilizador denunciante.
     */
    public function getReportsWithDetails(string $status = null): array
    {
        $builder = $this
            ->select('reports.*, properties.title as property_title, u_rep.full_name as reporter_name')
            ->join('properties', 'properties.id = reports.property_id', 'left')
            ->join('users u_rep', 'u_rep.id = reports.reporter_id', 'left')
            ->orderBy('reports.created_at', 'DESC');

        if ($status) {
            $builder->where('reports.status', $status);
        }

        return $builder->findAll();
    }

    /**
     * Verifica se um utilizador já denunciou este imóvel recentemente (anti-spam).
     */
    public function hasAlreadyReported(int $userId, int $propertyId): bool
    {
        return $this
            ->where('reporter_id', $userId)
            ->where('property_id', $propertyId)
            ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
            ->countAllResults() > 0;
    }
}
