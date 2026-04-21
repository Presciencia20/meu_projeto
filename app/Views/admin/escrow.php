<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Monitorização de Escrow<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .admin-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
        align-items: start;
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }
    @media (min-width: 992px) {
        .admin-layout { grid-template-columns: 280px 1fr; }
    }

    .admin-card {
        background: white;
        border-radius: 24px;
        padding: 40px;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--slate-100);
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 32px;
    }

    .status-held { color: var(--primary); background: var(--primary-50); border: 1px solid rgba(26, 86, 219, 0.1); }
    .status-released { color: var(--secondary); background: var(--secondary-50); border: 1px solid rgba(5, 150, 105, 0.1); }
    .status-refunded { color: var(--danger); background: var(--danger-50); border: 1px solid rgba(220, 38, 38, 0.1); }

    .escrow-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .escrow-table th {
        text-align: left;
        padding: 12px 24px;
        color: var(--slate-500);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .escrow-item {
        background: var(--slate-50);
        transition: all 0.2s;
    }

    .escrow-item:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
        background: white;
    }

    .escrow-item td {
        padding: 24px;
    }

    .escrow-item td:first-child { border-radius: 16px 0 0 16px; }
    .escrow-item td:last-child { border-radius: 0 16px 16px 0; }

    .user-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        color: var(--slate-900);
    }

    .btn-refund {
        color: var(--danger);
        background: var(--danger-50);
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 700;
        font-size: 0.8rem;
        transition: 0.2s;
    }

    .btn-refund:hover {
        background: var(--danger);
        color: white;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>
    
    <div>
        <div class="admin-card animate-fade-in">
        <div class="admin-header">
            <div>
                <h1 style="font-weight: 900; color: var(--slate-900); font-size: 2rem;">Controlo de Escrow</h1>
                <p style="color: var(--slate-500);">Gestão de fundos retidos e resolução de disputas.</p>
            </div>
            
            <?php 
                $totalHeld = 0;
                foreach($escrows as $e) if($e['status'] === 'held') $totalHeld += $e['amount'];
            ?>
            <div style="text-align: right;">
                <div style="font-size: 0.75rem; font-weight: 800; color: var(--slate-400); text-transform: uppercase;">Total em Custódia</div>
                <div style="font-size: 1.75rem; font-weight: 950; color: var(--primary);"><?= number_format($totalHeld, 0, ',', '.') ?> KZ</div>
            </div>
        </div>

        <?php if (empty($escrows)): ?>
            <div style="text-align: center; padding: 60px 0;">
                <i data-lucide="shield-off" style="width: 48px; height: 48px; color: var(--slate-200); margin-bottom: 16px;"></i>
                <p style="color: var(--slate-400);">Nenhuma transação registada.</p>
            </div>
        <?php else: ?>
            <table class="escrow-table">
                <thead>
                    <tr>
                        <th>Propriedade & Valor</th>
                        <th>Intervenientes (Inquilino → Dono)</th>
                        <th>Estado</th>
                        <th>Transação</th>
                        <th>Acções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($escrows as $e): ?>
                        <tr class="escrow-item">
                            <td>
                                <div style="font-weight: 800; color: var(--slate-900); mb-1;"><?= $e['property_title'] ?></div>
                                <div style="color: var(--primary); font-weight: 900; font-size: 1.1rem;"><?= number_format($e['amount'], 0, ',', '.') ?> KZ</div>
                            </td>
                            <td>
                                <div class="user-pill"><i data-lucide="user" style="width: 14px;"></i> <?= $e['tenant_name'] ?></div>
                                <div style="color: var(--slate-300); margin: 4px 0;">↓</div>
                                <div class="user-pill"><i data-lucide="home" style="width: 14px;"></i> <?= $e['owner_name'] ?></div>
                            </td>
                            <td>
                                <span class="status-badge status-<?= $e['status'] ?>" style="padding: 6px 12px; border-radius: 99px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase;">
                                    <?= $e['status'] ?>
                                </span>
                            </td>
                            <td style="font-family: monospace; font-size: 0.8rem; color: var(--slate-500);">
                                <?= $e['transaction_id'] ?><br>
                                <small><?= date('d/m/Y H:i', strtotime($e['created_at'])) ?></small>
                            </td>
                            <td>
                                <?php if ($e['status'] === 'held'): ?>
                                    <a href="/admin/refund-escrow/<?= $e['id'] ?>" class="btn-refund" onclick="return confirm('Tem a certeza que deseja devolver este valor ao inquilino? Esta acção é irreversível.')">
                                        Devolver Valor
                                    </a>
                                <?php else: ?>
                                    <span style="color: var(--slate-300); font-style: italic; font-size: 0.75rem;">Sem acções</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
