<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Anunciar Imóvel | CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    /* Hero Section */
    .vender-hero {
        text-align: center;
        padding: 40px 20px 60px;
        background: white;
        border-radius: 40px;
        margin-bottom: 40px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.02);
    }

    .vender-hero h1 {
        font-family: 'Outfit', sans-serif;
        font-size: 2.4rem;
        font-weight: 900;
        line-height: 1.1;
        margin-bottom: 20px;
        letter-spacing: -1px;
    }

    .vender-hero p {
        color: #666;
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto 32px;
    }

    /* Benefits Grid */
    .benefit-item {
        background: white;
        border-radius: 32px;
        padding: 30px;
        border: 1px solid rgba(0,0,0,0.04);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        text-align: center;
    }

    .benefit-item:hover {
        transform: translateY(-5px);
        border-color: var(--app-primary);
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .benefit-icon-circle {
        width: 60px; height: 60px;
        background: var(--app-primary-50);
        color: var(--app-primary);
        border-radius: 18px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }

    /* Pricing Section */
    .pricing-card-app {
        background: white;
        border-radius: 32px;
        padding: 40px 30px;
        border: 2px solid #f0f0f0;
        transition: all 0.3s;
        position: relative;
    }

    .pricing-card-app.featured {
        border-color: var(--app-primary);
        box-shadow: 0 15px 40px rgba(255, 107, 53, 0.1);
    }

    .pricing-badge {
        position: absolute;
        top: 20px; right: 20px;
        background: var(--app-primary);
        color: white;
        font-size: 0.7rem;
        font-weight: 800;
        padding: 5px 12px;
        border-radius: 50px;
        text-transform: uppercase;
    }

    .price-value {
        font-family: 'Outfit';
        font-size: 2.2rem;
        font-weight: 900;
        margin: 20px 0 10px;
    }

    .price-features {
        list-style: none; padding: 0; margin: 30px 0;
    }

    .price-features li {
        margin-bottom: 12px; font-size: 0.9rem; color: #555;
        display: flex; align-items: center; gap: 10px;
    }

    .price-features li::before {
        content: "✓"; color: var(--app-primary); font-weight: 900;
    }

    @media (max-width: 768px) {
        .vender-hero h1 { font-size: 1.8rem; }
        .vender-hero p { font-size: 1rem; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="vender-hero page-transition">
    <div style="background: var(--app-primary-50); color: var(--app-primary); padding: 6px 15px; border-radius: 50px; display: inline-block; font-size: 0.75rem; font-weight: 800; margin-bottom: 20px;">
        PROPRIETÁRIO OU AGENTE?
    </div>
    <h1>Anuncie com segurança e alcance milhares de angolanos.</h1>
    <p>A CasaSegura garante que o seu imóvel é visto por pessoas reais e que o negócio é fechado com proteção jurídica fatal.</p>
    <a href="/signup" class="btn-app-primary" style="width: auto; padding: 16px 40px;">Começar Agora <i data-lucide="arrow-right"></i></a>
</div>

<div class="featured-header">
    <h2>🚀 Porquê anunciar connosco?</h2>
</div>

<div class="app-grid">
    <div class="benefit-item">
        <div class="benefit-icon-circle"><i data-lucide="shield-check"></i></div>
        <h3>Proteção Total</h3>
        <p style="font-size: 0.9rem; color: #666;">Sistema de custódia que garante o seu pagamento sem riscos.</p>
    </div>
    <div class="benefit-item">
        <div class="benefit-icon-circle"><i data-lucide="eye"></i></div>
        <h3>Alta Exposição</h3>
        <div style="font-size: 0.9rem; color: #666;">Milhares de acessos diários de utilizadores verificados.</div>
    </div>
    <div class="benefit-item">
        <div class="benefit-icon-circle"><i data-lucide="file-check"></i></div>
        <h3>Contratos Digitais</h3>
        <p style="font-size: 0.9rem; color: #666;">Burocracia zero. Contratos gerados e assinados na hora.</p>
    </div>
</div>

<div class="featured-header" style="margin-top: 60px;">
    <h2>💎 Planos de Divulgação</h2>
</div>

<div class="app-grid">
    <div class="pricing-card-app">
        <h3 style="font-family: 'Outfit';">Básico</h3>
        <div class="price-value">0 <small style="font-size: 1rem; font-weight: 600;">KZ</small></div>
        <p style="color: #888; font-size: 0.8rem;">Ideal para proprietários individuais.</p>
        <ul class="price-features">
            <li>1 Anúncio Ativo</li>
            <li>5 Fotos Premium</li>
            <li>Chat Seguro</li>
            <li>Verificação via BI</li>
        </ul>
        <a href="/signup" class="btn-app-primary" style="background: var(--gray-100); color: var(--app-text); box-shadow: none;">Começar Grátis</a>
    </div>

    <div class="pricing-card-app featured">
        <div class="pricing-badge">Popular</div>
        <h3 style="font-family: 'Outfit';">Profissional</h3>
        <div class="price-value">15k <small style="font-size: 1rem; font-weight: 600;">KZ/mês</small></div>
        <p style="color: #888; font-size: 0.8rem;">Para consultores independentes.</p>
        <ul class="price-features">
            <li>12 Anúncios Ativos</li>
            <li>20 Fotos Premium</li>
            <li>Destaque nas Buscas</li>
            <li>Suporte Prioritário</li>
        </ul>
        <a href="/signup" class="btn-app-primary">Escolher Plano</a>
    </div>

    <div class="pricing-card-app">
        <h3 style="font-family: 'Outfit';">Agência</h3>
        <div class="price-value">45k <small style="font-size: 1rem; font-weight: 600;">KZ/mês</small></div>
        <p style="color: #888; font-size: 0.8rem;">A solução total para empresas.</p>
        <ul class="price-features">
            <li>Anúncios Ilimitados</li>
            <li>Vídeos e Tours 3D</li>
            <li>Gestor de Conta VIP</li>
            <li>Destaque na Home</li>
        </ul>
        <a href="/sobre" class="btn-app-primary" style="background: var(--gray-100); color: var(--app-text); box-shadow: none;">Contactar-nos</a>
    </div>
</div>

<div style="margin-top: 60px; background: white; border-radius: 40px; padding: 40px; border: 1px solid #f0f0f0; text-align: center;">
    <h3 style="font-family: 'Outfit'; font-size: 1.5rem; margin-bottom: 30px;">Alguma dúvida?</h3>
    <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <div class="category-icon-app" style="width: 40px; height: 40px; margin:0;"><i data-lucide="phone" style="width: 18px;"></i></div>
            <span style="font-weight: 700;">+244 923 000 000</span>
        </div>
        <div style="display: flex; align-items: center; gap: 10px;">
            <div class="category-icon-app" style="width: 40px; height: 40px; margin:0;"><i data-lucide="mail" style="width: 18px;"></i></div>
            <span style="font-weight: 700;">ajuda@casasegura.ao</span>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
