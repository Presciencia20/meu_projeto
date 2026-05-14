<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddMultiRoleToUsers extends Migration
{
    public function up()
    {
        $fields = [
            'is_admin'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'user_type'],
            'is_owner'  => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0, 'after' => 'is_admin'],
            'is_client' => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1, 'after' => 'is_owner'],
        ];
        $this->forge->addColumn('users', $fields);

        // Migrate existing data
        $this->db->query("UPDATE users SET is_admin = 1, is_owner = 1, is_client = 1 WHERE user_type IN ('Admin', 'Super Admin')");
        $this->db->query("UPDATE users SET is_owner = 1, is_client = 1 WHERE user_type = 'Proprietário'");
        $this->db->query("UPDATE users SET is_client = 1 WHERE user_type = 'Inquilino'");
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['is_admin', 'is_owner', 'is_client']);
    }
}
