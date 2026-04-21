<?php

namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table            = 'profiles';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id',
        'photo',
        'bio',
        'language',
        'notifications_email',
        'notifications_sms',
        'privacy_phone_visibility',
        'bank_name',
        'iban'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get profile by user ID, creates one if it doesn't exist.
     */
    public function getByUserId($userId)
    {
        $profile = $this->where('user_id', $userId)->first();

        if (!$profile) {
            $id = $this->insert([
                'user_id' => $userId,
                'language' => 'pt',
                'notifications_email' => true,
                'notifications_sms' => true,
                'privacy_phone_visibility' => 'after_visit'
            ]);
            return $this->find($id);
        }

        return $profile;
    }
}
