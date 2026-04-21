<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>CasaSegura Angola - O portal imobiliário 100% verificado<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .hero-section {
        padding: 120px 0 80px;
        text-align: center;
        max-width: 1000px;
        margin: 0 auto;
    }

    .hero-section h1 {
        font-size: 4rem;
        font-weight: 900;
        line-height: 1;
        letter-spacing: -3px;
        margin-bottom: 24px;
        color: var(--slate-900);
    }

    .hero-section p {
        font-size: 1.4rem;
        color: var(--slate-500);
        margin-bottom: 60px;
        font-weight: 500;
        line-height: 1.6;
    }

    .search-wrapper {
        background: white;
        padding: 12px;
        border-radius: 40px;
        box-shadow: 0 40px 100px rgba(0,0,0,0.06);
        display: flex;
        gap: 16px;
        border: 1px solid var(--slate-100);
        max-width: 900px;
        margin: 0 auto;
        align-items: center;
    }

    .search-group {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 0 24px;
        border-right: 1px solid var(--slate-100);
    }

    .search-group:last-of-type { border-right: none; }

    .search-group i { color: var(--primary); width: 20px; }

    .search-group input, .search-group select {
        border: none;
        outline: none;
        width: 100%;
        font-size: 1rem;
        font-weight: 600;
        color: var(--slate-900);
        padding: 16px 0;
    }

    /* Trust Signals */
    .trust-signals {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 32px;
        margin-top: 120px;
    }

    @media (max-width: 992px) { .trust-signals { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 576px) { .trust-signals { grid-template-columns: 1fr; } }

    .trust-card {
        background: white;
        padding: 40px 32px;
        border-radius: 32px;
        text-align: center;
        border: 1px solid var(--slate-100);
        transition: all 0.3s;
    }

    .trust-card:hover { 
        transform: translateY(-8px); 
        border-color: var(--primary-100);
        box-shadow: var(--shadow-xl);
    }

    .trust-icon {
        width: 64px;
        height: 64px;
        background: var(--primary-50);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        margin: 0 auto 24px;
    }

    .trust-card h3 { font-size: 1.25rem; font-weight: 800; margin-bottom: 12px; letter-spacing: -0.5px; }
    .trust-card p { font-size: 0.95rem; color: var(--slate-500); line-height: 1.6; }

    /* Featured Properties */
    .section-title {
        margin-top: 140px;
        margin-bottom: 48px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
    }

    .property-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
        gap: 32px;
    }

    .prop-card {
        background: white;
        border-radius: 32px;
        overflow: hidden;
        text-decoration: none;
        color: inherit;
        border: 1px solid var(--slate-100);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .prop-card:hover { 
        transform: translateY(-10px); 
        box-shadow: var(--shadow-xl);
        border-color: var(--primary-100);
    }

    .prop-img-wrapper { position: relative; width: 100%; aspect-ratio: 16/10; overflow: hidden; }
    .prop-img { 
        width: 100%; 
        height: 100%; 
        object-fit: cover; 
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .prop-card:hover .prop-img { transform: scale(1.05); }

    .prop-content { padding: 32px; }
    .prop-price { 
        font-size: 1.75rem; 
        font-weight: 900; 
        color: var(--primary); 
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }
    .prop-title { 
        font-size: 1.25rem; 
        font-weight: 800; 
        color: var(--slate-900); 
        margin-bottom: 16px; 
    }
    
    .prop-meta {
        display: flex;
        gap: 20px;
        color: var(--slate-500);
        font-size: 0.95rem;
        font-weight: 500;
        border-top: 1px solid var(--slate-50);
        padding-top: 20px;
    }
</style>
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <section class="hero-section animate-fade-in">
        <h1>Encontre a sua casa <span style="color: var(--primary)">com total segurança</span> em Angola.</h1>
        <p>A única plataforma com imóveis 100% verificados e sistema de custódia para garantir o seu dinheiro.</p>
        
        <form action="/search" class="search-wrapper">
            <div class="search-group">
                <i data-lucide="search"></i>
                <input type="text" name="q" placeholder="Bairro, condomínio ou cidade...">
            </div>
            <div class="search-group">
                <i data-lucide="home"></i>
                <select name="type">
                    <option value="">Tipo de Imóvel</option>
                    <option value="apartment">Apartamento</option>
                    <option value="house">Vivenda / Casa</option>
                    <option value="office">Escritório</option>
                </select>
            </div>
            <button type="submit" class="btn-primary" style="padding: 0 48px; border-radius: 30px; height: 64px; font-size: 1.1rem;">Pesquisar Agora</button>
        </form>
    </section>

    <!-- Trust Signals -->
    <div class="trust-signals animate-fade-in" style="animation-delay: 0.1s">
        <div class="trust-card">
            <div class="trust-icon"><i data-lucide="shield-check"></i></div>
            <h3>Pagamento Seguro</h3>
            <p>Dinheiro retido até confirmação segura.</p>
        </div>
        <div class="trust-card">
            <div class="trust-icon"><i data-lucide="user-check"></i></div>
            <h3>Donos Verificados</h3>
            <p>Contas validadas com BI e Selfie.</p>
        </div>
        <div class="trust-card">
            <div class="trust-icon"><i data-lucide="landmark"></i></div>
            <h3>Sistema de Custódia</h3>
            <p>Garantia total em todas as rendas.</p>
        </div>
        <div class="trust-card">
            <div class="trust-icon"><i data-lucide="star"></i></div>
            <h3>Avaliações Reais</h3>
            <p>Feedback de inquilinos autênticos.</p>
        </div>
    </div>

    <!-- Featured Properties -->
    <div class="section-title animate-fade-in" style="animation-delay: 0.2s">
        <div>
            <h2 style="font-size: 2.2rem; letter-spacing: -1px;">Imóveis em Destaque</h2>
            <p style="color: var(--slate-500); font-weight: 500;">As melhores oportunidades verificadas pela nossa equipa.</p>
        </div>
        <a href="/alugar" class="nav-link" style="color: var(--primary); font-weight: 700;">Explorar todos →</a>
    </div>

    <section class="property-grid animate-fade-in" style="animation-delay: 0.3s">
        <?php if (empty($properties)): ?>
            <div style="grid-column: 1/-1; text-align: center; padding: 120px 40px; background: white; border-radius: 40px; border: 2px dashed var(--slate-200);">
                <p style="color: var(--slate-400); font-weight: 600; font-size: 1.2rem;">À procura de novas propriedades verificadas...</p>
            </div>
        <?php else: ?>
            <?php foreach ($properties as $property): ?>
                <a href="/property/<?= $property['id'] ?>" class="prop-card">
                    <div class="prop-img-wrapper">
                        <img src="<?= !empty($property['images']) ? json_decode($property['images'])[0] : 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&q=80&w=2070' ?>" class="prop-img">
                        <div class="badge-verified" style="position: absolute; top: 20px; left: 20px; background: white; color: var(--secondary);"><i data-lucide="shield-check" style="width: 14px"></i> Verificado</div>
                    </div>
                    <div class="prop-content">
                        <div class="prop-price"><?= number_format($property['price'], 0, ',', '.') ?> <span style="font-size: 0.9rem; color: var(--slate-500);">Kz/mês</span></div>
                        <h3 class="prop-title"><?= esc($property['title']) ?></h3>
                        <div class="prop-meta">
                            <span style="display: flex; align-items: center; gap: 8px;"><i data-lucide="bed" style="width: 18px;"></i> <?= $property['bedrooms'] ?> Quartos</span>
                            <span style="display: flex; align-items: center; gap: 8px;"><i data-lucide="map-pin" style="width: 18px;"></i> <?= esc($property['neighborhood']) ?></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
<?= $this->endSection() ?>
