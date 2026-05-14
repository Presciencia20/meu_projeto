<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Minhas Conversas - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<style>
    .chat-inbox-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    @media (min-width: 992px) {
        .chat-inbox-layout { grid-template-columns: 380px 1fr; }
    }

    .inbox-list-premium {
        background: white;
        border-radius: 32px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
        overflow: hidden;
        height: calc(100vh - 200px);
        display: flex;
        flex-direction: column;
    }

    .inbox-header {
        padding: 2rem;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .inbox-title {
        font-family: 'Outfit';
        font-weight: 900;
        font-size: 1.5rem;
        color: var(--gray-800);
        letter-spacing: -1px;
    }

    .inbox-items {
        flex: 1;
        overflow-y: auto;
        padding: 1rem;
    }

    .chat-item-link {
        display: flex;
        gap: 1rem;
        padding: 1.25rem;
        border-radius: 20px;
        text-decoration: none;
        color: inherit;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        margin-bottom: 0.5rem;
        border: 1px solid transparent;
    }

    .chat-item-link:hover {
        background: #f8fafc;
        transform: translateX(4px);
    }

    .chat-item-link.active {
        background: var(--app-primary-50);
        border-color: rgba(37, 99, 235, 0.1);
    }

    .avatar-inbox {
        width: 52px;
        height: 52px;
        background: var(--gray-100);
        color: var(--gray-600);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 1.2rem;
        flex-shrink: 0;
        position: relative;
    }

    .chat-item-link.active .avatar-inbox {
        background: var(--app-primary);
        color: white;
    }

    .chat-meta {
        flex: 1;
        min-width: 0;
    }

    .chat-user-name {
        font-family: 'Outfit';
        font-weight: 800;
        font-size: 1rem;
        color: var(--gray-800);
        margin-bottom: 2px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .chat-last-msg {
        font-size: 0.85rem;
        color: var(--gray-500);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 500;
    }

    .property-tag {
        font-size: 0.7rem;
        color: var(--app-primary);
        font-weight: 700;
        text-transform: uppercase;
        margin-top: 4px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .empty-state-chat {
        background: white;
        border-radius: 32px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 4px 10px rgba(0,0,0,0.02);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 4rem;
        height: 100%;
    }

    .empty-icon-box {
        width: 80px;
        height: 80px;
        background: var(--app-primary-50);
        color: var(--app-primary);
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        margin-bottom: 1.5rem;
    }
</style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="chat-inbox-layout">
    <!-- Sidebar: Conversations -->
    <aside class="inbox-list-premium animate-fade-in">
        <div class="inbox-header">
            <h2 class="inbox-title">Conversas</h2>
            <i class="ph-bold ph-chat-centered-text" style="font-size: 1.5rem; color: var(--app-primary);"></i>
        </div>

        <div class="inbox-items">
            <?php if (empty($conversations)): ?>
                <div style="padding: 3rem 1rem; text-align: center; color: var(--gray-400);">
                    <p style="font-weight: 600;">A sua caixa de entrada está vazia.</p>
                </div>
            <?php else: ?>
                <?php foreach ($conversations as $conv): ?>
                    <a href="/chat/view/<?= $conv['id'] ?>" class="chat-item-link">
                        <div class="avatar-inbox">
                            <?= strtoupper(substr($conv['other_user_name'] ?? 'U', 0, 1)) ?>
                        </div>
                        <div class="chat-meta">
                            <div class="chat-user-name">
                                <span><?= esc($conv['other_user_name']) ?></span>
                                <span style="font-size: 0.7rem; color: var(--gray-400); font-family: 'Inter'; font-weight: 600;">RECEPÇÃO</span>
                            </div>
                            <div class="property-tag">
                                <i class="ph-bold ph-house-line"></i> <?= esc($conv['property_title']) ?>
                            </div>
                            <div class="chat-last-msg"><?= esc($conv['last_message'] ?? 'Inicie a conversa...') ?></div>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </aside>

    <!-- Main Placeholder (Desktop only) -->
    <main class="hide-mobile" style="height: calc(100vh - 200px);">
        <div class="empty-state-chat animate-fade-in">
            <div class="empty-icon-box">
                <i class="ph-bold ph-chats-circle"></i>
            </div>
            <h3 style="font-family: 'Outfit'; font-weight: 900; font-size: 1.75rem; color: var(--gray-800); margin-bottom: 0.5rem;">Canais Seguros</h3>
            <p style="color: var(--gray-500); font-weight: 600; line-height: 1.6; max-width: 320px;">
                Seus chats são monitorizados para sua segurança contra burlas. Não partilhe documentos confidenciais.
            </p>
        </div>
    </main>
</div>
<?php $this->endSection(); ?>

