<?php

namespace App\Controllers;

use App\Models\PropertyModel;
use CodeIgniter\Controller;

class Discovery extends BaseController
{
    protected PropertyModel $propModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);
        $this->propModel = new PropertyModel();
    }

    public function index()
    {
        // Redireciona para o modelo X por padrão ou mostra uma splash page
        return redirect()->to('/discovery/x');
    }

    public function layout_x()
    {
        $data['properties'] = $this->getRandomProperties(20);
        return view('discovery/layout_x', $data);
    }

    public function layout_y()
    {
        $data['properties'] = $this->getRandomProperties(20);
        return view('discovery/layout_y', $data);
    }

    public function layout_z()
    {
        $data['properties'] = $this->getRandomProperties(30);
        return view('discovery/layout_z', $data);
    }

    private function getRandomProperties($limit = 10)
    {
        return $this->propModel->select('properties.*, users.full_name as owner_name')
                               ->join('users', 'users.id = properties.owner_id')
                               ->where('properties.is_verified', true)
                               ->where('properties.status', 'available')
                               ->orderBy('RAND()')
                               ->limit($limit)
                               ->findAll();
    }
}
