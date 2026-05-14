<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Painel do Administrador - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<link rel="stylesheet" href="/css/admin.css">
<style>
    /* Estilos agora centralizados no admin.css */
    
    .stats-card {
        background: white;
        padding: 2rem;
        border-radius: 24px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        border: 1px solid var(--gray-200);
        transition: transform 0.2s;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }
    
    .stats-card i {
        font-size: 2rem;
        padding: 12px;
        background: var(--app-primary-50);
        color: var(--app-primary);
        border-radius: 14px;
        margin-bottom: 1.25rem;
        display: inline-block;
    }
    
    .stats-number {
        font-size: 2.25rem;
        font-weight: 900;
        margin-bottom: 0.25rem;
        font-family: 'Outfit';
        color: #1e293b;
    }
    
    .stats-label {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 700;
    }
    
    .table-container {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
        margin-bottom: 2rem;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.65rem;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        min-width: 100px;
        text-align: center;
    }
    
    .status-verificado { background: #f0fdf4; color: #166534; }
    .status-pendente { background: #fffbeb; color: #92400e; }
    .status-bloqueado { background: #fef2f2; color: #991b1b; }

    .admin-tab-content {
        display: none;
    }
    
    .admin-tab-content.active {
        display: block;
        animation: slideUp 0.4s cubic-bezier(0, 0, 0.2, 1);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>

<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>

    <main class="admin-main">
        <!-- TAB: DASHBOARD -->
        <div id="tab-dashboard" class="admin-tab-content active">
            <div class="dashboard-header" style="margin-bottom: 2.5rem;">
                <h2 style="font-weight: 800; font-family: 'Outfit'; font-size: 1.75rem;">Visão Geral</h2>
                <p style="color: var(--admin-text-muted);">Bem-vindo ao centro de comando estratégico.</p>
            </div>

            <!-- Analytics Core Stats -->
            <div class="stats-grid">
                <div class="stats-card">
                    <i class="ph-duotone ph-chart-line-up" style="color: var(--admin-primary); background: #eff6ff;"></i>
                    <div class="stats-number"><?= number_format($totalVisits, 0, ',', '.') ?></div>
                    <div class="stats-label">Total de Visitas</div>
                </div>
                <div class="stats-card">
                    <i class="ph-duotone ph-fingerprint" style="color: var(--admin-accent); background: #f5f3ff;"></i>
                    <div class="stats-number"><?= number_format($totalLogins, 0, ',', '.') ?></div>
                    <div class="stats-label">Logins Efetuados</div>
                </div>
                <div class="stats-card">
                    <i class="ph-duotone ph-buildings" style="color: var(--admin-success); background: #ecfdf5;"></i>
                    <div class="stats-number"><?= number_format($totalPropertyViews, 0, ',', '.') ?></div>
                    <div class="stats-label">Visualizações de Imóveis</div>
                </div>
                <div class="stats-card">
                    <i class="ph-duotone ph-users-four" style="color: var(--admin-warning); background: #fffbeb;"></i>
                    <div class="stats-number"><?= $totalUsers ?></div>
                    <div class="stats-label">Usuários Ativos</div>
                </div>
            </div>

            <!-- Operational Insights -->
            <div class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
                <div class="stats-card" style="display: flex; align-items: center; gap: 20px; padding: 20px;">
                    <i class="ph-duotone ph-house-line" style="color: var(--admin-primary); background: #eff6ff; margin-bottom: 0;"></i>
                    <div>
                        <div class="stats-number" style="font-size: 1.5rem;"><?= $activeProperties ?></div>
                        <div class="stats-label">Imóveis Ativos</div>
                    </div>
                </div>
                <div class="stats-card" style="display: flex; align-items: center; gap: 20px; padding: 20px;">
                    <i class="ph-duotone ph-clock-countdown" style="color: var(--admin-warning); background: #fffbeb; margin-bottom: 0;"></i>
                    <div>
                        <div class="stats-number" style="font-size: 1.5rem;"><?= $pendingProps ?></div>
                        <div class="stats-label">Aguardando Revisão</div>
                    </div>
                </div>
                <div class="stats-card" style="display: flex; align-items: center; gap: 20px; padding: 20px;">
                    <i class="ph-duotone ph-shield-checkered" style="color: var(--admin-accent); background: #f5f3ff; margin-bottom: 0;"></i>
                    <div>
                        <div class="stats-number" style="font-size: 1.5rem;"><?= $pendingKYC ?></div>
                        <div class="stats-label">KYC Pendentes</div>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; margin-bottom: 2.5rem;">
                <!-- Imóveis Populares -->
                <div class="table-container" style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 1.5rem; font-weight: 800; display: flex; align-items: center; gap: 10px; font-family: 'Outfit';">
                        <i class="ph-duotone ph-trend-up" style="color: var(--admin-primary);"></i> Imóveis mais Visitados
                    </h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="text-align: left; border-bottom: 2px solid var(--admin-border);">
                                <th style="padding: 1rem 0; font-size: 0.7rem; color: var(--admin-text-muted);">Imóvel</th>
                                <th style="padding: 1rem 0; font-size: 0.7rem; color: var(--admin-text-muted); text-align: right;">Engajamento</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($topProperties as $top): ?>
                            <tr style="border-bottom: 1px solid var(--admin-border);">
                                <td style="padding: 1.25rem 0;">
                                    <div style="font-weight: 700; color: var(--admin-text-main);"><?= esc($top['title']) ?></div>
                                    <div style="font-size: 0.75rem; color: var(--admin-text-muted);">REF: cs-<?= $top['property_id'] ?></div>
                                </td>
                                <td style="padding: 1.25rem 0; text-align: right; font-weight: 800; color: var(--admin-primary); font-family: 'Outfit';">
                                    <?= number_format($top['total'], 0, ',', '.') ?> <span style="font-size: 0.7rem; font-weight: 600; color: var(--admin-text-muted);">vistos</span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Visitas Diárias -->
                <div class="table-container" style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 1.5rem; font-weight: 800; font-family: 'Outfit';">Atividade Recente</h3>
                    <div style="display: flex; flex-direction: column; gap: 4px;">
                        <?php foreach($dailyVisits as $dv): ?>
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; border-radius: 12px; transition: background 0.2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                            <div style="font-weight: 700; color: var(--admin-text-main); font-size: 0.85rem;">
                                <?= date('d M', strtotime($dv['date'])) ?>
                            </div>
                            <div style="font-weight: 800; font-family: 'Outfit'; color: var(--admin-primary); background: #eff6ff; padding: 4px 10px; border-radius: 8px; font-size: 0.85rem;">
                                <?= $dv['total'] ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
                <div class="table-container" style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 1.5rem; font-weight: 800; font-family: 'Outfit';">Publicações Recentes</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="text-align: left; border-bottom: 2px solid var(--admin-border);">
                                <th style="padding: 1rem 0; font-size: 0.7rem; color: var(--admin-text-muted);">Imóvel</th>
                                <th style="padding: 1rem 0; font-size: 0.7rem; color: var(--admin-text-muted);">Status</th>
                                <th style="padding: 1rem 0; font-size: 0.7rem; color: var(--admin-text-muted); text-align: right;">Gestão</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach(array_slice($allProperties, 0, 5) as $prop): ?>
                            <tr style="border-bottom: 1px solid var(--admin-border);">
                                <td style="padding: 1.25rem 0;">
                                    <div style="font-weight: 700; color: var(--admin-text-main);"><?= esc($prop['title']) ?></div>
                                    <div style="font-size: 0.75rem; color: var(--admin-text-muted);"><?= number_format($prop['price'], 0, ',', '.') ?> Kz</div>
                                </td>
                                 <td style="padding: 1.25rem 0;">
                                    <?php 
                                        $statusClass = 'status-pendente';
                                        if ($prop['status'] === 'available' || $prop['status'] === 'ativo') $statusClass = 'status-verificado';
                                        if ($prop['status'] === 'rejected' || $prop['status'] === 'rejeitado') $statusClass = 'status-bloqueado';
                                    ?>
                                    <span class="status-badge <?= $statusClass ?>" style="font-size: 0.6rem; padding: 4px 10px;">
                                        <?= strtoupper(esc($prop['status'])) ?>
                                    </span>
                                </td>
                                <td style="padding: 1.25rem 0; text-align: right;">
                                    <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                        <?php if ($prop['status'] === 'pending' || $prop['status'] === 'pendente'): ?>
                                            <a href="/admin/approve-property/<?= $prop['id'] ?>" class="btn-circle" style="background: #ecfdf5; color: #10b981;"><i class="ph-bold ph-check"></i></a>
                                        <?php else: ?>
                                            <a href="/property/<?= $prop['id'] ?>" class="btn-circle"><i class="ph-bold ph-arrow-right"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="table-container" style="padding: 1.5rem;">
                    <h3 style="margin-bottom: 1.5rem; font-weight: 800; font-family: 'Outfit';">Alertas Críticos</h3>
                    <?php if (empty($recentReports)): ?>
                        <div style="text-align: center; padding: 2rem 0;">
                            <i class="ph-duotone ph-shield-check" style="font-size: 2.5rem; color: var(--admin-success); opacity: 0.3; margin-bottom: 1rem; display: block;"></i>
                            <p style="color: var(--admin-text-muted); font-size: 0.85rem;">Sistema monitorado e seguro.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach($recentReports as $rep): ?>
                        <div style="padding: 12px; border-radius: 12px; background: #fff1f2; border: 1px solid #ffe4e6; margin-bottom: 1rem; display: flex; gap: 12px; align-items: flex-start;">
                            <i class="ph-bold ph-warning-octagon" style="color: #e11d48; font-size: 1.25rem; margin-top: 2px;"></i>
                            <div>
                                <div style="font-weight: 800; font-size: 0.8rem; color: #9f1239;">Denúncia #<?= $rep['id'] ?></div>
                                <div style="font-size: 0.75rem; color: #be123c; opacity: 0.8; margin-top: 2px;"><?= esc($rep['title']) ?></div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- TAB: USUÁRIOS -->
        <div id="tab-users" class="admin-tab-content">
            <div class="table-container">
                <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Gestão de Usuários</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 2px solid var(--gray-100);">
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Usuário</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Papel</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">BI</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($allUsers as $user): ?>
                        <tr style="border-bottom: 1px solid var(--gray-100);">
                            <td style="padding: 1rem 0;">
                                <div style="font-weight: 700;"><?= esc($user['full_name']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--gray-500);"><?= esc($user['phone']) ?></div>
                            </td>
                            <td style="padding: 1rem 0; font-weight: 600;"><?= esc($user['user_type']) ?></td>
                            <td style="padding: 1rem 0;">
                                <span class="status-badge status-<?= $user['bi_status'] === 'aprovado' ? 'verificado' : ($user['bi_status'] === 'pendente' ? 'pendente' : 'bloqueado') ?>">
                                    <?= esc($user['bi_status'] ?: 'Nenhum') ?>
                                </span>
                            </td>
                            <td style="padding: 1rem 0;">
                                <div style="display: flex; gap: 8px;">
                                    <a href="/admin/approve-user/<?= $user['id'] ?>" class="btn-circle" title="Aprovar"><i class="ph-bold ph-check"></i></a>
                                    <a href="#" class="btn-circle" style="background: #fef2f2; color: #dc2626;" title="Bloquear"><i class="ph-bold ph-x-circle"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- TAB: IMÓVEIS -->
        <div id="tab-properties" class="admin-tab-content">
            <div class="table-container">
                <h3 style="margin-bottom: 1.5rem; font-weight: 700;">Todos os Imóveis</h3>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 2px solid var(--gray-100);">
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Título</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Preço</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Status</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($allProperties as $prop): ?>
                        <tr style="border-bottom: 1px solid var(--gray-100);">
                            <td style="padding: 1rem 0;">
                                <div style="font-weight: 700;"><?= esc($prop['title']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--gray-500);"><?= esc($prop['location'] ?? 'Angola') ?></div>
                            </td>
                            <td style="padding: 1rem 0; font-weight: 800; color: var(--app-primary);">
                                <?= number_format($prop['price'], 0, ',', '.') ?> Kz
                            </td>
                            <td style="padding: 1rem 0;">
                                <?php 
                                    $statusClass = 'status-pendente';
                                    if ($prop['status'] === 'available' || $prop['status'] === 'ativo') $statusClass = 'status-verificado';
                                    if ($prop['status'] === 'rejected' || $prop['status'] === 'rejeitado') $statusClass = 'status-bloqueado';
                                ?>
                                <span class="status-badge <?= $statusClass ?>">
                                    <?= strtoupper(esc($prop['status'])) ?>
                                </span>
                            </td>
                            <td style="padding: 1rem 0;">
                                <div style="display: flex; gap: 8px;">
                                    <?php if (in_array(strtolower($prop['status']), ['pending', 'pendente', 'espera', ''])): ?>
                                        <a href="<?= site_url('admin/approve-property/'.$prop['id']) ?>" class="btn-circle" style="background: #f0fdf4; color: #16a34a; display: flex; align-items: center; justify-content: center; text-decoration: none;" title="Aprovar">
                                            <i class="ph-bold ph-check"></i>
                                        </a>
                                        <a href="<?= site_url('admin/reject-property/'.$prop['id']) ?>" class="btn-circle" style="background: #fef2f2; color: #dc2626; display: flex; align-items: center; justify-content: center; text-decoration: none;" title="Rejeitar">
                                            <i class="ph-bold ph-trash"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= site_url('property/'.$prop['id']) ?>" class="btn-circle" style="background: var(--gray-50); color: var(--gray-400); display: flex; align-items: center; justify-content: center; text-decoration: none;" title="Ver">
                                            <i class="ph-bold ph-eye"></i>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    function showTab(tabName, el) {
        // Toggle menu
        document.querySelectorAll('.sidebar-item').forEach(item => item.classList.remove('active'));
        el.classList.add('active');
        
        // Toggle content
        document.querySelectorAll('.admin-tab-content').forEach(content => content.classList.remove('active'));
        document.getElementById('tab-' + tabName).classList.add('active');
    }
</script>
<?php $this->endSection(); ?>