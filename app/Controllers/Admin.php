<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\PropertyModel;
use App\Models\VerificacaoBiModel;
use App\Models\ReportModel;
use App\Models\RentalRequestModel;
use App\Models\VisitModel;
use App\Models\LoginModel;
use App\Models\PropertyViewModel;
use CodeIgniter\HTTP\RedirectResponse;

class Admin extends BaseController
{
    protected UserModel $userModel;
    protected PropertyModel $propertyModel;
    protected VerificacaoBiModel $biModel;
    protected ReportModel $reportModel;
    protected RentalRequestModel $rentalModel;
    protected VisitModel $visitModel;
    protected LoginModel $loginModel;
    protected PropertyViewModel $propertyViewModel;

    public function initController($request, $response, $logger)
    {
        parent::initController($request, $response, $logger);
        $this->userModel     = new UserModel();
        $this->propertyModel = new PropertyModel();
        $this->biModel       = new VerificacaoBiModel();
        $this->reportModel   = new ReportModel();
        $this->rentalModel   = new RentalRequestModel();
        $this->visitModel    = new VisitModel();
        $this->loginModel    = new LoginModel();
        $this->propertyViewModel = new PropertyViewModel();
    }

    /**
     * Ensure the current user is an admin.
     */
    private function ensureAdmin(): void
    {
        $session = session();
        
        // 1. Must be logged in
        if (!$session->get('isLoggedIn')) {
            header('Location: ' . base_url('login'));
            exit;
        }

        // 2. Must HAVE admin master permission (is_admin flag)
        if (!$session->get('is_admin')) {
            header('Location: ' . base_url('/'));
            exit;
        }

        // 3. Must be in Admin MODE (active_role)
        if ($session->get('active_role') !== 'admin') {
            header('Location: ' . base_url('/'));
            exit;
        }
    }

    /**
     * Granular permission check.
     */
    private function checkPermission(string $module): void
    {
        $this->ensureAdmin();
        $role = session()->get('user_type'); // We still use user_type for granularity
        
        if ($role === 'Super Admin' || $role === 'Admin') return;

        $permissions = [
            'Moderador'  => ['dashboard', 'properties', 'reports', 'messages', 'map'],
            'Financeiro' => ['dashboard', 'payments', 'plans', 'stats'],
            'Admin'      => ['dashboard', 'users', 'properties', 'verifications', 'payments', 'plans', 'reports' , 'stats', 'messages', 'map', 'settings', 'notifications']
        ];

        if (!isset($permissions[$role]) || !in_array($module, $permissions[$role])) {
            header('Location: ' . base_url('admin/dashboard'));
            exit;
        }
    }

    // 1. DASHBOARD
    public function dashboard()
    {
        $this->checkPermission('dashboard');

        $data = [
            'totalUsers'         => $this->userModel->countAll(),
            'totalProperties'    => $this->propertyModel->countAll(),
            'activeProperties'   => $this->propertyModel->where('status', 'ativo')->countAllResults(),
            'pendingKYC'         => $this->biModel->where('resultado', 'pendente')->countAllResults(),
            'pendingProps'       => $this->propertyModel->where('status', 'pendente')->countAllResults(),
            
            // Dados para Analytics Simplificado no Painel
            'totalVisits'        => $this->visitModel->countAllResults(),
            'totalLogins'        => $this->loginModel->countAllResults(),
            'totalPropertyViews' => $this->propertyViewModel->countAllResults(),
            
            // Tendências (Últimos 7 dias)
            'dailyVisits'        => $this->visitModel->select("DATE(created_at) as date, COUNT(*) as total")
                                    ->groupBy("date")
                                    ->orderBy("date", "DESC")
                                    ->limit(7)
                                    ->findAll(),
            
            // Dados Adicionais exigidos pela View (Tabs legadas ou resumos)
            'topProperties'      => $this->propertyViewModel->select('property_views.property_id, properties.title, COUNT(property_views.id) as total')
                                    ->join('properties', 'properties.id = property_views.property_id')
                                    ->groupBy('property_views.property_id, properties.title')
                                    ->orderBy('total', 'DESC')
                                    ->limit(5)
                                    ->findAll(),
            'allProperties'      => $this->propertyModel->orderBy('created_at', 'DESC')->limit(10)->findAll(),
            'recentReports'      => $this->reportModel->select('reports.*, properties.title')
                                    ->join('properties', 'properties.id = reports.property_id')
                                    ->orderBy('reports.created_at', 'DESC')
                                    ->limit(5)
                                    ->findAll(),
            'allUsers'           => $this->userModel->orderBy('created_at', 'DESC')->limit(10)->findAll(),
        ];

        return view('admin/dashboard', $data);
    }

