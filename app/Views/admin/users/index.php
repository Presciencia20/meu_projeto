<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Usuários - CasaSegura Admin<?php $this->endSection(); ?>

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
                <h2 style="font-weight: 800; font-family: 'Outfit';">👤 Gestão de Usuários</h2>
                <p style="color: var(--gray-500);">Visualize e controle todos os usuários da plataforma.</p>
            </div>
            <a href="/admin/users/create" class="btn-primary" style="padding: 10px 24px; border-radius: 12px; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                <i class="ph-bold ph-plus"></i> Novo Usuário
            </a>
        </header>

        <div class="filter-bar">
            <a href="/admin/users" class="filter-btn <?= !$filterStatus ? 'active' : '' ?>">Todos</a>
            <a href="/admin/users?status=verified" class="filter-btn <?= $filterStatus === 'verified' ? 'active' : '' ?>">Verificados</a>
            <a href="/admin/users?status=pending" class="filter-btn <?= $filterStatus === 'pending' ? 'active' : '' ?>">Pendentes</a>
            <a href="/admin/users?status=blocked" class="filter-btn <?= $filterStatus === 'blocked' ? 'active' : '' ?>">Bloqueados</a>
        </div>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">ID</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Nome / Contato</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Papel</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Status BI</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase; text-align: right;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($users as $user): ?>
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 1rem; font-weight: 600; color: #94a3b8;">#<?= $user['id'] ?></td>
                        <td style="padding: 1rem;">
                            <div style="font-weight: 700; color: #1e293b;"><?= esc($user['full_name']) ?></div>
                            <div style="font-size: 0.8rem; color: #64748b;"><?= esc($user['phone']) ?></div>
                        </td>
                        <td style="padding: 1rem;">
                            <span style="font-weight: 600; color: #475569;"><?= esc($user['user_type']) ?></span>
                        </td>
                        <td style="padding: 1rem;">
                            <?php 
                                $statusClass = 'status-pendente';
                                if ($user['bi_status'] === 'aprovado') $statusClass = 'status-verificado';
                                if ($user['bi_status'] === 'rejeitado') $statusClass = 'status-bloqueado';
                            ?>
                            <span class="status-badge <?= $statusClass ?>">
                                <?= esc(strtoupper($user['bi_status'] ?: 'NÃO ENVIADO')) ?>
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="/admin/users/view/<?= $user['id'] ?>" class="btn-circle" title="Ver Perfil"><i class="ph-bold ph-eye"></i></a>
                                <a href="/admin/users/edit/<?= $user['id'] ?>" class="btn-circle" style="background: #eef2ff; color: #6366f1;" title="Editar"><i class="ph-bold ph-pencil"></i></a>
                                <a href="/admin/users/block/<?= $user['id'] ?>" class="btn-circle" style="background: #fef2f2; color: #ef4444;" title="Bloquear"><i class="ph-bold ph-prohibit"></i></a>
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
