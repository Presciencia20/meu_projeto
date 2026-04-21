<?php

namespace App\Models;

use CodeIgniter\Model;

class RentalRequestModel extends Model
{
    protected $table            = 'rental_requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'property_id',
        'tenant_id',
        'owner_id',
        'status',
        'monthly_rent',
        'deposit_amount',
        'total_amount',
        'payment_intent_id'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    /**
     * Get requests for a specific user (tenant or owner)
     */
    public function getForUser($userId, $role = 'tenant')
    {
        $builder = $this->select('rental_requests.*, p.title as property_title, p.main_image')
                        ->join('properties p', 'p.id = rental_requests.property_id');
        
        if ($role === 'tenant') {
            $builder->where('tenant_id', $userId);
        } else {
            $builder->where('owner_id', $userId);
        }

        return $builder->orderBy('created_at', 'DESC')->findAll();
    }
}