    public function analytics()
    {
        $this->checkPermission('stats');
        
        $data = [
            'registrationTrend' => $this->userModel->select("DATE(created_at) as date, COUNT(*) as total")
                                        ->groupBy("date")
                                        ->orderBy("date", "ASC")
                                        ->limit(30)
                                        ->findAll(),
            'propertyStatusDist' => $this->propertyModel->select("status, COUNT(*) as total")
                                         ->groupBy("status")
                                         ->findAll(),
            'totalRevenue'      => 500000, // Placeholder for financial integration
        ];

        return view('admin/analytics', $data);
    }

    public function dashboardReports()
    {
        $this->checkPermission('reports');
        return view('admin/dashboard_reports');
    }

    // 2. USUÁRIOS
    public function users()
    {
        $this->checkPermission('users');
        $status = $this->request->getGet('status');
        
        $builder = $this->userModel->orderBy('created_at', 'DESC');
        if ($status === 'verified') $builder->where('status', 'verificado');
        if ($status === 'pending') $builder->where('bi_status', 'pendente');
        if ($status === 'blocked') $builder->where('status', 'bloqueado');

        return view('admin/users/index', [
            'users' => $builder->findAll(), 
            'filterStatus' => $status
        ]);
    }

    public function userCreate() { $this->ensureAdmin(); return view('admin/users/create'); }
    public function userView($id) { $this->ensureAdmin(); return view('admin/users/view', ['user' => $this->userModel->find($id)]); }
    public function userEdit($id) { $this->ensureAdmin(); return view('admin/users/edit', ['user' => $this->userModel->find($id)]); }
    public function userVerify($id) { $this->ensureAdmin(); /* Logic */ return redirect()->back(); }
    public function userBlock($id) { $this->ensureAdmin(); /* Logic */ return redirect()->back(); }
    public function userDelete($id) { $this->ensureAdmin(); /* Logic */ return redirect()->back(); }

    // 3. IMÓVEIS
    public function properties()
    {
        $this->checkPermission('properties');
        $status = $this->request->getGet('status');
        
        $builder = $this->propertyModel->orderBy('created_at', 'DESC');
        if ($status) $builder->where('status', $status);

        return view('admin/properties/index', [
            'properties' => $builder->findAll(), 
            'filterStatus' => $status
        ]);
    }

    public function propertiesPending() { return $this->propertiesByStatus('pending'); }
    public function propertiesApproved() { return $this->propertiesByStatus('active'); }
    public function propertiesRejected() { return $this->propertiesByStatus('rejected'); }

    private function propertiesByStatus($status)
    {
        $this->ensureAdmin();
        $props = $this->propertyModel->where('status', $status)->findAll();
        return view('admin/properties/index', ['properties' => $props, 'filterStatus' => $status]);
    }

    public function propertyView($id) { $this->ensureAdmin(); return view('admin/properties/view', ['property' => $this->propertyModel->find($id)]); }
    public function propertyEdit($id) { $this->ensureAdmin(); return view('admin/properties/edit', ['property' => $this->propertyModel->find($id)]); }
    public function propertyDelete($id) { $this->ensureAdmin(); $this->propertyModel->delete($id); return redirect()->to('/admin/properties'); }

    public function approveProperty($id)
    {
        $this->ensureAdmin();
        $this->propertyModel->update($id, ['status' => 'active', 'is_verified' => 1]);
        return redirect()->back()->with('success', 'Imóvel aprovado.');
    }

    public function rejectProperty($id)
    {
        $this->ensureAdmin();
        $this->propertyModel->update($id, ['status' => 'rejected']);
        return redirect()->back()->with('error', 'Imóvel rejeitado.');
    }

    // 4. VERIFICAÇÕES (KYC)
    public function verificationQueue()
    {
        $this->checkPermission('verifications');
        $pending = $this->biModel->where('resultado', 'pendente')->findAll();
        return view('admin/verifications/index', ['submissions' => $pending]);
    }

    public function verificationsPending() { return $this->verificationQueue(); }
    public function verificationsApproved() 
    { 
        $this->ensureAdmin();
        $approved = $this->biModel->where('resultado', 'aprovado')->findAll();
        return view('admin/verifications/index', ['submissions' => $approved]);
    }
    public function verificationsRejected()
    {
        $this->ensureAdmin();
        $rejected = $this->biModel->where('resultado', 'rejeitado')->findAll();
        return view('admin/verifications/index', ['submissions' => $rejected]);
    }

