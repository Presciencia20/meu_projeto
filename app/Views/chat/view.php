<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Chat com <?= esc($otherUser['full_name']) ?> - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<style>
    /* Chat Shell */
    .chat-wrapper {
        display: flex;
        flex-direction: column;
        height: calc(100vh - 200px); /* Adjust for header/footer and bottom nav */
        background: white;
        border-radius: 32px;
        border: 1px solid var(--gray-200);
        overflow: hidden;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
        position: relative;
    }

    .chat-header-premium {
        padding: 1.25rem 2rem;
        background: white;
        border-bottom: 1px solid var(--gray-100);
        display: flex;
        align-items: center;
        justify-content: space-between;
        z-index: 20;
    }

    .user-meta-chat {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .avatar-chat {
        width: 48px;
        height: 48px;
        background: var(--app-primary-50);
        color: var(--app-primary);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit';
        font-weight: 900;
        font-size: 1.2rem;
        position: relative;
        border: 1px solid var(--app-primary-50);
    }

    .online-indicator {
        position: absolute;
        bottom: -2px;
        right: -2px;
        width: 14px;
        height: 14px;
        background: #10b981;
        border: 3px solid white;
        border-radius: 50%;
    }

    .chat-body-messages {
        flex: 1;
        padding: 2rem;
        overflow-y: auto;
        background: #f8fafc;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        scroll-behavior: smooth;
    }

    /* Message Bubbles */
    .msg-bubble {
        max-width: 75%;
        padding: 1rem 1.25rem;
        border-radius: 20px;
        font-size: 0.95rem;
        font-weight: 500;
        line-height: 1.5;
        position: relative;
        animation: fadeIn 0.3s ease;
    }

    .msg-received {
        align-self: flex-start;
        background: white;
        color: var(--gray-800);
        border-bottom-left-radius: 4px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 2px 5px rgba(0,0,0,0.02);
    }

    .msg-sent {
        align-self: flex-end;
        background: var(--app-primary);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 15px rgba(37, 99, 235, 0.2);
    }

    .msg-time {
        font-size: 0.7rem;
        opacity: 0.6;
        margin-top: 6px;
        display: block;
        text-align: right;
    }

    .msg-sent .msg-time { color: rgba(255,255,255,0.8); }

    /* Footer / Input Area */
    .chat-footer-action {
        padding: 1.5rem 2rem;
        background: white;
        border-top: 1px solid var(--gray-100);
    }

    .input-wrapper-premium {
        background: #f1f5f9;
        border-radius: 20px;
        display: flex;
        align-items: center;
        padding: 6px 6px 6px 1.25rem;
        gap: 12px;
        border: 1px solid transparent;
        transition: all 0.2s;
    }

    .input-wrapper-premium:focus-within {
        background: white;
        border-color: var(--app-primary);
        box-shadow: 0 0 0 4px var(--app-primary-50);
    }

    .chat-input-field {
        flex: 1;
        background: transparent;
        border: none;
        outline: none;
        font-family: inherit;
        font-weight: 600;
        color: var(--gray-800);
        font-size: 0.95rem;
    }

    .btn-send-chat {
        width: 48px;
        height: 48px;
        background: var(--app-primary);
        color: white;
        border: none;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-send-chat:hover {
        transform: scale(1.05);
        background: var(--app-primary-dark);
    }

    .safety-tag {
        background: #fffbeb;
        color: #92400e;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 8px 16px;
        text-align: center;
        border-bottom: 1px solid #fef3c7;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    @media (max-width: 640px) {
        .chat-wrapper { height: calc(100vh - 180px); border-radius: 0; margin: -2rem -1rem; border: none; }
        .msg-bubble { max-width: 85%; }
        .chat-header-premium { padding: 1rem; }
    }
</style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="chat-wrapper animate-fade-in">
    <!-- Header -->
    <header class="chat-header-premium">
        <div class="user-meta-chat">
            <a href="/chat" class="btn-circle" style="background: var(--gray-100); width: 36px; height: 36px;">
                <i class="ph-bold ph-caret-left" style="font-size: 1rem;"></i>
            </a>
            <div class="avatar-chat">
                <?= strtoupper(substr($otherUser['full_name'] ?? 'U', 0, 1)) ?>
                <div class="online-indicator"></div>
            </div>
            <div>
                <h3 style="font-family: 'Outfit'; font-weight: 800; font-size: 1.1rem; color: #1e293b; margin: 0;"><?= esc($otherUser['full_name']) ?></h3>
                <span style="font-size: 0.75rem; color: #10b981; font-weight: 700; display: flex; align-items: center; gap: 4px;">
                   Online agora
                </span>
            </div>
        </div>
        <div>
            <a href="/property/<?= $property['id'] ?>#gallery" class="btn btn-secondary" style="font-size: 0.75rem; padding: 10px 16px; border-radius: 12px; font-weight: 800;">
                <i class="ph-bold ph-house-line"></i> <span class="hide-mobile">VER IMÓVEL</span>
            </a>
        </div>
    </header>

    <!-- Safety Banner -->
    <div class="safety-tag">
        <i class="ph-fill ph-shield-check" style="font-size: 1rem; color: #f59e0b;"></i>
        <span>COMPROMISSO ANTI-BURLA: NUNCA PARTILHE DADOS FORA DA PLATAFORMA.</span>
    </div>

    <!-- Messages Container -->
    <div class="chat-body-messages" id="chatContainer">
        <?php foreach ($messages as $msg): ?>
            <div class="msg-bubble <?= $msg['sender_id'] == $userId ? 'msg-sent' : 'msg-received' ?>">
                <?= esc($msg['text']) ?>
                <span class="msg-time"><?= date('H:i', strtotime($msg['created_at'])) ?></span>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Footer Input -->
    <footer class="chat-footer-action">
        <form action="/chat/send/<?= $conversation['id'] ?>" method="POST" id="chatForm">
            <?= csrf_field() ?>
            <div class="input-wrapper-premium">
                <input type="text" name="text" class="chat-input-field" placeholder="Escreva aqui..." required autocomplete="off">
                <button type="submit" class="btn-send-chat">
                    <i class="ph-bold ph-paper-plane-right" style="font-size: 1.25rem;"></i>
                </button>
            </div>
        </form>
    </footer>
</div>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    // Scroll to bottom immediately
    const container = document.getElementById('chatContainer');
    container.scrollTop = container.scrollHeight;

    // Handle form submission to avoid page jump issues if necessary (optional enhancement)
    document.getElementById('chatForm').addEventListener('submit', function() {
        // Scroll to bottom again after a short delay for browser to render
        setTimeout(() => {
            container.scrollTop = container.scrollHeight;
        }, 100);
    });
</script>
<?php $this->endSection(); ?>

