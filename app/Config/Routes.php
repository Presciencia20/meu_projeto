<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ─── Página inicial ───────────────────────────────────────────────────────────
$routes->get('/', 'Home::index');
$routes->get('vender', 'Home::vender');
$routes->get('sobre',  'Home::sobre');

// ─── Imóveis ──────────────────────────────────────────────────────────────────
$routes->get('comprar',                'Property::category/sell');
$routes->get('alugar',                 'Property::category/rent');
$routes->get('property/create',        'Property::create', ['filter' => 'auth']);
$routes->post('property/store',         'Property::store',  ['filter' => 'auth']);
$routes->get('property/(:num)',        'Property::view/$1');
$routes->get('search',                 'Property::search');

// ─── Autenticação — Registo multi-passo ──────────────────────────────────────
$routes->get('signup',             'Auth::showRegisterStep1', ['filter' => 'guest']);
$routes->post('auth/step1',        'Auth::processStep1');
$routes->get('auth/verify-otp',    'Auth::showVerifyOtp');
$routes->post('auth/verify-otp',   'Auth::processVerifyOtp');
$routes->get('auth/step2',         'Auth::showRegisterStep2');
$routes->post('auth/step2',        'Auth::processStep2');
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

// ─── Admin ────────────────────────────────────────────────────────────────────
$routes->get('admin/dashboard',              'Admin::dashboard');
$routes->get('admin/verifications',          'Admin::verificationQueue');
$routes->get('admin/review-verification/(:num)', 'Admin::reviewVerification/$1');
$routes->post('admin/approve-verification/(:num)', 'Admin::approveVerification/$1');
$routes->post('admin/reject-verification/(:num)', 'Admin::rejectVerification/$1');
$routes->get('admin/view-bi/(:any)',          'Admin::serveImage/$1');
$routes->get('admin/escrow',                 'Admin::escrow');
$routes->get('admin/refund-escrow/(:num)',    'Admin::refundEscrow/$1');
$routes->get('admin/approve-user/(:num)',    'Admin::approveUser/$1');
$routes->get('admin/approve-property/(:num)','Admin::approveProperty/$1');
$routes->get('admin/reject-property/(:num)', 'Admin::rejectProperty/$1');
$routes->get('admin/receipts',               'Admin::receipts');
$routes->get('admin/validate-receipt/(:num)/(:segment)', 'Admin::validateReceipt/$1/$2');
