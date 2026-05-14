<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 *
 * Extend this class in any new controllers:
 * ```
 *     class Home extends BaseController
 * ```
 *
 * For security, be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */

    // protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do not edit this line.
        parent::initController($request, $response, $logger);

        // Sync session flags if logged in
        $this->syncUserSession();

        // Track visit
        $this->trackVisit();
    }

    /**
     * Ensures session flags (is_admin, is_owner, etc.) are in sync with DB.
     */
    protected function syncUserSession(): void
    {
        $session = session();
        if ($session->get('isLoggedIn')) {
            $userId = $session->get('user_id');
            
            // Only sync if new flags are missing (to avoid DB hit on every request)
            // or if we want real-time role updates.
            if ($session->get('is_admin') === null) {
                $userModel = new \App\Models\UserModel();
                $user = $userModel->find($userId);
                
                if ($user) {
                    $session->set([
                        'is_admin'    => (bool) $user['is_admin'],
                        'is_owner'    => (bool) $user['is_owner'],
                        'is_client'   => (bool) $user['is_client'],
                        'active_role' => $session->get('active_role') ?: $user['active_role'] ?: ($user['is_admin'] ? 'admin' : ($user['is_owner'] ? 'owner' : 'client')),
                    ]);
                }
            }

            // Global Notification Count (Messages)
            $messageModel = new \App\Models\MessageModel();
            
            // Se for admin, pode ver a contagem de TODAS as mensagens não lidas no sistema (opcional)
            // Mas seguindo o pedido "ele pode ver todas smsms", vamos permitir que a contagem seja global para o admin
            if ($session->get('user_type') === 'Admin' || $session->get('user_type') === 'Super Admin') {
                $unreadCount = $messageModel->where('read', 0)->countAllResults();
            } else {
                $unreadCount = $messageModel->countUnreadForUser($userId);
            }
            
            // Share with all views
            service('renderer')->setVar('unreadMessages', $unreadCount);
        } else {
            service('renderer')->setVar('unreadMessages', 0);
        }
    }

    protected function trackVisit(): void
    {
        // Avoid tracking AJAX or internal spark requests
        if ($this->request->isAJAX()) {
            return;
        }

        $visitModel = new \App\Models\VisitModel();
        $visitModel->insert([
            'ip_address' => $this->request->getIPAddress(),
            'user_id'    => session()->get('user_id'),
            'page'       => (string) current_url()
        ]);
    }
}
