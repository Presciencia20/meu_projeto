<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddWalletToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'balance' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
                'default'    => 0.00,
                'after'      => 'user_type'
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'balance');
    }
}
