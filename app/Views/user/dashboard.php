<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Painel do Utilizador - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<style>
    .dashboard-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2.5rem;
        padding-bottom: 80px;
    }

    /* Sidebar Contextual */
    .user-sidebar {
        background: white;
        border-radius: 28px;
        padding: 1.5rem;
        height: fit-content;
        position: sticky;
        top: 90px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .user-sidebar-menu {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }

    .user-nav-link {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 14px;
        color: var(--gray-600);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.2s;
    }

    .user-nav-link:hover {
        background: #f8fafc;
        color: var(--app-primary);
    }

    .user-nav-link.active {
        background: var(--app-primary-50);
        color: var(--app-primary);
    }

    .user-nav-link i {
        font-size: 1.25rem;
    }

    /* Stats System */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .stat-card-premium {
        background: white;
        padding: 2rem;
        border-radius: 28px;
        border: 1px solid var(--gray-100);
        box-shadow: 0 10px 20px -5px rgba(0,0,0,0.03);
        transition: transform 0.2s;
    }

    .stat-card-premium:hover {
        transform: translateY(-5px);
        border-color: var(--app-primary-50);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        background: var(--app-primary-50);
        color: var(--app-primary);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-bottom: 1.25rem;
    }

    .stat-val {
        font-size: 2.25rem;
        font-weight: 900;
        font-family: 'Outfit';
        color: var(--gray-800);
        margin-bottom: 4px;
    }

    .stat-lab {
        color: var(--gray-500);
        font-weight: 700;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Verify Action */
    .hero-verify {
        background: linear-gradient(135deg, var(--app-primary), #1e40af);
        padding: 3rem;
        border-radius: 36px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 2.5rem;
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.25);
    }

    .hero-verify h2 {
        font-family: 'Outfit';
        font-weight: 900;
        font-size: 2.4rem;
        margin-bottom: 12px;
        letter-spacing: -1.5px;
    }

    /* Cards */
    .escrow-list {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }

    .escrow-card {
        background: white;
        border-radius: 28px;
        padding: 1.5rem;
        display: grid;
        grid-template-columns: 100px 1fr auto;
        gap: 1.5rem;
        align-items: center;
        border: 1px solid var(--gray-100);
        box-shadow: 0 4px 15px rgba(0,0,0,0.03);
        transition: transform 0.2s;
    }

    .escrow-card:hover {
        transform: scale(1.01);
        border-color: var(--app-primary-50);
    }

    @media (max-width: 992px) {
        .dashboard-layout { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: 1fr; }
        .hero-verify { flex-direction: column; text-align: center; gap: 2rem; padding: 2rem; }
        .escrow-card { grid-template-columns: 1fr; text-align: center; justify-items: center; }
    }
</style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="dashboard-layout">
    <!-- Sidebar -->
    <aside class="user-sidebar">
        <nav class="user-sidebar-menu">
            <a href="/dashboard" class="user-nav-link active">
                <i class="ph-duotone ph-layout"></i> Painel Geral
            </a>
            <a href="/user/profile" class="user-nav-link">
                <i class="ph-duotone ph-user-circle"></i> Meu Perfil
            </a>
            <a href="/favorites" class="user-nav-link">
                <i class="ph-duotone ph-heart"></i> Favoritos
            </a>
            <a href="/chat" class="user-nav-link">
                <i class="ph-duotone ph-chat-teardrop-dots"></i> Mensagens
            </a>
            <a href="/user/settings" class="user-nav-link">
                <i class="ph-duotone ph-gear"></i> Definições
            </a>

            <div style="margin-top: 2rem; padding-top: 1rem; border-top: 1px solid var(--gray-100);">
                <a href="/logout" class="user-nav-link" style="color: #ef4444;">
                    <i class="ph-duotone ph-sign-out"></i> Terminar Sessão
                </a>
            </div>
        </nav>
    </aside>

    <!-- Main -->
    <main class="dashboard-main">
        <div style="margin-bottom: 2.5rem;">
            <h1 style="font-family: 'Outfit'; font-weight: 950; font-size: 2.4rem; color: var(--gray-800); margin-bottom: 8px;">
                Olá, <?= explode(' ', $user['full_name'])[0] ?>! 👋
            </h1>
            <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span class="badge" style="background: <?= $badge['color'] ?>20; color: <?= $badge['color'] ?>; font-weight: 800; border-radius: 99px; padding: 6px 14px; font-size: 0.75rem;">
                        <?= $badge['icon'] ?> <?= strtoupper($badge['label']) ?>
                    </span>
                    <p style="color: var(--gray-500); font-weight: 600; font-size: 0.95rem; margin: 0;">Bem-vindo ao seu portal de segurança.</p>
                </div>
                <a href="/plans" style="text-decoration: none; background: #fff7ed; color: #f59e0b; padding: 8px 16px; border-radius: 12px; font-weight: 800; font-size: 0.8rem; border: 1px solid #ffedd5;">
                    <i class="ph-bold ph-trend-up"></i> Ser Premium
                </a>
            </div>
        </div>

        <?php if ($user['bi_status'] === 'nao_verificado' || $user['bi_status'] === 'rejeitado'): ?>
            <div class="hero-verify">
                <div>
                    <span style="background: rgba(255,255,255,0.2); padding: 6px 14px; border-radius: 99px; font-size: 0.7rem; font-weight: 900; text-transform: uppercase; margin-bottom: 1.5rem; display: inline-block;">Verificação Pendente</span>
                    <h2>Ganhe mais Confiança</h2>
                    <p style="opacity: 0.9; font-size: 1.1rem; max-width: 500px; font-weight: 500; line-height: 1.5;">Perfis verificados fecham negócios 3x mais rápido e têm prioridade na busca.</p>
                </div>
                <a href="/user/verify" class="btn btn-primary" style="background: white; color: var(--app-primary); padding: 1.1rem 3rem; font-weight: 800; font-size: 1rem; border-radius: 18px; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">Verificar Agora</a>
            </div>
        <?php elseif ($user['bi_status'] === 'pendente'): ?>
            <div style="background: #f8fafc; border: 1px solid var(--gray-200); padding: 2.5rem; border-radius: 36px; margin-bottom: 2.5rem; display: flex; gap: 1.5rem; align-items: center;">
                <div style="width: 64px; height: 64px; background: white; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--app-primary); box-shadow: var(--shadow-sm);">
                    <i class="ph-duotone ph-hourglass-high"></i>
                </div>
                <div>
                    <h3 style="font-weight: 800; color: var(--gray-800); margin-bottom: 4px;">Documentos em Análise</h3>
                    <p style="color: var(--gray-500); margin: 0; font-weight: 500;">Nossa equipa está a trabalhar na sua verificação. Tempo médio: 12h.</p>
                </div>
            </div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card-premium">
                <div class="stat-icon"><i class="ph-duotone ph-star"></i></div>
                <div class="stat-val"><?= number_format($stats['average_rating'], 1) ?></div>
                <div class="stat-lab">Avaliação</div>
            </div>
            <div class="stat-card-premium">
                <div class="stat-icon" style="background: #ecfdf5; color: #10b981;"><i class="ph-duotone ph-handshake"></i></div>
                <div class="stat-val"><?= $stats['completed_contracts'] ?></div>
                <div class="stat-lab">Contratos</div>
            </div>
            <div class="stat-card-premium">
                <div class="stat-icon" style="background: #fff7ed; color: #f59e0b;"><i class="ph-duotone ph-house"></i></div>
                <div class="stat-val"><?= ($user['user_type'] === 'Proprietário') ? $stats['published_properties'] : $stats['total_reviews'] ?></div>
                <div class="stat-lab"><?= ($user['user_type'] === 'Proprietário') ? 'Meus Imóveis' : 'Visitas' ?></div>
            </div>
        </div>

        <!-- Escrow Section -->
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                <h3 style="font-family: 'Outfit'; font-weight: 800; font-size: 1.4rem;">Pagamentos de Aluguel (Seguros)</h3>
                <span style="font-size: 0.8rem; font-weight: 800; color: #10b981; background: #ecfdf5; padding: 6px 12px; border-radius: 8px;">
                    <i class="ph-bold ph-shield-check"></i> PROTEÇÃO ATIVA
                </span>
            </div>

            <?php if (empty($escrows)): ?>
                <div style="text-align: center; padding: 4rem; background: white; border-radius: 36px; border: 2px dashed var(--gray-200);">
                    <i class="ph-duotone ph-shield-slash" style="font-size: 4rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
                    <h4 style="font-weight: 700; color: var(--gray-500);">Nenhum pagamento pendente</h4>
                </div>
            <?php else: ?>
                <div class="escrow-list">
                    <?php foreach($escrows as $e): 
                        $imgUrls = !empty($e['images']) ? json_decode($e['images'], true) : [];
                        $firstImg = !empty($imgUrls) ? $imgUrls[0] : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&q=80&w=200';
                    ?>
                    <div class="escrow-card">
                        <img src="<?= esc($firstImg) ?>" style="width: 100px; height: 100px; border-radius: 20px; object-fit: cover;">
                        <div>
                            <h4 style="font-weight: 800; color: #1e293b; margin-bottom: 4px;"><?= esc($e['property_title']) ?></h4>
                            <p style="font-size: 1.25rem; font-weight: 950; color: var(--app-primary); margin-bottom: 8px;">
                                <?= number_format($e['amount'], 0, ',', '.') ?> KZ
                            </p>
                            <div style="display: flex; gap: 8px; align-items: center;">
                                <span style="font-size: 0.7rem; font-weight: 800; background: #f1f5f9; color: #64748b; padding: 4px 8px; border-radius: 6px;">ID: <?= $e['transaction_id'] ?></span>
                                <span style="font-size: 0.75rem; font-weight: 700; color: #059669;">• Fundo Retido em Escrow</span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 10px; min-width: 200px;">
                            <?php if ($e['status'] === 'held' && $e['tenant_id'] == session()->get('user_id')): ?>
                                <a href="/user/release-escrow/<?= $e['id'] ?>" class="btn btn-primary" style="padding: 12px; font-size: 0.85rem; border-radius: 12px; width: 100%;" onclick="return confirm('Confirmar receção do imóvel?');">
                                    Libertar Fundos
                                </a>
                                <div style="text-align: center; padding: 8px; background: #fefce8; border-radius: 12px; border: 1px solid #fef3c7;">
                                    <span style="font-size: 0.65rem; font-weight: 900; color: #a16207; text-transform: uppercase;">Código de Segurança</span>
                                    <div style="font-family: monospace; font-size: 1rem; font-weight: 900; color: #1e293b; letter-spacing: 2px;"><?= $e['release_code'] ?></div>
                                </div>
                            <?php else: ?>
                                <span style="font-size: 0.85rem; color: var(--gray-400); font-style: italic; text-align: center;">Aguardando Inquilino...</span>
                            <?php endif; ?>
                            <a href="/contract/generate/<?= $e['id'] ?>" target="_blank" class="btn btn-secondary" style="padding: 10px; font-size: 0.85rem; border-radius: 12px;">
                                <i class="ph-bold ph-file-text"></i> Contrato Digital
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>
<?php $this->endSection(); ?>
