<aside class="admin-sidebar">
    <div class="sidebar-header">
        <div class="admin-profile">
            <div class="admin-avatar">
                <?php if (session()->get('user_photo')): ?>
                    <img src="<?= base_url(session()->get('user_photo')) ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover; border-radius: 12px;">
                <?php else: ?>
                    <i class="ph-bold ph-user-gear"></i>
                <?php endif; ?>
            </div>
            <div class="admin-meta">
                <span class="admin-name"><?= esc(session()->get('full_name')) ?></span>
                <span class="admin-role"><?= esc(session()->get('user_type')) ?></span>
            </div>
        </div>

        <!-- Role Switcher -->
        <div class="role-switcher">
            <p class="switcher-title">Modo Ativo: <strong><?= strtoupper(session()->get('active_role')) ?></strong></p>
            <div class="switcher-buttons">
                <?php if (session()->get('is_admin') && session()->get('active_role') !== 'admin'): ?>
                    <a href="/switch-role/admin" class="btn-switch" title="Mudar para Admin"><i class="ph-bold ph-shield-star"></i></a>
                <?php endif; ?>

                <?php if (session()->get('is_owner') && session()->get('active_role') !== 'owner'): ?>
                    <a href="/switch-role/owner" class="btn-switch" title="Mudar para Proprietário"><i class="ph-bold ph-house-line"></i></a>
                <?php endif; ?>

                <?php if (session()->get('is_client') && session()->get('active_role') !== 'client'): ?>
                    <a href="/switch-role/client" class="btn-switch" title="Mudar para Inquilino"><i class="ph-bold ph-user"></i></a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <nav class="admin-sidebar-menu">
        <?php 
            $path = current_url(true)->getPath(); 
            $userRole = session()->get('user_type');

            function isActive($segments, $path) {
                if (is_array($segments)) {
                    foreach($segments as $s) {
                        if (strpos($path, 'admin/' . $s) !== false) return 'active';
                    }
                    return '';
                }
                return strpos($path, 'admin/' . $segments) !== false ? 'active' : '';
            }

            function hasPermission($module, $role) {
                if ($role === 'Super Admin') return true;
                
                $permissions = [
                    'Moderador' => ['dashboard', 'properties', 'reports', 'messages', 'map'],
                    'Financeiro' => ['dashboard', 'payments', 'plans', 'stats'],
                    'Admin'      => ['dashboard', 'users', 'properties', 'verifications', 'payments', 'plans', 'reports' , 'stats', 'messages', 'map', 'settings', 'notifications']
                ];

                if (!isset($permissions[$role])) return false;
                return in_array($module, $permissions[$role]);
            }
        ?>

        <div class="menu-label">Principal</div>
        
        <!-- 1. DASHBOARD -->
        <?php if (hasPermission('dashboard', $userRole)): ?>
        <a href="/admin/dashboard" class="sidebar-item <?= isActive(['dashboard', 'painel-de-controle'], $path) ?>">
            <i class="ph-bold ph-chart-pie"></i>
            <span>Painel de Controle</span>
        </a>
        <?php endif; ?>

        <div class="menu-label">Gestão</div>

        <!-- 2. USUÁRIOS -->
        <?php if (hasPermission('users', $userRole)): ?>
        <a href="/admin/users" class="sidebar-item <?= isActive(['users', 'usuários'], $path) ?>">
            <i class="ph-bold ph-users"></i>
            <span>Usuários</span>
        </a>
        <?php endif; ?>

        <!-- 3. IMÓVEIS -->
        <?php if (hasPermission('properties', $userRole)): ?>
        <a href="/admin/properties" class="sidebar-item <?= isActive(['properties', 'propriedades'], $path) ?>">
            <i class="ph-bold ph-house"></i>
            <span>Imóveis</span>
        </a>
        <?php endif; ?>

        <!-- 4. VERIFICAÇÕES -->
        <?php if (hasPermission('verifications', $userRole)): ?>
        <a href="/admin/verifications" class="sidebar-item <?= isActive(['verifications', 'verificações'], $path) ?>">
            <i class="ph-bold ph-identification-card"></i>
            <span>Verificações</span>
        </a>
        <?php endif; ?>

        <!-- 5. PAGAMENTOS -->
        <?php if (hasPermission('payments', $userRole)): ?>
        <a href="/admin/payments" class="sidebar-item <?= isActive(['payments', 'pagamentos'], $path) ?>">
            <i class="ph-bold ph-credit-card"></i>
            <span>Pagamentos</span>
        </a>
        <?php endif; ?>

        <!-- 6. PLANOS -->
        <?php if (hasPermission('plans', $userRole)): ?>
        <a href="/admin/plans" class="sidebar-item <?= isActive(['plans', 'planos'], $path) ?>">
            <i class="ph-bold ph-package"></i>
            <span>Planos</span>
        </a>
        <?php endif; ?>

        <div class="menu-label">Operacional</div>

        <!-- 7. DENÚNCIAS -->
        <?php if (hasPermission('reports', $userRole)): ?>
        <a href="/admin/reports" class="sidebar-item <?= isActive(['reports', 'relatórios'], $path) ?>">
            <i class="ph-bold ph-warning-circle"></i>
            <span>Denúncias</span>
        </a>
        <?php endif; ?>

        <!-- 8. ESTATÍSTICAS -->
        <?php if (hasPermission('stats', $userRole)): ?>
        <a href="/admin/stats" class="sidebar-item <?= isActive('stats', $path) ?>">
            <i class="ph-bold ph-chart-bar"></i>
            <span>Estatísticas</span>
        </a>
        <?php endif; ?>

        <!-- 9. MENSAGENS -->
        <?php if (hasPermission('messages', $userRole)): ?>
        <a href="/admin/messages" class="sidebar-item <?= isActive(['messages', 'mensagens'], $path) ?>">
            <i class="ph-bold ph-chat-centered-dots"></i>
            <span>Mensagens</span>
            <?php if (isset($unreadMessages) && $unreadMessages > 0): ?>
                <span class="badge-notif" style="background: #ef4444; color: white; border-radius: 20px; padding: 2px 8px; font-size: 0.7rem; font-weight: 800; margin-left: auto;"><?= $unreadMessages ?></span>
            <?php endif; ?>
        </a>
        <?php endif; ?>

        <!-- 10. MAPA -->
        <?php if (hasPermission('map', $userRole)): ?>
        <a href="/admin/map" class="sidebar-item <?= isActive(['map', 'mapa'], $path) ?>">
            <i class="ph-bold ph-map-trifold"></i>
            <span>Mapa</span>
        </a>
        <?php endif; ?>

        <div class="menu-label">Sistema</div>

        <!-- 11. CONFIGURAÇÕES -->
        <?php if (hasPermission('settings', $userRole)): ?>
        <a href="/admin/settings" class="sidebar-item <?= isActive(['settings', 'configurações'], $path) ?>">
            <i class="ph-bold ph-gear-six"></i>
            <span>Configurações</span>
        </a>
        <?php endif; ?>

        <!-- 12. LOGS DO SISTEMA -->
        <?php if (hasPermission('logs', $userRole)): ?>
        <a href="/admin/logs" class="sidebar-item <?= isActive('logs', $path) ?>">
            <i class="ph-bold ph-scroll"></i>
            <span>Logs</span>
        </a>
        <?php endif; ?>

        <!-- 13. NOTIFICAÇÕES -->
        <?php if (hasPermission('notifications', $userRole)): ?>
        <a href="/admin/notifications" class="sidebar-item <?= isActive(['notifications', 'notificações'], $path) ?>">
            <i class="ph-bold ph-bell"></i>
            <span>Notificações</span>
        </a>
        <?php endif; ?>

        <!-- 14. ADMINISTRADORES -->
        <?php if (hasPermission('admins', $userRole)): ?>
        <a href="/admin/admins" class="sidebar-item <?= isActive('admins', $path) ?>">
            <i class="ph-bold ph-user-gear"></i>
            <span>Administradores</span>
        </a>
        <?php endif; ?>

        <div class="sidebar-footer">
            <!-- 15. SESSÃO -->
            <a href="/admin/logout" class="sidebar-item logout">
                <i class="ph-bold ph-sign-out"></i>
                <span>Sair</span>
            </a>
        </div>
    </nav>
</aside>


