<?php

namespace App\Models;

use CodeIgniter\Model;

class FavoriteModel extends Model
{
    protected $table            = 'favorites';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = ['user_id', 'property_id', 'created_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getUserFavorites($userId)
    {
        return $this->select('favorites.*, properties.*, properties.id as property_id')
                    ->join('properties', 'properties.id = favorites.property_id')
                    ->where('favorites.user_id', $userId)
                    ->findAll();
    }

    public function isFavorited($userId, $propertyId)
    {
        return $this->where('user_id', $userId)
                    ->where('property_id', $propertyId)
                    ->first() !== null;
    }
}
