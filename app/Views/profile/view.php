<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .profile-header {
        background: white;
        border-radius: 40px;
        padding: 60px 48px;
        box-shadow: var(--shadow-xl);
        display: flex;
        align-items: center;
        gap: 48px;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        border: 1px solid var(--slate-100);
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, var(--primary-50) 0%, transparent 70%);
        z-index: 0;
    }

    .profile-photo-wrapper {
        position: relative;
        z-index: 2;
    }

    .profile-photo {
        width: 160px;
        height: 160px;
        border-radius: 48px;
        object-fit: cover;
        border: 6px solid var(--white);
        box-shadow: var(--shadow-lg);
        background: var(--slate-100);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }

    .profile-info {
        flex: 1;
        z-index: 2;
    }

    .profile-name {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        letter-spacing: -1.5px;
    }

    .trust-badge-modern {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 10px 24px;
        border-radius: 99px;
        font-size: 0.9rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: var(--shadow-sm);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 32px;
        margin-bottom: 48px;
    }

    .stat-card {
        background: white;
        border-radius: 32px;
        padding: 40px 32px;
        text-align: center;
        border: 1px solid var(--slate-100);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: var(--primary-100);
    }

    .stat-value {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--primary);
        margin-bottom: 8px;
        letter-spacing: -1px;
    }

    .stat-label {
        font-size: 0.95rem;
        color: var(--slate-500);
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--slate-900);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
        letter-spacing: -0.5px;
    }

    .section-title i { color: var(--primary); width: 24px; }

    .card-modern {
        background: white;
        border-radius: 32px;
        padding: 32px;
        margin-bottom: 24px;
        border: 1px solid var(--slate-100);
        transition: all 0.3s;
    }

    .card-modern:hover { border-color: var(--primary-100); box-shadow: var(--shadow-lg); }

    .review-user {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 16px;
    }

    .review-user-img {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        background: var(--primary-50);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
    }

    .rating-stars {
        color: #F59E0B;
        display: flex;
        gap: 4px;
    }

    .verification-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 0;
        border-bottom: 1px solid var(--slate-50);
        font-size: 1rem;
        font-weight: 500;
        color: var(--slate-600);
    }

    .verification-item:last-child { border-bottom: none; }

    .verification-status {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .status-active { color: var(--secondary); }
    .status-pending { color: var(--slate-400); }

    .btn-edit-profile {
        position: absolute;
        top: 32px;
        right: 32px;
        z-index: 10;
    }

    @media (max-width: 992px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
            padding: 60px 32px;
            gap: 32px;
        }
        .profile-name { justify-content: center; }
        .btn-edit-profile { position: static; margin-bottom: 24px; }
    }
    @media (max-width: 768px) {
        .profile-header {
            flex-direction: column;
            text-align: center;
            padding: 30px 20px;
        }
        .profile-name { justify-content: center; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="animate-fade-in">
    
    <!-- Header -->
    <div class="profile-header">
        <?php if ($isOwnProfile): ?>
            <div class="btn-edit-profile">
                <a href="/user/settings" class="btn-secondary">
                    <i data-lucide="settings" style="width:18px"></i> Configurações
                </a>
            </div>
        <?php endif; ?>

        <div class="profile-photo-wrapper">
            <?php if (!empty($profile['photo'])): ?>
                <img src="<?= base_url($profile['photo']) ?>" alt="<?= esc($user['full_name']) ?>" class="profile-photo">
            <?php else: ?>
                <div class="profile-photo">
                    <i data-lucide="user" style="width:72px; height:72px; color:var(--slate-300)"></i>
                </div>
            <?php endif; ?>
        </div>

        <div class="profile-info">
            <h1 class="profile-name">
                <?= esc($user['full_name']) ?>
                <?php if ($user['bi_status'] === 'aprovado'): ?>
                    <i data-lucide="shield-check" style="color:var(--primary); width:32px; height:32px;"></i>
                <?php endif; ?>
            </h1>
            
            <div class="trust-badge-modern" style="background: <?= $badge['color'] ?>15; color: <?= $badge['color'] ?>">
                <span><?= $badge['icon'] ?> <?= $badge['label'] ?></span>
            </div>

            <p style="color: var(--slate-500); margin-top: 16px; font-weight: 600; font-size: 1.05rem;">
                <i data-lucide="calendar" style="width:18px; vertical-align:middle; margin-right: 8px;"></i>
                Membro desde <?= date('F Y', strtotime($user['created_at'])) ?>
            </p>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 32px;">
        <!-- Left Column -->
        <div>
            <!-- Stats -->
            <div class="section-title">
                <i data-lucide="bar-chart-2"></i> Estatísticas do <?= $user['user_type'] ?>
            </div>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?= $stats['total_reviews'] ?></div>
                    <div class="stat-label">Avaliações</div>
                </div>
                <?php if ($user['user_type'] === 'Inquilino'): ?>
                    <div class="stat-card">
                        <div class="stat-value"><?= $stats['completed_contracts'] ?></div>
                        <div class="stat-label">Contratos</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">98%</div>
                        <div class="stat-label">Pagamentos em Dia</div>
                    </div>
                <?php else: ?>
                    <div class="stat-card">
                        <div class="stat-value"><?= $stats['published_properties'] ?></div>
                        <div class="stat-label">Imóveis</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value"><?= $stats['response_rate'] ?>%</div>
                        <div class="stat-label">Taxa de Resposta</div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Bio -->
            <div class="section-title">
                <i data-lucide="user-text"></i> Sobre o Proprietário
            </div>
            <div class="card-modern" style="margin-bottom: 48px;">
                <p style="color: var(--slate-600); line-height: 1.8; font-size: 1.1rem; font-weight: 500;">
                    <?= esc($profile['bio']) ?: 'Este utilizador ainda não adicionou uma biografia detalhada.' ?>
                </p>
            </div>

            <!-- History -->
            <div class="section-title">
                <i data-lucide="home"></i> Histórico de Arrendamentos
            </div>
            <?php if (empty($history)): ?>
                <div class="sidebar-card" style="text-align: center; padding: 40px;">
                    <i data-lucide="calendar" style="width:48px; color:var(--slate-300); margin-bottom: 12px;"></i>
                    <p style="color: var(--slate-500);">Nenhum contrato concluído até ao momento.</p>
                </div>
            <?php else: ?>
                <!-- Render history cards -->
            <?php endif; ?>

            <!-- Reviews -->
            <div class="section-title" style="margin-top: 48px;">
                <i data-lucide="star"></i> Experiências da Comunidade
            </div>
            <?php if (empty($reviews)): ?>
                <div class="card-modern" style="text-align: center; padding: 60px 40px; border: 2px dashed var(--slate-200);">
                    <p style="color: var(--slate-400); font-weight: 600; font-size: 1.1rem;">Ainda não existem avaliações para este utilizador.</p>
                </div>
            <?php else: ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="card-modern" style="padding: 40px;">
                        <div class="review-user">
                            <div class="review-user-img">
                                <i data-lucide="user" style="width:24px;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 800; font-size: 1.1rem; color: var(--slate-900);"><?= esc($review['reviewer_name']) ?></div>
                                <div class="rating-stars">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <i data-lucide="star" style="width:16px; fill: <?= $i <= $review['rating'] ? '#F59E0B' : 'none' ?>; color: #F59E0B"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <p style="color: var(--slate-600); font-size: 1.05rem; line-height: 1.7; font-weight: 500;">"<?= esc($review['comment']) ?>"</p>
                        <div style="font-size: 0.85rem; color: var(--slate-400); margin-top: 20px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">
                            <?= date('d M Y', strtotime($review['created_at'])) ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Right Column / Sidebar -->
        <div class="animate-fade-in" style="animation-delay: 0.2s">
            
            <?php if ($isOwnProfile): ?>
                <!-- Dashboard Shortcuts if own profile -->
                <div class="sidebar-card">
                    <h3 class="section-title" style="font-size: 1rem;"><i data-lucide="layout"></i> Meu Painel</h3>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <a href="/dashboard" class="btn-secondary" style="font-size: 0.85rem; padding: 10px;">Ir para Dashboard</a>
                        <a href="/messages" class="btn-secondary" style="font-size: 0.85rem; padding: 10px;">Mensagens</a>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Verification Status -->
            <div class="card-modern">
                <h3 class="section-title" style="font-size: 1.15rem; margin-bottom: 24px;"><i data-lucide="shield-check"></i> Verificações</h3>
                
                <div class="verification-item">
                    <span>Telemóvel</span>
                    <div class="verification-status status-active">
                        <i data-lucide="check-circle" style="width: 14px;"></i> Verificado
                    </div>
                </div>
                <div class="verification-item">
                    <span>Email Principal</span>
                    <div class="verification-status <?= !empty($user['email']) ? 'status-active' : 'status-pending' ?>">
                        <i data-lucide="<?= !empty($user['email']) ? 'check-circle' : 'circle' ?>" style="width: 14px;"></i>
                        <?= !empty($user['email']) ? 'Verificado' : 'Pendente' ?>
                    </div>
                </div>
                <div class="verification-item">
                    <span>Documento Identidade</span>
                    <div class="verification-status <?= $user['bi_status'] === 'aprovado' ? 'status-active' : 'status-pending' ?>">
                        <i data-lucide="<?= $user['bi_status'] === 'aprovado' ? 'check-circle' : 'circle' ?>" style="width: 14px;"></i>
                        <?= $user['bi_status'] === 'aprovado' ? 'Confirmado' : 'Pendente' ?>
                    </div>
                </div>
                <div class="verification-item" style="border-bottom: none;">
                    <span>Reconhecimento Facial</span>
                    <div class="verification-status <?= $user['status'] === 'verificado' ? 'status-active' : 'status-pending' ?>">
                        <i data-lucide="<?= $user['status'] === 'verificado' ? 'check-circle' : 'circle' ?>" style="width: 14px;"></i>
                        <?= $user['status'] === 'verificado' ? 'Concluído' : 'Pendente' ?>
                    </div>
                </div>

                <?php if ($isOwnProfile && $user['bi_status'] !== 'aprovado'): ?>
                    <a href="/user/verify" class="btn-primary" style="width: 100%; margin-top: 24px;">
                        Completar Verificação
                    </a>
                <?php endif; ?>
            </div>

            <!-- Contacts -->
            <?php if (!$isOwnProfile): ?>
                <div class="card-modern" style="background: var(--primary-50); border-color: var(--primary-100);">
                    <h3 class="section-title" style="font-size: 1.15rem; color: var(--primary);"><i data-lucide="message-square"></i> Contactar</h3>
                    <p style="font-size: 0.95rem; color: var(--slate-600); margin-bottom: 24px; line-height: 1.6; font-weight: 500;">
                        Garanta o seu negócio enviando uma mensagem direta. O contacto telefónico será partilhado após o agendamento.
                    </p>
                    <button class="btn-primary" style="width: 100%;">Enviar Mensagem Segura</button>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>
<?= $this->endSection() ?>
