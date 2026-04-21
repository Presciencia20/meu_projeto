<?php

namespace App\Controllers;

use App\Models\PropertyModel;
use CodeIgniter\Controller;

class Property extends BaseController
{
    public function view($id)
    {
        $model = new PropertyModel();
        $property = $model->find($id);

        if (!$property) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Imóvel não encontrado");
        }

        // Fetch Owner Data
        $userModel = new \App\Models\UserModel();
        $owner = $userModel->find($property['owner_id']);

        // Fetch Owner Reputation
        $reviewModel = new \App\Models\ReviewModel();
        $data['reviews'] = $reviewModel->getReviewsForUser($property['owner_id']);
        $data['avgRating'] = $reviewModel->getAverageRating($property['owner_id']);
        
        $data['property'] = $property;
        $data['owner']    = $owner;
        $data['badge']    = $userModel->getBadgeInfo($owner);

        return view('property/view', $data);
    }

    public function create()
    {
        // Must be logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Allow Admin, Owner, Intermediary
        if (!in_array(session()->get('user_type'), ['Proprietário', 'Intermediário', 'Admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Acesso negado. Apenas proprietários podem publicar imóveis.');
        }

        return view('property/create');
    }

    public function store()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $model = new PropertyModel();

        // Process images
        $imageUrls = [];
        if ($imageFiles = $this->request->getFileMultiple('images')) {
            foreach ($imageFiles as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    
                    if (!is_dir(FCPATH . 'uploads/properties')) {
                        mkdir(FCPATH . 'uploads/properties', 0777, true);
                    }
                    
                    $img->move(FCPATH . 'uploads/properties', $newName);
                    $imageUrls[] = 'uploads/properties/' . $newName;
                }
            }
        }

        // Prepare data
        $data = [
            'owner_id'     => session()->get('user_id'),
            'title'        => $this->request->getPost('title'),
            'description'  => $this->request->getPost('description'),
            'price'        => $this->request->getPost('price'),
            'province'     => $this->request->getPost('province'),
            'municipality' => $this->request->getPost('municipality'),
            'neighborhood' => $this->request->getPost('neighborhood'),
            'bedrooms'     => $this->request->getPost('bedrooms'),
            'bathrooms'    => $this->request->getPost('bathrooms'),
            'images'       => json_encode($imageUrls),
            'status'       => 'available',
            'latitude'     => $this->request->getPost('latitude'),
            'longitude'    => $this->request->getPost('longitude'),
            // If the user is admin or verified owner, we might auto-verify it, but usually standard flow is to leave false.
            // Let's leave false so admin process kicks in.
            'is_verified'  => (session()->get('user_type') === 'Admin') ? true : false, 
        ];

        $model->insert($data);

        $msg = $data['is_verified'] ? 'Imóvel publicado automaticamente (Admin).' : 'Imóvel submetido e colocado na fila para verificação pela nossa equipa.';
        return redirect()->to('/dashboard')->with('success', $msg);
    }

    public function search()
    {
        $model = new PropertyModel();
        $q = $this->request->getGet('q');
        $type = $this->request->getGet('type');

        $data['properties'] = $model->searchProperties($q);
        $data['q'] = $q;

        return view('home', $data);
    }

    public function category($type)
    {
        $model = new PropertyModel();

        $q        = $this->request->getGet('q');
        $province = $this->request->getGet('province');
        $bedrooms = $this->request->getGet('bedrooms');
        $minPrice = $this->request->getGet('min_price');
        $maxPrice = $this->request->getGet('max_price');

        $builder = $model->where('status', 'available');

        if ($q) {
            $builder->groupStart()
                ->like('title', $q)
                ->orLike('neighborhood', $q)
                ->orLike('municipality', $q)
                ->groupEnd();
        }
        if ($province) {
            $builder->where('province', $province);
        }
        if ($bedrooms) {
            $builder->where('bedrooms >=', (int)$bedrooms);
        }
        if ($minPrice) {
            $builder->where('price >=', (float)$minPrice);
        }
        if ($maxPrice) {
            $builder->where('price <=', (float)$maxPrice);
        }

        $data['properties'] = $builder->findAll();
        $data['q']          = $q;
        $data['province']   = $province;
        $data['bedrooms']   = $bedrooms;
        $data['minPrice']   = $minPrice;
        $data['maxPrice']   = $maxPrice;

        $view = ($type === 'rent') ? 'alugar' : 'comprar';
        return view($view, $data);
    }
}
