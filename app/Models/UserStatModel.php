<?php

namespace App\Models;

use CodeIgniter\Model;

class UserStatModel extends Model
{
    protected $table            = 'user_stats';
    protected $primaryKey       = 'user_id';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id',
        'total_reviews',
        'average_rating',
        'completed_contracts',
        'published_properties',
        'response_rate',
        'avg_response_time_hours'
    ];

    protected $useTimestamps = true;
    protected $createdField  = '';
    protected $updatedField  = 'updated_at';

    /**
     * Get stats by user ID, creates initial entry if missing.
     */
    public function getByUserId($userId)
    {
        $stats = $this->find($userId);

        if (!$stats) {
            $this->insert([
                'user_id' => $userId,
                'total_reviews' => 0,
                'average_rating' => 0.0,
                'completed_contracts' => 0,
                'published_properties' => 0,
                'response_rate' => 0
            ]);
            return $this->find($userId);
        }

        return $stats;
    }

    /**
     * Recalculate statistics for a user.
     */
    public function refreshStats($userId)
    {
        $reviewModel = new ReviewModel();
        $reviews = $reviewModel->where('reviewed_id', $userId)->findAll();
        
        $totalReviews = count($reviews);
        $avgRating = 0;
        
        if ($totalReviews > 0) {
            $sum = array_sum(array_column($reviews, 'rating'));
            $avgRating = $sum / $totalReviews;
        }

        // Simulating contract and property counts for now
        // In a real scenario, these would be queried from ContractModel and PropertyModel
        $db = \Config\Database::connect();
        $publishedCount = $db->table('properties')->where('owner_id', $userId)->countAllResults();
        
        // This is a simplified logic, can be expanded as specific models are integrated
        $this->update($userId, [
            'total_reviews' => $totalReviews,
            'average_rating' => $avgRating,
            'published_properties' => $publishedCount,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }
}
