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
}
