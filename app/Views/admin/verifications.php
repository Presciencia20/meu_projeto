<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Fila de Verificação (KYC) - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<link rel="stylesheet" href="/css/admin.css">
<style>
    /* Layout centralizado no admin.css */

    .table-container {
        background: white;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
        margin-bottom: 2rem;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 99px;
        font-size: 0.75rem;
        font-weight: 800;
        background: #fffbeb;
        color: #d97706;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }
</style>

<?php $this->endSection(); ?>

<?php $this->section('content'); ?>

<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>

    <main class="admin-main">
        <div style="margin-bottom: 2rem;">
            <h2 style="font-weight: 800; font-family: 'Outfit';">Verificações KYC</h2>
            <p style="color: var(--gray-500);">Revise os documentos de identidade dos utilizadores.</p>
        </div>

        <div class="table-container">
            <?php if (empty($submissions)): ?>
                <div style="text-align: center; padding: 4rem 0;">
                    <i class="ph-duotone ph-check-circle" style="font-size: 4rem; color: #10b981; margin-bottom: 1rem;"></i>
                    <h3 style="font-weight: 700; color: #1e293b;">Tudo em dia!</h3>
                    <p style="color: var(--gray-500);">Nenhuma verificação pendente no momento.</p>
                </div>
            <?php else: ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="text-align: left; border-bottom: 2px solid var(--gray-100);">
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Utilizador</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Tipo</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Data</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Estado</th>
                            <th style="padding: 1rem 0; color: var(--gray-500); font-size: 0.8rem; text-transform: uppercase;">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($submissions as $s): ?>
                        <tr style="border-bottom: 1px solid var(--gray-100);">
                            <td style="padding: 1.25rem 0;">
                                <div style="font-weight: 700;"><?= esc($s['full_name'] ?? 'Usuário #'.$s['user_id']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--gray-500);"><?= esc($s['phone'] ?? '---') ?></div>
                            </td>
                            <td style="padding: 1.25rem 0; font-weight: 600; color: var(--gray-600);"><?= esc($s['user_type'] ?? 'Proprietário') ?></td>
                            <td style="padding: 1.25rem 0; color: var(--gray-500); font-size: 0.85rem;">
                                <?= isset($s['created_at']) ? date('d/m/Y H:i', strtotime($s['created_at'])) : '---' ?>
                            </td>
                            <td style="padding: 1.25rem 0;">
                                <span class="status-badge">Pendente</span>
                            </td>
                            <td style="padding: 1.25rem 0;">
                                <a href="/admin/review-verification/<?= $s['id'] ?>" class="btn-circle" style="background: var(--app-primary-50); color: var(--app-primary); width: 100px; border-radius: 8px; font-weight: 700; font-size: 0.75rem;">
                                    REVISAR
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </main>
</div>

<?php $this->endSection(); ?>

