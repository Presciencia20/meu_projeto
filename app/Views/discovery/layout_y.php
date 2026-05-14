<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Me Surpreenda - Reels | CasaSegura</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="/css/discovery.css">
    <style>
        .reel-side-actions {
            position: absolute;
            right: 15px;
            bottom: 120px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
            z-index: 20;
        }
        .action-circle {
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
        }
        .action-circle:hover { background: var(--ds-primary); transform: scale(1.1); }
        .action-label { font-size: 0.65rem; font-weight: 700; margin-top: 4px; }
    </style>
</head>
<body class="discovery-body">

<nav class="discovery-nav">
    <a href="/" class="back-btn"><i data-lucide="chevron-left"></i></a>
    <div class="mode-selector">
        <a href="/discovery/x" class="mode-btn">Stack</a>
        <a href="/discovery/y" class="mode-btn active">Reels</a>
        <a href="/discovery/z" class="mode-btn">Mosaic</a>
    </div>
</nav>

<div class="reels-container">
    <?php foreach ($properties as $p): ?>
    <section class="reel-item">
        <div class="reel-video-container">
            <!-- Simulated background image as a reel background -->
            <img src="/img/placeholder_house.png" alt="<?= esc($p['title']) ?>" style="width:100%; height:100%; object-fit: cover;">
        </div>
        
        <div class="reel-content animate-up">
            <h2 style="font-size: 2rem; font-weight: 900; margin-bottom: 8px; text-shadow: 0 4px 10px rgba(0,0,0,0.5);">
                <?= esc($p['title']) ?>
            </h2>
            <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                <span class="badge" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px); color: white; padding: 6px 12px; border-radius: 12px; font-weight: 700;">
                    <i data-lucide="map-pin" style="width:12px;"></i> <?= esc($p['neighborhood']) ?>
                </span>
                <span class="badge" style="background: var(--ds-primary); color: white; padding: 6px 12px; border-radius: 12px; font-weight: 800;">
                    <?= number_format($p['price'], 0, ',', '.') ?> KZ
                </span>
            </div>
            <p style="opacity: 0.9; font-size: 0.95rem; line-height: 1.5; max-width: 85%;">
                Fantástico <?= strtolower($p['type'] == 'rent' ? 'arrendamento' : 'imóvel') ?> localizado numa das zonas mais nobres de Luanda. Ideal para quem procura conforto e segurança.
            </p>
        </div>

        <div class="reel-side-actions">
            <div>
                <div class="action-circle"><i data-lucide="heart"></i></div>
                <div class="action-label">Gostar</div>
            </div>
            <div>
                <div class="action-circle"><i data-lucide="message-square"></i></div>
                <div class="action-label">Chat</div>
            </div>
            <div>
                <a href="/property/<?= $p['id'] ?>" class="action-circle" style="background: white; color: black;"><i data-lucide="eye"></i></a>
                <div class="action-label">Ver</div>
            </div>
            <div>
                <div class="action-circle"><i data-lucide="share-2"></i></div>
                <div class="action-label">Partilhar</div>
            </div>
        </div>
    </section>
    <?php endforeach; ?>
</div>

<script>
    lucide.createIcons();
    // Prevenir scroll horizontal
    document.body.addEventListener('touchmove', function(e) {
        if (e.target.closest('.reels-container')) return;
        e.preventDefault();
    }, {passive: false});
</script>
</body>
</html>
