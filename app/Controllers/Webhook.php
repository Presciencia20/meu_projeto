<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\RentalRequestModel;
use App\Models\EscrowModel;

class Webhook extends ResourceController
{
    /**
     * Endpoint chamado pela ProxyPay / Banco quando o utilizador efectua o
     * pagamento com a Referência ou no Multicaixa Express
     */
    public function proxypay()
    {
        // 1. Receção segura de dados JSON do prestador
        $json = $this->request->getJSON(true);
        if (!$json) {
            return $this->response->setJSON(['error' => 'Payload inválido'])->setStatusCode(400);
        }

        // A resposta do webhooks normalmente contém o `reference` e/ou `custom_fields`.
        $reference = $json['reference']['number'] ?? $json['reference'] ?? null;
        $sysRef    = $json['custom_fields']['rental_request_id'] ?? null;

        if (!$reference && !$sysRef) {
            return $this->response->setJSON(['error' => 'Referência não providenciada'])->setStatusCode(400);
        }

        $rentalModel = new RentalRequestModel();
        
        // Vamos procurar na Base de Dados quem é que estava a tentar pagar esta mesma Referência Bancária
        $requests = $rentalModel->where('status', 'pending')->findAll();
        $targetRequest = null;
        
        foreach($requests as $req) {
            $data = json_decode($req['payment_intent_id'], true) ?? [];
            if (isset($data['sys_ref_id']) && $data['sys_ref_id'] === $sysRef) {
                $targetRequest = $req;
                break;
            } elseif (isset($data['reference']) && str_replace(' ', '', $data['reference']) === str_replace(' ', '', $reference)) {
                $targetRequest = $req;
                break;
            }
        }

        if ($targetRequest) {
            // ✅ Encontrado: O Dinheiro chegou efetivamente ao Banco!
            $requestId = $targetRequest['id'];
            $rentalModel->update($requestId, ['status' => 'paid']);

            // Criar a retenção de fundos segura (Escrow) real
            $escrowModel = new EscrowModel();
            $escrowModel->insert([
                'rental_request_id' => $requestId,
                'amount'            => $targetRequest['total_amount'],
                'status'            => 'held',
                'payment_method'    => 'Multicaixa ProxyPay',
                'transaction_id'    => 'CS-' . strtoupper(bin2hex(random_bytes(4))),
                'release_code'      => strtoupper(substr(md5(time().$requestId), 0, 8))
            ]);
            
            return $this->respond(['status' => 'sucesso', 'mensagem' => 'Pagamento reconhecido pela plataforma']);
        }

        return $this->response->setJSON(['error' => 'Reserva não encontrada'])->setStatusCode(404);
    }
}
