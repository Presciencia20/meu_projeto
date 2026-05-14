<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Reports extends Migration
{
    public function up(): void
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'reporter_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => true,
                'comment'  => 'NULL se o utilizador não está autenticado',
            ],
            'property_id' => [
                'type'     => 'INT',
                'unsigned' => true,
                'null'     => false,
            ],
            'reason' => [
                'type'       => 'ENUM',
                'constraint' => [
                    'imovel_falso',
                    'fotos_enganosas',
                    'preco_suspeito',
                    'proprietario_suspeito',
                    'fraude',
                    'outro',
                ],
                'null' => false,
            ],
            'details' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pendente', 'em_analise', 'resolvido', 'ignorado'],
                'default'    => 'pendente',
            ],
            'resolved_by' => [
                'type' => 'INT',
                'null' => true,
            ],
            'resolved_note' => [
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
        $this->forge->addKey('property_id');
        $this->forge->addKey('status');
        $this->forge->addForeignKey('property_id', 'properties', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('reports');
    }

    public function down(): void
    {
        $this->forge->dropTable('reports', true);
    }
}
