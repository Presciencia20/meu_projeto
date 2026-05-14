<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();

        $adminData = [
            'full_name'    => 'Administrador Geral',
            'email'        => 'admin@casasegura.ao',
            'phone'        => '+244900000000',
            'password'     => 'admin123', // Será hasheado automaticamente caso o UserModel o faça ou a nivel de DB. Vamos usar o hash
            'user_type'    => 'Super Admin',
            'active_role'  => 'admin',
            'status'       => 'verificado',
            'bi_status'    => 'aprovado',
            'is_admin'     => 1,
            'is_owner'     => 0,
            'is_client'    => 0,
        ];

        // Password will be hashed automatically by UserModel callback
        
        $userModel->insert($adminData);
        echo "Administrador criado: admin@casasegura.ao / admin123\n";
    }
}
