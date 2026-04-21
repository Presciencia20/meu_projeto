<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Painel Administrativo<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .admin-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 40px;
        align-items: start;
    }
    @media (min-width: 992px) {
        .admin-layout { grid-template-columns: 280px 1fr; }
    }

    .admin-grid {
        background: white;
        padding: 40px;
        border-radius: 40px;
        border: 1px solid var(--slate-100);
        box-shadow: var(--shadow-xl);
    }

    .admin-card h2 {
        font-size: 1.5rem;
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 32px;
        letter-spacing: -1px;
    }

    .table-admin {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0 12px;
    }

    .table-admin th {
        padding: 16px 24px;
        text-align: left;
        font-weight: 800;
        color: var(--slate-400);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1.5px;
    }

    .table-admin td {
        padding: 24px;
        background: var(--slate-50);
        border: 1px solid var(--slate-100);
        border-style: solid none;
    }

    .table-admin td:first-child {
        border-left-style: solid;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
    }

    .table-admin td:last-child {
        border-right-style: solid;
        border-top-right-radius: 20px;
        border-bottom-right-radius: 20px;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 99px;
        font-size: 0.8rem;
        font-weight: 800;
    }

    .status-pending { background: #FFFBEB; color: #92400E; border: 1px solid #FEF3C7; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <header style="margin-bottom: 60px; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h1 style="font-size: 2.5rem; font-weight: 950; color: var(--slate-900); letter-spacing: -2px;">Gestão Administrativa</h1>
            <p style="color: var(--slate-500); font-size: 1.1rem; font-weight: 500;">Moderação de utilizadores e validação de anúncios seguros.</p>
        </div>
        <div style="background: var(--primary-50); color: var(--primary); padding: 16px 24px; border-radius: 24px; font-weight: 800; display: flex; align-items: center; gap: 12px;">
            <i data-lucide="shield-check"></i> Modo Supervisor
        </div>
    </header>

    <div class="admin-layout">
        <?= $this->include('templates/admin_sidebar') ?>
        
        <div class="admin-grid">
            <section class="admin-card">
            <h2 style="font-size: 1.25rem; font-weight: 700;">Utilizadores Pendentes</h2>
            <table class="table-admin">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Nº BI</th>
                        <th>Estado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendingUsers)): ?>
                        <tr><td colspan="4" style="text-align: center; color: var(--slate-400);">Nenhum pedido pendente.</td></tr>
                    <?php else: ?>
                        <?php foreach ($pendingUsers as $user): ?>
                            <tr>
                                <td style="font-weight: 800; color: var(--slate-900);"><?= $user['full_name'] ?></td>
                                <td style="font-weight: 600; font-family: monospace;"><?= $user['bi_number'] ?></td>
                                <td><span class="status-badge status-pending">Aguardando BI</span></td>
                                <td>
                                    <div style="display: flex; gap: 8px;">
                                        <a href="/admin/approve-user/<?= $user['id'] ?>" class="btn-primary" style="padding: 10px 20px; font-size: 0.85rem; border-radius: 12px; font-weight: 800;">Aprovar</a>
                                        <button class="btn-secondary" style="padding: 10px 20px; font-size: 0.85rem; border-radius: 12px; font-weight: 700;">Detalhes</button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>

        <section class="admin-card">
            <h2 style="font-size: 1.25rem; font-weight: 700;">Anúncios para Validar</h2>
            <table class="table-admin">
                <thead>
                    <tr>
                        <th>Imóvel</th>
                        <th>Localização</th>
                        <th>Preço</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pendingProperties)): ?>
                        <tr><td colspan="4" style="text-align: center; color: var(--slate-400);">Nenhum anúncio pendente.</td></tr>
                    <?php else: ?>
                        <?php foreach ($pendingProperties as $prop): ?>
                            <tr class="animate-fade-in">
                                <td style="font-weight: 800; color: var(--slate-900);"><?= $prop['title'] ?></td>
                                <td style="font-weight: 600; color: var(--slate-500);"><?= $prop['neighborhood'] ?></td>
                                <td style="font-weight: 900; color: var(--primary);"><?= number_format($prop['price'], 0, ',', '.') ?> <span style="font-size: 0.7rem;">KZ</span></td>
                                <td>
                                    <div style="display: flex; gap: 8px;">
                                        <a href="/admin/approve-property/<?= $prop['id'] ?>" class="btn-primary" style="padding: 10px 20px; font-size: 0.85rem; border-radius: 12px; font-weight: 800;">Validar</a>
                                        <a href="/admin/reject-property/<?= $prop['id'] ?>" class="btn-secondary" style="padding: 10px 20px; font-size: 0.85rem; border-radius: 12px; font-weight: 700; text-decoration: none;" onclick="return confirm('Tem certeza que pretende remover definitivamente este anúncio da plataforma?');">Remover</a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
        </div>
    </div>
<?= $this->endSection() ?>
