<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserModel;
use App\Models\PropertyModel;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $userModel = new UserModel();
        $propModel = new PropertyModel();

        // 1. Criar Proprietários de Teste (se necessário)
        $owners = $userModel->where('user_type', 'Proprietário')->limit(5)->findAll();
        
        if (count($owners) < 5) {
            $nicks = ['AngolaReal', 'VistaLuanda', 'ImobiKanda', 'RentMaster', 'CasaFacil'];
            foreach ($nicks as $nick) {
                $userData = [
                    'full_name'    => $nick . ' Imobiliária',
                    'email'        => strtolower($nick) . '@exemplo.ao',
                    'phone'        => '+2449' . rand(10000000, 99999999),
                    'password'     => 'CasaSegura2024!',
                    'user_type'    => 'Proprietário',
                    'active_role'  => 'Proprietário',
                    'status'       => 'ativo',
                    'bi_status'    => 'aprovado'
                ];
                $userModel->insert($userData);
            }
            $owners = $userModel->where('user_type', 'Proprietário')->findAll();
        }

        $ownerIds = array_column($owners, 'id');

        // 2. Localizações (Luanda)
        $luandaNeighborhoods = [
            'Maianga', 'Talatona', 'Benfica', 'Kilamba', 'Viana', 'Cazenga', 
            'Sambizanga', 'Cassenda', 'Ingombota', 'Alvalade', 'Miramar',
            'Camama', 'Morro Bento', 'Ilha do Cabo', 'Cacuaco'
        ];

        // 3. Províncias Secundárias
        $otherProvinces = [
            'Benguela'   => ['Lobito', 'Catumbela'],
            'Huambo'     => ['Huambo Centro', 'Caála'],
            'Huíla'      => ['Lubango', 'Humpata'],
            'Cabinda'    => ['Cabinda Centro'],
            'Cuanza Sul' => ['Sumbe', 'Porto Amboim']
        ];

        // 4. Tipos e Descrições
        $types = ['Apartamento', 'Vivenda', 'Escritório', 'Loja', 'Terreno'];
        $adjectives = ['Luxuoso', 'Moderno', 'Espaçoso', 'Económico', 'Bem localizado', 'Recém-remodelado'];

        // --- GERAR 200 EM LUANDA ---
        for ($i = 0; $i < 200; $i++) {
            $type = $types[array_rand($types)];
            $adj  = $adjectives[array_rand($adjectives)];
            $neighborhood = $luandaNeighborhoods[array_rand($luandaNeighborhoods)];
            
            $status = 'available';
            $rand = rand(0, 100);
            if ($rand > 70 && $rand <= 90) $status = 'rented';
            elseif ($rand > 90) $status = 'sold';

            $price = ($type == 'Terreno') ? rand(5, 50) * 100000 : rand(15, 80) * 100000;

            $data = [
                'title'        => "$adj $type em $neighborhood",
                'description'  => "Excelente oportunidade em $neighborhood. Este $type oferece todas as comodidades modernas e segurança 24h.",
                'price'        => $price,
                'province'     => 'Luanda',
                'municipality' => 'Belas', // Simplificado
                'neighborhood' => $neighborhood,
                'bedrooms'     => rand(1, 5),
                'bathrooms'    => rand(1, 4),
                'type'         => $type,
                'owner_id'     => $ownerIds[array_rand($ownerIds)],
                'status'       => $status,
                'is_verified'  => (rand(0, 10) > 3) ? 1 : 0, // 70% verificados
                'images'       => json_encode(['https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&q=80&w=800']),
                'latitude'     => -8.839988 + (rand(-1000, 1000) / 10000),
                'longitude'    => 13.235443 + (rand(-1000, 1000) / 10000),
            ];

            $propModel->insert($data);
        }

        // --- GERAR 10 FORA DE LUANDA ---
        foreach ($otherProvinces as $province => $neighborhoods) {
            foreach ($neighborhoods as $neighborhood) {
                $type = $types[array_rand($types)];
                
                $data = [
                    'title'        => "Magnífica $type em $neighborhood, $province",
                    'description'  => "Imóvel de alto padrão localizado no centro de $neighborhood.",
                    'price'        => rand(5, 40) * 100000,
                    'province'     => $province,
                    'municipality' => $neighborhood,
                    'neighborhood' => 'Centro',
                    'bedrooms'     => rand(2, 6),
                    'bathrooms'    => rand(1, 3),
                    'type'         => $type,
                    'owner_id'     => $ownerIds[array_rand($ownerIds)],
                    'status'       => 'available',
                    'is_verified'  => 1,
                    'images'       => json_encode(['https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?auto=format&fit=crop&q=80&w=800']),
                ];
                $propModel->insert($data);
            }
        }

        echo "Total de 210 imóveis semeados com sucesso!\n";
    }
}
