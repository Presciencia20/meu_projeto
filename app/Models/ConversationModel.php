<?php

namespace App\Models;

use CodeIgniter\Model;

class ConversationModel extends Model
{
    protected $table            = 'conversations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'property_id',
        'tenant_id',
        'owner_id',
        'last_message',
        'last_message_time'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'last_message_time';

    public function getConversationsForUser($userId)
    {
        return $this->db->table('conversations c')
            ->select('c.*, p.title as property_title, u.full_name as other_user_name')
            ->join('properties p', 'c.property_id = p.id')
            ->join('users u', '(u.id = c.tenant_id OR u.id = c.owner_id) AND u.id != ' . $userId)
            ->where('c.tenant_id', $userId)
            ->orWhere('c.owner_id', $userId)
            ->orderBy('c.last_message_time', 'DESC')
            ->get()->getResultArray();
    }
}
