<?php

namespace App\Controllers;

use App\Models\UserModel;

class Account extends BaseController
{
    /**
     * Switch the current active role for the user.
     */
    public function switchRole($role)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('login');
        }

        $userId = $session->get('user_id');
        $userModel = new UserModel();
        $user = $userModel->find($userId);

        if (!$user) {
            return redirect()->to('login');
        }

        // Validate if user has permission for the requested role
        $canSwitch = false;
        if ($role === 'admin' && $user['is_admin']) $canSwitch = true;
        if ($role === 'owner' && $user['is_owner']) $canSwitch = true;
        if ($role === 'client' && $user['is_client']) $canSwitch = true;

        if ($canSwitch) {
            $session->set('active_role', $role);
            
            // Persist to database
            $userModel->update($userId, ['active_role' => $role]);
            if ($role === 'admin') {
                return redirect()->to('admin/dashboard')->with('success', 'Modo Administrador Ativado');
            } elseif ($role === 'owner') {
                return redirect()->to('dashboard')->with('success', 'Modo Proprietário Ativado');
            } else {
                return redirect()->to('/')->with('success', 'Modo Inquilino Ativado');
            }
        }

        return redirect()->back()->with('error', 'Você não tem permissão para este papel.');
    }
}
