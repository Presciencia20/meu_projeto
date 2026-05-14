<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table            = 'messages';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'conversation_id',
        'sender_id',
        'text',
        'read'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    public function getMessagesForConversation($conversationId)
    {
        return $this->where('conversation_id', $conversationId)
            ->orderBy('created_at', 'ASC')
            ->findAll();
    }

    public function countUnreadForUser($userId)
    {
        return $this->db->table('messages m')
            ->join('conversations c', 'm.conversation_id = c.id')
            ->where('m.sender_id !=', $userId)
            ->where('m.read', 0)
            ->groupStart()
                ->where('c.tenant_id', $userId)
                ->orWhere('c.owner_id', $userId)
            ->groupEnd()
            ->countAllResults();
    }

    public function markAsReadInConversation($conversationId, $userId)
    {
        return $this->where('conversation_id', $conversationId)
                    ->where('sender_id !=', $userId)
                    ->where('read', 0)
                    ->set(['read' => 1])
                    ->update();
    }
}
