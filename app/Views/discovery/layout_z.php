<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Me Surpreenda - Mosaic | CasaSegura</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="/css/discovery.css">
    <style>
        .mosaic-item {
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
            cursor: pointer;
            border: 1px solid rgba(255,255,255,0.1);
        }
        .mosaic-item:hover {
            transform: scale(0.98);
            z-index: 10;
        }
        .mosaic-item:hover .mosaic-overlay {
            opacity: 1;
            transform: translateY(0);
        }
        .mosaic-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(4px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.4s;
            padding: 20px;
            text-align: center;
        }
        .mosaic-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        .mosaic-item:hover .mosaic-image {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="discovery-body" style="background: #050505; overflow-y: auto;">

<nav class="discovery-nav">
    <a href="/" class="back-btn"><i data-lucide="chevron-left"></i></a>
    <div class="mode-selector">
        <a href="/discovery/x" class="mode-btn">Stack</a>
        <a href="/discovery/y" class="mode-btn">Reels</a>
        <a href="/discovery/z" class="mode-btn active">Mosaic</a>
    </div>
</nav>

<div class="mosaic-container">
    <div style="text-align: center; margin-bottom: 40px;" class="animate-up">
        <h1 style="font-size: 2.5rem; font-weight: 900; letter-spacing: -1.5px; margin-bottom: 10px;">Mosaico Infinito</h1>
        <p style="color: #888;">Explore uma grelha curada de propriedades exclusivas</p>
    </div>

    <div class="mosaic-grid">
        <?php foreach ($properties as $idx => $p): 
            $classes = '';
            if ($idx % 5 == 0) $classes = 'large';
            if ($idx % 3 == 0) $classes = 'wide';
        ?>
        <div class="mosaic-item <?= $classes ?> animate-up" style="animation-delay: <?= $idx * 0.05 ?>s;">
            <img src="/img/placeholder_house.png" alt="<?= esc($p['title']) ?>" class="mosaic-image">
            <div class="mosaic-overlay">
                <h4 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 5px;"><?= esc($p['title']) ?></h4>
                <p style="font-size: 0.75rem; opacity: 0.8; margin-bottom: 15px;"><?= esc($p['neighborhood']) ?></p>
                <div style="font-weight: 900; color: var(--ds-primary); margin-bottom: 15px;"><?= number_format($p['price'], 0, ',', '.') ?> KZ</div>
                <a href="/property/<?= $p['id'] ?>" class="btn-sm" style="background: white; color: black; padding: 6px 15px; border-radius: 10px; font-size: 0.7rem; font-weight: 800; text-decoration: none;">DETALHES</a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    lucide.createIcons();
</script>
</body>
</html>
