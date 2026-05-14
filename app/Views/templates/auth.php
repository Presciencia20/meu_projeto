<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?= $this->renderSection('title') ?> | CasaSegura</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@600;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        :root {
            --app-primary: #FF6B35;
            --app-primary-dark: #e55a2b;
            --app-secondary: #0f172a;
            --app-bg: #ffffff;
            --app-gray: #f8fafc;
            --app-radius: 32px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        h1, h2, h3 { font-family: 'Outfit', sans-serif; }

        body {
            background-color: var(--app-bg);
            color: var(--app-secondary);
            height: 100vh;
            overflow: hidden;
        }

        .split-layout {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* Side Illustration Panel */
        .auth-side-panel {
            flex: 1.2;
            position: relative;
            background: #0f172a;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-image {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.8;
            filter: saturate(1.2) contrast(1.1);
        }

        .auth-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(15, 23, 42, 0.9) 0%, rgba(15, 23, 42, 0.2) 100%);
            z-index: 2;
        }

        .auth-side-content {
            position: relative;
            z-index: 3;
            padding: 80px;
            color: white;
            max-width: 600px;
        }

        .auth-side-content h2 {
            font-size: 3.5rem;
            font-weight: 900;
            line-height: 1;
            margin-bottom: 24px;
            letter-spacing: -2px;
        }

        .auth-side-content p {
            font-size: 1.2rem;
            opacity: 0.8;
            font-weight: 500;
            line-height: 1.6;
        }

        /* Form Panel */
        .auth-form-panel {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px;
            overflow-y: auto;
            position: relative;
        }

        .auth-form-inner {
            width: 100%;
            max-width: 440px;
        }

        .mobile-logo { display: none; margin-bottom: 40px; text-align: center; }
        .mobile-logo img { height: 50px; }

        @media (max-width: 1024px) {
            .auth-side-panel { display: none; }
            body { overflow: auto; }
            .auth-form-panel { padding: 40px 24px; min-height: 100vh; }
            .mobile-logo { display: block; }
        }

        /* Modern Elements */
        .input-modern {
            width: 100%;
            padding: 18px 24px;
            background: #f1f5f9;
            border: 2px solid transparent;
            border-radius: 20px;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            outline: none;
            margin-bottom: 20px;
            color: var(--app-secondary);
        }

        .input-modern:focus {
            background: white;
            border-color: var(--app-primary);
            box-shadow: 0 10px 25px rgba(255, 107, 53, 0.1);
        }

        .btn-app-primary {
            width: 100%;
            background: var(--app-primary);
            color: white;
            padding: 20px;
            border: none;
            border-radius: 24px;
            font-size: 1.1rem;
            font-weight: 800;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            box-shadow: 0 12px 28px rgba(255, 107, 53, 0.25);
        }

        .btn-app-primary:hover {
            transform: translateY(-3px);
            background: var(--app-primary-dark);
            box-shadow: 0 15px 35px rgba(255, 107, 53, 0.35);
        }

        .alert {
            padding: 16px 20px;
            border-radius: 20px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #fee2e2;
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.1);
        }

        /* Branding link */
        .auth-footer { margin-top: 40px; text-align: center; font-size: 0.85rem; color: #94a3b8; font-weight: 600; }
        .auth-footer a { color: var(--app-primary); text-decoration: none; font-weight: 800; }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <div class="split-layout">
        <!-- Visualization Panel -->
        <div class="auth-side-panel">
            <img src="/img/casasegura_auth_illustration.png" class="auth-image" alt="Vibe">
            <div class="auth-overlay"></div>
            <div class="auth-side-content">
                <div style="margin-bottom: 60px;">
                    <img src="/img/logo.png" alt="Logo" style="height: 60px; filter: brightness(0) invert(1);">
                </div>
                <h2>A sua nova casa em cada clique.</h2>
                <p>Junte-se à plataforma imobiliária mais segura de Angola. Proteção antifraude, contratos digitais e os melhores imóveis do mercado.</p>
                
                <div style="margin-top: 60px; display: flex; gap: 24px;">
                    <div><h4 style="font-size: 1.5rem; font-weight: 900;">100%</h4><p style="font-size: 0.8rem; opacity: 0.6;">Seguro</p></div>
                    <div><h4 style="font-size: 1.5rem; font-weight: 900;">24/7</h4><p style="font-size: 0.8rem; opacity: 0.6;">Suporte</p></div>
                    <div><h4 style="font-size: 1.5rem; font-weight: 900;">ANG</h4><p style="font-size: 0.8rem; opacity: 0.6;">Market</p></div>
                </div>
            </div>
        </div>

        <!-- Form Panel -->
        <div class="auth-form-panel">
            <div class="auth-form-inner">
                <div class="mobile-logo">
                    <a href="/"><img src="/img/logo.png" alt="CasaSegura"></a>
                </div>
                
                <?= $this->renderSection('content') ?>

                <div class="auth-footer">
                    &copy; <?= date('Y') ?> CasaSegura • Made with 🧡 in Angola
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
