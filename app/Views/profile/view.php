<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?><?= esc($user['full_name']) ?> | Perfil CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .profile-page { padding: 40px 0; }
    .profile-card-premium {
        background: white;
        border-radius: 48px;
        padding: 56px;
        box-shadow: 0 30px 80px rgba(0,0,0,0.06);
        border: 1px solid var(--slate-100);
        margin-bottom: 40px;
        display: grid;
        grid-template-columns: 200px 1fr;
        gap: 56px;
        align-items: center;
    }

    @media (max-width: 768px) {
        .profile-card-premium { grid-template-columns: 1fr; text-align: center; padding: 40px 24px; gap: 32px; border-radius: 40px; }
        .p-actions { justify-content: center !important; }
    }

    .p-avatar-box { position: relative; width: 200px; height: 200px; margin: 0 auto; }
    .p-avatar {
        width: 100%;
        height: 100%;
        background: var(--app-primary-50);
        border-radius: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
        font-weight: 900;
        color: var(--app-primary);
        overflow: hidden;
        border: 4px solid white;
        box-shadow: 0 15px 35px rgba(26, 86, 219, 0.1);
    }
    .p-avatar img { width: 100%; height: 100%; object-fit: cover; }
    
    .p-v-badge {
        position: absolute;
        bottom: 10px;
        right: 10px;
        background: #22c55e;
        color: white;
        width: 48px;
        height: 48px;
        border-radius: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 5px solid white;
        box-shadow: 0 10px 20px rgba(34, 197, 94, 0.2);
    }

    .p-stats { display: flex; gap: 32px; margin-top: 24px; }
    .p-stat-item div:first-child { font-size: 1.5rem; font-weight: 900; color: var(--app-text); }
    .p-stat-item div:last-child { font-size: 0.75rem; font-weight: 800; color: #999; text-transform: uppercase; }

    .p-actions { display: flex; gap: 16px; margin-top: 40px; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="profile-page animate-fade-in">
    <div class="profile-card-premium">
        <div class="p-avatar-box">
            <div class="p-avatar">
                <?php if (!empty($profile['photo'])): ?>
                    <img src="<?= base_url($profile['photo']) ?>" alt="<?= esc($user['full_name']) ?>">
                <?php else: ?>
                    <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                <?php endif; ?>
            </div>
            <?php if ($user['bi_status'] === 'aprovado'): ?>
                <div class="p-v-badge" title="Identidade Verificada">
                    <i class="ph-duotone ph-shield-check" style="font-size: 24px;"></i>
                </div>
            <?php endif; ?>
        </div>

        <div class="p-info">
            <div style="font-size: 0.8rem; font-weight: 800; color: var(--app-primary); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">
                <?= $user['user_type'] ?> Verificado
            </div>
            <h1 style="font-size: 2.8rem; font-weight: 900; letter-spacing: -1.5px; color: var(--app-text); margin-bottom: 12px;"><?= esc($user['full_name']) ?></h1>
            <p style="font-size: 1.1rem; color: #666; font-weight: 500; line-height: 1.6; max-width: 600px;">
                <?= esc($profile['bio']) ?: 'Trabalhando para oferecer as melhores experiências de arrendamento em Angola.' ?>
            </p>

            <div class="p-stats">
                <div class="p-stat-item">
                    <div><?= $stats['total_reviews'] ?></div>
                    <div>Avaliações</div>
                </div>
                <div class="p-stat-item">
                    <div><?= $stats['published_properties'] ?? 2 ?></div>
                    <div>Anúncios</div>
                </div>
                <div class="p-stat-item">
                    <div><?= number_format($stats['average_rating'], 1) ?> ★</div>
                    <div>Rating</div>
                </div>
            </div>

            <div class="p-actions">
                <?php if ($isOwnProfile): ?>
                    <a href="/user/settings" class="btn-app-primary" style="padding: 16px 32px; border-radius: 18px; text-decoration: none;">Editar Perfil</a>
                    <a href="/dashboard" class="btn-secondary" style="padding: 16px 32px; border-radius: 18px; text-decoration: none;">Painel de Controlo</a>
                <?php else: ?>
                    <a href="/chat/start/<?= $user['id'] ?>" class="btn-app-primary" style="padding: 16px 32px; border-radius: 18px; text-decoration: none; display: flex; align-items: center; gap: 8px;">
                        <i class="ph-duotone ph-chat-centered-dots" style="font-size: 20px;"></i> Enviar Mensagem
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Listings Section if applicable -->
    <div style="margin-top: 60px;">
        <h2 style="font-size: 1.8rem; font-weight: 900; margin-bottom: 32px; letter-spacing: -0.5px;">Anúncios de <?= explode(' ', $user['full_name'])[0] ?></h2>
        <div class="app-grid">
            <!-- Property cards would go here -->
            <p style="color: #999; font-weight: 600;">Explore os imóveis disponíveis deste anunciante.</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
