<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Boas-vindas | CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    /* Executive Luxury Layout Override */
    body { background: #f8fafc; }
    .app-main { padding: 0 !important; }
    
    .hero-executive {
        background: linear-gradient(180deg, #1e293b 0%, #0f172a 100%);
        height: 280px;
        width: 100%;
        position: absolute;
        top: 0;
        left: 0;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding-top: 40px;
        color: white;
        text-align: center;
    }

    .hero-executive h2 { font-size: 1.25rem; opacity: 0.9; font-weight: 800; font-family: 'Outfit'; max-width: 320px; line-height: 1.4; margin-top: 10px; letter-spacing: -0.02em; }

    .executive-container {
        position: relative;
        z-index: 2;
        padding: 100px 24px 60px;
        max-width: 520px;
        margin: 0 auto;
    }

    /* Primary Dashboard Card */
    .executive-card {
        background: white;
        border-radius: 32px;
        padding: 40px 28px;
        box-shadow: 0 20px 40px rgba(0,0,0,0.06);
        margin-bottom: 24px;
        display: flex;
        flex-direction: column;
        gap: 24px;
        border: 1px solid rgba(255,255,255,0.8);
    }

    .brand-title {
        text-align: center;
        font-family: 'Outfit';
        font-size: 2.5rem;
        font-weight: 900;
        color: #1e293b;
        letter-spacing: -0.05em;
        margin-bottom: 12px;
    }

    .e-actions-grid {
        display: grid;
        grid-template-columns: 1fr 1.2fr 1fr;
        gap: 16px;
        align-items: stretch;
    }

    .e-action-item {
        background: #f8fafc;
        border-radius: 20px;
        padding: 20px 12px;
        text-decoration: none;
        color: inherit;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid #f1f5f9;
        min-height: 140px;
    }
    .e-action-item:hover { transform: translateY(-4px); background: white; border-color: var(--app-primary); box-shadow: 0 10px 20px rgba(0,0,0,0.04); }
    
    .e-action-large {
        background: white;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 12px rgba(0,0,0,0.02);
        padding: 24px 12px;
    }

    .e-icon-box {
        font-size: 2rem;
        margin-bottom: 12px;
        color: var(--app-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        height: 48px;
    }

    .e-label { font-size: 0.95rem; font-weight: 800; color: #1e293b; font-family: 'Outfit'; line-height: 1.2; }
    .e-sublabel { font-size: 0.7rem; color: #64748b; margin-top: 6px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.02em; }

    /* Search Interaction (Premium) */
    .executive-search-bar {
        background: white;
        border-radius: 24px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 10px 20px rgba(0,0,0,0.04);
        margin-bottom: 20px;
        cursor: pointer;
        border: 1px solid #f1f5f9;
        transition: all 0.3s;
    }
    .executive-search-bar:hover { border-color: var(--app-primary); transform: translateY(-2px); box-shadow: 0 15px 30px rgba(0,0,0,0.06); }
    .executive-search-bar i { color: var(--app-primary); font-size: 1.4rem; }
    .executive-search-bar span { flex: 1; color: #475569; font-weight: 600; font-size: 1rem; }

    /* List components */
    .executive-list {
        background: white;
        border-radius: 28px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.03);
        border: 1px solid #f1f5f9;
    }

    .e-list-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 18px 24px;
        text-decoration: none;
        color: inherit;
        border-bottom: 1px solid #f8fafc;
        transition: background 0.2s;
    }
    .e-list-item:last-child { border-bottom: none; }
    .e-list-item:hover { background: #f8fafc; }
    
    .e-list-icon {
        width: 48px;
        height: 48px;
        background: #f8fafc;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--app-primary);
        font-size: 1.4rem;
        border: 1px solid #f1f5f9;
    }

    .e-list-info { flex: 1; }
    .e-list-title { font-size: 1rem; font-weight: 800; color: #1e293b; font-family: 'Outfit'; }
    .e-list-meta { font-size: 0.75rem; color: #94a3b8; font-weight: 600; }

    /* Filter Components */
    .filter-chips { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 15px; margin: 10px 0 20px; scrollbar-width: none; }
    .filter-chips::-webkit-scrollbar { display: none; }
    .chip { padding: 10px 20px; background: white; border: 1px solid #f1f5f9; border-radius: 50px; font-size: 0.85rem; font-weight: 700; color: #475569; white-space: nowrap; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: 0.2s; box-shadow: 0 4px 10px rgba(0,0,0,0.02); }
    .chip.active { background: var(--app-primary); color: white; border-color: var(--app-primary); }

    .filter-sheet { position: fixed; bottom: -100%; left: 0; right: 0; height: 80vh; background: white; z-index: 2000; border-radius: 40px 40px 0 0; transition: 0.5s cubic-bezier(0.16, 1, 0.3, 1); padding: 40px 30px; overflow-y: auto; box-shadow: 0 -10px 40px rgba(0,0,0,0.1); }
    .filter-sheet.active { bottom: 0; }
    .filter-overlay { position: fixed; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(4px); z-index: 1999; display: none; }
    .filter-overlay.active { display: block; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (!empty($properties)): ?>
    <!-- Search Results View -->
    <div class="search-results-container animate-fade-in" style="padding: 20px 0 100px;">
        
        <!-- Global Search Bar for Results -->
        <div class="executive-search-bar" style="margin-bottom: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid #f1f5f9; padding: 12px 20px;">
            <form action="/search" method="GET" style="display: flex; align-items: center; width: 100%; gap: 12px;">
                <i class="ph-bold ph-magnifying-glass" style="color: var(--app-primary);"></i>
                <input type="text" name="q" value="<?= esc($q) ?>" placeholder="Pesquisar Bairro, Cidade ou Tipo de Casa..." style="border: none; outline: none; flex: 1; font-weight: 700; font-family: 'Inter'; font-size: 1rem; background: transparent;">
                <button type="submit" class="btn-app-primary" style="height: 44px; width: auto; padding: 0 20px; font-size: 0.85rem;">Pesquisar</button>
            </form>
        </div>

        <!-- Filter Chips -->
        <div class="filter-chips">
            <button class="chip" onclick="openFilterSheet()">
                <i class="ph-bold ph-bed"></i> Quartos
            </button>
            <button class="chip" onclick="openFilterSheet()">
                <i class="ph-bold ph-currency-circle-dollar"></i> Preço
            </button>
            <button class="chip active" onclick="openFilterSheet()">
                <i class="ph-bold ph-sliders-horizontal"></i> Filtros Avançados
            </button>
        </div>

        <div style="margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h2 style="font-family: 'Outfit'; font-size: 1.75rem; font-weight: 900; color: var(--gray-800); margin: 0;">Resultados Encontrados</h2>
                <p style="color: var(--gray-500); font-weight: 500; margin: 4px 0 0;"><?= count($properties) ?> opções verificadas para "<?= esc($q) ?>"</p>
            </div>
            <a href="/" class="btn-circle" style="background: var(--gray-100);"><i class="ph-bold ph-x"></i></a>
        </div>

        <div class="app-grid">
            <?php foreach ($properties as $property): ?>
                <?php 
                    $images = !empty($property['images']) ? json_decode($property['images'], true) : [];
                    $firstImage = !empty($images) ? $images[0] : '/img/placeholder-house.jpg';
                ?>
                <a href="/property/<?= $property['id'] ?>" class="property-card">
                    <div class="property-card-img">
                        <img src="<?= $firstImage ?>" alt="<?= esc($property['title']) ?>" loading="lazy">
                        <?php if ($property['is_verified']): ?>
                            <div class="property-card-badge" style="background: #ecfdf5; color: #059669; border: none; font-weight: 800;">
                                <i class="ph-fill ph-shield-check"></i> Verificado
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="property-card-content">
                        <div class="property-card-price" style="color: var(--app-primary); font-family: 'Outfit'; font-weight: 900; font-size: 1.4rem;">
                            <?= number_format($property['price'], 0, ',', '.') ?> <small style="font-size: 0.8rem; opacity: 0.6;">KZ</small>
                        </div>
                        <h3 class="property-card-title"><?= esc($property['title']) ?></h3>
                        <div class="property-card-location">
                            <i class="ph-bold ph-map-pin"></i> <?= esc($property['neighborhood']) ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Filter Sheet -->
        <div class="filter-overlay" id="filterOverlay"></div>
        <div class="filter-sheet" id="filterSheet">
            <h2 style="font-family: 'Outfit'; font-size: 1.8rem; font-weight: 900; color: var(--gray-800); margin-bottom: 30px;">Refinar Busca</h2>
            
            <form action="/search" method="GET">
                <input type="hidden" name="q" value="<?= esc($q) ?>">
                
                <div class="filter-group">
                    <label>Tipo de Imóvel</label>
                    <select name="type" class="input-modern">
                        <option value="">Todos os tipos</option>
                        <option value="Apartamento" <?= (isset($type) && $type == 'Apartamento') ? 'selected' : '' ?>>Apartamento</option>
                        <option value="Vivenda" <?= (isset($type) && $type == 'Vivenda') ? 'selected' : '' ?>>Vivenda</option>
                        <option value="Escritório" <?= (isset($type) && $type == 'Escritório') ? 'selected' : '' ?>>Escritório</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Dormitórios</label>
                    <select name="bedrooms" class="input-modern">
                        <option value="">Qualquer quantidade</option>
                        <option value="1" <?= (isset($bedrooms) && $bedrooms == 1) ? 'selected' : '' ?>>T1 ou superior</option>
                        <option value="2" <?= (isset($bedrooms) && $bedrooms == 2) ? 'selected' : '' ?>>T2 ou superior</option>
                        <option value="3" <?= (isset($bedrooms) && $bedrooms == 3) ? 'selected' : '' ?>>T3 ou superior</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Faixa de Preço (KZ)</label>
                    <div style="display:flex; gap:12px;">
                        <input type="number" name="min_price" value="<?= $minPrice ?? '' ?>" placeholder="Min" class="input-modern" style="flex:1;">
                        <input type="number" name="max_price" value="<?= $maxPrice ?? '' ?>" placeholder="Max" class="input-modern" style="flex:1;">
                    </div>
                </div>

                <button type="submit" class="btn-primary" style="margin-top:20px;">Aplicar Filtros</button>
            </form>
        </div>

        <script>
            const sheet = document.getElementById('filterSheet');
            const overlay = document.getElementById('filterOverlay');
            function openFilterSheet() {
                sheet.classList.add('active');
                overlay.classList.add('active');
            }
            overlay.onclick = () => {
                sheet.classList.remove('active');
                overlay.classList.remove('active');
            }
        </script>

        <!-- Pagination -->
        <?php if (isset($pager)): ?>
            <div style="margin-top: 40px;">
                <?= $pager->links('default', 'premium') ?>
            </div>
        <?php endif; ?>
        
        <div style="text-align: center; margin-top: 40px;">
            <p style="color: var(--gray-400); font-weight: 600; font-size: 0.9rem;">Não encontrou o que procurava?</p>
            <a href="/search" class="btn btn-primary" style="display: inline-flex; width: auto; padding: 0 40px; margin-top: 10px; height: 54px; border-radius: 50px;">
                Tentar nova busca <i class="ph-bold ph-magnifying-glass"></i>
            </a>
        </div>
    </div>

<?php else: ?>
    <!-- Brand Background -->
    <div class="hero-executive">
    </div>

    <div class="executive-container">
        <!-- Main Floating Card -->
        <div class="executive-card animate-fade-in" style="animation-delay: 0.1s">
            <div class="brand-title">CasaSegura</div>
            
            <div class="e-actions-grid">
                <a href="/alugar" class="e-action-item">
                    <div class="e-icon-box"><i class="ph-bold ph-key"></i></div>
                    <div class="e-label">Arrendar</div>
                    <div class="e-sublabel">Opções</div>
                </a>

                <a href="/property/create" class="e-action-item e-action-large">
                    <div class="e-icon-box" style="font-size: 3rem; color: var(--app-primary);"><i class="ph-bold ph-house-line"></i></div>
                    <div class="e-label" style="font-size: 1.1rem;">Anunciar</div>
                    <div class="e-sublabel" style="color: var(--app-primary);">Premium</div>
                </a>

                <a href="/comprar" class="e-action-item">
                    <div class="e-icon-box"><i class="ph-bold ph-handshake"></i></div>
                    <div class="e-label">Investir</div>
                    <div class="e-sublabel">Direto</div>
                </a>
            </div>
        </div>

        <!-- Search Interaction -->
        <div onclick="window.location='<?= site_url('search') ?>'" class="executive-search-bar animate-fade-in" style="animation-delay: 0.1s; margin-top: 24px;">
            <i class="ph-bold ph-magnifying-glass"></i>
            <span>Bairro ou condomínio...</span>
            <i class="ph-bold ph-arrow-right" style="font-size: 1.1rem; opacity: 0.5;"></i>
        </div>

        <!-- Recent Actions / Saved Places Style -->
        <div class="executive-list animate-fade-in" style="animation-delay: 0.3s">
            <a href="/search?q=Condomínio" class="e-list-item">
                <div class="e-list-icon"><i class="ph-fill ph-shield-star"></i></div>
                <div class="e-list-info">
                    <span class="e-list-meta" style="float: right;">Filtro VIP</span>
                    <div class="e-list-title">Condomínios</div>
                </div>
            </a>
            <a href="/favorites" class="e-list-item">
                <div class="e-list-icon" style="color: #ef4444; background: #fff1f2;"><i class="ph-fill ph-heart"></i></div>
                <div class="e-list-info">
                    <span class="e-list-meta" style="float: right;">Acesso</span>
                    <div class="e-list-title">Meus Favoritos</div>
                </div>
            </a>
        </div>

        <!-- Guidance Section -->
        <div style="margin-top: 56px;">
            <h3 style="font-family: 'Outfit'; font-weight: 800; font-size: 1.2rem; color: #1e293b; margin-bottom: 24px; text-align: center;">Ecossistema CasaSegura</h3>
            <div style="display: grid; grid-template-columns: 1fr; gap: 16px;">
                <div style="background: white; padding: 24px; border-radius: 24px; display: flex; align-items: center; gap: 20px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                    <div style="width: 52px; height: 52px; background: #eff6ff; color: var(--app-primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="ph-bold ph-fingerprint"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; font-size: 1rem; color: #1e293b; font-family: 'Outfit';">Identidade Verificada</div>
                        <p style="font-size: 0.8rem; color: #64748b; margin: 4px 0 0; font-weight: 500;">Biometria para segurança total.</p>
                    </div>
                </div>
                
                <div style="background: white; padding: 24px; border-radius: 24px; display: flex; align-items: center; gap: 20px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                    <div style="width: 52px; height: 52px; background: #f5f3ff; color: #6366f1; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="ph-bold ph-scroll"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; font-size: 1rem; color: #1e293b; font-family: 'Outfit';">Contratos Digitais</div>
                        <p style="font-size: 0.8rem; color: #64748b; margin: 4px 0 0; font-weight: 500;">Validade jurídica sem intermediários.</p>
                    </div>
                </div>

                <div style="background: white; padding: 24px; border-radius: 24px; display: flex; align-items: center; gap: 20px; border: 1px solid #f1f5f9; box-shadow: 0 4px 12px rgba(0,0,0,0.02);">
                    <div style="width: 52px; height: 52px; background: #ecfdf5; color: #10b981; border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem;">
                        <i class="ph-bold ph-shield-checkered"></i>
                    </div>
                    <div>
                        <div style="font-weight: 800; font-size: 1rem; color: #1e293b; font-family: 'Outfit';">Pagamento Protegido</div>
                        <p style="font-size: 0.8rem; color: #64748b; margin: 4px 0 0; font-weight: 500;">Garantia de recebimento seguro.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Banner Opcional -->
        <div style="margin-top: 48px; border-radius: 28px; overflow: hidden; height: 160px; background: #1e293b; position: relative; border: 1px solid rgba(255,255,255,0.05);">
            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?auto=format&fit=crop&q=80&w=600" style="width: 100%; height: 100%; object-fit: cover; opacity: 0.3;">
            <div style="position: absolute; bottom: 24px; left: 24px; right: 24px; color: white;">
                <div style="font-weight: 800; font-family: 'Outfit'; font-size: 1.4rem; letter-spacing: -0.02em;">Garantia Institucional</div>
                <div style="font-size: 0.85rem; opacity: 0.8; font-weight: 500; margin-top: 4px;">O seu investimento imobiliário protegido por tecnologia de ponta.</div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?= $this->endSection() ?>