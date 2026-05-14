<?php

namespace App\Controllers;

use App\Models\PropertyModel;
use App\Models\ReportModel;
use CodeIgniter\Controller;

class Property extends BaseController
{
    public function view($id)
    {
        $model    = new PropertyModel();
        $property = $model->find($id);

        if ($property) {
            $this->trackPropertyView((int) $id);
        }

        if (!$property) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Imóvel não encontrado");
        }

        // Removi a restrição de 404 para imóveis não verificados para evitar quebras de favoritos
        // A verificação será exibida visualmente na página ao invés de bloquear o acesso

        $userModel   = new \App\Models\UserModel();
        $owner       = $userModel->find($property['owner_id']);
        $reviewModel = new \App\Models\ReviewModel();

        $data['reviews']   = $reviewModel->getReviewsForUser($property['owner_id']);
        $data['avgRating'] = $reviewModel->getAverageRating($property['owner_id']);
        $data['property']  = $property;
        $data['owner']     = $owner;
        $data['badge']     = $userModel->getBadgeInfo($owner);

        return view('property/view', $data);
    }

    public function create()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        if (!in_array(session()->get('user_type'), ['Proprietário', 'Intermediário', 'Admin', 'Super Admin'])) {
            return redirect()->to('/dashboard')->with('error', 'Acesso negado. Apenas proprietários podem publicar imóveis.');
        }

        // Proprietários sem BI aprovado não podem publicar
        $userModel = new \App\Models\UserModel();
        $user      = $userModel->find(session()->get('user_id'));

        $isAdmin = in_array(session()->get('user_type'), ['Admin', 'Super Admin']);
        if (!$isAdmin && ($user['bi_status'] ?? '') !== 'aprovado') {
            return redirect()->to('/auth/verify-bi')
                ->with('error', '⚠️ Precisa de ter a identidade verificada (BI aprovado) para publicar um imóvel. Submeta os seus documentos primeiro.');
        }

        return view('property/create');
    }

    public function store()
    {
        if (!session()->get('isLoggedIn')) return redirect()->to('/login');

        $model     = new PropertyModel();
        $userModel = new \App\Models\UserModel();
        $userId    = session()->get('user_id');
        $user      = $userModel->find($userId);

        // ── Antifraude: BI obrigatório para não-admins ───────────────────────
        $isAdmin = in_array(session()->get('user_type'), ['Admin', 'Super Admin']);
        if (!$isAdmin && ($user['bi_status'] ?? '') !== 'aprovado') {
            return redirect()->to('/auth/verify-bi')
                ->with('error', '⚠️ A sua identidade ainda não foi verificada. Submeta o seu BI primeiro.');
        }

        // ── Antifraude: Limite de 5 anúncios activos ─────────────────────────
        $activeCount = $model
            ->where('owner_id', $userId)
            ->where('status', 'available')
            ->countAllResults();

        if ($activeCount >= 5 && !$isAdmin) {
            return redirect()->back()
                ->with('error', '⚠️ Atingiu o limite de 5 anúncios activos. Remova ou desactive um anúncio antes de publicar um novo.');
        }

        // ── Imagens ─────────────────────────────────────────────────────────
        $imageUrls = [];
        if ($imageFiles = $this->request->getFileMultiple('images')) {
            foreach ($imageFiles as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    // Validar tipo de ficheiro (Segurança)
                    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
                    if (!in_array($img->getMimeType(), $allowedMimes)) {
                        continue; // Ignora ficheiros maliciosos/inválidos
                    }

                    $newName = $img->getRandomName();
                    if (!is_dir(FCPATH . 'uploads/properties')) {
                        mkdir(FCPATH . 'uploads/properties', 0777, true);
                    }
                    $img->move(FCPATH . 'uploads/properties', $newName);
                    $imageUrls[] = 'uploads/properties/' . $newName;
                }
            }
        }

        if (empty($imageUrls)) {
            return redirect()->back()->with('error', '⚠️ Deve incluir pelo menos uma fotografia do imóvel.');
        }

        // ── Documento do Imóvel (OBRIGATÓRIO para não-admins) ──────────────
        $docPath = null;
        $docType = $this->request->getPost('doc_type');

        if ($docFile = $this->request->getFile('property_doc')) {
            if ($docFile->isValid() && !$docFile->hasMoved()) {
                $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];
                if (!in_array($docFile->getMimeType(), $allowedMimes)) {
                    return redirect()->back()->with('error', '⚠️ Formato de documento inválido. Aceites: JPG, PNG, PDF.');
                }
                $newName = $docFile->getRandomName();
                $destDir = WRITEPATH . 'uploads/property_docs';
                if (!is_dir($destDir)) {
                    mkdir($destDir, 0755, true);
                }
                $docFile->move($destDir, $newName);
                $docPath = $newName;
            }
        }

        if (!$docPath && session()->get('user_type') !== 'Admin') {
            return redirect()->back()->with('error', '⚠️ O documento do imóvel é obrigatório (título de propriedade, contrato ou declaração de posse).');
        }

        // ── Antifraude: Flag de preço suspeito (<15.000 KZ) ──────────────────
        $price     = (float) $this->request->getPost('price');
        $priceFlag = ($price < 15000 && $price > 0) ? 1 : 0;

        // ── Preparar dados ───────────────────────────────────────────────────
        $data = [
            'owner_id'          => $userId,
            'title'             => $this->request->getPost('title'),
            'description'       => $this->request->getPost('description'),
            'price'             => $price,
            'type'              => $this->request->getPost('type'),
            'province'          => $this->request->getPost('province') ?: 'Luanda',
            'municipality'      => $this->request->getPost('municipality'),
            'neighborhood'      => $this->request->getPost('neighborhood'),
            'bedrooms'          => $this->request->getPost('bedrooms'),
            'bathrooms'         => $this->request->getPost('bathrooms'),
            'images'            => json_encode($imageUrls),
            'status'            => 'pending',
            'latitude'          => $this->request->getPost('latitude'),
            'longitude'         => $this->request->getPost('longitude'),
            'property_doc_path' => $docPath,
            'property_doc_type' => $docType ?: 'outro',
            'price_flag'        => $priceFlag,
            'is_verified'       => (session()->get('user_type') === 'Admin') ? true : false,
        ];

        $model->insert($data);

        $msg = $data['is_verified']
            ? 'Imóvel publicado automaticamente (Admin).'
            : 'Imóvel submetido! A nossa equipa irá analisar os documentos e publicará em breve.';

        $redirectUrl = (session()->get('user_type') === 'Admin') ? '/admin/properties' : '/plans';
        $sucessMsg = $msg . ((session()->get('user_type') === 'Admin') ? '' : ' Selecione um plano para dar destaque ao seu anúncio!');

        return redirect()->to($redirectUrl)->with('success', $sucessMsg);
    }

    /**
     * Denunciar um imóvel.
     */
    public function report($id)
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('error', 'Precisa de estar autenticado para denunciar um anúncio.');
        }

        $reportModel = new ReportModel();
        $propertyModel = new PropertyModel();

        $property = $propertyModel->find($id);
        if (!$property) {
            return redirect()->back()->with('error', 'Imóvel não encontrado.');
        }

        $userId = session()->get('user_id');

        // Anti-spam: já denunciou nos últimos 7 dias?
        if ($reportModel->hasAlreadyReported($userId, (int)$id)) {
            return redirect()->back()->with('error', 'Já submeteu uma denúncia para este imóvel recentemente. A nossa equipa está a analisar.');
        }

        $reportModel->insert([
            'reporter_id' => $userId,
            'property_id' => (int)$id,
            'reason'      => $this->request->getPost('reason') ?? 'outro',
            'details'     => $this->request->getPost('details'),
            'status'      => 'pendente',
        ]);

        return redirect()->back()->with('success', '✅ Denúncia enviada com sucesso. A nossa equipa irá analisar brevemente. Obrigado por ajudar a manter a plataforma segura.');
    }

    public function search()
    {
        $model = new PropertyModel();
        $q           = $this->request->getGet('q') ?? '';
        $type_filter = $this->request->getGet('type');
        $bedrooms    = $this->request->getGet('bedrooms');
        $minPrice    = $this->request->getGet('min_price');
        $maxPrice    = $this->request->getGet('max_price');

        $builder = $model->select('properties.*, users.is_verified_user as owner_verified')
                         ->join('users', 'users.id = properties.owner_id', 'left')
                         ->where('properties.is_verified', 1)
                         ->where('properties.status', 'available');

        if (!empty($q)) {
            $builder->groupStart()
                    ->like('properties.title', $q)
                    ->orLike('properties.neighborhood', $q)
                    ->orLike('properties.municipality', $q)
                    ->groupEnd();
        }

        if ($type_filter) {
            $builder->where('properties.type', $type_filter);
        }

        if ($bedrooms) {
            $builder->where('properties.bedrooms >=', (int)$bedrooms);
        }

        if ($minPrice) {
            $builder->where('properties.price >=', (float)$minPrice);
        }

        if ($maxPrice) {
            $builder->where('properties.price <=', (float)$maxPrice);
        }

        $data['properties'] = $builder->paginate(12);
        $data['pager']      = $model->pager;
        $data['q']          = $q;
        $data['type']       = $type_filter;
        $data['bedrooms']   = $bedrooms;
        $data['minPrice']   = $minPrice;
        $data['maxPrice']   = $maxPrice;

        return view('home', $data);
    }

    public function category($type)
    {
        $propertyModel = new PropertyModel();
        
        $q           = $this->request->getGet('q');
        $type_filter = $this->request->getGet('type');
        $province    = $this->request->getGet('province');
        $bedrooms    = $this->request->getGet('bedrooms');
        $minPrice    = $this->request->getGet('min_price');
        $maxPrice    = $this->request->getGet('max_price');

        // Construir a query usando o model para permitir paginação automática
        $builder = $propertyModel->select('properties.*, users.is_verified_user as owner_verified, users.bi_status as owner_bi_status, users.full_name as owner_name')
            ->join('users', 'users.id = properties.owner_id', 'left')
            ->where('properties.status', 'available')
            ->where('properties.is_verified', 1);

        // Filtro por tipo (segmento da URL: alugar ou comprar)
        if ($type === 'rent') {
            $builder->where('properties.price_flag', 'alugar');
        } else {
            $builder->where('properties.price_flag', 'vender');
        }

        if ($q) {
            $builder->groupStart()
                ->like('properties.title', (string)$q)
                ->orLike('properties.neighborhood', (string)$q)
                ->orLike('properties.municipality', (string)$q)
                ->groupEnd();
        }

        if ($type_filter) {
            if (is_array($type_filter)) {
                $builder->whereIn('properties.type', $type_filter);
            } else {
                $builder->where('properties.type', $type_filter);
            }
        }

        if ($province) {
            $builder->where('properties.province', $province);
        }

        if ($bedrooms) {
            $builder->where('properties.bedrooms >=', (int)$bedrooms);
        }

        if ($minPrice) {
            $builder->where('properties.price >=', (float)$minPrice);
        }

        if ($maxPrice) {
            $builder->where('properties.price <=', (float)$maxPrice);
        }

        // Executar com paginação (10 por página)
        $data['properties'] = $builder->paginate(12);
        $data['pager']      = $propertyModel->pager;

        $data['q']          = $q;
        $data['province']   = $province;
        $data['bedrooms']   = $bedrooms;
        $data['minPrice']   = $minPrice;
        $data['maxPrice']   = $maxPrice;

        $view = ($type === 'rent') ? 'alugar' : 'comprar';
        return view($view, $data);
    }

    public function toggleFavorite($id)
    {
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Precisa iniciar sessão para guardar favoritos.']);
        }

        $favModel = new \App\Models\FavoriteModel();
        $userId = session()->get('user_id');

        $exists = $favModel->where('user_id', $userId)->where('property_id', $id)->first();

        if ($exists) {
            $favModel->delete($exists['id']);
            return $this->response->setJSON(['status' => 'success', 'action' => 'removed']);
        } else {
            $favModel->insert([
                'user_id' => $userId,
                'property_id' => $id
            ]);
            return $this->response->setJSON(['status' => 'success', 'action' => 'added']);
        }
    }

    /**
     * Record property view event for analytics.
     */
    private function trackPropertyView(int $propertyId): void
    {
        $viewModel = new \App\Models\PropertyViewModel();
        $viewModel->insert([
            'property_id' => $propertyId,
            'user_id'     => session()->get('user_id'),
            'ip_address'  => $this->request->getIPAddress()
        ]);
    }
}
