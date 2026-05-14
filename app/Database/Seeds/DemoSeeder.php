<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;
use App\Models\PropertyModel;

class DemoSeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $propModel = new PropertyModel();

        // 1. Criar 5 Proprietários
        $ownersData = [
            [
                'full_name'    => 'António Joaquim',
                'email'        => 'antonio@demo.com',
                'phone'        => '+244921000001',
                'password'     => 'senha123',
                'user_type'    => 'Proprietário',
                'active_role'  => 'Proprietário',
                'status'       => 'verificado',
                'bi_status'    => 'aprovado',
                'is_owner'     => 1
            ],
            [
                'full_name'    => 'Maria dos Santos',
                'email'        => 'maria@demo.com',
                'phone'        => '+244921000002',
                'password'     => 'senha123',
                'user_type'    => 'Proprietário',
                'active_role'  => 'Proprietário',
                'status'       => 'verificado',
                'bi_status'    => 'aprovado',
                'is_owner'     => 1
            ],
            [
                'full_name'    => 'José Manuel',
                'email'        => 'jose@demo.com',
                'phone'        => '+244921000003',
                'password'     => 'senha123',
                'user_type'    => 'Proprietário',
                'active_role'  => 'Proprietário',
                'status'       => 'verificado',
                'bi_status'    => 'aprovado',
                'is_owner'     => 1
            ],
            [
                'full_name'    => 'Ana Paula',
                'email'        => 'ana@demo.com',
                'phone'        => '+244921000004',
                'password'     => 'senha123',
                'user_type'    => 'Proprietário',
                'active_role'  => 'Proprietário',
                'status'       => 'verificado',
                'bi_status'    => 'aprovado',
                'is_owner'     => 1
            ],
            [
                'full_name'    => 'Carlos Alberto',
                'email'        => 'carlos@demo.com',
                'phone'        => '+244921000005',
                'password'     => 'senha123',
                'user_type'    => 'Proprietário',
                'active_role'  => 'Proprietário',
                'status'       => 'verificado',
                'bi_status'    => 'aprovado',
                'is_owner'     => 1
            ],
        ];

        $ownerIds = [];
        foreach ($ownersData as $data) {
            // Check if user exists by phone to avoid duplicates
            $existing = $userModel->where('phone', $data['phone'])->first();
            if (!$existing) {
                $userModel->insert($data);
                $ownerIds[] = $userModel->getInsertID();
            } else {
                $ownerIds[] = $existing['id'];
            }
        }

        // 2. Criar 20 Imóveis
        $neighborhoods = ['Talatona', 'Kilamba', 'Patriota', 'Alvalade', 'Nova Vida', 'Benfica', 'Maianga', 'Miramar'];
        $types = ['Vivenda', 'Apartamento', 'Vivenda T3', 'Apartamento T2', 'Vivenda T4'];
        
        $images = [
            'https://images.unsplash.com/photo-1580587771525-78b9dba3b914?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1518780664697-55e3ad937233?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1600607687940-47a04f699773?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1600585154526-990dcea464f9?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1600573472591-ee6b68d14c68?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1600047509807-ba8f99d2cdde?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1600566753086-00f18fb6b3ea?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1598228723793-52759bba239c?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1583608205776-bfd35f0d9f83?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1568605114967-8130f3a36994?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1480074568708-e7b720bb3f09?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1513584684374-8bdb74838a0f?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1502672260266-1c1ef2d93688?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1448630305456-d39fa5433944?auto=format&fit=crop&q=80&w=800',
            'https://images.unsplash.com/photo-1416331108676-a22ccb276e35?auto=format&fit=crop&q=80&w=800',
        ];

        for ($i = 1; $i <= 20; $i++) {
            $neighborhood = $neighborhoods[array_rand($neighborhoods)];
            $type = $types[array_rand($types)];
            $ownerId = $ownerIds[array_rand($ownerIds)];
            $image = $images[$i - 1]; // Usar uma imagem diferente para cada casa
            
            $propertyData = [
                'title'        => "$type no $neighborhood - Modelo " . $i,
                'description'  => "Excelente imóvel modelo $i localizado no prestigiado bairro do $neighborhood. Com acabamentos de luxo e prontos a habitar.",
                'price'        => rand(50, 500) * 100000, // 5M a 50M Kz
                'province'     => 'Luanda',
                'municipality' => 'Belas',
                'neighborhood' => $neighborhood,
                'bedrooms'     => rand(2, 5),
                'bathrooms'    => rand(1, 4),
                'images'       => json_encode([$image]),
                'owner_id'     => $ownerId,
                'status'       => 'available',
                'type'         => (strpos($type, 'Apartamento') !== false) ? 'Apartamento' : 'Vivenda',
                'is_verified'  => 1,
                'latitude'     => -8.9 + (rand(-100, 100) / 1000),
                'longitude'    => 13.2 + (rand(-100, 100) / 1000),
            ];

            $propModel->insert($propertyData);
        }

        echo "Semeado com sucesso: 5 Proprietários e 20 Imóveis.\n";
    }
}
