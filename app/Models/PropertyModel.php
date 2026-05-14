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
        'type',
        'is_verified',
        'latitude',
        'longitude',
        'property_doc_path',
        'property_doc_type',
        'rejection_reason',
        'price_flag',
        'is_premium'
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

    // Haversine Distance Logic
    public function getNearProperties($lat, $lng, $radius = 10) // default 10km
    {
        $all = $this->where('status', 'available')->findAll();
        $result = [];

        foreach ($all as $p) {
            if (empty($p['latitude']) || empty($p['longitude'])) continue;

            $dist = $this->calculateDistance($lat, $lng, $p['latitude'], $p['longitude']);
            
            if ($dist <= $radius) {
                $p['distance'] = $dist;
                $result[] = $p;
            }
        }

        // Sort by distance
        usort($result, function($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });

        return $result;
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        
        $dLat = deg2rad((float)$lat2 - (float)$lat1);
        $dLon = deg2rad((float)$lon2 - (float)$lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) + 
             cos(deg2rad((float)$lat1)) * cos(deg2rad((float)$lat2)) * 
             sin($dLon/2) * sin($dLon/2);
             
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return $earthRadius * $c;
    }
}
