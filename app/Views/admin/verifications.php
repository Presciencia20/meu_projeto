<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Fila de Verificação<?= $this->endSection() ?>

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

    .admin-header h1 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--slate-900);
        letter-spacing: -0.5px;
    }

    .verification-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .verification-table th {
        text-align: left;
        padding: 12px 24px;
        color: var(--slate-500);
        font-weight: 600;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .verification-table tr {
        background: var(--slate-50);
        transition: all 0.2s;
    }

    .verification-table tr:hover {
        background: var(--primary-50);
        transform: scale(1.005);
    }

    .verification-table td {
        padding: 20px 24px;
        border-top: 1px solid transparent;
        border-bottom: 1px solid transparent;
    }

    .verification-table td:first-child {
        border-radius: 16px 0 0 16px;
        border-left: 1px solid transparent;
    }

    .verification-table td:last-child {
        border-radius: 0 16px 16px 0;
        border-right: 1px solid transparent;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 12px;
        border-radius: 99px;
        font-size: 0.75rem;
        font-weight: 700;
        background: white;
    }

    .status-pending { color: var(--accent); border: 1px solid rgba(245, 158, 11, 0.2); }
    .status-approved { color: var(--secondary); border: 1px solid rgba(5, 150, 105, 0.2); }
    .status-rejected { color: var(--danger); border: 1px solid rgba(220, 38, 38, 0.2); }

    .user-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: var(--primary-100);
        color: var(--primary);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .btn-review {
        background: var(--primary);
        color: white;
        padding: 8px 16px;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.2s;
    }

    .btn-review:hover {
        background: var(--primary-dark);
        box-shadow: 0 4px 12px rgba(26, 86, 219, 0.2);
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
                <h1>Fila de Verificação</h1>
                <p style="color: var(--slate-500);">Existem <?= count($submissions) ?> submissões pendentes de análise.</p>
            </div>
            <div class="status-badge status-pending" style="padding: 12px 24px; font-size: 0.9rem;">
                <i data-lucide="clock"></i>
                Análise Manual Requerida
            </div>
        </div>

        <?php if (empty($submissions)): ?>
            <div style="text-align: center; padding: 60px 0;">
                <div style="margin-bottom: 24px; color: var(--secondary);"><i data-lucide="check-circle" style="width: 64px; height: 64px;"></i></div>
                <h2 style="font-weight: 800; color: var(--slate-900);">Tudo em dia!</h2>
                <p style="color: var(--slate-500);">Não existem verificações pendentes no momento.</p>
            </div>
        <?php else: ?>
            <table class="verification-table">
                <thead>
                    <tr>
                        <th>Utilizador</th>
                        <th>Nº de Telemóvel</th>
                        <th>Data Submissão</th>
                        <th>Estado</th>
                        <th>Acções</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($submissions as $s): ?>
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar"><?= substr($s['full_name'], 0, 1) ?></div>
                                    <div>
                                        <div style="font-weight: 700; color: var(--slate-900);"><?= $s['full_name'] ?></div>
                                        <div style="font-size: 0.75rem; color: var(--slate-500);"><?= $s['user_type'] ?? 'Proprietário' ?></div>
                                    </div>
                                </div>
                            </td>
                            <td style="font-weight: 600; color: var(--slate-700);"><?= $s['phone'] ?></td>
                            <td style="color: var(--slate-500); font-size: 0.9rem;">
                                <?= date('d/m/Y H:i', strtotime($s['created_at'])) ?>
                            </td>
                            <td>
                                <span class="status-badge status-pending">
                                    <i data-lucide="alert-circle" style="width: 14px;"></i>
                                    Pendente
                                </span>
                            </td>
                            <td>
                                <a href="/admin/review-verification/<?= $s['id'] ?>" class="btn-review">
                                    Rever Documentos
                                </a>
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
