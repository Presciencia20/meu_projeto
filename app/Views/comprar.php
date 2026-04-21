<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Comprar Imóvel em Angola<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    /* Page Hero */
    .page-hero {
        padding: 60px 0 40px;
        text-align: center;
    }

    .page-hero h1 {
        font-size: 3.5rem;
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 24px;
        letter-spacing: -2px;
        line-height: 1;
    }

    .page-hero p {
        color: var(--slate-500);
        font-size: 1.2rem;
        max-width: 640px;
        margin: 0 auto;
        font-weight: 500;
        line-height: 1.8;
    }

    /* Filters */
    .filters-bar {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        align-items: center;
        background: white;
        padding: 12px;
        border-radius: 32px;
        border: 1px solid var(--slate-100);
        box-shadow: var(--shadow-xl);
        margin: 40px auto 80px;
        max-width: 1000px;
    }

    .filter-group {
        display: flex;
        align-items: center;
        gap: 12px;
        flex: 1;
        min-width: 200px;
        padding: 0 20px;
        border-right: 1px solid var(--slate-100);
    }

    .filter-group:last-of-type {
        border-right: none;
    }

    .filter-group i { color: var(--primary); flex-shrink: 0; width: 20px; }
    
    .filter-group select,
    .filter-group input {
        border: none;
        background: transparent;
        outline: none;
        font-size: 0.95rem;
        font-weight: 600;
        color: var(--slate-900);
        width: 100%;
        padding: 16px 0;
    }

    /* Stats Banner */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 32px;
        margin-bottom: 80px;
    }

    .stat-card {
        background: white;
        border: 1px solid var(--slate-100);
        border-radius: 32px;
        padding: 40px 32px;
        text-align: center;
        transition: transform 0.3s;
    }

    .stat-card:hover { transform: translateY(-5px); }

    .stat-card .stat-number {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--primary);
        line-height: 1;
        margin-bottom: 8px;
        letter-spacing: -1px;
    }

    .stat-card .stat-label {
        font-size: 0.9rem;
        color: var(--slate-500);
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Property Grid */
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 40px;
    }

    .section-header h2 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--slate-900);
        letter-spacing: -1px;
    }

    .property-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 32px;
        margin-bottom: 100px;
    }

    .property-card {
        background: white;
        border-radius: 32px;
        overflow: hidden;
        border: 1px solid var(--slate-100);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        color: inherit;
    }

    .property-card:hover {
        transform: translateY(-8px);
        box-shadow: var(--shadow-xl);
        border-color: var(--primary-100);
    }

    .img-wrapper { 
        position: relative; 
        overflow: hidden; 
        aspect-ratio: 16/10;
        background: var(--slate-100);
    }
    
    .img-wrapper img { 
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); 
    }

    .property-card:hover .img-wrapper img { transform: scale(1.05); }

    .property-badges {
        position: absolute;
        top: 20px;
        left: 20px;
        display: flex;
        gap: 10px;
    }

    .badge-tag {
        padding: 6px 14px;
        border-radius: 99px;
        font-size: 0.75rem;
        font-weight: 800;
        backdrop-filter: blur(12px);
    }

    .badge-venda {
        background: rgba(26, 86, 219, 0.9);
        color: white;
    }

    .property-content { padding: 32px; }

    .property-price {
        font-size: 1.75rem;
        font-weight: 900;
        color: var(--primary);
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .property-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--slate-900);
        margin-bottom: 16px;
        line-height: 1.3;
    }

    .property-meta {
        display: flex;
        gap: 20px;
        color: var(--slate-500);
        font-size: 0.9rem;
        font-weight: 500;
        padding-top: 20px;
        border-top: 1px solid var(--slate-50);
    }

    .meta-item { display: flex; align-items: center; gap: 8px; }

    /* CTA Banner */
    .cta-banner {
        background: linear-gradient(135deg, var(--primary), #4F46E5);
        border-radius: 40px;
        padding: 80px 48px;
        text-align: center;
        color: white;
        margin-bottom: 100px;
        position: relative;
        overflow: hidden;
    }

    .cta-banner h2 { 
        font-size: 2.5rem; 
        font-weight: 900; 
        margin-bottom: 16px; 
        letter-spacing: -1px;
    }

    .cta-banner p { 
        font-size: 1.2rem; 
        opacity: 0.9; 
        margin-bottom: 40px; 
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-white {
        background: white;
        color: var(--primary);
        padding: 18px 40px;
        border-radius: 20px;
        font-weight: 800;
        text-decoration: none;
        font-size: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 12px;
        transition: all 0.3s;
    }

    .btn-white:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,0,0,0.2); }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <section class="page-hero animate-fade-in">
        <div class="badge-verified" style="background: var(--primary-50); color: var(--primary); margin-bottom: 24px;">
            <i data-lucide="home" style="width:16px;height:16px"></i>
            Imóveis para Compra
        </div>
        <h1>Compre o seu <span style="color: var(--primary)">lar de sonho</span><br>em Angola.</h1>
        <p>Encontre apartamentos, vivendas e terrenos verificados nas melhores localizações de Angola, com total segurança e transparência.</p>
    </section>

    <!-- Filters -->
    <form action="/comprar" method="get" class="filters-bar animate-fade-in">
        <div class="filter-group">
            <i data-lucide="map-pin"></i>
            <input type="text" name="q" placeholder="Localização, bairro..." value="<?= esc($q ?? '') ?>">
        </div>
        <div class="filter-group">
            <i data-lucide="building-2"></i>
            <select name="province">
                <option value="">Província</option>
                <option value="Luanda" <?= ($province ?? '') == 'Luanda' ? 'selected' : '' ?>>Luanda</option>
                <option value="Benguela" <?= ($province ?? '') == 'Benguela' ? 'selected' : '' ?>>Benguela</option>
                <option value="Huíla" <?= ($province ?? '') == 'Huíla' ? 'selected' : '' ?>>Huíla</option>
            </select>
        </div>
        <div class="filter-group">
            <i data-lucide="bed-double"></i>
            <select name="bedrooms">
                <option value="">Quartos</option>
                <option value="1">T1</option>
                <option value="2">T2</option>
                <option value="3">T3</option>
                <option value="4">T4+</option>
            </select>
        </div>
        <div class="filter-group" style="min-width: 300px;">
            <i data-lucide="tag"></i>
            <div style="display: flex; gap: 8px; flex: 1;">
                <input type="number" name="min_price" value="<?= esc($minPrice ?? '') ?>" placeholder="Preço Min" style="padding: 16px 12px;">
                <input type="number" name="max_price" value="<?= esc($maxPrice ?? '') ?>" placeholder="Preço Max" style="padding: 16px 12px;">
            </div>
        </div>
        <button type="submit" class="btn-primary" style="padding: 0 32px; height: 60px; border-radius: 20px;">
            Pesquisar
        </button>
    </form>

    <!-- Stats -->
    <div class="stats-row animate-fade-in">
        <div class="stat-card">
            <div class="stat-number"><?= count($properties) ?>+</div>
            <div class="stat-label">Disponíveis</div>
        </div>
        <div class="stat-card">
            <div class="stat-number"><?= count(array_filter($properties, fn($p) => $p['is_verified'] ?? false)) ?>+</div>
            <div class="stat-label">Verificados</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">18</div>
            <div class="stat-label">Províncias</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">100%</div>
            <div class="stat-label">Seguro</div>
        </div>
    </div>

    <!-- Property Listing -->
    <div class="section-header">
        <h2>Imóveis à Venda</h2>
        <span class="count"><?= count($properties) ?> resultado<?= count($properties) !== 1 ? 's' : '' ?> encontrado<?= count($properties) !== 1 ? 's' : '' ?></span>
    </div>

    <section class="property-grid animate-fade-in">
        <?php if (empty($properties)): ?>
            <div class="empty-state">
                <i data-lucide="search-x"></i>
                <h3 style="font-size: 1.5rem; color: var(--slate-900); margin-bottom: 8px;">Nenhum imóvel encontrado</h3>
                <p>Tente ajustar os filtros acima para encontrar o que procura.</p>
            </div>
        <?php else: ?>
            <?php foreach ($properties as $property): ?>
                <?php 
                    $imgUrls = !empty($property['images']) ? json_decode($property['images']) : [];
                    $firstImg = !empty($imgUrls) ? $imgUrls[0] : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&q=80&w=1200';
                ?>
                <a href="/property/<?= $property['id'] ?>" class="property-card">
                    <div class="img-wrapper">
                        <img src="<?= $firstImg ?>" alt="<?= esc($property['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&q=80&w=1200'">
                        <div class="property-badges">
                            <span class="badge-tag badge-venda">Venda</span>
                            <?php if (($property['is_verified'] ?? false) || ($property['owner_id'] ?? 0) > 0): ?>
                                <span class="badge-verified" style="background: white; color: var(--secondary);"><i data-lucide="shield-check" style="width: 14px"></i> Verificado</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="property-content">
                        <div class="property-price"><?= number_format($property['price'], 0, ',', '.') ?> KZ</div>
                        <h3 class="property-title"><?= esc($property['title']) ?></h3>
                        <div class="property-meta">
                            <div class="meta-item"><i data-lucide="bed"></i> <?= $property['bedrooms'] ?> Quartos</div>
                            <div class="meta-item"><i data-lucide="bath"></i> <?= $property['bathrooms'] ?> Banhos</div>
                            <div class="meta-item"><i data-lucide="map-pin"></i> <?= esc($property['neighborhood']) ?></div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <!-- CTA -->
    <div class="cta-banner animate-fade-in">
        <h2>Tem um imóvel para vender?</h2>
        <p>Publique gratuitamente no CasaSegura e alcance milhares de compradores verificados em Angola.</p>
        <a href="/signup" class="btn-white">Publicar Imóvel Agora <i data-lucide="arrow-right"></i></a>
    </div>

<?= $this->endSection() ?>
