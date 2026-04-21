<?php

namespace App\Controllers;

use App\Models\PropertyModel;
use App\Models\EscrowModel;
use App\Models\RentalRequestModel;
use App\Models\UserModel;
use CodeIgniter\Controller;

class Checkout extends BaseController
{
    protected PropertyModel      $propertyModel;
    protected EscrowModel        $escrowModel;
    protected RentalRequestModel $rentalModel;
    protected UserModel          $userModel;

    public function initController(
        \CodeIgniter\HTTP\RequestInterface $request,
        \CodeIgniter\HTTP\ResponseInterface $response,
        \Psr\Log\LoggerInterface $logger
    ): void {
        parent::initController($request, $response, $logger);
        
        $this->propertyModel = new PropertyModel();
        $this->escrowModel   = new EscrowModel();
        $this->rentalModel   = new RentalRequestModel();
        $this->userModel     = new UserModel();
    }

    public function index($propertyId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Inicie sessão para reservar um imóvel.');
        }

        $property = $this->propertyModel->find($propertyId);

        if (!$property) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['property'] = $property;
        return view('checkout/index', $data);
    }

    /**
     * Step 1: Initialize Payment & Show Confirmation Page
     */
    public function process($propertyId)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $property = $this->propertyModel->find($propertyId);
        $userId   = session()->get('user_id');

        // Simple validation
        if (!$property) return redirect()->back()->with('error', 'Imóvel não encontrado.');

        // For MVP: Check if the user is verified (Optional for tenant, but recommended)
        $user = $this->userModel->find($userId);
        
        $paymentMethod = $this->request->getPost('payment_method') ?: 'mcx';
        $totalAmount = $property['price'] * 2;
        
        if ($paymentMethod === 'iban') {
            $paymentData = [
                'method' => 'iban',
                'status' => 'waiting_proof',
                'sys_ref_id' => 'RR-' . time() . '-' . $userId
            ];
        } else {
            $proxyPay = new \App\Libraries\ProxyPay();
            $sysRef = 'RR-' . time() . '-' . $userId;
            $paymentData = $proxyPay->generateReference($totalAmount, $sysRef);
            $paymentData['method'] = 'mcx';
        }

        // Generate a Temporary Rental Request
        $data = [
            'property_id'    => $propertyId,
            'tenant_id'      => $userId,
            'owner_id'       => $property['owner_id'],
            'status'         => 'pending',
            'monthly_rent'   => $property['price'],
            'deposit_amount' => $property['price'],
            'total_amount'   => $totalAmount,
            'payment_intent_id' => json_encode($paymentData)
        ];

        $requestId = $this->rentalModel->insert($data);

        return redirect()->to("/checkout/confirm/{$requestId}");
    }

    /**
     * Step 2: Show Simulation of Multicaixa Express
     */
    public function confirm($requestId)
    {
        $request = $this->rentalModel->select('rental_requests.*, p.title, p.price')
                                     ->join('properties p', 'p.id = rental_requests.property_id')
                                     ->find($requestId);

        if (!$request) return redirect()->to('/')->with('error', 'Pedido não encontrado.');

        $paymentData = !empty($request['payment_intent_id']) ? json_decode($request['payment_intent_id'], true) : [];

        return view('checkout/confirmation', ['r' => $request, 'payment' => $paymentData]);
    }

    /**
     * Step 3: Complete Payment (Simulation)
     */
    public function complete($requestId)
    {
        $request = $this->rentalModel->find($requestId);
        if (!$request) return redirect()->to('/');

        // 1. Update Request Status
        $this->rentalModel->update($requestId, ['status' => 'paid']);

        // 2. Create Escrow Entry
        $this->escrowModel->insert([
            'rental_request_id' => $requestId,
            'amount'            => $request['total_amount'],
            'status'            => 'held',
            'payment_method'    => 'Multicaixa Express',
            'transaction_id'    => 'CS-' . strtoupper(bin2hex(random_bytes(4))),
            'release_code'      => strtoupper(substr(md5(time().$requestId), 0, 8))
        ]);

        return redirect()->to('/checkout/success');
    }

    public function uploadProof($requestId)
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $request = $this->rentalModel->find($requestId);
        if (!$request) return redirect()->to('/');

        $file = $this->request->getFile('proof_receipt');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            if (!is_dir(FCPATH . 'uploads/receipts')) mkdir(FCPATH . 'uploads/receipts', 0777, true);
            $file->move(FCPATH . 'uploads/receipts', $newName);
            
            $paymentData = json_decode($request['payment_intent_id'], true) ?? [];
            $paymentData['receipt_path'] = 'uploads/receipts/' . $newName;
            $paymentData['status'] = 'verifying_receipt';
            
            // Save receipt and change status
            $this->rentalModel->update($requestId, [
                'payment_intent_id' => json_encode($paymentData),
                'status' => 'verifying_receipt'
            ]);
            
            return redirect()->to("/checkout/confirm/{$requestId}")->with('success', 'Comprovativo enviado com sucesso! A aguardar validação manual da nossa equipa.');
        }

        return redirect()->back()->with('error', 'Falha ao fazer upload do comprovativo. Tente novamente.');
    }

    public function status($requestId)
    {
        $request = $this->rentalModel->find($requestId);
        if (!$request) return $this->response->setJSON(['status' => 'error']);

        return $this->response->setJSON([
            'status' => $request['status'] // 'pending', 'paid', etc.
        ]);
    }

    public function success()
    {
        return view('checkout/success');
    }
}
