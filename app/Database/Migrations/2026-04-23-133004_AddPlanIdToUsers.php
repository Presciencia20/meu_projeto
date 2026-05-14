<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPlanIdToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'plan_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
                'after'      => 'balance'
            ],
            'plan_expires_at' => [
                'type'  => 'DATETIME',
                'null'  => true,
                'after' => 'plan_id'
            ]
        ]);
        
        $this->forge->addForeignKey('plan_id', 'plans', 'id', 'SET NULL', 'CASCADE');
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['plan_id', 'plan_expires_at']);
    }
}
