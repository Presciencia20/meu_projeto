<aside class="admin-sidebar" style="background: white; border-radius: 40px; padding: 32px 24px; box-shadow: var(--shadow-xl); border: 1px solid var(--slate-100); position: sticky; top: 120px;">
    <div style="font-size: 0.8rem; font-weight: 800; color: var(--slate-400); text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 16px; padding-left: 16px;">Painel da Equipa</div>
    
    <?php 
        $path = current_url(true)->getPath(); 
        $isDashboard = strpos($path, 'dashboard') !== false;
        $isVerifications = strpos($path, 'verification') !== false || strpos($path, 'bi') !== false;
        $isEscrow = strpos($path, 'escrow') !== false;
    ?>

    <a href="/admin/dashboard" class="nav-item <?= $isDashboard ? 'active' : '' ?>" style="display: flex; align-items: center; gap: 12px; padding: 16px; border-radius: 20px; text-decoration: none; font-weight: 700; transition: all 0.2s; <?= $isDashboard ? 'background: var(--primary); color: white;' : 'color: var(--slate-600);' ?> margin-bottom: 8px;">
        <i data-lucide="layout-dashboard" style="width: 20px;"></i> Visão Geral
    </a>
    <a href="/admin/verifications" class="nav-item <?= $isVerifications ? 'active' : '' ?>" style="display: flex; align-items: center; gap: 12px; padding: 16px; border-radius: 20px; text-decoration: none; font-weight: 700; transition: all 0.2s; <?= $isVerifications ? 'background: var(--primary); color: white;' : 'color: var(--slate-600);' ?> margin-bottom: 8px;">
        <i data-lucide="shield-check" style="width: 20px;"></i> Verificações (BI)
    </a>
    <a href="/admin/escrow" class="nav-item <?= $isEscrow ? 'active' : '' ?>" style="display: flex; align-items: center; gap: 12px; padding: 16px; border-radius: 20px; text-decoration: none; font-weight: 700; transition: all 0.2s; <?= $isEscrow ? 'background: var(--primary); color: white;' : 'color: var(--slate-600);' ?> margin-bottom: 8px;">
        <i data-lucide="lock" style="width: 20px;"></i> Gestão Escrow
    </a>
    <a href="/admin/receipts" class="nav-item <?= strpos($path, 'receipts') !== false ? 'active' : '' ?>" style="display: flex; align-items: center; gap: 12px; padding: 16px; border-radius: 20px; text-decoration: none; font-weight: 700; transition: all 0.2s; <?= strpos($path, 'receipts') !== false ? 'background: var(--primary); color: white;' : 'color: var(--slate-600);' ?>">
        <i data-lucide="file-text" style="width: 20px;"></i> Comprovativos
    </a>
</aside>
