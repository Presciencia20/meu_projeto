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
    
    <!-- Lucide Icons (CDN) -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <style>
        :root {
            --primary: #1A56DB;
            --primary-50: #EFF6FF;
            --primary-100: #DBEAFE;
            --primary-600: #1C64F2;
            --primary-700: #1A56DB;
            --primary-dark: #1241A3;
            --secondary: #059669;
            --secondary-50: #ECFDF5;
            --accent: #F59E0B;
            --danger: #DC2626;
            --danger-50: #FEF2F2;
            --slate-50: #F9FAFB;
            --slate-100: #F1F5F9;
            --slate-200: #E2E8F0;
            --slate-300: #CBD5E1;
            --slate-400: #94A3B8;
            --slate-500: #6B7280;
            --slate-600: #4B5563;
            --slate-800: #1F2937;
            --slate-900: #111827;
            --white: #ffffff;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            --glass: rgba(255, 255, 255, 0.95);
            --radius-lg: 24px;
            --radius-md: 12px;
            --radius-sm: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        h1, h2, h3, h4, .font-heading {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: var(--slate-50);
            color: var(--slate-900);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Premium Navbar */
        .navbar {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            width: 95%;
            max-width: 1200px;
            background: var(--glass);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: var(--radius-lg);
            padding: 10px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .logo {
            display: flex;
            align-items: center;
            text-decoration: none;
            background: white;
            padding: 8px;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .logo:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .logo img {
            height: 48px;
            width: auto;
        }

        .nav-links {
            display: none;
            gap: 28px;
        }

        @media (min-width: 992px) {
            .nav-links { display: flex; }
        }

        .nav-link {
            text-decoration: none;
            color: var(--slate-600);
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.2s;
            position: relative;
        }

        .nav-link:hover, .nav-link.active { color: var(--primary); }
        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 100%;
            height: 2px;
            background: var(--primary);
            border-radius: 2px;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            padding: 12px 28px;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
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

        .btn-secondary {
            background: var(--white);
            color: var(--slate-900);
            padding: 12px 28px;
            border-radius: var(--radius-md);
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.2s;
            border: 1px solid var(--slate-200);
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-secondary:hover {
            background: var(--slate-50);
            border-color: var(--slate-300);
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding-top: 130px;
            min-height: 80vh;
        }

        /* Global Components */
        .badge-verified {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--secondary-50);
            color: var(--secondary);
            padding: 6px 14px;
            border-radius: 99px;
            font-size: 0.75rem;
            font-weight: 700;
            border: 1px solid rgba(5, 150, 105, 0.1);
        }

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
            background: var(--danger-50);
            color: var(--danger);
            border: 1px solid rgba(220, 38, 38, 0.1);
        }

        .alert-success {
            background: var(--secondary-50);
            color: var(--secondary);
            border: 1px solid rgba(5, 150, 105, 0.1);
        }

        /* Mobile Menu */
        .nav-toggle {
            display: flex;
            flex-direction: column;
            gap: 6px;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
            z-index: 2001;
        }

        .nav-toggle span {
            display: block;
            width: 24px;
            height: 2px;
            background: var(--slate-900);
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        @media (max-width: 991px) {
            #navToggle { display: flex !important; }
        }

        .mobile-menu-overlay {
            position: fixed;
            top: 0;
            right: -100%;
            width: 100%;
            height: 100vh;
            background: var(--white);
            z-index: 2000;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            padding: 100px 40px;
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .mobile-menu-overlay.active {
            right: 0;
        }

        .mobile-nav-link {
            font-size: 2rem;
            font-weight: 800;
            text-decoration: none;
            color: var(--slate-900);
            font-family: 'Poppins', sans-serif;
        }

        /* Footer */
        .site-footer {
            background: var(--white);
            padding: 100px 0 40px;
            margin-top: 120px;
            border-top: 1px solid var(--slate-200);
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr 1.2fr;
            gap: 40px;
            margin-bottom: 60px;
        }

        @media (max-width: 992px) {
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 576px) {
            .footer-grid { grid-template-columns: 1fr; }
        }

        .footer-logo img { height: 48px; margin-bottom: 24px; }
        .footer-desc { color: var(--slate-500); font-size: 0.95rem; line-height: 1.8; }
        .footer-head { font-weight: 700; margin-bottom: 24px; font-size: 1.1rem; color: var(--slate-900); }
        .footer-links { list-style: none; }
        .footer-links li { margin-bottom: 14px; }
        .footer-links a { text-decoration: none; color: var(--slate-500); transition: 0.2s; font-weight: 500; }
        .footer-links a:hover { color: var(--primary); padding-left: 6px; }

        .footer-bottom {
            padding-top: 40px;
            border-top: 1px solid var(--slate-100);
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            color: var(--slate-400);
            font-size: 0.9rem;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
        }

    </style>
    <?= $this->renderSection('styles') ?>
</head>
<body>

    <?php $currentPath = '/' . ltrim(current_url(true)->getPath(), '/'); ?>
    <nav class="navbar" id="mainNavbar">
        <a href="/" class="logo">
            <img src="/img/logo.png" alt="CasaSegura Logo">
        </a>

        <div class="nav-links">
            <a href="/comprar" class="nav-link <?= ($currentPath === '/comprar') ? 'active' : '' ?>">Comprar</a>
            <a href="/alugar"  class="nav-link <?= ($currentPath === '/alugar')  ? 'active' : '' ?>">Arrendar</a>
            <a href="/vender"  class="nav-link <?= ($currentPath === '/vender')  ? 'active' : '' ?>">Vender</a>
            <a href="/sobre"   class="nav-link <?= ($currentPath === '/sobre')   ? 'active' : '' ?>">Sobre</a>
        </div>

        <div style="display: flex; gap: 16px; align-items: center;">
            <div class="nav-links">
                <?php if (session()->get('isLoggedIn')): ?>
                    <?php if (session()->get('user_type') === 'Admin'): ?>
                        <a href="/admin/dashboard" class="nav-link" style="margin-right: 8px; color: var(--primary); font-weight: 800;"><i data-lucide="shield-check" style="width: 16px; display: inline-block;"></i> Área Admin</a>
                    <?php else: ?>
                        <a href="/dashboard" class="nav-link" style="margin-right: 8px;">Painel</a>
                    <?php endif; ?>
                    
                    <a href="/user/profile" style="display:flex; align-items:center; text-decoration:none; margin-right: 8px;" title="Ver Meu Perfil">
                        <?php 
                            $nameParts = explode(' ', session()->get('full_name') ?? 'User');
                            $initials = strtoupper(substr($nameParts[0], 0, 1));
                            if(count($nameParts) > 1) {
                                $initials .= strtoupper(substr(end($nameParts), 0, 1));
                            }
                        ?>
                        <div style="width:40px; height:40px; border-radius:50%; background:var(--slate-100); color:var(--slate-700); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:0.95rem; border: 2px solid white; box-shadow: 0 4px 6px rgba(0,0,0,0.05); transition: 0.2s;">
                            <?= $initials ?>
                        </div>
                    </a>

                    <a href="/logout" class="btn-primary" style="background: var(--danger);"><i data-lucide="log-out" style="width: 16px;"></i> Sair</a>
                <?php else: ?>
                    <a href="/login" class="nav-link" style="margin-right: 8px;">Entrar</a>
                    <a href="/signup" class="btn-primary">Registar</a>
                <?php endif; ?>
            </div>
            <button class="nav-toggle" id="navToggle" style="display: none;">
                <span></span><span></span><span></span>
            </button>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobileMenu">
        <a href="/comprar" class="mobile-nav-link">Comprar</a>
        <a href="/alugar"  class="mobile-nav-link">Arrendar</a>
        <a href="/vender"  class="mobile-nav-link">Vender</a>
        <a href="/sobre"   class="mobile-nav-link">Sobre</a>
        <hr style="border: none; border-top: 1px solid var(--slate-100);">
        <?php if (session()->get('isLoggedIn')): ?>
            <?php if (session()->get('user_type') === 'Admin'): ?>
                <a href="/admin/dashboard" class="mobile-nav-link" style="color: var(--primary);">Área Admin</a>
            <?php else: ?>
                <a href="/dashboard" class="mobile-nav-link">Painel</a>
            <?php endif; ?>
            <a href="/logout"  class="btn-primary" style="font-size: 1.2rem; background: var(--danger); padding: 20px;">Sair</a>
        <?php else: ?>
            <a href="/login"   class="mobile-nav-link">Entrar</a>
            <a href="/signup"  class="btn-primary" style="font-size: 1.2rem; padding: 20px;">Registar Agora</a>
        <?php endif; ?>
    </div>

    <div class="container">
        <?= $this->renderSection('content') ?>
    </div>

    <footer class="site-footer">
        <div style="width: 90%; max-width: 1200px; margin: 0 auto;">
            <div class="footer-grid">
                <div>
                    <div class="footer-logo"><img src="/img/logo.png" alt="CasaSegura"></div>
                    <p class="footer-desc">A plataforma líder em negócios imobiliários seguros em Angola. Protegemos o seu dinheiro e garantimos a validade de cada contrato.</p>
                </div>
                <div>
                    <h4 class="footer-head">Plataforma</h4>
                    <ul class="footer-links">
                        <li><a href="/comprar">Comprar Imóveis</a></li>
                        <li><a href="/alugar">Arrendar Casa</a></li>
                        <li><a href="/vender">Venda Directa</a></li>
                        <li><a href="/dashboard">Painel de Controlo</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="footer-head">Suporte</h4>
                    <ul class="footer-links">
                        <li><a href="/sobre">Sobre a CasaSegura</a></li>
                        <li><a href="/ajuda">Centro de Segurança</a></li>
                        <li><a href="/termos">Termos & Condições</a></li>
                        <li><a href="/privacidade">Privacidade</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="footer-head">Contacto</h4>
                    <ul class="footer-links">
                        <li style="display: flex; align-items: center; gap: 12px; color: var(--slate-500);"><i data-lucide="map-pin" style="width: 18px;"></i> Luanda, Angola</li>
                        <li style="display: flex; align-items: center; gap: 12px; color: var(--slate-500);"><i data-lucide="phone" style="width: 18px;"></i> +244 944 013 345</li>
                        <li style="display: flex; align-items: center; gap: 12px; color: var(--slate-500);"><i data-lucide="mail" style="width: 18px;"></i> apoio@arrendaseguro.ao</li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>© <?= date('Y') ?> CasaSegura Angola. Todos os direitos reservados.</p>
                <div style="display: flex; gap: 24px;">
                    <a href="#" class="footer-desc">Facebook</a>
                    <a href="#" class="footer-desc">Instagram</a>
                    <a href="#" class="footer-desc">LinkedIn</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Init Lucide Icons
        lucide.createIcons();

        // Mobile Menu Toggle logic
        const navToggle = document.getElementById('navToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const body = document.body;

        navToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
            navToggle.classList.toggle('active');
            body.style.overflow = mobileMenu.classList.contains('active') ? 'hidden' : 'auto';
            
            // Transform hamburger to X
            const spans = navToggle.querySelectorAll('span');
            if(mobileMenu.classList.contains('active')) {
                spans[0].style.transform = 'rotate(45deg) translate(5px, 5px)';
                spans[1].style.opacity = '0';
                spans[2].style.transform = 'rotate(-45deg) translate(7px, -7px)';
            } else {
                spans[0].style.transform = 'none';
                spans[1].style.opacity = '1';
                spans[2].style.transform = 'none';
            }
        });

        // Sticky Navbar effect
        window.addEventListener('scroll', () => {
            const navbar = document.getElementById('mainNavbar');
            if (window.scrollY > 20) {
                navbar.style.top = '10px';
                navbar.style.boxShadow = '0 20px 40px rgba(0,0,0,0.08)';
            } else {
                navbar.style.top = '20px';
                navbar.style.boxShadow = '0 10px 30px rgba(0,0,0,0.03)';
            }
        });
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>
