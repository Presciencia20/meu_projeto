<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Gestão de Denúncias - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<link rel="stylesheet" href="/css/admin.css">
<style>
    /* Layout centralizado no admin.css */

    .report-tabs {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
        background: white;
        padding: 0.5rem;
        border-radius: 16px;
        width: fit-content;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
    }

    .report-tab {
        padding: 0.7rem 1.5rem;
        border-radius: 12px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.85rem;
        color: var(--gray-500);
        transition: all 0.2s;
    }

    .report-tab.active {
        background: var(--app-primary);
        color: white;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }

    .table-container {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 99px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-pendente { background: #fffbeb; color: #d97706; }
    .status-em_analise { background: #e0f2fe; color: #075985; }
    .status-resolvido { background: #ecfdf5; color: #059669; }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(8px);
        align-items: center;
        justify-content: center;
        animation: fadeIn 0.3s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background: white;
        padding: 2.5rem;
        border-radius: 32px;
        width: 100%;
        max-width: 480px;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        transform: scale(0.9);
        animation: modalScale 0.3s cubic-bezier(0, 0, 0.2, 1) forwards;
    }

    @keyframes modalScale {
        to { transform: scale(1); }
    }
</style>

<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>

    <main class="admin-main">
        <div style="margin-bottom: 2rem;">
            <h2 style="font-weight: 800; font-family: 'Outfit';">Gestão de Denúncias</h2>
            <p style="color: var(--gray-500);">Monitore e resolva reclamações sobre anúncios.</p>
        </div>

        <div class="report-tabs">
            <a href="/admin/reports?status=pendente" class="report-tab <?= $status === 'pendente' ? 'active' : '' ?>">
                Pendentes (<?= $counts['pendente'] ?>)
            </a>
            <a href="/admin/reports?status=em_analise" class="report-tab <?= $status === 'em_analise' ? 'active' : '' ?>">
                Em Análise (<?= $counts['em_analise'] ?>)
            </a>
            <a href="/admin/reports?status=resolvido" class="report-tab <?= $status === 'resolvido' ? 'active' : '' ?>">
                Resolvidos (<?= $counts['resolvido'] ?>)
            </a>
        </div>

        <div class="table-container">
            <?php if (empty($reports)): ?>
                <div style="text-align: center; padding: 4rem 0;">
                    <i class="ph-duotone ph-warning-circle" style="font-size: 4rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
                    <h3 style="font-weight: 700; color: #1e293b;">Tudo limpo!</h3>
                    <p style="color: var(--gray-500);">Nenhuma denúncia encontrada para este filtro.</p>
                </div>
            <?php else: ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 2px solid var(--gray-100);">
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Denunciante</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Imóvel</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Motivo</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reports as $r): ?>
                        <tr style="border-bottom: 1px solid var(--gray-100);">
                            <td style="padding: 1.25rem 0;">
                                <div style="font-weight: 700;"><?= esc($r['reporter_name'] ?: 'Utilizador #'.$r['reporter_id']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--gray-500);"><?= date('d M, Y', strtotime($r['created_at'])) ?></div>
                            </td>
                            <td style="padding: 1.25rem 0;">
                                <a href="/property/<?= $r['property_id'] ?>" target="_blank" style="font-weight: 600; color: var(--app-primary); text-decoration: none;">
                                    <?= esc($r['property_title'] ?: 'Ver Imóvel') ?>
                                </a>
                            </td>
                            <td style="padding: 1.25rem 0;">
                                <span class="status-badge status-<?= $r['status'] ?>">
                                    <?= str_replace('_', ' ', $r['reason']) ?>
                                </span>
                            </td>
                            <td style="padding: 1.25rem 0;">
                                <div style="display: flex; gap: 8px;">
                                    <!-- Analisar -->
                                    <a href="/admin/reports/view/<?= $r['id'] ?>" class="btn-circle" style="background: #e0f2fe; color: #0284c7;" title="Analisar">
                                        <i class="ph-bold ph-magnifying-glass"></i>
                                    </a>
                                    <!-- Aceitar / Resolver -->
                                    <button onclick="openModal(<?= $r['id'] ?>)" class="btn-circle" style="background: #ecfdf5; color: #10b981; border: none; cursor: pointer;" title="Aceitar / Resolver">
                                        <i class="ph-bold ph-check"></i>
                                    </button>
                                    <!-- Remover (Denúncia ou Imóvel) -->
                                    <a href="/admin/reports/delete/<?= $r['id'] ?>" class="btn-circle" style="background: #fef2f2; color: #ef4444;" title="Remover" onclick="return confirm('Tem certeza que deseja remover esta denúncia?');">
                                        <i class="ph-bold ph-trash"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</div>

<!-- Modal de Ação -->
<div id="actionModal" class="modal">
    <div class="modal-content">
        <h3 style="font-weight: 800; margin-bottom: 0.5rem;">Gerir Denúncia</h3>
        <p style="color: var(--gray-500); margin-bottom: 2rem;">Atualize o estado da denúncia após investigação.</p>
        
        <form action="" method="POST" id="modalForm">
            <?= csrf_field() ?>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label style="font-weight: 700; font-size: 0.85rem; display: block; margin-bottom: 0.5rem;">Novo Estado</label>
                <select name="status" style="width: 100%; padding: 0.75rem; border-radius: 12px; border: 1px solid var(--gray-200); font-weight: 600;">
                    <option value="pendente">Pendente</option>
                    <option value="em_analise">Em Análise</option>
                    <option value="resolvido">Resolvido</option>
                    <option value="ignorado">Ignorado / Falsa Denúncia</option>
                </select>
            </div>
            
            <div class="form-group" style="margin-bottom: 2rem;">
                <label style="font-weight: 700; font-size: 0.85rem; display: block; margin-bottom: 0.5rem;">Observações</label>
                <textarea name="resolved_note" style="width: 100%; padding: 0.75rem; border-radius: 12px; border: 1px solid var(--gray-200); min-height: 100px;" placeholder="Ex: Anúncio removido por fraude."></textarea>
            </div>
            
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1; border-radius: 12px;">Salvar</button>
                <button type="button" onclick="closeModal()" class="btn btn-secondary" style="flex: 1; border-radius: 12px;">Cancelar</button>
            </div>
        </form>
    </div>
</div>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    function openModal(id) {
        const modal = document.getElementById('actionModal');
        const form = document.getElementById('modalForm');
        form.action = '/admin/reports/resolve/' + id;
        modal.style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('actionModal').style.display = 'none';
    }

    window.onclick = function(event) {
        const modal = document.getElementById('actionModal');
        if (event.target == modal) closeModal();
    }
</script>
<?php $this->endSection(); ?>
