<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Chat com <?= $otherUser['full_name'] ?><?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .chat-container {
        display: grid;
        grid-template-columns: 1fr;
        height: 80vh;
        background: white;
        border-radius: 48px;
        border: 1px solid var(--slate-100);
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    .chat-header {
        padding: 24px 40px;
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(20px);
        border-bottom: 1px solid var(--slate-100);
        display: flex;
        align-items: center;
        justify-content: space-between;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .chat-user-info {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .chat-messages {
        flex: 1;
        padding: 40px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 24px;
        background: var(--slate-50);
        scroll-behavior: smooth;
    }

    .message {
        max-width: 65%;
        padding: 20px 24px;
        border-radius: 24px;
        font-size: 1rem;
        line-height: 1.6;
        position: relative;
        font-weight: 500;
        transition: all 0.3s;
    }

    .message.received {
        align-self: flex-start;
        background: white;
        color: var(--slate-800);
        border-bottom-left-radius: 6px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        border: 1px solid var(--slate-100);
    }

    .message.sent {
        align-self: flex-end;
        background: var(--primary);
        color: white;
        border-bottom-right-radius: 6px;
        box-shadow: 0 10px 25px rgba(26, 86, 219, 0.15);
    }

    .chat-footer {
        padding: 32px 40px;
        background: white;
        border-top: 1px solid var(--slate-100);
    }

    .message-input-form {
        display: flex;
        gap: 16px;
    }

    .safety-banner {
        background: var(--primary-50);
        color: var(--primary);
        padding: 12px 24px;
        font-size: 0.9rem;
        text-align: center;
        border-bottom: 1px solid var(--primary-100);
        font-weight: 800;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="chat-container animate-fade-in">
        <header class="chat-header">
            <div class="chat-user-info">
                <a href="/chat" class="btn-secondary" style="padding: 10px;"><i data-lucide="chevron-left"></i></a>
                <div class="avatar"><?= strtoupper(substr($otherUser['full_name'], 0, 1)) ?></div>
                <div>
                    <div style="font-weight: 800; color: var(--slate-900);"><?= $otherUser['full_name'] ?></div>
                    <div style="font-size: 0.75rem; color: var(--brand-600); font-weight: 700;">Interesse: <?= $property['title'] ?></div>
                </div>
            </div>
            <a href="/property/<?= $property['id'] ?>" class="btn-secondary" style="font-size: 0.8rem; border-radius: 12px;">Ver Imóvel</a>
        </header>

        <div class="safety-banner">
            <i data-lucide="shield-check" style="width: 18px;"></i> 
            Compromisso Anti-Burla: Nunca partilhe dados bancários. Utilize sempre o nosso <strong>Pagamento Seguro</strong>.
        </div>

        <div class="chat-messages" id="message-container">
            <?php foreach ($messages as $msg): ?>
                <div class="message <?= $msg['sender_id'] == $userId ? 'sent' : 'received' ?>">
                    <?= esc($msg['text']) ?>
                    <div style="font-size: 0.7rem; opacity: 0.6; margin-top: 8px; text-align: right;">
                        <?= date('H:i', strtotime($msg['created_at'])) ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <footer class="chat-footer">
            <form action="/chat/send/<?= $conversation['id'] ?>" method="POST" class="message-input-form">
                <input type="text" name="text" class="input-modern" placeholder="Escreva a sua mensagem personalizada..." required autocomplete="off" style="margin-bottom: 0;">
                <button type="submit" class="btn-primary" style="padding: 0 32px; border-radius: 20px; box-shadow: 0 10px 20px rgba(26, 86, 219, 0.2);">
                    <i data-lucide="send" style="width: 20px;"></i>
                </button>
            </form>
        </footer>
    </div>

    <script>
        // Scroll to bottom
        const container = document.getElementById('message-container');
        container.scrollTop = container.scrollHeight;
    </script>
<?= $this->endSection() ?>