    public function reviewVerification($id)
    {
        $this->ensureAdmin();
        $verification = $this->biModel->find($id);
        if (! $verification) return redirect()->to('/admin/verifications')->with('error', 'não encontrada.');
        $user = $this->userModel->find($verification['user_id']);
        return view('admin/verifications/view', ['verification' => $verification, 'user' => $user]);
    }

    public function approveVerification($id)
    {
        $this->ensureAdmin();
        $this->biModel->update($id, ['resultado' => 'aprovado']);
        $ver = $this->biModel->find($id);
        $this->userModel->update($ver['user_id'], ['bi_status' => 'aprovado', 'status' => 'verificado']);
        return redirect()->to('/admin/verifications')->with('success', 'Aprovada.');
    }

    public function rejectVerification($id)
    {
        $this->ensureAdmin();
        $this->biModel->update($id, ['resultado' => 'rejeitado']);
        $ver = $this->biModel->find($id);
        $this->userModel->update($ver['user_id'], ['bi_status' => 'rejeitado']);
        return redirect()->to('/admin/verifications')->with('error', 'Rejeitada.');
    }

    // Serve BI Image
    public function serveImage($filename)
    {
        $this->ensureAdmin();
        $path = WRITEPATH . 'uploads/bi/' . $filename;
        if (! is_file($path)) throw new \CodeIgniter\Exceptions\PageNotFoundException();
        return $this->response->setHeader('Content-Type', mime_content_type($path))->setBody(file_get_contents($path));
    }

    // 5. PAGAMENTOS
    public function paymentsQueue()
    {
        $this->checkPermission('payments');
        $paymentModel = new \App\Models\PaymentModel();
        
        $payments = $paymentModel->select('payments.*, users.full_name as user_name')
                                 ->join('users', 'users.id = payments.user_id')
                                 ->orderBy('payments.created_at', 'DESC')
                                 ->findAll();
        
        $totalStats = $paymentModel->selectSum('amount', 'total')->first() ?: ['total' => 0];
        
        return view('admin/payments/index', [
            'payments'   => $payments,
            'totalStats' => $totalStats
        ]);
    }

    public function paymentsPending() { return $this->paymentsByStatus('pending'); }
    public function paymentsApproved() { return $this->paymentsByStatus('approved'); }
    public function paymentsRejected() { return $this->paymentsByStatus('rejected'); }

    private function paymentsByStatus($status)
    {
        $this->ensureAdmin();
        $paymentModel = new \App\Models\PaymentModel();
        $payments = $paymentModel->select('payments.*, users.full_name as user_name')
                                 ->join('users', 'users.id = payments.user_id')
                                 ->where('payments.status', $status)
                                 ->orderBy('payments.created_at', 'DESC')
                                 ->findAll();
        
        $totalStats = $paymentModel->selectSum('amount', 'total')->first() ?: ['total' => 0];

        return view('admin/payments/index', [
            'payments'     => $payments, 
            'filterStatus' => $status,
            'totalStats'   => $totalStats
        ]);
    }

    public function paymentView($id) { $this->ensureAdmin(); return view('admin/payments/view'); }

    public function processPaymentAction($id, $action)
    {
        $this->ensureAdmin();
        $paymentModel = new \App\Models\PaymentModel();
        $payment = $paymentModel->find($id);
        if (!$payment) return redirect()->back();

        if ($action === 'approve') {
            $paymentModel->update($id, ['status' => 'approved']);
            // Complex activation logic...
            return redirect()->back()->with('success', 'Aprovado.');
        } else {
            $paymentModel->update($id, ['status' => 'rejected']);
            return redirect()->back()->with('error', 'Rejeitado.');
        }
    }

    // 6. PLANOS
    public function plans()
    {
        $this->checkPermission('plans');
        $planModel = new \App\Models\PlanModel();
        return view('admin/plans/index', ['plans' => $planModel->findAll()]);
    }
    public function planCreate() { $this->ensureAdmin(); return view('admin/plans/create'); }
    public function planEdit($id) { $this->ensureAdmin(); return view('admin/plans/edit'); }
    public function planDelete($id) { $this->ensureAdmin(); return redirect()->back(); }
    public function planToggle($id) { $this->ensureAdmin(); return redirect()->back(); }

