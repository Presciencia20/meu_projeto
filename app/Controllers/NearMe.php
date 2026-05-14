<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PropertyModel;

class NearMe extends BaseController
{
    public function index()
    {
        return view('near_me/index');
    }

    public function getProperties()
    {
        $lat    = $this->request->getGet('lat');
        $lng    = $this->request->getGet('lng');
        $radius = $this->request->getGet('radius') ?: 10; // km

        if (!$lat || !$lng) {
            return $this->response->setJSON(['error' => 'Localização necessária']);
        }

        $model = new PropertyModel();
        $properties = $model->getNearProperties($lat, $lng, $radius);

        return $this->response->setJSON($properties);
    }
}
