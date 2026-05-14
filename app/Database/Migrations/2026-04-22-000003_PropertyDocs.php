<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class PropertyDocs extends Migration
{
    public function up(): void
    {
        // Adicionar colunas de documento do imóvel à tabela properties
        $fields = [
            'property_doc_path' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'longitude',
            ],
            'property_doc_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
                'after'      => 'property_doc_path',
                'comment'    => 'Ex: titulo_propriedade, contrato_compra_venda, declaracao_posse',
            ],
            'rejection_reason' => [
                'type'       => 'TEXT',
                'null'       => true,
                'after'      => 'property_doc_type',
            ],
            'price_flag' => [
                'type'    => 'TINYINT',
                'default' => 0,
                'after'   => 'rejection_reason',
                'comment' => '1 = preço suspeito, requer atenção do admin',
            ],
        ];

        $this->forge->addColumn('properties', $fields);
    }

    public function down(): void
    {
        $this->forge->dropColumn('properties', [
            'property_doc_path',
            'property_doc_type',
            'rejection_reason',
            'price_flag',
        ]);
    }
}
