<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixOtpIdentifier extends Migration
{
    public function up(): void
    {
        // Alterar coluna telemovel para identifier e aumentar tamanho para 255
        $this->forge->modifyColumn('codigos_otp', [
            'telemovel' => [
                'name'       => 'identifier',
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => false,
            ],
        ]);
    }

    public function down(): void
    {
        $this->forge->modifyColumn('codigos_otp', [
            'identifier' => [
                'name'       => 'telemovel',
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => false,
            ],
        ]);
    }
}
