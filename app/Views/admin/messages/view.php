<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Visualizar Conversa | Admin CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="/css/admin.css">
<style>
    .chat-header-admin {
        background: white;
        padding: 20px;
        border-radius: 16px 16px 0 0;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .chat-participants {
        display: flex;
        gap: 20px;
    }
    .participant-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .participant-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        color: #94a3b8;
        font-weight: 700;
        display: block;
    }
    .participant-name {
        font-weight: 600;
        color: #1e293b;
    }
    .chat-messages-container {
        background: #f8fafc;
        height: 500px;
        overflow-y: auto;
        padding: 20px;
        display: flex;
        flex-direction: column;
        gap: 12px;
    }
    .message-bubble {
        max-width: 80%;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 0.95rem;
        line-height: 1.5;
        position: relative;
    }
    .message-tenant {
        align-self: flex-start;
        background: white;
        color: #1e293b;
        border: 1px solid #e2e8f0;
    }
    .message-owner {
        align-self: flex-end;
        background: #2563eb;
        color: white;
    }
    .message-time {
        font-size: 0.7rem;
        opacity: 0.7;
        margin-top: 4px;
        display: block;
    }
    .property-preview {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #eff6ff;
        padding: 10px;
        border-radius: 12px;
    }
    .property-preview img {
        width: 50px;
        height: 50px;
        border-radius: 8px;
        object-fit: cover;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>

    <main class="admin-main">
        <div class="admin-header">
            <h1 class="admin-title">Monitoramento de Chat</h1>
            <a href="/admin/messages" class="btn-primary" style="background: var(--gray-200); color: var(--gray-800);">
                <i class="ph-bold ph-arrow-left"></i> Voltar
            </a>
        </div>

        <div class="card" style="padding: 0; overflow: hidden; border-radius: 16px;">
            <div class="chat-header-admin">
                <div class="chat-participants">
                    <div class="participant-info">
                        <div>
                            <span class="participant-label">Inquilino</span>
                            <span class="participant-name"><?= esc($tenant['full_name'] ?? 'Pendente') ?></span>
                        </div>
                    </div>
                    <div style="font-size: 1.5rem; color: #cbd5e1; align-self: center;"><i class="ph-bold ph-arrows-left-right"></i></div>
                    <div class="participant-info">
                        <div>
                            <span class="participant-label">Proprietário</span>
                            <span class="participant-name"><?= esc($owner['full_name'] ?? 'Pendente') ?></span>
                        </div>
                    </div>
                </div>

                <?php if ($property): ?>
                <div class="property-preview">
                    <?php 
                        $imgs = json_decode($property['images'], true);
                        $img = !empty($imgs) ? base_url($imgs[0]) : '/img/placeholder.png';
                    ?>
                    <img src="<?= $img ?>" alt="Imóvel">
                    <div>
                        <div style="font-weight: 700; font-size: 0.85rem; color: #1e3a8a;"><?= esc($property['title']) ?></div>
                        <div style="font-size: 0.75rem; color: #3b82f6;"><?= number_format($property['price'], 2) ?> Kz</div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <div class="chat-messages-container">
                <?php if (empty($messages)): ?>
                    <div style="text-align: center; padding: 100px 0; color: #94a3b8;">
                        <i class="ph-bold ph-chat-centered-slash" style="font-size: 3rem; margin-bottom: 10px; display: block;"></i>
                        <p>Nenhuma mensagem trocada ainda nesta conversa.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($messages as $msg): ?>
                        <?php 
                            $isOwner = ($msg['sender_id'] == $conversation['owner_id']);
                            $senderName = $isOwner ? ($owner['full_name'] ?? 'Proprietário') : ($tenant['full_name'] ?? 'Inquilino');
                        ?>
                        <div class="message-bubble <?= $isOwner ? 'message-owner' : 'message-tenant' ?>">
                            <div style="font-weight: 800; font-size: 0.7rem; margin-bottom: 4px; text-transform: uppercase; opacity: 0.8;">
                                <?= esc($senderName) ?>
                            </div>
                            <?= nl2br(esc($msg['text'])) ?>
                            <span class="message-time"><?= date('H:i', strtotime($msg['created_at'])) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div style="padding: 20px; background: white; border-top: 1px solid #eee; display: flex; justify-content: space-between; align-items: center;">
                <div style="color: #64748b; font-size: 0.85rem;">
                    <i class="ph-bold ph-shield-check" style="color: #10b981;"></i> Modo de Monitoramento Administrativo Ativo
                </div>
                <a href="/admin/messages/block/<?= $conversation['id'] ?>" class="btn-danger" style="font-size: 0.85rem; padding: 8px 16px;">
                    <i class="ph-bold ph-lock"></i> Bloquear Conversa
                </a>
            </div>
        </div>
    </main>
</div>
<?= $this->endSection() ?>
