<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Verificações KYC - CasaSegura Admin<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<link rel="stylesheet" href="/css/admin.css">
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>
    <main class="admin-main">
        <header class="admin-header" style="margin-bottom: 2rem;">
            <h2 style="font-weight: 800; font-family: 'Outfit';">🪪 Verificações KYC</h2>
            <p style="color: var(--gray-500);">Validar identidades dos usuários através do Bilhete de Identidade.</p>
        </header>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">ID</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Número do BI</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Usuário ID</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Data de Envio</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Resultado</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase; text-align: right;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($submissions)): ?>
                    <tr>
                        <td colspan="6" style="padding: 3rem; text-align: center; color: #94a3b8;">Nenhum pedido de verificação pendente.</td>
                    </tr>
                    <?php endif; ?>
                    <?php foreach($submissions as $sub): ?>
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 1rem; font-weight: 600; color: #94a3b8;">#<?= $sub['id'] ?></td>
                        <td style="padding: 1rem; font-weight: 700; color: #1e293b;"><?= esc($sub['bi_number']) ?></td>
                        <td style="padding: 1rem; color: #64748b;">ID #<?= $sub['user_id'] ?></td>
                        <td style="padding: 1rem; color: #64748b; font-size: 0.9rem;">
                            <?= date('d/m/Y H:i', strtotime($sub['created_at'])) ?>
                        </td>
                        <td style="padding: 1rem;">
                            <?php 
                                $statusClass = 'status-pendente';
                                if ($sub['resultado'] === 'aprovado') $statusClass = 'status-verificado';
                                if ($sub['resultado'] === 'rejeitado') $statusClass = 'status-bloqueado';
                            ?>
                            <span class="status-badge <?= $statusClass ?>">
                                <?= esc(strtoupper($sub['resultado'])) ?>
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="/admin/verifications/view/<?= $sub['id'] ?>" class="btn-circle" title="Analisar Documento"><i class="ph-bold ph-magnifying-glass"></i></a>
                                <?php if ($sub['resultado'] === 'pendente'): ?>
                                    <a href="/admin/verifications/approve/<?= $sub['id'] ?>" class="btn-circle" style="background: #f0fdf4; color: #10b981;" title="Aprovar Automático"><i class="ph-bold ph-check"></i></a>
                                <?php endif; ?>
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
