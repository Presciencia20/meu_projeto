<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Comprar Imóvel | CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    /* Estilo App para Listagens (Sincronizado com Alugar) */
    .filter-chips {
        display: flex;
        gap: 12px;
        overflow-x: auto;
        padding: 5px 2px 20px;
        margin-bottom: 20px;
        scrollbar-width: none;
    }
    .filter-chips::-webkit-scrollbar { display: none; }

    .chip {
        padding: 10px 20px;
        background: white;
        border: 1px solid var(--gray-100);
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 700;
        text-decoration: none;
        color: var(--gray-600);
        white-space: nowrap;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }
    .chip.active {
        background: var(--app-primary);
        color: white;
        border-color: var(--app-primary);
        box-shadow: 0 5px 15px rgba(37, 99, 235, 0.2);
    }
    .chip i { font-size: 1.1rem; }

    /* Floating Filter Button */
    .filter-fab {
        position: fixed;
        bottom: 90px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--app-primary);
        color: white;
        padding: 0 28px;
        height: 54px;
        border-radius: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);
        z-index: 900;
        border: none;
        font-weight: 800;
        cursor: pointer;
        font-family: 'Outfit', sans-serif;
        font-size: 1rem;
        transition: 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .filter-sheet {
        position: fixed;
        bottom: -100%;
        left: 0;
        right: 0;
        height: 85vh;
        background: white;
        z-index: 2000;
        border-radius: 40px 40px 0 0;
        transition: bottom 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        padding: 40px 30px;
        overflow-y: auto;
        box-shadow: 0 -10px 40px rgba(0,0,0,0.1);
    }
    .filter-sheet.active { bottom: 0; }
    
    .filter-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.4);
        backdrop-filter: blur(4px);
        z-index: 1999;
        display: none;
        opacity: 0;
        transition: opacity 0.3s;
    }
    .filter-overlay.active { display: block; opacity: 1; }

    .sheet-handle {
        width: 40px;
        height: 4px;
        background: #e0e0e0;
        border-radius: 2px;
        margin: -20px auto 20px;
    }

    /* Pagination Styling */
    .pagination-container {
        margin: 3rem 0 8rem;
        display: flex;
        justify-content: center;
    }
    .pagination {
        display: flex;
        gap: 8px;
        list-style: none;
        padding: 0;
    }
    .pagination li a, .pagination li span {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: white;
        color: var(--gray-600);
        text-decoration: none;
        font-weight: 800;
        border: 1px solid var(--gray-100);
        transition: all 0.2s;
    }
    .pagination li.active span {
        background: var(--app-primary);
        color: white;
        border-color: var(--app-primary);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="filter-chips">
    <button class="chip" onclick="openFilterSheet('price')">
        <i class="ph-bold ph-bank"></i> Preço
    </button>
    <button class="chip" onclick="openFilterSheet('bedrooms')">
        <i class="ph-bold ph-bed"></i> Dormitórios
    </button>
    <button class="chip" onclick="openFilterSheet('location')">
        <i class="ph-bold ph-map-pin"></i> Cidade
    </button>
    <button class="chip active" onclick="openFilterSheet('all')">
        <i class="ph-bold ph-sliders-horizontal"></i> Filtros
    </button>
</div>

<div style="margin-bottom: 30px;">
    <h2 style="font-family: 'Outfit'; font-size: 2rem; font-weight: 900; letter-spacing: -1px; color: var(--gray-800); margin-bottom: 4px;">Imóveis à Venda</h2>
    <p style="color: var(--gray-500); font-weight: 500;">Oportunidades de investimento verificadas</p>
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
                <button class="btn-card-fav" onclick="event.preventDefault(); toggleFavorite(<?= $property['id'] ?>)">
                    <i class="ph-bold ph-heart"></i>
                </button>
            </div>
            <div class="property-card-content">
                <div class="property-card-price" style="font-family: 'Outfit'; font-weight: 900; font-size: 1.4rem; color: var(--app-primary);">
                    <?= number_format($property['price'], 0, ',', '.') ?> <small style="font-size: 0.8rem; color: var(--gray-400); font-weight: 700;">KZ</small>
                </div>
                <h3 class="property-card-title"><?= esc($property['title']) ?></h3>
                <div class="property-card-location">
                    <i class="ph-bold ph-map-pin"></i> <?= esc($property['neighborhood']) ?>
                </div>
                <div class="property-card-meta">
                    <div class="meta-pill"><i class="ph-duotone ph-bed"></i> T<?= $property['bedrooms'] ?></div>
                    <div class="meta-pill"><i class="ph-duotone ph-bathtub"></i> <?= $property['bathrooms'] ?></div>
                    <div class="meta-pill"><i class="ph-duotone ph-ruler"></i> <?= $property['area'] ?? 150 ?>m²</div>
                </div>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<!-- Pagination Links -->
<?php if (isset($pager)): ?>
    <div style="margin-top: 40px;">
        <?= $pager->links('default', 'premium') ?>
    </div>
<?php endif; ?>

<button class="filter-fab" id="openFilters"><i class="ph-bold ph-sliders-horizontal"></i> O que procura?</button>

<div class="filter-overlay" id="filterOverlay"></div>
<div class="filter-sheet" id="filterSheet">
    <div class="sheet-handle"></div>
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:40px;">
        <h2 style="font-family: 'Outfit'; font-size: 1.8rem; font-weight: 900; color: var(--gray-800);">Busca Avançada</h2>
        <button id="closeFilters" style="background:var(--gray-100); border:none; width:44px; height:44px; border-radius:50%; cursor:pointer; display:flex; align-items:center; justify-content:center;"><i class="ph-bold ph-x"></i></button>
    </div>
    <form action="/comprar" method="GET">
        <div class="filter-group">
            <label>Onde deseja investir?</label>
            <div style="position: relative;">
                <i class="ph-bold ph-map-pin" style="position: absolute; left: 20px; top: 18px; color: var(--app-primary); font-size: 1.2rem; z-index: 10;"></i>
                <input type="text" name="q" value="<?= esc($q) ?>" placeholder="Bairro ou Município..." class="input-modern" style="padding-left: 55px;">
            </div>
        </div>

        <div class="filter-group">
            <label>Faixa de Preço (KZ)</label>
            <div style="display:flex; gap:12px;">
                <input type="number" name="min_price" value="<?= esc($minPrice) ?>" placeholder="Mínimo" class="input-modern" style="flex:1;">
                <input type="number" name="max_price" value="<?= esc($maxPrice) ?>" placeholder="Máximo" class="input-modern" style="flex:1;">
            </div>
        </div>

        <button type="submit" class="btn-primary" style="margin-top:30px;">
            Filtrar Oportunidades <i class="ph-bold ph-magnifying-glass"></i>
        </button>
        <a href="/comprar" style="display: block; text-align: center; width:100%; margin-top:15px; color:var(--gray-400); font-weight:700; text-decoration: none; font-size: 0.9rem;">Limpar tudo</a>
    </form>
</div>

<script>
    const sheet = document.getElementById('filterSheet');
    const overlay = document.getElementById('filterOverlay');
    function toggleSheet(show) {
        if (show) { sheet.classList.add('active'); overlay.classList.add('active'); document.body.style.overflow = 'hidden'; } 
        else { sheet.classList.remove('active'); overlay.classList.remove('active'); document.body.style.overflow = ''; }
    }
    document.getElementById('openFilters').onclick = () => toggleSheet(true);
    document.getElementById('closeFilters').onclick = overlay.onclick = () => toggleSheet(false);
</script>
<?= $this->endSection() ?>