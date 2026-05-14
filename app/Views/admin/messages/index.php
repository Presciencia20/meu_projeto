<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Mensagens do Sistema | Admin CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="/css/admin.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>

    <main class="admin-main">
        <div class="admin-header">
            <div>
                <h1 class="admin-title">Monitoramento de Chat</h1>
                <p class="admin-subtitle">Visualize e modere todas as conversas entre usuários da plataforma.</p>
            </div>
        </div>

        <div class="card">
            <div class="table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Conversa #</th>
                            <th>Property ID</th>
                            <th>Última Mensagem</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($conversations)): ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 3rem; color: var(--gray-400);">Nenhuma conversa ativa no sistema.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($conversations as $conv): ?>
                            <tr>
                                <td><strong>#<?= $conv['id'] ?></strong></td>
                                <td><span class="badge badge-pending">Prop #<?= $conv['property_id'] ?></span></td>
                                <td>
                                    <div style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; color: var(--gray-600);">
                                        <?= esc($conv['last_message'] ?: 'Nenhuma mensagem') ?>
                                    </div>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($conv['last_message_time'] ?: $conv['created_at'])) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="/admin/messages/view/<?= $conv['id'] ?>" class="btn-action" title="Visualizar Chat">
                                            <i class="ph-bold ph-chats"></i>
                                        </a>
                                        <a href="/admin/messages/block/<?= $conv['id'] ?>" class="btn-action" style="color: #ef4444;" title="Bloquear">
                                            <i class="ph-bold ph-lock-key"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>
<?= $this->endSection() ?>
