<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Imóveis - CasaSegura Admin<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<link rel="stylesheet" href="/css/admin.css">
<style>
    .filter-bar {
        display: flex;
        gap: 1rem;
        margin-bottom: 2rem;
    }
    .filter-btn {
        padding: 8px 20px;
        border-radius: 50px;
        background: white;
        border: 1px solid #e2e8f0;
        color: #64748b;
        font-weight: 600;
        font-size: 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    .filter-btn.active {
        background: var(--app-primary);
        color: white;
        border-color: var(--app-primary);
    }
</style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>
    <main class="admin-main">
        <header class="admin-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-weight: 800; font-family: 'Outfit';">🏠 Gestão de Imóveis</h2>
                <p style="color: var(--gray-500);">Aprovação e monitoramento de listagens de imóveis.</p>
            </div>
        </header>

        <div class="filter-bar">
            <a href="/admin/properties" class="filter-btn <?= !$filterStatus ? 'active' : '' ?>">Todos</a>
            <a href="/admin/properties/pending" class="filter-btn <?= $filterStatus === 'pending' ? 'active' : '' ?>">Pendentes</a>
            <a href="/admin/properties/approved" class="filter-btn <?= $filterStatus === 'active' ? 'active' : '' ?>">Aprovados</a>
            <a href="/admin/properties/rejected" class="filter-btn <?= $filterStatus === 'rejected' ? 'active' : '' ?>">Rejeitados</a>
        </div>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Imóvel</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Preço</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Proprietário</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Status</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase; text-align: right;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($properties)): ?>
                    <tr>
                        <td colspan="5" style="padding: 3rem; text-align: center; color: #94a3b8;">Nenhum imóvel encontrado nesta categoria.</td>
                    </tr>
                    <?php endif; ?>
                    <?php foreach($properties as $prop): ?>
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 1rem;">
                            <div style="font-weight: 700; color: #1e293b;"><?= esc($prop['title']) ?></div>
                            <div style="font-size: 0.8rem; color: #64748b;"><?= esc($prop['neighborhood']) ?>, <?= esc($prop['municipality']) ?></div>
                        </td>
                        <td style="padding: 1rem; font-weight: 800; color: var(--app-primary);">
                            Kz <?= number_format($prop['price'], 0, ',', '.') ?>
                        </td>
                        <td style="padding: 1rem; font-size: 0.9rem; color: #475569;">
                            ID #<?= $prop['owner_id'] ?>
                        </td>
                        <td style="padding: 1rem;">
                            <?php 
                                $statusClass = 'status-pendente';
                                if ($prop['status'] === 'active' || $prop['status'] === 'ativo') $statusClass = 'status-verificado';
                                if ($prop['status'] === 'rejected' || $prop['status'] === 'rejeitado') $statusClass = 'status-bloqueado';
                            ?>
                            <span class="status-badge <?= $statusClass ?>">
                                <?= esc(strtoupper($prop['status'])) ?>
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="/admin/properties/view/<?= $prop['id'] ?>" class="btn-circle" title="Ver Detalhes"><i class="ph-bold ph-eye"></i></a>
                                <?php if ($prop['status'] === 'pending' || $prop['status'] === 'pendente'): ?>
                                    <a href="/admin/properties/approve/<?= $prop['id'] ?>" class="btn-circle" style="background: #f0fdf4; color: #10b981;" title="Aprovar"><i class="ph-bold ph-check"></i></a>
                                    <a href="/admin/properties/reject/<?= $prop['id'] ?>" class="btn-circle" style="background: #fef2f2; color: #ef4444;" title="Rejeitar"><i class="ph-bold ph-x"></i></a>
                                <?php endif; ?>
                                <a href="/admin/properties/edit/<?= $prop['id'] ?>" class="btn-circle" style="background: #eef2ff; color: #6366f1;" title="Editar"><i class="ph-bold ph-pencil"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>
<?php $this->endSection(); ?>
