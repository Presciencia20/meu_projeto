<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title><?= $this->renderSection('title') ?> | CasaSegura</title>
    <link rel="icon" type="image/png" href="/img/logo.png">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- App Theme Styles -->
    <link rel="stylesheet" href="/css/app_navigation.css">
    
    <style>
        /* Global Reset & Base Styles */
        :root {
            --app-primary: #2563eb;
            --app-primary-dark: #1d4ed8;
            --app-primary-50: #eff6ff;
            --gray-100: #F8F9FA;
            --gray-200: #F0F2F5;
            --gray-300: #E5E7EB;
            --gray-500: #94a3b8;
            --gray-600: #64748b;
            --gray-800: #1e293b;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            color: #1a1a2e;
            -webkit-font-smoothing: antialiased;
        }

        .logo-app {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: #1e293b;
        }

        .logo-app img { height: 34px; width: auto; object-fit: contain; }
        .logo-app span { 
            font-weight: 800; 
            font-family: 'Outfit'; 
            font-size: 1.35rem; 
            letter-spacing: -0.03em; 
            background: linear-gradient(135deg, #1e293b, #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        @media (max-width: 768px) {
            :root {
                --app-header-height: 64px;
            }
            .logo-app span { font-size: 1.1rem; }
            .header-user-badge { width: 32px; height: 32px; font-size: 0.75rem; }
            .header-actions { gap: 8px; }
            .header-btn { width: 36px; height: 36px; }
        }

        @media (max-width: 480px) {
            .logo-app span { display: none; }
        }

        .btn-circle {
            transition: all 0.2s;
        }

        .btn-circle:hover { background: var(--gray-300); }

        /* Animation Classes */
        .page-transition {
            animation: fadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Micro-interactions */
        .click-feedback:active {
            transform: scale(0.95);
        }

        .skeleton {
            background: linear-gradient(90deg, #f0f2f5 25%, #e2e8f0 50%, #f0f2f5 75%);
            background-size: 200% 100%;
            animation: skeleton-loading 1.5s infinite;
            border-radius: 12px;
        }

        @keyframes skeleton-loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        .img-modern { transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
        .img-modern:hover { transform: scale(1.05); }

        /* Premium Alerts */
        .alert-premium {
            padding: 14px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            font-size: 0.9rem;
            animation: slideDown 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            border-left: 4px solid transparent;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: #ffffff;
            color: #059669;
            border-left-color: #10b981;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }

        .alert-error {
            background: #ffffff;
            color: #ef4444;
            border-left-color: #ef4444;
            box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        }
    </style>
    <?= $this->renderSection('styles') ?>
    <style>
        /* Leaflet Fix: Ensure tiles are visible */
        .leaflet-tile-container img {
            max-width: none !important;
            max-height: none !important;
        }
        /* Fix for markers in some mobile devices */
        .leaflet-marker-icon {
            max-width: none !important;
        }
    </style>
</head>
<body>

    <?php 
        $currentPath = '/' . ltrim(current_url(true)->getPath(), '/'); 
        $isLoggedIn = session()->get('isLoggedIn');
        $userType = session()->get('user_type');

        // Define Auth Pages (No menus)
        $authRoutes = ['/login', '/signup', '/forgot-password', '/auth/verify-otp', '/auth/step2', '/auth/reset'];
        $isAuthPage = false;
        
        // Normalize path to handle /index.php/login
        $normPath = str_replace('/index.php', '', $currentPath);
        
        foreach($authRoutes as $route) {
            if (str_starts_with($normPath, $route)) {
                $isAuthPage = true;
                break;
            }
        }

        $isAdminPage = str_starts_with($normPath, '/admin');
    ?>

    <div class="app-shell">
        <?php if (!$isAuthPage && !$isAdminPage): ?>
        <!-- Premium Universal Header -->
        <header class="app-header">
            <div class="header-container">
                <div class="header-logo">
                    <a href="/" class="logo-app">
                        <img src="/img/logo.png" alt="CasaSegura" onerror="this.src='/img/logo_alt.png'">
                        <span>CasaSegura</span>
                    </a>
                </div>
                <div class="header-actions">
                    <a href="<?= site_url('search') ?>" class="header-btn"><i class="ph-bold ph-magnifying-glass"></i></a>
                    
                    <?php if ($isLoggedIn): ?>
                        <!-- Mensagens / Notificações -->
                        <a href="<?= site_url('chat') ?>" class="header-btn" style="position: relative;">
                            <i class="ph-bold ph-chat-centered-text"></i>
                            <?php if ($unreadMessages > 0): ?>
                                <span class="notification-badge"><?= $unreadMessages ?></span>
                            <?php endif; ?>
                        </a>

                        <div class="header-role-switcher">
                            <div class="role-badge-trigger">
                                <i class="ph-bold ph-user-circle"></i>
                                <?php 
                                    $roleLabels = ['admin' => 'Admin', 'owner' => 'Proprietário', 'client' => 'Inquilino'];
                                    $currentRole = session()->get('active_role') ?: 'client';
                                ?>
                                <span><?= $roleLabels[$currentRole] ?? ucfirst($currentRole) ?></span>
                            </div>
                            <div class="role-dropdown">
                                <div class="dropdown-header">Escolher Perfil</div>
                                <?php if (session()->get('is_admin')): ?>
                                    <a href="/switch-role/admin" class="dropdown-item <?= session()->get('active_role') == 'admin' ? 'active' : '' ?>">
                                        <i class="ph-bold ph-shield-star"></i> Admin
                                    </a>
                                <?php endif; ?>
                                <?php if (session()->get('is_owner')): ?>
                                    <a href="/switch-role/owner" class="dropdown-item <?= session()->get('active_role') == 'owner' ? 'active' : '' ?>">
                                        <i class="ph-bold ph-house-line"></i> Proprietário
                                    </a>
                                <?php endif; ?>
                                <?php if (session()->get('is_client')): ?>
                                    <a href="/switch-role/client" class="dropdown-item <?= session()->get('active_role') == 'client' ? 'active' : '' ?>">
                                        <i class="ph-bold ph-user"></i> Inquilino
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php $dashboardUrl = (session()->get('active_role') === 'admin') ? site_url('admin/dashboard') : site_url('dashboard'); ?>
                        <a href="<?= $dashboardUrl ?>" class="header-user-badge-link">
                            <div class="header-user-badge">
                                <?php if (session()->get('user_photo')): ?>
                                    <img src="<?= base_url(session()->get('user_photo')) ?>" alt="Perfil" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                <?php else: ?>
                                    <span><?= strtoupper(substr(session()->get('full_name') ?? 'G', 0, 1)) ?></span>
                                <?php endif; ?>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </header>
        <?php endif; ?>

        <div class="app-body">
            <main class="app-main" style="<?= $isAuthPage ? 'padding-top: 20px;' : '' ?>">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert-premium alert-success animate-fade-in">
                        <i class="ph-fill ph-check-circle"></i>
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert-premium alert-error animate-fade-in">
                        <i class="ph-fill ph-warning-circle"></i>
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
                
                <?php if (!$isAuthPage && !$isAdminPage): ?>
                <footer style="margin-top: 60px; padding: 20px 0 100px 0; border-top: 1px solid #eee; text-align: center; color: #999; font-size: 0.8rem;">
                    <p>© <?= date('Y') ?> CasaSegura Angola. Proteção em cada contrato.</p>
                </footer>
                <?php endif; ?>
            </main>
        </div>

        <!-- NEW FLOATING BOTTOM NAVIGATION (Universal) -->
        <?php if (!$isAuthPage && !$isAdminPage): ?>
        <nav class="bottom-nav">
            <a href="/" class="nav-item <?= ($currentPath === '/') ? 'active' : '' ?>">
                <div class="nav-item-icon" style="font-size: 1.5rem;"><i class="ph-bold ph-house"></i></div>
                <span class="nav-label">Início</span>
            </a>
            
            <a href="/near-me" class="nav-item <?= ($currentPath === '/near-me') ? 'active' : '' ?>">
                <div class="nav-item-icon" style="font-size: 1.5rem;"><i class="ph-bold ph-navigation-arrow"></i></div>
                <span class="nav-label">Perto</span>
            </a>

            <a href="/search" class="nav-item">
                <div class="nav-item-icon nav-action-button attention-pulse" style="width: 54px; height: 54px;">
                    <i class="ph-bold ph-magnifying-glass" style="font-size: 1.6rem;"></i>
                </div>
            </a>

            <a href="/property/create" class="nav-item <?= ($currentPath === '/property/create') ? 'active' : '' ?>">
                <div class="nav-item-icon" style="font-size: 1.5rem;"><i class="ph-bold ph-plus-circle"></i></div>
                <span class="nav-label">Publicar</span>
            </a>

            <?php if ($isLoggedIn): ?>
                <a href="<?= (isset($userType) && $userType === 'Admin') ? '/admin/dashboard' : '/dashboard' ?>" class="nav-item <?= (str_contains($currentPath, 'dashboard') || str_contains($currentPath, 'profile')) ? 'active' : '' ?>">
                    <div class="nav-item-icon" style="font-size: 1.5rem;"><i class="ph-bold ph-user-circle"></i></div>
                    <span class="nav-label">Perfil</span>
                </a>
            <?php else: ?>
                <a href="/login" class="nav-item">
                    <div class="nav-item-icon" style="font-size: 1.5rem;"><i class="ph-bold ph-user"></i></div>
                    <span class="nav-label">Entrar</span>
                </a>
            <?php endif; ?>
        </nav>
        <?php endif; ?>
    </div>

    <!-- Icons: Phosphor Icons (Premium DuoTone) -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
    <script>
        // Role Switcher Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const trigger = document.querySelector('.role-badge-trigger');
            const switcher = document.querySelector('.header-role-switcher');
            
            if (trigger) {
                trigger.addEventListener('click', function(e) {
                    e.stopPropagation();
                    switcher.classList.toggle('active');
                });

                document.addEventListener('click', function() {
                    switcher.classList.remove('active');
                });
            }
        });

        async function toggleFavorite(id) {
            const btn = event.currentTarget;
            const icon = btn.querySelector('i');
            const isLoggedIn = <?= $isLoggedIn ? 'true' : 'false' ?>;

            if (!isLoggedIn) {
                window.location.href = '/login';
                return;
            }
            
            btn.style.transform = 'scale(0.8)';
            setTimeout(() => btn.style.transform = '', 150);

            // Optimistic UI update (optional, but makes it instantly responsive)
            const wasFavorited = icon.classList.contains('ph-heart-fill');
            if (wasFavorited) {
                icon.classList.remove('ph-heart-fill', 'ph-fill');
                icon.classList.add('ph-heart', 'ph-duotone');
                icon.style.color = '';
            } else {
                icon.classList.remove('ph-heart', 'ph-duotone');
                icon.classList.add('ph-heart-fill', 'ph-fill');
                icon.style.color = '#ef4444';
            }

            try {
                const response = await fetch(`/property/favorite/${id}`, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                const data = await response.json();

                if (data.status !== 'success') {
                    // Revert on failure
                    if (wasFavorited) {
                        icon.classList.remove('ph-heart', 'ph-duotone');
                        icon.classList.add('ph-heart-fill', 'ph-fill');
                        icon.style.color = '#ef4444';
                    } else {
                        icon.classList.remove('ph-heart-fill', 'ph-fill');
                        icon.classList.add('ph-heart', 'ph-duotone');
                        icon.style.color = '';
                    }
                    if (data.message) alert(data.message);
                }
            } catch (error) {
                console.error("Erro ao favoritar:", error);
                alert("Ocorreu um erro de rede. Tente comunicar-se novamente.");
                // Revert on network error
                if (wasFavorited) {
                    icon.classList.remove('ph-heart', 'ph-duotone');
                    icon.classList.add('ph-heart-fill', 'ph-fill');
                    icon.style.color = '#ef4444';
                } else {
                    icon.classList.remove('ph-heart-fill', 'ph-fill');
                    icon.classList.add('ph-heart', 'ph-duotone');
                    icon.style.color = '';
                }
            }
        }
    </script>
    <?= $this->renderSection('scripts') ?>
</body>
</html>