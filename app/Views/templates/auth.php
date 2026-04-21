<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> | CasaSegura</title>
    
    <!-- Google Fonts: Poppins & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        :root {
            --primary: #1A56DB;
            --primary-50: #EFF6FF;
            --primary-600: #1C64F2;
            --primary-dark: #1241A3;
            --slate-50: #F9FAFB;
            --slate-100: #F1F5F9;
            --slate-200: #E2E8F0;
            --slate-400: #94A3B8;
            --slate-500: #6B7280;
            --slate-600: #4B5563;
            --slate-800: #1F2937;
            --slate-900: #111827;
            --white: #ffffff;
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            --radius-lg: 24px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        h1, h2, h3, h4 {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--white);
            color: var(--slate-900);
            height: 100vh;
            overflow: hidden;
        }

        .auth-wrapper {
            display: flex;
            height: 100vh;
            width: 100%;
        }

        /* Left Side: Image */
        .auth-visual {
            flex: 1;
            position: relative;
            background-image: url('/img/auth_bg.jpg');
            background-size: cover;
            background-position: center;
            display: none;
        }

        @media (min-width: 1024px) {
            .auth-visual {
                display: flex;
                flex-direction: column;
                justify-content: flex-end;
                padding: 60px;
            }
        }

        .auth-visual::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, rgba(17, 24, 39, 0.1), rgba(17, 24, 39, 0.8));
        }

        .visual-content {
            position: relative;
            z-index: 1;
            color: white;
            max-width: 500px;
        }

        .visual-content h2 {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 20px;
        }

        .visual-content p {
            font-size: 1.1rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 400;
        }

        /* Right Side: Content */
        .auth-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            padding: 40px;
            background: var(--white);
        }

        @media (min-width: 1024px) {
            .auth-content {
                flex: 0 0 600px;
                padding: 60px 80px;
            }
        }

        .auth-logo {
            display: inline-block;
            background: white;
            padding: 12px;
            border-radius: 20px;
            box-shadow: var(--shadow-xl);
            margin-bottom: 40px;
            transition: all 0.3s ease;
        }

        .auth-logo:hover {
            transform: translateY(-4px);
        }

        .auth-logo img {
            height: 64px;
            width: auto;
        }

        .auth-form-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-width: 440px;
            margin: 0 auto;
            width: 100%;
        }

        /* Shared Styles from main.php */
        .input-modern {
            width: 100%;
            padding: 16px 20px;
            background: var(--slate-50);
            border: 1px solid var(--slate-200);
            border-radius: 16px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.2s;
            outline: none;
        }

        .input-modern:focus {
            background: white;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-50);
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 16px 28px;
            border-radius: 16px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            transition: all 0.2s;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(26, 86, 219, 0.1);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(26, 86, 219, 0.2);
        }

        .alert {
            padding: 16px 20px;
            border-radius: 16px;
            margin-bottom: 24px;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-error {
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid rgba(220, 38, 38, 0.1);
        }

        .info-section {
            margin-top: 60px;
            padding-top: 40px;
            border-top: 1px solid var(--slate-100);
        }

        .info-item {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: var(--primary-50);
            color: var(--primary);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-text h4 {
            font-size: 0.95rem;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .info-text p {
            font-size: 0.85rem;
            color: var(--slate-500);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
        }
    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

    <div class="auth-wrapper">
        <div class="auth-visual">
            <div class="visual-content animate-fade-in">
                <h2>Encontre o seu próximo lar com segurança.</h2>
                <p>A CasaSegura ajuda milhares de angolanos a realizarem negócios imobiliários sem fraudes e com total transparência.</p>
            </div>
        </div>

        <div class="auth-content">
            <div class="auth-logo">
                <a href="/"><img src="/img/logo.png" alt="CasaSegura"></a>
            </div>

            <div class="auth-form-container">
                <?= $this->renderSection('content') ?>

                <!-- Informacoes no lado direito (dentro do scroll de conteudo) -->
                <div class="info-section animate-fade-in" style="animation-delay: 0.2s;">
                    <?= $this->renderSection('info') ?>
                </div>
                
                <p style="margin-top: 40px; color: var(--slate-400); font-size: 0.8rem;">
                    &copy; <?= date('Y') ?> CasaSegura. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
