<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PaymentSystem extends Migration
{
    public function up()
    {
        // Plans table
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'name' => ['type' => 'VARCHAR', 'constraint' => 50],
            'price' => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'duration_days' => ['type' => 'INT', 'constraint' => 5, 'default' => 30],
            'features' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('plans');

        // Bookings (Rent Requests)
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'property_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tenant_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'owner_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'amount' => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'awaiting_payment', 'paid_pending_admin', 'approved', 'rejected', 'completed', 'cancelled'], 'default' => 'pending'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('bookings');

        // Payments
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'related_type' => ['type' => 'ENUM', 'constraint' => ['plan', 'rent'], 'default' => 'plan'],
            'related_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'method' => ['type' => 'ENUM', 'constraint' => ['express', 'paypay']],
            'reference' => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'amount' => ['type' => 'DECIMAL', 'constraint' => '15,2'],
            'proof_file' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected'], 'default' => 'pending'],
            'admin_note' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('payments');
    }

    public function down()
    {
        $this->forge->dropTable('payments');
        $this->forge->dropTable('bookings');
        $this->forge->dropTable('plans');
    }
}
