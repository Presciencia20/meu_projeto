<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Pagamentos - CasaSegura Admin<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<link rel="stylesheet" href="/css/admin.css">
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>
    <main class="admin-main">
        <header class="admin-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <div>
                <h2 style="font-weight: 800; font-family: 'Outfit';">💰 Controlo Financeiro</h2>
                <p style="color: var(--gray-500);">Gestão de faturas, pagamentos e comprovativos.</p>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 0.8rem; color: var(--gray-400);">Total Arrecadado</div>
                <div style="font-size: 1.5rem; font-weight: 900; color: #10b981; font-family: 'Outfit';">Kz <?= number_format($totalStats['total'], 0, ',', '.') ?></div>
            </div>
        </header>

        <div class="table-container">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="text-align: left; border-bottom: 2px solid #f1f5f9;">
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">ID</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Usuário</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Valor</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Método / Referência</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase;">Status</th>
                        <th style="padding: 1rem; color: #64748b; font-size: 0.75rem; text-transform: uppercase; text-align: right;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($payments)): ?>
                    <tr>
                        <td colspan="6" style="padding: 3rem; text-align: center; color: #94a3b8;">Nenhum registro de pagamento encontrado.</td>
                    </tr>
                    <?php endif; ?>
                    <?php foreach($payments as $pay): ?>
                    <tr style="border-bottom: 1px solid #f8fafc;">
                        <td style="padding: 1rem; font-weight: 600; color: #94a3b8;">#<?= $pay['id'] ?></td>
                        <td style="padding: 1rem;">
                            <div style="font-weight: 700; color: #1e293b;"><?= esc($pay['user_name']) ?></div>
                            <div style="font-size: 0.8rem; color: #64748b;">ID Usuário #<?= $pay['user_id'] ?></div>
                        </td>
                        <td style="padding: 1rem; font-weight: 800; color: #1e293b;">
                            Kz <?= number_format($pay['amount'], 0, ',', '.') ?>
                        </td>
                        <td style="padding: 1rem; color: #64748b; font-size: 0.9rem;">
                            <div style="font-weight: 600;"><?= strtoupper(esc($pay['method'])) ?></div>
                            <div>Ref: <?= esc($pay['reference'] ?: 'N/A') ?></div>
                        </td>
                        <td style="padding: 1rem;">
                            <?php 
                                $statusClass = 'status-pendente';
                                if ($pay['status'] === 'completed' || $pay['status'] === 'pago') $statusClass = 'status-verificado';
                                if ($pay['status'] === 'failed' || $pay['status'] === 'cancelado') $statusClass = 'status-bloqueado';
                            ?>
                            <span class="status-badge <?= $statusClass ?>">
                                <?= esc(strtoupper($pay['status'])) ?>
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                <a href="/admin/payments/view/<?= $pay['id'] ?>" class="btn-circle" title="Ver Comprovativo"><i class="ph-bold ph-file-text"></i></a>
                                <?php if ($pay['status'] === 'pending' || $pay['status'] === 'pendente'): ?>
                                    <a href="/admin/payments/approve/<?= $pay['id'] ?>" class="btn-circle" style="background: #f0fdf4; color: #10b981;" title="Confirmar Recebimento"><i class="ph-bold ph-check-square"></i></a>
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
