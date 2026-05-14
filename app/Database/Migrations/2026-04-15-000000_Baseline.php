<?php
namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Baseline extends Migration
{
    public function up()
    {
        // 1. Users Table (Core fields)
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'full_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'unique'     => true,
            ],
            'bi_number' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'user_type' => [
                'type'       => 'ENUM',
                'constraint' => ['Inquilino', 'Proprietário', 'Intermediário', 'Admin', 'Super Admin'],
                'default'    => 'Inquilino',
            ],
            'active_role' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'is_verified_user' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'verification_data' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users', true);

        // 3. Properties Table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'description' => [
                'type' => 'TEXT',
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'province' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'municipality' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'neighborhood' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
            ],
            'bedrooms' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'bathrooms' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'images' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'owner_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['available', 'rented', 'sold', 'unavailable'],
                'default'    => 'available',
            ],
            'type' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
            ],
            'is_verified' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'latitude' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,8',
                'null'       => true,
            ],
            'longitude' => [
                'type'       => 'DECIMAL',
                'constraint' => '11,8',
                'null'       => true,
            ],
            'is_premium' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('owner_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('properties', true);

        // 4. Rental Requests Table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'property_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tenant_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'owner_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pending', 'accepted', 'rejected', 'cancelled', 'paid'],
                'default'    => 'pending',
            ],
            'monthly_rent' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'deposit_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'total_amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'payment_intent_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('property_id', 'properties', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tenant_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('owner_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('rental_requests', true);

        // 5. Reviews Table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'rental_request_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'reviewer_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'reviewed_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'rating' => [
                'type'       => 'INT',
                'constraint' => 1,
            ],
            'comment' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'categories' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'reply' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rental_request_id', 'rental_requests', 'id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('reviewer_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('reviewed_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('reviews', true);

        // 6. Conversations Table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'property_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'tenant_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'owner_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'last_message' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'last_message_time' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('property_id', 'properties', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tenant_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('owner_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('conversations', true);

        // 7. Messages Table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'conversation_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'sender_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'text' => [
                'type' => 'TEXT',
            ],
            'read' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('conversation_id', 'conversations', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('sender_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('messages', true);

        // 8. Escrow Payments Table
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'rental_request_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'amount' => [
                'type'       => 'DECIMAL',
                'constraint' => '15,2',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['held', 'released', 'refunded', 'disputed'],
                'default'    => 'held',
            ],
            'payment_method' => [
                'type'       => 'VARCHAR',
                'constraint' => '50',
                'null'       => true,
            ],
            'transaction_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '100',
                'null'       => true,
            ],
            'release_code' => [
                'type'       => 'VARCHAR',
                'constraint' => '20',
                'null'       => true,
            ],
            'visit_confirmed' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'released_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('rental_request_id', 'rental_requests', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('escrow_payments', true);
    }

    public function down()
    {
        $this->forge->dropTable('escrow_payments', true);
        $this->forge->dropTable('messages', true);
        $this->forge->dropTable('conversations', true);
        $this->forge->dropTable('reviews', true);
        $this->forge->dropTable('rental_requests', true);
        $this->forge->dropTable('properties', true);
        $this->forge->dropTable('users', true);
    }
}
