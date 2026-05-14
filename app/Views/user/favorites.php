<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Meus Favoritos - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="favorites-wrapper animate-fade-in" style="padding-bottom: 5rem;">
    <div class="page-header" style="margin-bottom: 2.5rem; display: flex; align-items: center; gap: 1rem;">
        <div style="width: 54px; height: 54px; background: #fff1f2; color: #e11d48; border-radius: 16px; display: flex; align-items: center; justify-content: center;">
            <i class="ph-duotone ph-heart" style="font-size: 2rem;"></i>
        </div>
        <div>
            <h1 style="font-family: 'Outfit'; font-weight: 900; color: var(--gray-800); font-size: 2rem; letter-spacing: -1px; margin: 0;">Meus Favoritos</h1>
            <p style="color: var(--gray-500); font-weight: 500; font-size: 0.95rem; margin: 0;">Imóveis que captaram a sua atenção.</p>
        </div>
    </div>

    <?php if (empty($favorites)): ?>
        <div class="empty-favorites" style="text-align: center; padding: 5rem 2rem; background: white; border-radius: 32px; border: 1px solid var(--gray-100); box-shadow: 0 10px 40px rgba(0,0,0,0.03);">
            <div style="width: 100px; height: 100px; background: #f8fafc; color: var(--gray-300); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem;">
                <i class="ph-duotone ph-house-line" style="font-size: 4rem;"></i>
            </div>
            <h3 style="font-family: 'Outfit'; font-weight: 900; font-size: 1.5rem; color: var(--gray-800); margin-bottom: 0.75rem;">Ainda sem favoritos</h3>
            <p style="color: var(--gray-500); margin-bottom: 2rem; max-width: 320px; margin-left: auto; margin-right: auto; line-height: 1.6;">Explore a nossa seleção de imóveis verificados e guarde os que mais gostar clicando no ícone do coração.</p>
            <a href="/alugar" class="btn btn-primary" style="padding: 1rem 2.5rem; border-radius: 18px; font-weight: 800; box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);">
                Explorar Imóveis <i class="ph-bold ph-magnifying-glass"></i>
            </a>
        </div>
    <?php else: ?>
        <div class="app-grid">
            <?php foreach ($favorites as $property): ?>
                <?php 
                    $images = json_decode($property['images'], true);
                    $firstImage = !empty($images) ? $images[0] : '/img/placeholder-house.jpg';
                ?>
                <a href="/property/<?= $property['property_id'] ?>" class="property-card">
                    <div class="property-card-img">
                        <img src="<?= $firstImage ?>" alt="<?= esc($property['title']) ?>" loading="lazy">
                        <div class="property-card-badge" style="background: #fff1f2; color: #e11d48; border: none;">
                            <i class="ph-fill ph-heart"></i> Guardado
                        </div>
                    </div>
                    <div class="property-card-content">
                        <div class="property-card-price">
                            <?= number_format($property['price'], 0, ',', '.') ?> <small>KZ/mês</small>
                        </div>
                        <h3 class="property-card-title"><?= esc($property['title']) ?></h3>
                        <div class="property-card-location">
                            <i class="ph-bold ph-map-pin"></i> <?= esc($property['neighborhood']) ?>, <?= esc($property['municipality']) ?>
                        </div>
                        <div class="property-card-meta">
                            <div class="meta-pill"><i class="ph-duotone ph-bed"></i> T<?= $property['bedrooms'] ?></div>
                            <div class="meta-pill"><i class="ph-duotone ph-bathtub"></i> <?= $property['bathrooms'] ?></div>
                            <div class="meta-pill"><i class="ph-duotone ph-buildings"></i> <?= $property['type'] ?></div>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endSection(); ?>

