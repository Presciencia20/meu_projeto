<?php

namespace App\Models;

use CodeIgniter\Model;

class WalletTransactionModel extends Model
{
    protected $table            = 'wallet_transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $allowedFields    = [
        'user_id',
        'amount',
        'type',
        'category',
        'description',
        'status',
        'created_at'
    ];

    protected $useTimestamps = false;
}
