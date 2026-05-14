<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateWalletTransactionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'plan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['credit', 'debit'],
            ],
            'category' => [
                'type'       => 'ENUM',
                'constraint' => ['rent_payment', 'plan_activation', 'withdrawal', 'transfer', 'system_credit'],
                'default'    => 'rent_payment',
            ],
            'description' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'completed', 'failed'],
                'default'    => 'completed',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('wallet_transactions');
    }

    public function down()
    {
        $this->forge->dropTable('wallet_transactions');
    }
}
