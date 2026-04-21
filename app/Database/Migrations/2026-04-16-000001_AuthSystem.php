<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AuthSystem extends Migration
{
    public function up(): void
    {
        // --- Alterar tabela users ---
        $fields = [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'after'      => 'full_name',
            ],
            'status' => [
                'type'       => 'ENUM',
                'constraint' => ['pendente', 'ativo', 'bloqueado', 'verificado'],
                'default'    => 'pendente',
                'after'      => 'bi_number',
            ],
            'bi_status' => [
                'type'       => 'ENUM',
                'constraint' => ['nao_submetido', 'pendente', 'aprovado', 'rejeitado'],
                'default'    => 'nao_submetido',
                'after'      => 'status',
            ],
            'bi_foto_frente' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'bi_status',
            ],
            'bi_foto_verso' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'bi_foto_frente',
            ],
            'selfie_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'bi_foto_verso',
            ],
            'login_attempts' => [
                'type'    => 'TINYINT',
                'default' => 0,
                'after'   => 'selfie_path',
            ],
            'locked_until' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'login_attempts',
            ],
            'last_login' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'locked_until',
            ],
        ];

        $this->forge->addColumn('users', $fields);

        // Tornar bi_number opcional (pode ser NULL para inquilinos)
        $this->forge->modifyColumn('users', [
            'bi_number' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'unique'     => true,
            ],
        ]);

        // Tornar password opcional (login por SMS não precisa)
        $this->forge->modifyColumn('users', [
            'password' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
        ]);

        // --- Criar tabela codigos_otp ---
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'telemovel' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
            'codigo' => [
                'type'       => 'VARCHAR',
                'constraint' => 6,
                'null'       => false,
            ],
            'tipo' => [
                'type'       => 'ENUM',
                'constraint' => ['registo', 'login', 'recuperacao', '2fa'],
                'null'       => false,
            ],
            'expira_em' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'usado' => [
                'type'    => 'TINYINT',
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('telemovel');
        $this->forge->createTable('codigos_otp');

        // --- Criar tabela verificacoes_bi ---
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'auto_increment' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'null' => false,
            ],
            'foto_frente' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'foto_verso' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'selfie' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'resultado' => [
                'type'       => 'ENUM',
                'constraint' => ['pendente', 'aprovado', 'rejeitado'],
                'default'    => 'pendente',
            ],
            'motivo_rejeicao' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'verificado_por' => [
                'type' => 'INT',
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
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('verificacoes_bi');
    }

    public function down(): void
    {
        $this->forge->dropTable('verificacoes_bi', true);
        $this->forge->dropTable('codigos_otp', true);

        $this->forge->dropColumn('users', [
            'email', 'status', 'bi_status', 'bi_foto_frente', 'bi_foto_verso',
            'selfie_path', 'login_attempts', 'locked_until', 'last_login',
        ]);
    }
}
