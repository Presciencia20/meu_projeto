<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Me Surpreenda - Stack | CasaSegura</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="/css/discovery.css">
</head>
<body class="discovery-body">

<nav class="discovery-nav">
    <a href="/" class="back-btn"><i data-lucide="chevron-left"></i></a>
    <div class="mode-selector">
        <a href="/discovery/x" class="mode-btn active">Stack</a>
        <a href="/discovery/y" class="mode-btn">Reels</a>
        <a href="/discovery/z" class="mode-btn">Mosaic</a>
    </div>
</nav>

<div class="stack-container">
    <div class="card-stack" id="stack">
        <?php foreach ($properties as $idx => $p): ?>
        <div class="discovery-card" style="z-index: <?= 100 - $idx ?>; transform: scale(<?= 1 - ($idx * 0.05) ?>) translateY(<?= $idx * 15 ?>px);">
            <img src="/img/placeholder_house.png" alt="<?= esc($p['title']) ?>" class="card-image">
            <div class="card-overlay">
                <span class="badge" style="background: var(--ds-primary); color: white; padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; margin-bottom: 10px; display: inline-block;">
                    <?= $p['type'] == 'rent' ? 'ARRENDAR' : 'COMPRAR' ?>
                </span>
                <h2 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 5px;"><?= esc($p['title']) ?></h2>
                <p style="opacity: 0.8; font-size: 0.9rem; margin-bottom: 15px;"><i data-lucide="map-pin" style="width:14px; vertical-align: middle;"></i> <?= esc($p['neighborhood']) ?>, Luanda</p>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div style="font-size: 1.5rem; font-weight: 900; color: white;"><?= number_format($p['price'], 0, ',', '.') ?> <small style="font-size: 0.8rem;">KZ</small></div>
                    <a href="/property/<?= $p['id'] ?>" class="back-btn" style="border-radius: 12px; width: auto; padding: 0 20px; font-weight: 700;">Ver Mais</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<div style="position: fixed; bottom: 40px; left: 0; right: 0; display: flex; justify-content: center; gap: 20px; z-index: 1000;">
    <button class="back-btn" style="width: 64px; height: 64px; background: white; color: #f44336;" onclick="swipe('left')"><i data-lucide="x" style="width: 32px; height: 32px;"></i></button>
    <button class="back-btn" style="width: 64px; height: 64px; background: var(--ds-primary);" onclick="swipe('right')"><i data-lucide="heart" style="width: 32px; height: 32px;"></i></button>
</div>

<script>
    lucide.createIcons();

    function swipe(direction) {
        const stack = document.getElementById('stack');
        const cards = stack.querySelectorAll('.discovery-card');
        if (cards.length === 0) return;

        const topCard = cards[0];
        const angle = direction === 'left' ? -30 : 30;
        const xTranslate = direction === 'left' ? -500 : 500;

        topCard.style.transition = 'all 0.5s ease-out';
        topCard.style.transform = `translateX(${xTranslate}px) translateY(-100px) rotate(${angle}deg)`;
        topCard.style.opacity = '0';

        setTimeout(() => {
            topCard.remove();
            // Re-stack remaining cards
            const remaining = stack.querySelectorAll('.discovery-card');
            remaining.forEach((card, idx) => {
                card.style.transition = 'all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                card.style.transform = `scale(${1 - (idx * 0.05)}) translateY(${idx * 15}px)`;
            });
        }, 300);
    }
</script>
</body>
</html>
