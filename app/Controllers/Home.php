<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $propModel = new \App\Models\PropertyModel();
        
        // Recommended (verified, higher price or premium)
        $data['recommended'] = $propModel->where('status', 'available')->where('is_verified', 1)->orderBy('price', 'DESC')->findAll(4);
        
        // Recent
        $data['recent'] = $propModel->where('status', 'available')->orderBy('created_at', 'DESC')->findAll(4);
        
        // Near You (Luanda as default)
        $data['near_you'] = $propModel->where('status', 'available')->where('province', 'Luanda')->findAll(2);

        // Get Search Query
        $q = $this->request->getGet('q');
        
        if ($q) {
            $data['properties'] = $propModel->where('status', 'available')
                                            ->groupStart()
                                                ->like('title', $q)
                                                ->orLike('neighborhood', $q)
                                                ->orLike('city', $q)
                                            ->groupEnd()
                                            ->paginate(10, 'default');
            $data['pager'] = $propModel->pager;
        } else {
            $data['properties'] = [];
        }
        
        $data['q'] = $q;
        
        return view('home', $data);
    }

    public function vender(): string
    {
        return view('vender');
    }

    public function sobre(): string
    {
        return view('sobre');
    }

    public function ajuda(): string
    {
        return view('errors/html/production'); // Placeholder util we build them
    }

    public function termos(): string
    {
        return view('errors/html/production'); // Placeholder
    }

    public function privacidade(): string
    {
        return view('errors/html/production'); // Placeholder
    }
}
