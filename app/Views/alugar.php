<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Arrendar Imóveis Verificados em Angola<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="/css/alugar.css?v=<?= time() ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="animate-fade-in">
        <header class="page-header">
            <h1 class="page-title">Arrendar em <span class="highlight">Angola</span></h1>
            <p class="page-description">Explore nossa seleção de imóveis verificados com segurança garantida.</p>
        </header>

        <div class="listing-layout">
            <!-- Sidebar -->
            <aside class="filter-sidebar">
                <form action="/alugar" method="GET">
                    <div class="filter-section">
                        <label class="filter-title"><i data-lucide="map-pin"></i> Localização</label>
                        <input type="text" name="q" value="<?= esc($q ?? '') ?>" class="input-modern" placeholder="Bairro ou Município...">
                    </div>

                    <div class="filter-section">
                        <label class="filter-title"><i data-lucide="banknote"></i> Preço Mensal (KZ)</label>
                        <div class="price-range">
                            <input type="number" name="min_price" value="<?= esc($minPrice ?? '') ?>" class="input-modern" placeholder="Mínimo">
                            <input type="number" name="max_price" value="<?= esc($maxPrice ?? '') ?>" class="input-modern" placeholder="Máximo">
                        </div>
                    </div>

                    <div class="filter-section">
                        <label class="filter-title"><i data-lucide="building"></i> Tipo de Imóvel</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label"><input type="checkbox" name="type[]" value="apartment" checked> <span>Apartamento</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="type[]" value="house"> <span>Moradia / Vivenda</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="type[]" value="room"> <span>Quarto</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="type[]" value="office"> <span>Escritório</span></label>
                        </div>
                    </div>

                    <div class="filter-section">
                        <label class="filter-title"><i data-lucide="bed-double"></i> Quartos</label>
                        <div class="checkbox-group">
                            <label class="checkbox-label"><input type="checkbox" name="bedrooms[]" value="1"> <span>T1</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="bedrooms[]" value="2"> <span>T2</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="bedrooms[]" value="3"> <span>T3</span></label>
                            <label class="checkbox-label"><input type="checkbox" name="bedrooms[]" value="4"> <span>T4+</span></label>
                        </div>
                    </div>

                    <div style="margin-top: 40px; display: flex; flex-direction: column; gap: 12px;">
                        <button type="submit" class="btn-primary filter-submit">Aplicar Filtros</button>
                        <a href="/alugar" class="clear-filters">Limpar tudo</a>
                    </div>
                </form>
            </aside>

            <!-- Results -->
            <main>
                <div class="listing-header">
                    <h2 class="results-count"><?= count($properties) ?> Resultados</h2>
                </div>

                <div class="results-grid">
                    <?php if (empty($properties)): ?>
                        <div class="no-results">
                            <div class="no-results-icon">
                                <i data-lucide="search-x"></i>
                            </div>
                            <h3 class="no-results-title">Nenhum imóvel encontrado</h3>
                            <p class="no-results-text">Tente ajustar seus filtros ou pesquisar por uma localização diferente.</p>
                            <a href="/alugar" class="btn-secondary">Limpar Filtros</a>
                        </div>
                    <?php else: ?>
                        <?php foreach ($properties as $property): ?>
                            <?php 
                                $imgUrls = !empty($property['images']) ? json_decode($property['images']) : [];
                                $firstImg = !empty($imgUrls) ? $imgUrls[0] : 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&q=80&w=1200';
                            ?>
                            <a href="/property/<?= $property['id'] ?>" class="listing-card">
                                <div class="listing-img-wrapper">
                                    <img src="<?= $firstImg ?>" class="listing-img" onerror="this.src='https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?auto=format&fit=crop&q=80&w=1200'">
                                    <div class="badge-verified"><i data-lucide="shield-check"></i> Verificado</div>
                                </div>
                                <div class="listing-content">
                                    <div class="price-tag"><?= number_format($property['price'], 0, ',', '.') ?> <span class="price-unit">Kz/mês</span></div>
                                    <h3 class="listing-title"><?= esc($property['title']) ?></h3>
                                    <p class="listing-location">
                                        <i data-lucide="map-pin"></i> <?= esc($property['neighborhood']) ?>, <?= esc($property['province'] ?? 'Luanda') ?>
                                    </p>
                                    
                                    <div class="meta-row">
                                        <div class="meta-item"><i data-lucide="bed"></i> <?= $property['bedrooms'] ?> Quartos</div>
                                        <div class="meta-item"><i data-lucide="bath"></i> <?= $property['bathrooms'] ?> Banhos</div>
                                    </div>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>
<?= $this->endSection() ?>
