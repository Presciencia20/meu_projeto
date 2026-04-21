<?php

namespace App\Controllers;

use App\Models\EscrowModel;
use App\Models\PropertyModel;
use App\Models\UserModel;
use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;

class Contract extends BaseController
{
    /**
     * Generate and stream the Contract PDF
     */
    public function generate($escrowId)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Inicie sessão para aceder ao contrato.');
        }

        $escrowModel = new EscrowModel();
        $escrow = $escrowModel->find($escrowId);
        
        if (!$escrow) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Transação financeira não encontrada.');
        }

        // 1. Data Fetching
        $db = \Config\Database::connect();
        $request = $db->table('rental_requests')->where('id', $escrow['rental_request_id'])->get()->getRowArray();
        
        if (!$request) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Pedido de arrendamento não encontrado.');
        }

        // 2. Permission Check (Security)
        $userId = session()->get('user_id');
        $userType = session()->get('user_type');

        if ($userId != $request['tenant_id'] && $userId != $request['owner_id'] && $userType !== 'Admin') {
            return $this->response->setStatusCode(403)->setBody('Acesso Negado: Não tem permissão para visualizar este contrato.');
        }

        $userModel = new UserModel();
        $propModel = new PropertyModel();
        
        $tenant   = $userModel->find($request['tenant_id']);
        $owner    = $userModel->find($request['owner_id']);
        $property = $propModel->find($request['property_id']);

        // Check if BI numbers are available (crucial for legal validity)
        if (empty($tenant['bi_number']) || empty($owner['bi_number'])) {
            // No MVP, se não houver BI, podemos avisar ou prosseguir com placeholder
            // Idealmente, pedir verificação primeiro.
        }

        $data = [
            'escrow'   => $escrow,
            'request'  => $request,
            'tenant'   => $tenant,
            'owner'    => $owner,
            'property' => $property,
            'date'     => date('d/m/Y')
        ];

        $html = view('contracts/pdf_template', $data);

        // 3. Setup Dompdf
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Helvetica');
        
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // 4. Output the PDF
        $filename = 'Contrato_CasaSegura_' . $escrow['transaction_id'] . '.pdf';
        
        return $this->response->setHeader('Content-Type', 'application/pdf')
                             ->setHeader('Content-Disposition', 'inline; filename="' . $filename . '"')
                             ->setBody($dompdf->output());
    }
}
