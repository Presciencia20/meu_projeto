<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Payment extends BaseController
{
    protected $planModel;
    protected $paymentModel;
    protected $bookingModel;
    protected $propertyModel;

    public function __construct()
    {
        $this->planModel     = new \App\Models\PlanModel();
        $this->paymentModel  = new \App\Models\PaymentModel();
        $this->bookingModel  = new \App\Models\BookingModel();
        $this->propertyModel = new \App\Models\PropertyModel();
    }

    public function plans()
    {
        $data['plans'] = $this->planModel->findAll();
        return view('payment/plans', $data);
    }

    public function checkout($type, $id)
    {
        $amount = 0;
        $title  = "";

        if ($type === 'plan') {
            $plan = $this->planModel->find($id);
            if (!$plan) return redirect()->to('/plans');
            $amount = $plan['price'];
            $title  = "Assinatura Plano " . $plan['name'];

            // Handle Free Plan Auto-Activation
            if ($amount <= 0) {
                $userModel = new \App\Models\UserModel();
                $userModel->update(session()->get('user_id'), ['user_type' => 'Simples']);
                return redirect()->to('/dashboard')->with('success', 'Plano Simples ativado com sucesso! Bons negócios.');
            }
        } else {
            $prop = $this->propertyModel->find($id);
            if (!$prop) return redirect()->to('/');
            // Renter flow: Create a booking first if not exists
            $amount = $prop['price']; // First month example
            $title  = "Arrendamento: " . $prop['title'];
        }

        return view('payment/checkout', [
            'type'   => $type,
            'id'     => $id,
            'amount' => $amount,
            'title'  => $title
        ]);
    }

    public function processPayment()
    {
        $type   = $this->request->getPost('type');
        $id     = $this->request->getPost('id');
        $method = $this->request->getPost('method');
        $amount = $this->request->getPost('amount');
        $userId = session()->get('user_id');

        $ref = ($method === 'paypay') ? 'PAY-' . strtoupper(bin2hex(random_bytes(4))) : 'EXP-' . rand(100000, 999999);

        // For Rent flow, create booking
        $relatedId = $id;
        if ($type === 'rent') {
            $prop = $this->propertyModel->find($id);
            $bookingId = $this->bookingModel->insert([
                'property_id' => $id,
                'tenant_id'   => $userId,
                'owner_id'    => $prop['owner_id'],
                'amount'      => $amount,
                'status'      => 'awaiting_payment'
            ]);
            $relatedId = $bookingId;
        }

        $paymentId = $this->paymentModel->insert([
            'user_id'      => $userId,
            'related_type' => $type,
            'related_id'   => $relatedId,
            'method'       => $method,
            'reference'    => $ref,
            'amount'       => $amount,
            'status'       => 'pending'
        ]);

        return redirect()->to("/payment/instructions/{$paymentId}");
    }

    public function instructions($paymentId)
    {
        $payment = $this->paymentModel->find($paymentId);
        if (!$payment) return redirect()->to('/');

        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($payment['user_id']);

        $phone = $user['phone'] ?? session()->get('phone');
        $phone = str_replace('+244', '', $phone);

        return view('payment/instructions', [
            'payment' => $payment,
            'userPhone' => $phone
        ]);
    }

    public function uploadProof($paymentId)
    {
        $payment = $this->paymentModel->find($paymentId);
        if (!$payment) return redirect()->to('/');

        $file = $this->request->getFile('proof');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $name = $file->getRandomName();
            $file->move(FCPATH . 'uploads/payments', $name);

            $this->paymentModel->update($paymentId, ['proof_file' => 'uploads/payments/' . $name]);

            // Update related status
            if ($payment['related_type'] === 'rent') {
                $this->bookingModel->update($payment['related_id'], ['status' => 'paid_pending_admin']);
            }

            return redirect()->to("/payment/status/{$paymentId}")->with('success', 'Comprovativo enviado! Aguarde a aprovação.');
        }

        return redirect()->back()->with('error', 'Erro ao carregar ficheiro.');
    }

    public function status($paymentId)
    {
        $payment = $this->paymentModel->find($paymentId);
        return view('payment/status', ['payment' => $payment]);
    }
}
