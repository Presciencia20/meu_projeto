<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        $model = new \App\Models\PropertyModel();
        $data['properties'] = $model->where('status', 'available')->orderBy('id', 'DESC')->findAll(6);
        
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
}
