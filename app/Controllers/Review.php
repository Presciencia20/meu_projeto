<?php

namespace App\Controllers;

use App\Models\ReviewModel;
use App\Models\EscrowModel;
use CodeIgniter\Controller;

class Review extends BaseController
{
    public function submit($requestId)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $db = \Config\Database::connect();
        $request = $db->table('rental_requests')->where('id', $requestId)->get()->getRowArray();

        if (!$request) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        $userId = session()->get('user_id');
        $reviewedId = ($userId == $request['tenant_id']) ? $request['owner_id'] : $request['tenant_id'];

        if ($this->request->getMethod() === 'POST') {
            $model = new ReviewModel();
            $type = ($userId == $request['tenant_id']) ? 'tenant_to_owner' : 'owner_to_tenant';
            
            $model->insert([
                'rental_request_id'     => $requestId,
                'reviewer_id'           => $userId,
                'reviewed_id'           => $reviewedId,
                'rating'                => $this->request->getPost('rating'),
                'rating_communication' => $this->request->getPost('rating_communication'),
                'rating_trust'         => $this->request->getPost('rating_trust'),
                'rating_accuracy'      => $this->request->getPost('rating_accuracy'),
                'comment'               => $this->request->getPost('comment'),
                'type'                  => $type,
                'categories'            => json_encode($this->request->getPost('categories'))
            ]);

            // Refresh statistics for the reviewed user
            (new \App\Models\UserStatModel())->refreshStats($reviewedId);

            return redirect()->to('/dashboard')->with('success', 'Avaliação enviada com sucesso!');
        }

        $data['request'] = $request;
        $data['reviewed_id'] = $reviewedId;
        
        return view('reviews/form', $data);
    }
}
