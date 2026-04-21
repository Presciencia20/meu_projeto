<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyModel extends Model
{
    protected $table            = 'properties';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'title',
        'description',
        'price',
        'province',
        'municipality',
        'neighborhood',
        'bedrooms',
        'bathrooms',
        'images',
        'owner_id',
        'status',
        'is_verified',
        'latitude',
        'longitude'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    // Search helper
    public function searchProperties($search = null, $province = null)
    {
        $builder = $this->builder();
        
        if ($search) {
            $builder->groupStart()
                ->like('title', $search)
                ->orLike('neighborhood', $search)
                ->orLike('municipality', $search)
                ->groupEnd();
        }

        if ($province) {
            $builder->where('province', $province);
        }

        return $builder->get()->getResultArray();
    }
}
