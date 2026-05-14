<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ─── Página inicial ───────────────────────────────────────────────────────────
$routes->get('switch-role/(:segment)', 'Account::switchRole/$1');
$routes->get('/', 'Home::index');
$routes->get('vender', 'Home::vender');
$routes->get('sobre',  'Home::sobre');
$routes->get('ajuda',  'Home::ajuda');
$routes->get('termos', 'Home::termos');
$routes->get('privacidade', 'Home::privacidade');

// ─── Imóveis ──────────────────────────────────────────────────────────────────
$routes->get('comprar',                'Property::category/sell');
$routes->get('alugar',                 'Property::category/rent');
$routes->get('property/create',        'Property::create', ['filter' => 'auth']);
$routes->post('property/store',         'Property::store',  ['filter' => 'auth']);
$routes->get('property/(:num)',        'Property::view/$1');
$routes->post('property/favorite/(:num)', 'Property::toggleFavorite/$1', ['filter' => 'auth']);
$routes->get('search',                 'Property::search');

// ─── Autenticação — Registo multi-passo ──────────────────────────────────────
$routes->get('signup',             'Auth::showRegisterStep1', ['filter' => 'guest']);
$routes->post('auth/step1',        'Auth::processStep1');
$routes->get('auth/verify-otp',    'Auth::showVerifyOtp');
$routes->post('auth/verify-otp',   'Auth::processVerifyOtp');
$routes->get('auth/step2',         'Auth::showRegisterStep2');
$routes->post('auth/step2',         'Auth::processStep2');
$routes->post('auth/register',      'Auth::processStep2'); // Alias for compatibility
$routes->get('auth/verify-bi',     'Auth::showBiUpload',      ['filter' => 'auth']);
$routes->post('auth/verify-bi',    'Auth::processBiUpload',   ['filter' => 'auth']);

// ─── Autenticação — Login ─────────────────────────────────────────────────────
$routes->get('login',              'Auth::showLogin',         ['filter' => 'guest']);
$routes->post('auth/login',        'Auth::processLogin');
$routes->post('auth/send-otp',     'Auth::sendLoginOtp');
$routes->post('auth/login-otp',    'Auth::processLoginOtp');
$routes->get('logout',             'Auth::logout');

// ─── Autenticação — Recuperação de senha ─────────────────────────────────────
$routes->get('forgot-password',    'Auth::showForgotPassword',['filter' => 'guest']);
$routes->get('auth/forgot-password', 'Auth::showForgotPassword',['filter' => 'guest']);
$routes->post('auth/forgot',       'Auth::processForgotPassword');
$routes->get('auth/reset',         'Auth::showResetPassword');
$routes->post('auth/reset',        'Auth::processResetPassword');

// ─── Área do utilizador (protegida) ──────────────────────────────────────────
$routes->get('dashboard',          'User::dashboard',         ['filter' => 'auth']);
$routes->get('user/profile', 'User::profile', ['filter' => 'auth']);
$routes->get('user/settings', 'User::settings', ['filter' => 'auth']);
$routes->post('user/settings', 'User::settings', ['filter' => 'auth']);
$routes->get('user/verify', 'User::verify', ['filter' => 'auth']);
$routes->post('user/verify', 'User::verify', ['filter' => 'auth']);
$routes->get('user/profile/(:num)', 'User::profile/$1');
$routes->get('profile/(:num)',     'User::profile/$1');
$routes->get('verify',             'User::verify',            ['filter' => 'auth']);
$routes->get('user/release-escrow/(:num)', 'User::releaseEscrow/$1', ['filter' => 'auth']);
$routes->get('favorites', 'User::favorites', ['filter' => 'auth']);

// ─── Chat (protegido) ─────────────────────────────────────────────────────────
$routes->get('chat',               'Chat::index',             ['filter' => 'auth']);
$routes->get('chat/view/(:num)',   'Chat::view/$1',           ['filter' => 'auth']);
$routes->post('chat/send/(:num)',  'Chat::send/$1',           ['filter' => 'auth']);
$routes->get('chat/start/(:num)', 'Chat::start/$1',          ['filter' => 'auth']);

// ─── Checkout & Contrato (protegido) ─────────────────────────────────────────
$routes->get('checkout/(:num)',     'Checkout::index/$1',     ['filter' => 'auth']);
$routes->post('checkout/process/(:num)', 'Checkout::process/$1', ['filter' => 'auth']);
$routes->get('checkout/confirm/(:num)', 'Checkout::confirm/$1', ['filter' => 'auth']);
$routes->post('checkout/complete/(:num)', 'Checkout::complete/$1', ['filter' => 'auth']);
$routes->post('checkout/uploadProof/(:num)', 'Checkout::uploadProof/$1', ['filter' => 'auth']);
$routes->get('checkout/success',   'Checkout::success',      ['filter' => 'auth']);
$routes->get('checkout/status/(:num)', 'Checkout::status/$1', ['filter' => 'auth']);
$routes->get('contract/generate/(:num)', 'Contract::generate/$1', ['filter' => 'auth']);

