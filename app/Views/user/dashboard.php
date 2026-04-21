<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Painel de Controlo<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .dashboard-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 32px;
        padding-bottom: 60px;
        gap: 40px;
        padding-bottom: 80px;
        margin-top: 40px;
    }

    @media (min-width: 992px) {
        .dashboard-layout { grid-template-columns: 320px 1fr; }
    }

    .sidebar {
        background: white;
        padding: 40px 24px;
        border-radius: 40px;
        border: 1px solid var(--slate-100);
        height: fit-content;
        box-shadow: var(--shadow-xl);
        position: sticky;
        top: 100px;
    }

    .sidebar-nav {
        display: flex;
        flex-direction: column;
        gap: 12px;
    }

    .nav-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 24px;
        text-decoration: none;
        color: var(--slate-500);
        font-weight: 700;
        border-radius: 20px;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .nav-item i { width: 22px; height: 22px; }

    .nav-item:hover {
        background: var(--slate-50);
        color: var(--slate-900);
        transform: translateX(4px);
    }

    .nav-item.active {
        background: var(--primary);
        color: white;
        box-shadow: 0 10px 20px rgba(26, 86, 219, 0.2);
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 24px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        padding: 40px;
        border-radius: 40px;
        border: 1px solid var(--slate-100);
        box-shadow: var(--shadow-xl);
        transition: all 0.3s;
    }

    .stat-card:hover {
        transform: translateY(-8px);
        border-color: var(--primary-100);
    }

    .stat-label {
        color: var(--slate-500);
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 12px;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 900;
        color: var(--slate-900);
    }

    /* Verification Box */
    .verify-box {
        background: linear-gradient(135deg, var(--brand-600), var(--brand-700));
        padding: 40px;
        border-radius: 32px;
        color: white;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 40px;
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.2);
    }

    .empty-state {
        background: white;
        padding: 80px 40px;
        border-radius: 40px;
        border: 2px dashed var(--slate-200);
        text-align: center;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="dashboard-layout">
        <aside class="sidebar">
            <div class="sidebar-nav">
                <a href="/dashboard" class="nav-item active"><i data-lucide="layout-dashboard"></i> Painel</a>
                <a href="/user/profile" class="nav-item"><i data-lucide="user"></i> Ver Meu Perfil</a>
                <a href="/user/profile" class="nav-item"><i data-lucide="home"></i> Meus Imóveis</a>
                <a href="/chat" class="nav-item"><i data-lucide="message-square"></i> Mensagens</a>
                <a href="/user/settings" class="nav-item"><i data-lucide="settings"></i> Definições</a>
            </div>
        </aside>

        <main class="main-content">
            <header style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: flex-end;">
                <div>
                    <h1 style="font-size: 2rem; font-weight: 800; display: flex; align-items: center; gap: 12px;">
                        Olá, <?= explode(' ', $user['full_name'])[0] ?>!
                        <div class="trust-badge" style="background: <?= $badge['color'] ?>20; color: <?= $badge['color'] ?>; font-size: 0.75rem; padding: 4px 12px; border-radius: 99px;">
                            <?= $badge['icon'] ?> <?= $badge['label'] ?>
                        </div>
                    </h1>
                    <p style="color: var(--slate-500); font-weight: 500;">Bem-vindo ao seu portal Anti-Burla.</p>
                </div>
                <?php if (in_array($user['user_type'], ['Proprietário', 'Intermediário', 'Admin'])): ?>
                    <a href="/property/create" class="btn-primary" style="padding: 14px 28px; display: flex; align-items: center; gap: 8px; text-decoration: none;">
                        <i data-lucide="plus-circle" style="width: 20px;"></i> Novo Anúncio
                    </a>
                <?php endif; ?>
            </header>

            <?php if ($user['bi_status'] === 'nao_verificado' || $user['bi_status'] === 'rejeitado'): ?>
                <div class="verify-box animate-fade-in" style="background: linear-gradient(135deg, var(--primary), #1e40af); padding: 56px; border-radius: 48px; border: none;">
                    <div style="flex: 1;">
                        <span style="background: rgba(255,255,255,0.2); padding: 6px 16px; border-radius: 99px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px; display: inline-block;">Por Verificar</span>
                        <h2 style="font-size: 2.25rem; font-weight: 900; margin-bottom: 16px; letter-spacing: -1.5px;">Aumente a sua Confiança</h2>
                        <p style="opacity: 0.85; font-size: 1.1rem; max-width: 500px; line-height: 1.6; font-weight: 500;">Utilizadores verificados têm 3x mais probabilidades de fechar negócios seguros na plataforma.</p>
                    </div>
                    <a href="/user/verify" class="btn-primary" style="background: white; color: var(--primary); padding: 20px 48px; font-weight: 900; font-size: 1.1rem; border-radius: 24px; box-shadow: 0 20px 40px rgba(0,0,0,0.1);">Submeter BI</a>
                </div>
            <?php elseif ($user['bi_status'] === 'pendente'): ?>
                <div class="verify-box animate-fade-in" style="background: var(--slate-100); padding: 40px 56px; border-radius: 48px; border: 1px solid var(--slate-200); color: var(--slate-900); align-items: flex-start;">
                    <div style="flex: 1;">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                            <i data-lucide="clock" style="color: var(--primary); width: 32px; height: 32px;"></i>
                            <h2 style="font-size: 1.75rem; font-weight: 800; letter-spacing: -0.5px; margin: 0;">Documentos Em Análise</h2>
                        </div>
                        <p style="color: var(--slate-600); font-size: 1.05rem; max-width: 600px; line-height: 1.6; font-weight: 500;">
                            A nossa equipa de segurança em Luanda está a verificar a sua identidade. Este processo demora normalmente menos de 24 horas úteis. Irá receber uma notificação assim que estiver concluído.
                        </p>
                    </div>
                </div>
            <?php endif; ?>

            <div class="stats-grid animate-fade-in">
                <div class="stat-card">
                    <div class="stat-label">Avaliação Média</div>
                    <div class="stat-value"><?= number_format($stats['average_rating'], 1) ?> <span style="font-size: 1rem; color: #fbbf24;">★</span></div>
                </div>
                <div class="stat-card">
                    <div class="stat-label">Contratos Concluídos</div>
                    <div class="stat-value"><?= $stats['completed_contracts'] ?></div>
                </div>
                <?php if ($user['user_type'] === 'Proprietário'): ?>
                    <div class="stat-card">
                        <div class="stat-label">Imóveis Publicados</div>
                        <div class="stat-value"><?= $stats['published_properties'] ?></div>
                    </div>
                <?php else: ?>
                    <div class="stat-card">
                        <div class="stat-label">Visitas Realizadas</div>
                        <div class="stat-value"><?= $stats['total_reviews'] ?></div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Secção de Pagamentos em Escrow -->
            <?php if (!empty($escrows)): ?>
                <div class="animate-fade-in" style="margin-top: 40px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                        <h3 style="font-size: 1.5rem; font-weight: 800; color: var(--slate-900);">Pagamentos Seguros (Escrow)</h3>
                        <div class="badge-verified"><i data-lucide="shield"></i> 100% Protegido</div>
                    </div>
                    
                    <div class="stats-grid" style="grid-template-columns: 1fr; gap: 20px;">
                        <?php foreach ($escrows as $e): ?>
                            <div class="stat-card" style="display: flex; gap: 24px; align-items: center; padding: 24px;">
                                <?php 
                                    $imgUrls = !empty($e['images']) ? json_decode($e['images'], true) : [];
                                    $firstImg = !empty($imgUrls) ? $imgUrls[0] : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&q=80&w=200';
                                ?>
                                <img src="<?= esc($firstImg) ?>" style="width: 100px; height: 100px; border-radius: 20px; object-fit: cover;">
                                <div style="flex: 1;">
                                    <h4 style="font-weight: 800; color: var(--slate-900); margin-bottom: 4px;"><?= $e['property_title'] ?></h4>
                                    <div style="display: flex; gap: 16px; align-items: center; font-size: 0.9rem; color: var(--slate-500); margin-bottom: 12px;">
                                        <span style="font-weight: 700; color: var(--primary);"><?= number_format($e['amount'], 0, ',', '.') ?> KZ</span>
                                        <span>•</span>
                                        <span>Transação: <?= $e['transaction_id'] ?></span>
                                    </div>
                                    
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <?php if ($e['status'] === 'held'): ?>
                                            <span class="status-badge" style="background: var(--primary-50); color: var(--primary); padding: 4px 12px; border-radius: 99px; font-size: 0.75rem; font-weight: 800;">Fundo Retido pela CasaSegura</span>
                                            
                                            <?php if ($e['tenant_id'] == session()->get('user_id')): ?>
                                                <a href="/user/release-escrow/<?= $e['id'] ?>" class="btn-primary" style="padding: 10px 20px; font-size: 0.85rem; border-radius: 12px;" onclick="return confirm('Confirmar que já visitou o imóvel ou recebeu as chaves? O dinheiro será libertado para o proprietário.')">
                                                    Libertar Pagamento <i data-lucide="check-circle" style="width: 16px;"></i>
                                                </a>
                                                
                                                <a href="/contract/generate/<?= $e['id'] ?>" target="_blank" class="btn-secondary" style="padding: 10px 20px; font-size: 0.85rem; border-radius: 12px; margin-left: 8px;">
                                                    <i data-lucide="download" style="width: 16px;"></i> Baixar Contrato
                                                </a>
                                            <?php else: ?>
                                                <span style="font-size: 0.85rem; color: var(--slate-400); font-style: italic;">A aguardar confirmação do inquilino...</span>
                                            <?php endif; ?>

                                        <?php else: ?>
                                            <span class="status-badge" style="background: var(--secondary-50); color: var(--secondary); padding: 4px 12px; border-radius: 99px; font-size: 0.75rem; font-weight: 800;">Concluído / Pago</span>
                                            
                                            <a href="/contract/generate/<?= $e['id'] ?>" target="_blank" class="btn-secondary" style="padding: 10px 20px; font-size: 0.85rem; border-radius: 12px; margin-left: 12px;">
                                                <i data-lucide="file-text" style="width: 16px;"></i> Ver Contrato
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php if ($e['status'] === 'held' && $e['tenant_id'] == session()->get('user_id')): ?>
                                    <div style="text-align: right; padding: 16px; background: var(--slate-50); border-radius: 16px;">
                                        <div style="font-size: 0.7rem; font-weight: 800; color: var(--slate-400); margin-bottom: 4px; text-transform: uppercase;">Código de Segurança</div>
                                        <div style="font-family: monospace; font-size: 1.1rem; font-weight: 900; color: var(--slate-900); letter-spacing: 2px;"><?= $e['release_code'] ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="empty-state animate-fade-in">
                    <div style="width: 80px; height: 80px; background: var(--slate-50); border-radius: 20px; display: flex; align-items: center; justify-content: center; color: var(--slate-300); margin: 0 auto 24px;">
                        <i data-lucide="shield-alert" style="width: 40px; height: 40px;"></i>
                    </div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 8px;">Sem pagamentos seguros</h3>
                    <p style="color: var(--slate-500);">Ainda não realizou reservas através do nosso sistema Anti-Burla.</p>
                </div>
            <?php endif; ?>

        </main>
    </div>
<?= $this->endSection() ?>
