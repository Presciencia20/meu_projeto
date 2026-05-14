<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?><?= esc($property['title']) ?> - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<style>
    /* Premium Header */
    .p-header-v2 {
        margin-bottom: 2rem;
        padding: 0 1rem;
    }

    .p-badge-verified {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #ecfdf5;
        color: #059669;
        padding: 0.5rem 1rem;
        border-radius: 50px;
        font-weight: 800;
        font-size: 0.75rem;
        text-transform: uppercase;
        border: 1px solid #10b98120;
        margin-bottom: 1rem;
    }

    .p-title-v2 {
        font-family: 'Outfit';
        font-weight: 900;
        font-size: 2.25rem;
        color: var(--gray-800);
        letter-spacing: -1px;
        line-height: 1.1;
        margin-bottom: 0.5rem;
    }

    .p-location-v2 {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--gray-500);
        font-weight: 600;
    }

    /* Modern Gallery System */
    .p-gallery-shell {
        margin: 0 -1rem 2.5rem;
        position: relative;
    }

    .p-main-img-wrap {
        height: 450px;
        width: 100%;
        overflow: hidden;
        position: relative;
    }

    @media (min-width: 992px) {
        .p-gallery-shell { margin: 0 0 3rem; border-radius: 32px; overflow: hidden; }
        .p-main-img-wrap { height: 550px; }
    }

    .p-main-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Floating Detail Card (Pricing) */
    .p-price-card {
        background: white;
        padding: 2rem;
        border-radius: 28px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.06);
        border: 1px solid var(--gray-100);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: -3rem;
        position: relative;
        z-index: 10;
        margin-left: 1rem;
        margin-right: 1rem;
    }

    @media (min-width: 992px) {
        .p-price-card { margin-top: -4rem; padding: 2.5rem 3rem; }
    }

    .p-price-value {
        font-family: 'Outfit';
        font-weight: 900;
        font-size: 2.5rem;
        color: var(--app-primary);
        letter-spacing: -1px;
    }

    .p-price-value span {
        font-weight: 700;
        font-size: 1rem;
        color: var(--gray-500);
        margin-left: 4px;
        text-transform: uppercase;
    }

    /* Info Grids */
    .p-feature-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin: 2.5rem 1rem;
    }

    .p-feature-box {
        background: #f8fafc;
        padding: 1.5rem 1rem;
        border-radius: 24px;
        text-align: center;
        border: 1px solid var(--gray-100);
    }

    .p-feature-box i {
        font-size: 1.5rem;
        color: var(--app-primary);
        margin-bottom: 0.5rem;
    }

    .p-feature-box div {
        font-weight: 900;
        font-size: 1.1rem;
        color: var(--gray-800);
    }

    .p-feature-box span {
        font-size: 0.65rem;
        font-weight: 800;
        color: var(--gray-400);
        text-transform: uppercase;
    }

    /* Description Section */
    .p-desc-section {
        padding: 0 1.25rem;
        margin-bottom: 3rem;
    }

    .p-section-title {
        font-family: 'Outfit';
        font-weight: 900;
        font-size: 1.5rem;
        margin-bottom: 1rem;
        color: var(--gray-800);
    }

    .p-desc-text {
        color: var(--gray-600);
        line-height: 1.8;
        font-size: 1.05rem;
        font-weight: 500;
    }

    /* Owner Card Premium */
    .p-owner-card {
        margin: 0 1rem 100px;
        background: var(--app-primary-50);
        border: 1px solid var(--app-primary-50);
        padding: 2rem;
        border-radius: 32px;
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .avatar-owner-large {
        width: 72px;
        height: 72px;
        background: var(--app-primary);
        color: white;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit';
        font-weight: 900;
        font-size: 1.8rem;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
    }

    /* Sticky Bar V2 */
    .sticky-action-bar {
        position: fixed;
        bottom: 100px;
        left: 1rem;
        right: 1rem;
        background: white;
        padding: 1.25rem 1.5rem;
        border-radius: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        z-index: 1000;
        border: 1px solid var(--gray-100);
        animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @media (max-width: 480px) {
        .sticky-action-bar { bottom: 90px; }
    }
</style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="animate-fade-in">
    <!-- Header Info -->
    <header class="p-header-v2">
        <?php if ($property['is_verified']): ?>
            <div class="p-badge-verified">
                <i class="ph-fill ph-shield-check"></i> Imóvel Verificado
            </div>
        <?php endif; ?>
        <h1 class="p-title-v2"><?= esc($property['title']) ?></h1>
        <div class="p-location-v2">
            <i class="ph-bold ph-map-pin" style="color: var(--app-primary);"></i>
            <?= esc($property['neighborhood']) ?>, <?= esc($property['municipality']) ?>
        </div>
    </header>

    <!-- Main Gallery -->
    <section class="p-gallery-shell">
        <?php 
            $images = !empty($property['images']) ? json_decode($property['images']) : [];
            $mainImg = !empty($images) ? $images[0] : '/img/placeholder-house.jpg';
        ?>
        <div class="p-main-img-wrap">
            <img src="<?= $mainImg ?>" class="p-main-img" alt="<?= esc($property['title']) ?>">
        </div>
    </section>

    <!-- Price Card -->
    <div class="p-price-card">
        <div>
            <div style="font-size: 0.75rem; font-weight: 800; color: var(--app-primary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">
                <i class="ph-fill ph-user-circle"></i> <?= esc($owner['full_name']) ?>
            </div>
            <div class="p-price-value">
                <?= number_format($property['price'], 0, ',', '.') ?> <span>KZ/Mês</span>
            </div>
        </div>
        <button class="btn-circle" style="width: 52px; height: 52px; background: #fff1f2; color: #e11d48; border: none;">
            <i class="ph-bold ph-heart" style="font-size: 1.5rem;"></i>
        </button>
    </div>

    <!-- Feature Stats -->
    <section class="p-feature-grid">
        <div class="p-feature-box">
            <i class="ph-duotone ph-bed"></i>
            <div>T<?= $property['bedrooms'] ?></div>
            <span>Quartos</span>
        </div>
        <div class="p-feature-box">
            <i class="ph-duotone ph-bathtub"></i>
            <div><?= $property['bathrooms'] ?></div>
            <span>Banheiros</span>
        </div>
        <div class="p-feature-box">
            <i class="ph-duotone ph-ruler"></i>
            <div><?= $property['area'] ?? 120 ?>m²</div>
            <span>Área Total</span>
        </div>
    </section>

    <!-- Description -->
    <section class="p-desc-section" style="margin-top: 4rem;">
        <h2 class="p-section-title">Sobre este imóvel</h2>
        <div class="p-desc-text">
            <?= nl2br(esc($property['description'])) ?>
        </div>
    </section>

    <!-- Owner Card -->
    <section class="p-owner-card" style="margin-top: 4rem;">
        <div class="avatar-owner-large">
            <?= strtoupper(substr($owner['full_name'], 0, 1)) ?>
        </div>
        <div>
            <div style="font-family: 'Outfit'; font-weight: 800; font-size: 1.15rem; color: var(--gray-800); margin-bottom: 2px;">
                <?= esc($owner['full_name']) ?>
            </div>
            <div style="display: flex; align-items: center; gap: 4px; font-size: 0.8rem; color: #059669; font-weight: 700;">
                <i class="ph-bold ph-check-circle"></i> Proprietário Confiável
            </div>
        </div>
    </section>

    <!-- Floating Action Bar V3 (Native App Style) -->
    <div class="sticky-action-bar">
        <div class="action-bar-inner">
            <div class="action-price-info">
                <span class="action-label" style="color: var(--app-primary);"><?= esc($owner['full_name']) ?></span>
                <div class="action-price-value"><?= number_format($property['price'], 0, ',', '.') ?> <small>KZ/Mês</small></div>
            </div>
            
            <div class="action-buttons-group">
                <a href="https://wa.me/244<?= preg_replace('/\D/', '', $owner['phone'] ?? '') ?>" class="action-btn-secondary" title="WhatsApp">
                    <i class="ph-bold ph-whatsapp-logo"></i>
                </a>
                
                <a href="/chat/start/<?= $property['id'] ?>" class="action-btn-secondary" title="Mensagem">
                    <i class="ph-bold ph-chat-centered-dots"></i>
                </a>

                <a href="/property/pay/<?= $property['id'] ?>" class="action-btn-primary">
                    <i class="ph-bold ph-credit-card"></i>
                    <span>Pagar</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .sticky-action-bar {
        position: fixed;
        bottom: 100px;
        left: 0;
        right: 0;
        padding: 0 1rem;
        z-index: 1000;
        pointer-events: none; /* Allow interaction with content behind if needed, but inner has pointer-events auto */
    }

    .action-bar-inner {
        max-width: 500px;
        margin: 0 auto;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        padding: 0.75rem 1rem;
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
        border: 1px solid rgba(255, 255, 255, 0.5);
        pointer-events: auto;
        animation: slideUpAction 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes slideUpAction {
        from { opacity: 0; transform: translateY(40px) scale(0.95); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .action-price-info {
        display: flex;
        flex-direction: column;
        padding-left: 0.5rem;
    }

    .action-label {
        font-size: 0.65rem;
        font-weight: 800;
        color: var(--gray-400);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .action-price-value {
        font-family: 'Outfit';
        font-weight: 900;
        font-size: 1.2rem;
        color: var(--gray-800);
    }

    .action-price-value small { font-size: 0.7rem; opacity: 0.5; }

    .action-buttons-group {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    .action-btn-secondary {
        width: 48px;
        height: 48px;
        background: var(--gray-100);
        color: var(--gray-600);
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        text-decoration: none;
        transition: all 0.2s;
        font-size: 1.4rem;
    }

    .action-btn-secondary:hover { background: var(--gray-200); color: var(--gray-800); transform: translateY(-2px); }

    .action-btn-primary {
        background: var(--app-primary);
        color: white;
        padding: 0 1.5rem;
        height: 48px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        font-family: 'Outfit';
        font-weight: 800;
        font-size: 0.95rem;
        transition: all 0.3s;
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.25);
    }

    .action-btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.35);
    }

    @media (max-width: 400px) {
        .action-price-info { display: none; }
        .action-bar-inner { justify-content: center; width: 100%; max-width: 100%; }
        .action-buttons-group { width: 100%; justify-content: center; }
        .action-btn-primary { flex: 1; justify-content: center; }
    }
</style>
<?php $this->endSection(); ?>

