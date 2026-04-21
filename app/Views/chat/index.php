<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Mensagens<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .chat-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
        padding-bottom: 60px;
    }

    @media (min-width: 992px) {
        .chat-layout { grid-template-columns: 350px 1fr; }
    }

    .conversation-list {
        background: white;
        border-radius: 40px;
        border: 1px solid var(--slate-100);
        overflow: hidden;
        height: 80vh;
        display: flex;
        flex-direction: column;
        box-shadow: var(--shadow-xl);
    }

    .conv-header {
        padding: 32px;
        border-bottom: 1px solid var(--slate-100);
        font-weight: 900;
        font-size: 1.5rem;
        color: var(--slate-900);
        letter-spacing: -1px;
    }

    .conv-items {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
    }

    .conv-item {
        display: flex;
        gap: 16px;
        padding: 20px;
        border-radius: 24px;
        text-decoration: none;
        color: inherit;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        margin-bottom: 8px;
    }

    .conv-item:hover {
        background: var(--slate-50);
        transform: translateX(4px);
    }

    .conv-item.active {
        background: var(--primary-50);
        border: 1px solid var(--primary-100);
    }

    .avatar {
        width: 56px;
        height: 56px;
        background: var(--primary-100);
        color: var(--primary);
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 900;
        font-size: 1.25rem;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(26, 86, 219, 0.1);
    }

    .conv-meta {
        flex: 1;
        min-width: 0;
    }

    .conv-name {
        font-weight: 700;
        font-size: 0.95rem;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .conv-last {
        font-size: 0.8rem;
        color: var(--slate-500);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .empty-chat {
        background: white;
        border-radius: 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 60px;
        color: var(--slate-400);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="chat-layout">
        <aside class="conversation-list animate-fade-in">
            <div class="conv-header">Conversas</div>
            <div class="conv-items">
                <?php if (empty($conversations)): ?>
                    <div style="padding: 40px; text-align: center; color: var(--slate-400);">
                        Nenhuma conversa iniciada.
                    </div>
                <?php else: ?>
                    <?php foreach ($conversations as $conv): ?>
                        <a href="/chat/view/<?= $conv['id'] ?>" class="conv-item">
                            <div class="avatar">
                                <?= strtoupper(substr($conv['other_user_name'], 0, 1)) ?>
                            </div>
                            <div class="conv-meta">
                                <div class="conv-name" style="font-weight: 800; color: var(--slate-900);"><?= $conv['other_user_name'] ?></div>
                                <div style="font-size: 0.8rem; color: var(--primary); font-weight: 700; margin-bottom: 4px; display: flex; align-items: center; gap: 4px;">
                                    <i data-lucide="home" style="width: 12px; height: 12px;"></i>
                                    <?= $conv['property_title'] ?>
                                </div>
                                <div class="conv-last" style="color: var(--slate-500); font-weight: 500;"><?= $conv['last_message'] ?? 'Inicie a conversa...' ?></div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </aside>

        <main>
            <div class="empty-chat animate-fade-in" style="height: 80vh; background: white; border: 1px solid var(--slate-100); box-shadow: var(--shadow-md);">
                <div style="width: 120px; height: 120px; background: var(--primary-50); border-radius: 40px; display: flex; align-items: center; justify-content: center; margin-bottom: 32px; color: var(--primary);">
                    <i data-lucide="message-square" style="width: 56px; height: 56px;"></i>
                </div>
                <h2 style="color: var(--slate-900); font-weight: 900; margin-bottom: 12px; font-size: 1.75rem; letter-spacing: -0.5px;">Mensagens Seguras</h2>
                <p style="color: var(--slate-500); font-size: 1.1rem; max-width: 400px; line-height: 1.6; font-weight: 500;">
                    Escolha um contacto à esquerda para gerir o seu aluguer com total segurança.
                </p>
            </div>
        </main>
    </div>
<?= $this->endSection() ?>