// ─── API Webhooks ────────────────────────────────────────────────────────────
$routes->post('api/webhooks/proxypay', 'Webhook::proxypay');

// ─── Reviews ──────────────────────────────────────────────────────────────────
$routes->get('review/submit/(:num)',  'Review::submit/$1',  ['filter' => 'auth']);
$routes->post('review/submit/(:num)', 'Review::submit/$1',  ['filter' => 'auth']);

// ─── Admin Group ──────────────────────────────────────────────────────────────
$routes->group('admin', function ($routes) {
    // 1. PAINEL DE CONTROLE
    $routes->get('painel-de-controle',     'Admin::dashboard');
    $routes->get('dashboard',              'Admin::dashboard');
    $routes->get('dashboard/analytics',    'Admin::analytics');
    $routes->get('dashboard/reports',      'Admin::dashboardReports');

    // 2. USUÁRIOS
    $routes->get('usuários',               'Admin::users');
    $routes->get('users',                  'Admin::users');
    $routes->get('users/create',           'Admin::userCreate');
    $routes->get('users/view/(:num)',      'Admin::userView/$1');
    $routes->get('users/edit/(:num)',      'Admin::userEdit/$1');
    $routes->get('users/verify/(:num)',    'Admin::userVerify/$1');
    $routes->get('users/block/(:num)',     'Admin::userBlock/$1');
    $routes->get('users/delete/(:num)',    'Admin::userDelete/$1');

    // 3. IMÓVEIS
    $routes->get('propriedades',           'Admin::properties');
    $routes->get('properties',             'Admin::properties');
    $routes->get('properties/pending',     'Admin::propertiesPending');
    $routes->get('properties/approved',    'Admin::propertiesApproved');
    $routes->get('properties/rejected',    'Admin::propertiesRejected');
    $routes->get('properties/view/(:num)', 'Admin::propertyView/$1');
    $routes->get('properties/edit/(:num)', 'Admin::propertyEdit/$1');
    $routes->get('properties/approve/(:num)','Admin::approveProperty/$1');
    $routes->get('properties/reject/(:num)', 'Admin::rejectProperty/$1');
    $routes->get('properties/delete/(:num)', 'Admin::propertyDelete/$1');

    // 4. VERIFICAÇÕES (KYC)
    $routes->get('verificações',           'Admin::verificationQueue');
    $routes->get('verificações/pendentes', 'Admin::verificationsPending');
    $routes->get('verificações/aprovadas', 'Admin::verificationsApproved');
    $routes->get('verificações/rejeitadas', 'Admin::verificationsRejected');
    $routes->get('verificações/visualizar/(:num)', 'Admin::reviewVerification/$1');
    $routes->get('verificações/aprovar/(:num)', 'Admin::approveVerification/$1');
    $routes->get('verificações/rejeitar/(:num)', 'Admin::rejectVerification/$1');
    
    // Alisases para compatibilidade
    $routes->get('verifications',          'Admin::verificationQueue');
    $routes->get('verifications/pending',  'Admin::verificationsPending');
    $routes->get('verifications/approved', 'Admin::verificationsApproved');
    $routes->get('verifications/rejected', 'Admin::verificationsRejected');
    $routes->get('verifications/view/(:num)', 'Admin::reviewVerification/$1');
    $routes->post('verifications/approve/(:num)', 'Admin::approveVerification/$1');
    $routes->post('verifications/reject/(:num)', 'Admin::rejectVerification/$1');
    
    // Serve BI Image
    $routes->get('view-bi/(:any)',         'Admin::serveImage/$1');

    // 5. PAGAMENTOS
    $routes->get('pagamentos',             'Admin::paymentsQueue');
    $routes->get('pagamentos/pendentes',   'Admin::paymentsPending');
    $routes->get('pagamentos/aprovados',   'Admin::paymentsApproved');
    $routes->get('pagamentos/rejeitados',  'Admin::paymentsRejected');
    $routes->get('pagamentos/visualizar/(:num)', 'Admin::paymentView/$1');
    $routes->get('pagamentos/aprovar/(:num)',    'Admin::processPaymentAction/$1/approve');
    $routes->get('pagamentos/rejeitar/(:num)',   'Admin::processPaymentAction/$1/reject');

    $routes->get('payments',               'Admin::paymentsQueue');
    $routes->get('payments/pending',       'Admin::paymentsPending');
    $routes->get('payments/approved',      'Admin::paymentsApproved');
    $routes->get('payments/rejected',      'Admin::paymentsRejected');
    $routes->get('payments/view/(:num)',   'Admin::paymentView/$1');
    $routes->post('payments/approve/(:num)', 'Admin::processPaymentAction/$1/approve');
    $routes->post('payments/reject/(:num)',  'Admin::processPaymentAction/$1/reject');

    // 6. PLANOS
    $routes->get('planos',                 'Admin::plans');
    $routes->get('plans',                  'Admin::plans');
    $routes->get('plans/create',           'Admin::planCreate');
    $routes->get('plans/edit/(:num)',      'Admin::planEdit/$1');
    $routes->get('plans/delete/(:num)',    'Admin::planDelete/$1');
    $routes->get('plans/toggle/(:num)',    'Admin::planToggle/$1');

    // 7. DENÚNCIAS
    $routes->get('relatórios',             'Admin::reportsQueue');
    $routes->get('reports',                'Admin::reportsQueue');
    $routes->get('reports/view/(:num)',    'Admin::reportView/$1');
    $routes->post('reports/resolve/(:num)', 'Admin::updateReport/$1');
    $routes->get('reports/delete/(:num)',  'Admin::reportDelete/$1');

    // 8. ESTATÍSTICAS
    $routes->get('stats',                  'Admin::stats');
    $routes->get('stats/visitas',           'Admin::statsVisits');
    $routes->get('stats/usuários',          'Admin::statsUsers');
    $routes->get('stats/propriedades',       'Admin::statsProperties');
    $routes->get('stats/pagamentos',         'Admin::statsPayments');

    // 9. MENSAGENS
    $routes->get('mensagens',              'Admin::messages');
    $routes->get('mensagens/visualizar/(:num)', 'Admin::messageView/$1');
    $routes->get('mensagens/bloquear/(:num)',   'Admin::messageBlock/$1');
    
    $routes->get('messages',               'Admin::messages');
    $routes->get('messages/view/(:num)',   'Admin::messageView/$1');
    $routes->get('messages/block/(:num)',  'Admin::messageBlock/$1');

    // 10. MAPA
    $routes->get('mapa',                   'Admin::map');
    $routes->get('map',                    'Admin::map');
    $routes->get('map/properties',         'Admin::mapProperties');
    $routes->get('map/heatmap',            'Admin::mapHeatmap');

    // 11. CONFIGURAÇÕES
    $routes->get('configurações',           'Admin::settings');
    $routes->get('configurações/geral',     'Admin::settingsGeneral');
    $routes->get('configurações/pagamentos', 'Admin::settingsPayments');
    $routes->get('configurações/segurança',  'Admin::settingsSecurity');
    $routes->get('configurações/limites',    'Admin::settingsLimits');
    $routes->get('configurações/email',      'Admin::settingsEmail');
    
    $routes->get('settings',               'Admin::settings');
    $routes->get('settings/general',       'Admin::settingsGeneral');
    $routes->get('settings/payments',      'Admin::settingsPayments');
    $routes->get('settings/security',      'Admin::settingsSecurity');
    $routes->get('settings/limits',        'Admin::settingsLimits');
    $routes->get('settings/email',         'Admin::settingsEmail');

    // 12. LOGS DO SISTEMA
    $routes->get('logs',                   'Admin::logs');
    $routes->get('logs/logins',            'Admin::logsLogins');
    $routes->get('logs/errors',            'Admin::logsErrors');
    $routes->get('logs/actions',           'Admin::logsActions');

    // 13. NOTIFICAÇÕES
    $routes->get('notificações',           'Admin::notifications');
    $routes->get('notifications',          'Admin::notifications');
    $routes->get('notifications/send',     'Admin::notificationSend');

    // 14. ADMINISTRADORES
    $routes->get('admins',                 'Admin::admins');
    $routes->get('admins/create',          'Admin::adminCreate');
    $routes->get('admins/edit/(:num)',     'Admin::adminEdit/$1');
    $routes->get('admins/delete/(:num)',   'Admin::adminDelete/$1');

    // 15. SESSÃO
    $routes->get('logout',                 'Auth::logout');
});

// ─── Denúncia de imóvel ───────────────────────────────────────────────────────
$routes->post('property/report/(:num)', 'Property::report/$1', ['filter' => 'auth']);

// ─── Payment & Plans ─────────────────────────────────────────────────────────
$routes->get('plans',                 'Payment::plans');
$routes->get('payment/checkout/(:any)/(:num)', 'Payment::checkout/$1/$2', ['filter' => 'auth']);
$routes->post('payment/process',      'Payment::processPayment',   ['filter' => 'auth']);
$routes->get('payment/instructions/(:num)', 'Payment::instructions/$1', ['filter' => 'auth']);
$routes->post('payment/upload/(:num)', 'Payment::uploadProof/$1',  ['filter' => 'auth']);
$routes->get('payment/status/(:num)', 'Payment::status/$1',        ['filter' => 'auth']);
$routes->get('property/pay/(:num)',    'Payment::checkout/rent/$1', ['filter' => 'auth']);

// ─── Proximidade (Casas Perto de Mim) ─────────────────────────────────────────
$routes->get('near-me',               'NearMe::index');
$routes->get('api/near-me',           'NearMe::getProperties');
