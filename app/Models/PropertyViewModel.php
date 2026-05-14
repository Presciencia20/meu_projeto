<?php

namespace App\Models;

use CodeIgniter\Model;

class PropertyViewModel extends Model
{
    protected $table            = 'property_views';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['property_id', 'user_id', 'ip_address', 'created_at'];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getMostViewed(int $limit = 10): array
    {
        return $this->select('property_id, COUNT(*) as total')
                    ->groupBy('property_id')
                    ->orderBy('total', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}
