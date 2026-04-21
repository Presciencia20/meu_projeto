<?php

namespace App\Models;

use CodeIgniter\Model;

class EscrowModel extends Model
{
    protected $table            = 'escrow_payments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'rental_request_id',
        'amount',
        'status',          // 'held', 'released', 'refunded', 'disputed'
        'payment_method',
        'transaction_id',
        'release_code',
        'visit_confirmed',
        'released_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getPendingEscrows($userId)
    {
        return $this->db->table('escrow_payments ep')
            ->select('ep.*, rr.property_id, rr.tenant_id, rr.owner_id, p.title as property_title, p.images')
            ->join('rental_requests rr', 'ep.rental_request_id = rr.id')
            ->join('properties p', 'rr.property_id = p.id')
            ->groupStart()
                ->where('rr.tenant_id', $userId)
                ->orWhere('rr.owner_id', $userId)
            ->groupEnd()
            ->orderBy('ep.created_at', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Release funds to the owner
     */
    public function releaseFunds(int $escrowId): bool
    {
        return $this->update($escrowId, [
            'status'      => 'released',
            'released_at' => date('Y-m-d H:i:s')
        ]);
    }
}