    // 7. DENÚNCIAS
    public function reportsQueue()
    {
        $this->checkPermission('reports');
        $data = [
            'reports' => $this->reportModel->getReportsWithDetails('pendente'),
            'counts'  => [
                'pendente'   => $this->reportModel->where('status', 'pendente')->countAllResults(),
                'em_analise' => $this->reportModel->where('status', 'em_analise')->countAllResults(),
                'resolvido'  => $this->reportModel->where('status', 'resolvido')->countAllResults(),
            ]
        ];
        return view('admin/reports/index', $data);
    }
    public function reportView($id) { $this->ensureAdmin(); return view('admin/reports/view'); }
    public function reportDelete($id) { $this->ensureAdmin(); $this->reportModel->delete($id); return redirect()->back(); }
    public function updateReport($id)
    {
        $this->ensureAdmin();
        $this->reportModel->update($id, ['status' => $this->request->getPost('status')]);
        return redirect()->back();
    }

    // 8. ESTATÍSTICAS
    public function stats() 
    { 
        $this->checkPermission('stats'); 
        
        $data = [
            'usersByType' => $this->userModel->select("user_type, COUNT(*) as total")
                                  ->groupBy("user_type")
                                  ->findAll(),
            'propertyCategories' => $this->propertyModel->select("type, COUNT(*) as total")
                                        ->groupBy("type")
                                        ->findAll(),
            'monthlyVisits' => $this->visitModel->select("MONTH(created_at) as month, COUNT(*) as total")
                                    ->groupBy("month")
                                    ->findAll(),
        ];

        return view('admin/stats/index', $data); 
    }
    public function statsVisits() { $this->ensureAdmin(); return view('admin/stats/visits'); }
    public function statsUsers() { $this->ensureAdmin(); return view('admin/stats/users'); }
    public function statsProperties() { $this->ensureAdmin(); return view('admin/stats/properties'); }
    public function statsPayments() { $this->ensureAdmin(); return view('admin/stats/payments'); }

    // 9. MENSAGENS
    public function messages()
    {
        $this->checkPermission('messages');
        $convModel = new \App\Models\ConversationModel();
        return view('admin/messages/index', ['conversations' => $convModel->findAll()]);
    }
    public function messageView($id) 
    { 
        $this->ensureAdmin(); 
        $convModel = new \App\Models\ConversationModel();
        $msgModel = new \App\Models\MessageModel();
        $userModel = new \App\Models\UserModel();
        $propModel = new \App\Models\PropertyModel();

        $conversation = $convModel->find($id);
        if (!$conversation) return redirect()->to('/admin/messages')->with('error', 'Conversa não encontrada.');

        $data = [
            'conversation' => $conversation,
            'messages'     => $msgModel->getMessagesForConversation($id),
            'tenant'       => $userModel->find($conversation['tenant_id']),
            'owner'        => $userModel->find($conversation['owner_id']),
            'property'     => $propModel->find($conversation['property_id'])
        ];

        return view('admin/messages/view', $data); 
    }
    public function messageBlock($id) { $this->ensureAdmin(); return redirect()->back(); }

    // 10. MAPA
    public function map() { $this->checkPermission('map'); return view('admin/map/index'); }
    public function mapProperties() { $this->ensureAdmin(); return view('admin/map/properties'); }
    public function mapHeatmap() { $this->ensureAdmin(); return view('admin/map/heatmap'); }

    // 11. CONFIGURAÇÕES
    public function settings() { $this->checkPermission('settings'); return view('admin/settings/general'); }
    public function settingsGeneral() { return $this->settings(); }
    public function settingsPayments() { $this->ensureAdmin(); return view('admin/settings/payments'); }
    public function settingsSecurity() { $this->ensureAdmin(); return view('admin/settings/security'); }
    public function settingsLimits() { $this->ensureAdmin(); return view('admin/settings/limits'); }
    public function settingsEmail() { $this->ensureAdmin(); return view('admin/settings/email'); }

    // 12. LOGS DO SISTEMA
    public function logs()
    {
        $this->checkPermission('logs');
        return view('admin/logs/index', ['logs' => $this->loginModel->limit(100)->findAll()]);
    }
    public function logsLogins() { return $this->logs(); }
    public function logsErrors() { $this->ensureAdmin(); return view('admin/logs/errors'); }
    public function logsActions() { $this->ensureAdmin(); return view('admin/logs/actions'); }

    // 13. NOTIFICAÇÕES
    public function notifications() { $this->checkPermission('notifications'); return view('admin/notifications/index'); }
    public function notificationSend() { $this->ensureAdmin(); return view('admin/notifications/send'); }

    // 14. ADMINISTRADORES
    public function admins() { $this->checkPermission('admins'); return view('admin/admins/index'); }
    public function adminCreate() { $this->ensureAdmin(); return view('admin/admins/create'); }
    public function adminEdit($id) { $this->ensureAdmin(); return view('admin/admins/edit'); }
    public function adminDelete($id) { $this->ensureAdmin(); return redirect()->back(); }
}
?>
