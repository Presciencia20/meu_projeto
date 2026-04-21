<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\ProfileModel;
use App\Models\ReviewModel;
use App\Models\UserStatModel;
use CodeIgniter\Controller;

class User extends BaseController
{
    public function dashboard()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        $statsModel = new \App\Models\UserStatModel();
        
        $data['user'] = $user;
        $data['badge'] = $userModel->getBadgeInfo($user);
        $data['stats'] = $statsModel->getByUserId($userId);
        
        $escrowModel = new \App\Models\EscrowModel();
        $data['escrows'] = $escrowModel->getPendingEscrows($userId);

        return view('user/dashboard', $data);
    }

    /**
     * Release funds from Escrow (Action by Tenant)
     */
    public function releaseEscrow($id)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $escrowModel = new \App\Models\EscrowModel();
        $escrow = $escrowModel->find($id);

        if (!$escrow) return redirect()->back()->with('error', 'Pagamento não encontrado.');

        // 1. Verify if the user is the tenant of this request
        $rentalModel = new \App\Models\RentalRequestModel();
        $request = $rentalModel->find($escrow['rental_request_id']);

        if ($request['tenant_id'] != session()->get('user_id')) {
            return redirect()->back()->with('error', 'Não tem permissão para libertar estes fundos.');
        }

        // 2. Release funds
        $escrowModel->releaseFunds($id);

        return redirect()->to('/dashboard')->with('success', 'Fundos libertados com sucesso! O proprietário foi notificado. ⭐');
    }

    public function profile($id = null)
    {
        $isOwnProfile = false;
        if ($id === null || $id == session()->get('user_id')) {
            if (!session()->get('isLoggedIn')) {
                return redirect()->to('/login');
            }
            $id = session()->get('user_id');
            $isOwnProfile = true;
        }

        $userModel = new UserModel();
        $user = $userModel->find($id);

        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $profileModel = new ProfileModel();
        $reviewModel = new ReviewModel();
        $statsModel = new UserStatModel();

        $data = [
            'user'         => $user,
            'isOwnProfile' => $isOwnProfile,
            'badge'        => $userModel->getBadgeInfo($user),
            'profile'      => $profileModel->getByUserId($id),
            'stats'        => $statsModel->getByUserId($id),
            'reviews'      => $reviewModel->getReviewsForUser($id),
            'title'        => 'Perfil de ' . $user['full_name']
        ];

        return view('profile/view', $data);
    }

    public function settings()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $userId = session()->get('user_id');
        $userModel = new UserModel();
        $profileModel = new ProfileModel();

        if ($this->request->getMethod() === 'POST') {
            $userData = [
                'full_name' => $this->request->getPost('full_name'),
                'email'     => $this->request->getPost('email'),
            ];

            $profileData = [
                'bio'                      => $this->request->getPost('bio'),
                'language'                 => $this->request->getPost('language'),
                'notifications_email'      => $this->request->getPost('notifications_email') ? 1 : 0,
                'notifications_sms'        => $this->request->getPost('notifications_sms') ? 1 : 0,
                'privacy_phone_visibility' => $this->request->getPost('privacy_phone_visibility'),
                'bank_name'                => $this->request->getPost('bank_name'),
                'iban'                     => $this->request->getPost('iban'),
            ];

            // Handle Photo Upload
            $file = $this->request->getFile('photo');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads/profiles', $newName);
                $profileData['photo'] = 'uploads/profiles/' . $newName;
            }

            $userModel->update($userId, $userData);
            $profileModel->where('user_id', $userId)->set($profileData)->update();

            return redirect()->to('/user/settings')->with('success', 'Perfil atualizado com sucesso!');
        }

        $data = [
            'user'    => $userModel->find($userId),
            'profile' => $profileModel->getByUserId($userId),
            'title'   => 'Configurações de Perfil'
        ];

        return view('profile/settings', $data);
    }

    public function verify()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if ($this->request->getMethod() === 'POST') {
            // Logic for document submission
            // ... truncated or handled as before
            return redirect()->to('/dashboard')->with('success', 'Documentos enviados para análise!');
        }

        return view('user/verify');
    }
}
