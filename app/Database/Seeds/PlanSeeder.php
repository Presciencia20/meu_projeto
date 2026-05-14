<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name'          => 'Iniciação',
                'price'         => 0,
                'duration_days' => 30,
                'features'      => json_encode(['Limite de anúncios ativo', 'Visibilidade Básica', 'Ideal para começar'])
            ],
            [
                'name'          => 'Essencial',
                'price'         => 2000,
                'duration_days' => 30,
                'features'      => json_encode(['Visibilidade Bronze', 'Até 5 anúncios', 'Suporte Padrão'])
            ],
            [
                'name'          => 'Impulso',
                'price'         => 5000,
                'duration_days' => 30,
                'features'      => json_encode(['Visibilidade Silver (Destaque)', 'Limite de 15 anúncios', 'Selo de Verificado'])
            ],
            [
                'name'          => 'Elite 90',
                'price'         => 30000,
                'duration_days' => 90,
                'features'      => json_encode(['Ilimitado por 3 meses', 'Destaque Diamante (Topo)', 'Suporte Prioritário 24/7'])
            ],
        ];

        $this->db->table('plans')->truncate();
        $this->db->table('plans')->insertBatch($data);
    }
}
