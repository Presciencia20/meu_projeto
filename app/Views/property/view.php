<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?><?= $property['title'] ?><?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .property-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 40px;
    }

    .property-title-group h1 {
        font-size: 2.8rem;
        font-weight: 800;
        color: var(--slate-900);
        margin-bottom: 12px;
        letter-spacing: -1.5px;
        line-height: 1.1;
    }

    .property-location {
        display: flex;
        align-items: center;
        gap: 10px;
        color: var(--slate-500);
        font-weight: 500;
        font-size: 1.1rem;
    }

    /* Premium Gallery */
    .gallery-container {
        display: grid;
        grid-template-columns: 2.2fr 1fr;
        gap: 20px;
        height: 550px;
        margin-bottom: 60px;
        border-radius: 40px;
        overflow: hidden;
    }

    .gallery-item {
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .gallery-item:hover img {
        transform: scale(1.05);
    }

    .side-gallery {
        display: grid;
        grid-template-rows: 1fr 1fr;
        gap: 20px;
    }

    /* Layout Grid */
    .detail-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 80px;
    }

    @media (min-width: 992px) {
        .detail-grid { grid-template-columns: 1.6fr 1fr; }
    }

    .p-section {
        margin-bottom: 60px;
    }

    .p-section h2 {
        font-size: 1.75rem;
        font-weight: 800;
        margin-bottom: 32px;
        letter-spacing: -0.5px;
    }

    .amenities {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 24px;
    }

    .amenity-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 24px;
        background: white;
        border-radius: 24px;
        border: 1px solid var(--slate-100);
        transition: all 0.3s;
    }

    .amenity-item:hover {
        border-color: var(--primary);
        box-shadow: var(--shadow-md);
    }

    .amenity-item i {
        width: 24px !important;
        height: 24px !important;
        color: var(--primary);
    }

    /* Booking Card */
    .booking-card {
        background: white;
        padding: 48px;
        border-radius: 40px;
        border: 1px solid var(--slate-100);
        box-shadow: 0 40px 100px rgba(0, 0, 0, 0.04);
        position: sticky;
        top: 120px;
    }

    .price-box {
        margin-bottom: 40px;
    }

    .price-main {
        font-size: 3rem;
        font-weight: 900;
        color: var(--primary);
        letter-spacing: -1px;
    }

    .booking-feature {
        display: flex;
        gap: 16px;
        margin-top: 40px;
        padding-top: 40px;
        border-top: 1px solid var(--slate-100);
    }

    .booking-feature-icon {
        color: var(--primary);
        flex-shrink: 0;
    }

    .booking-feature p {
        font-size: 0.9rem;
        color: var(--slate-500);
        line-height: 1.7;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="property-header animate-fade-in">
        <div class="property-title-group">
            <div class="badge-verified" style="margin-bottom: 16px;"><i data-lucide="shield-check" style="width: 14px"></i> Imóvel Verificado</div>
            <h1><?= $property['title'] ?></h1>
            <div class="property-location">
                <i data-lucide="map-pin" style="width: 20px; color: var(--primary)"></i>
                <?= $property['neighborhood'] ?>, <?= $property['municipality'] ?>, <?= $property['province'] ?>
            </div>
        </div>
        <div style="display: flex; gap: 16px;">
            <button class="btn-secondary" style="border-radius: 16px; width: 56px; height: 56px; padding: 0;"><i data-lucide="share-2"></i></button>
            <button class="btn-secondary" style="border-radius: 16px; width: 56px; height: 56px; padding: 0;"><i data-lucide="heart"></i></button>
        </div>
    </div>

    <?php 
        $images = !empty($property['images']) ? json_decode($property['images']) : [];
        $mainImg = !empty($images) ? $images[0] : 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&q=80&w=2070';
        $sideImg1 = isset($images[1]) ? $images[1] : 'https://images.unsplash.com/photo-1493809842364-78817add7ffb?auto=format&fit=crop&q=80&w=2070';
        $sideImg2 = isset($images[2]) ? $images[2] : 'https://images.unsplash.com/photo-1484154218962-a197022b5858?auto=format&fit=crop&q=80&w=2070';
    ?>
    <section class="gallery-container animate-fade-in">
        <div class="gallery-item main-gallery">
            <img src="<?= $mainImg ?>">
        </div>
        <div class="side-gallery">
            <div class="gallery-item">
                <img src="<?= $sideImg1 ?>">
            </div>
            <div class="gallery-item">
                <img src="<?= $sideImg2 ?>">
            </div>
        </div>
    </section>

    <div class="detail-grid">
        <div class="main-content">
            <div class="p-section">
                <h2>Sobre este imóvel</h2>
                <p style="color: var(--slate-600); line-height: 1.8; font-size: 1.1rem;"><?= $property['description'] ?></p>
            </div>

            <div class="p-section">
                <h2>Comodidades</h2>
                <div class="amenities">
                    <div class="amenity-item">
                        <i data-lucide="bed"></i>
                        <div>
                            <div style="font-weight: 800; font-size: 1.1rem;"><?= $property['bedrooms'] ?></div>
                            <div style="font-size: 0.8rem; color: var(--slate-500); font-weight: 500;">Quartos</div>
                        </div>
                    </div>
                    <div class="amenity-item">
                        <i data-lucide="bath"></i>
                        <div>
                            <div style="font-weight: 800; font-size: 1.1rem;"><?= $property['bathrooms'] ?></div>
                            <div style="font-size: 0.8rem; color: var(--slate-500); font-weight: 500;">Casas de Banho</div>
                        </div>
                    </div>
                    <div class="amenity-item">
                        <i data-lucide="zap"></i>
                        <div>
                            <div style="font-weight: 800; font-size: 1.1rem;">Sim</div>
                            <div style="font-size: 0.8rem; color: var(--slate-500); font-weight: 500;">Água e Luz</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-section" style="background: var(--white); padding: 48px; border-radius: 40px; border: 1px solid var(--slate-100); display: flex; align-items: center; justify-content: space-between; box-shadow: var(--shadow-sm);">
                <div style="display: flex; gap: 24px; align-items: center;">
                    <div style="width: 72px; height: 72px; background: <?= $badge['color'] ?>20; color: <?= $badge['color'] ?>; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.5rem;">
                        <?= strtoupper(substr($owner['full_name'], 0, 1)) ?>
                    </div>
                    <div>
                        <div style="font-weight: 800; font-size: 1.25rem; color: var(--slate-900);"><?= esc($owner['full_name']) ?></div>
                        <div style="color: <?= $badge['color'] ?>; font-size: 0.9rem; font-weight: 600; display: flex; align-items: center; gap: 6px;">
                            <i data-lucide="<?= strpos($badge['icon'], 'shield') !== false ? 'shield-check' : 'check-circle' ?>" style="width: 14px;"></i> <?= esc($badge['label']) ?>
                            <?php if ($avgRating > 0): ?>
                                <span style="margin-left: 8px; color: #fbbf24; display: flex; align-items: center; gap: 4px;">
                                    <i data-lucide="star" style="width: 14px; fill: #fbbf24;"></i> <?= number_format($avgRating, 1) ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <a href="/user/profile/<?= $owner['id'] ?>" class="btn-secondary" style="font-weight: 700; border-radius: 16px; padding: 14px 24px; text-decoration: none;">Ver Perfil</a>
            </div>

            <?php if (!empty($reviews)): ?>
                <div class="p-section" style="margin-top: 60px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px;">
                        <h2 style="margin-bottom: 0;">O que dizem os inquilinos</h2>
                        <div style="color: var(--slate-500); font-weight: 600;"><?= count($reviews) ?> avaliações</div>
                    </div>
                    
                    <div style="display: grid; gap: 24px;">
                        <?php foreach ($reviews as $rev): ?>
                            <div style="background: var(--slate-50); padding: 32px; border-radius: 32px; border: 1px solid var(--slate-100);">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 16px;">
                                    <div style="font-weight: 800;"><?= esc($rev['reviewer_name']) ?></div>
                                    <div style="color: #fbbf24; display: flex; gap: 2px;">
                                        <?php for($i=1; $i<=5; $i++): ?>
                                            <i data-lucide="star" style="width: 14px; <?= $i <= $rev['rating'] ? 'fill: #fbbf24;' : 'color: var(--slate-200);' ?>"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p style="color: var(--slate-600); line-height: 1.6;"><?= esc($rev['comment']) ?></p>
                                <div style="margin-top: 16px; font-size: 0.8rem; color: var(--slate-400);"><?= date('d M, Y', strtotime($rev['created_at'])) ?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <aside>
            <div class="booking-card">
                <div class="price-box">
                    <div style="color: var(--slate-500); font-weight: 700; font-size: 0.8rem; text-transform: uppercase; margin-bottom: 8px;">Preço por mês</div>
                    <div class="price-main"><?= number_format($property['price'], 0, ',', '.') ?> <span style="font-size: 1.25rem; color: var(--slate-400)">KZ</span></div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <a href="/checkout/<?= $property['id'] ?>" class="btn-primary" style="text-align: center; font-size: 1.1rem; padding: 20px;">Arrendar com Segurança</a>
                    <a href="/chat/start/<?= $property['id'] ?>" class="btn-secondary" style="display: flex; align-items: center; justify-content: center; gap: 12px; padding: 18px; border-radius: 16px; font-weight: 700; text-decoration: none;">
                        <i data-lucide="message-circle" style="width: 20px;"></i> Falar com Proprietário
                    </a>
                </div>

                <div class="booking-feature">
                    <div class="booking-feature-icon"><i data-lucide="shield-check"></i></div>
                    <div>
                        <h4 style="font-size: 0.9rem; font-weight: 700; margin-bottom: 4px;">Arrendamento Protegido</h4>
                        <p>O seu pagamento é retido pela nossa plataforma até que confirme o estado do imóvel durante a entrada.</p>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <!-- Final spacer -->
    <div style="height: 100px;"></div>
<?= $this->endSection() ?>
