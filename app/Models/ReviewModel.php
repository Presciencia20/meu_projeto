<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table            = 'reviews';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'rental_request_id',
        'reviewer_id',
        'reviewed_id',
        'rating',
        'rating_communication',
        'rating_trust',
        'rating_accuracy',
        'comment',
        'categories',
        'type',
        'reply'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getReviewsForUser($userId)
    {
        return $this->db->table('reviews r')
            ->select('r.*, u.full_name as reviewer_name')
            ->join('users u', 'r.reviewer_id = u.id')
            ->where('r.reviewed_id', $userId)
            ->orderBy('r.created_at', 'DESC')
            ->get()->getResultArray();
    }

    /**
     * Get average rating for a user
     */
    public function getAverageRating($userId)
    {
        $result = $this->selectAvg('rating', 'avg')
                       ->where('reviewed_id', $userId)
                       ->first();
        
        return $result ? (float)$result['avg'] : 0.0;
    }
}
