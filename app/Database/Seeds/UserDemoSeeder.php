<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class UserDemoSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $usersData = [
            // 2 Proprietários
            [
                'full_name'    => 'Ricardo Pereira',
                'email'        => 'ricardo@exemplo.com',
                'phone'        => '+244931000010',
                'password'     => 'senha123',
                'user_type'    => 'Proprietário',
                'active_role'  => 'Proprietário',
                'status'       => 'verificado',
                'bi_status'    => 'aprovado',
                'is_owner'     => 1
            ],
            [
                'full_name'    => 'Sandra Gomes',
                'email'        => 'sandra@exemplo.com',
                'phone'        => '+244931000011',
                'password'     => 'senha123',
                'user_type'    => 'Proprietário',
                'active_role'  => 'Proprietário',
                'status'       => 'verificado',
                'bi_status'    => 'aprovado',
                'is_owner'     => 1
            ],
            // 2 Utilizadores Normais (Inquilinos)
            [
                'full_name'    => 'Miguel Barros',
                'email'        => 'miguel@exemplo.com',
                'phone'        => '+244931000012',
                'password'     => 'senha123',
                'user_type'    => 'Inquilino',
                'active_role'  => 'Inquilino',
                'status'       => 'ativo',
                'is_client'    => 1
            ],
            [
                'full_name'    => 'Teresa Matos',
                'email'        => 'teresa@exemplo.com',
                'phone'        => '+244931000013',
                'password'     => 'senha123',
                'user_type'    => 'Inquilino',
                'active_role'  => 'Inquilino',
                'status'       => 'ativo',
                'is_client'    => 1
            ],
        ];

        foreach ($usersData as $data) {
            $existing = $userModel->where('phone', $data['phone'])->first();
            if (!$existing) {
                $userModel->insert($data);
                echo "Criado: {$data['full_name']} ({$data['user_type']})\n";
            } else {
                echo "Já existe: {$data['full_name']}\n";
            }
        }
    }
}
