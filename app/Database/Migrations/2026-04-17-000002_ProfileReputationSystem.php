<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProfileReputationSystem extends Migration
{
    public function up()
    {
        // 1. Profiles Table
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
                'unique'     => true,
            ],
            'photo' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => true,
            ],
            'bio' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'language' => [
                'type'       => 'VARCHAR',
                'constraint' => '10',
                'default'    => 'pt',
            ],
            'notifications_email' => [
                'type'    => 'BOOLEAN',
                'default' => true,
            ],
            'notifications_sms' => [
                'type'    => 'BOOLEAN',
                'default' => true,
            ],
            'privacy_phone_visibility' => [
                'type'       => 'ENUM',
                'constraint' => ['never', 'after_visit', 'after_contract'],
                'default'    => 'after_visit',
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('profiles');

        // 2. User Statistics Table
        $this->forge->addField([
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'total_reviews' => [
                'type'       => 'INT',
                'default'    => 0,
            ],
            'average_rating' => [
                'type'       => 'DECIMAL',
                'constraint' => '2,1',
                'default'    => 0,
            ],
            'completed_contracts' => [
                'type'       => 'INT',
                'default'    => 0,
            ],
            'published_properties' => [
                'type'       => 'INT',
                'default'    => 0,
            ],
            'response_rate' => [
                'type'       => 'INT',
                'default'    => 0,
            ],
            'avg_response_time_hours' => [
                'type'       => 'DECIMAL',
                'constraint' => '3,1',
                'null'       => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('user_id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('user_stats');

        // 3. Update Reviews Table
        // Assuming we add the categorical ratings to the existing table
        $fields = [
            'rating_communication' => [
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => true,
            ],
            'rating_trust' => [
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => true,
            ],
            'rating_accuracy' => [
                'type'       => 'INT',
                'constraint' => 1,
                'null'       => true,
            ],
            'type' => [
                'type'       => 'ENUM',
                'constraint' => ['tenant_to_owner', 'owner_to_tenant'],
                'null'       => false,
            ],
        ];
        $this->forge->addColumn('reviews', $fields);
    }

    public function down()
    {
        $this->forge->dropTable('profiles');
        $this->forge->dropTable('user_stats');
        $this->forge->dropColumn('reviews', ['rating_communication', 'rating_trust', 'rating_accuracy', 'type']);
    }
}
