<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Definições de Conta - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<style>
    /* User Settings Layout */
    .settings-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        min-height: calc(100vh - 160px);
        gap: 2rem;
        padding-bottom: 80px; /* Espaço para a navegação inferior */
    }

    .settings-sidebar {
        background: white;
        border-radius: 24px;
        padding: 1.5rem;
        height: fit-content;
        position: sticky;
        top: 90px;
        border: 1px solid var(--gray-200);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .settings-nav-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        border-radius: 14px;
        color: var(--gray-600);
        text-decoration: none;
        font-weight: 700;
        font-size: 0.95rem;
        transition: all 0.2s;
        margin-bottom: 4px;
        border: none;
        background: transparent;
        width: 100%;
        cursor: pointer;
        text-align: left;
    }

    .settings-nav-item:hover {
        background: #f8fafc;
        color: var(--app-primary);
    }

    .settings-nav-item.active {
        background: var(--app-primary-50);
        color: var(--app-primary);
    }

    .settings-main {
        background: white;
        border-radius: 32px;
        padding: 3rem;
        border: 1px solid var(--gray-200);
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
        animation: slideUp 0.4s cubic-bezier(0, 0, 0.2, 1);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .form-group-app {
        margin-bottom: 1.5rem;
    }

    .form-label-app {
        display: block;
        font-weight: 800;
        font-size: 0.8rem;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.5rem;
    }

    .input-premium {
        width: 100%;
        padding: 1rem 1.25rem;
        border-radius: 16px;
        border: 1px solid var(--gray-200);
        background: #f8fafc;
        font-weight: 600;
        transition: all 0.2s;
        font-family: inherit;
    }

    .input-premium:focus {
        outline: none;
        border-color: var(--app-primary);
        background: white;
        box-shadow: 0 0 0 4px var(--app-primary-50);
    }

    @media (max-width: 992px) {
        .settings-layout {
            grid-template-columns: 1fr;
        }
        .settings-sidebar {
            position: relative;
            top: 0;
            display: flex;
            overflow-x: auto;
            gap: 1rem;
            padding: 1rem;
        }
        .settings-nav-item {
            white-space: nowrap;
            width: auto;
        }
    }
</style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div style="margin-bottom: 2.5rem; display: flex; align-items: center; gap: 1rem;">
    <a href="/dashboard" class="btn-circle" style="background: white; border: 1px solid var(--gray-200);">
        <i class="ph-bold ph-arrow-left"></i>
    </a>
    <div>
        <h1 style="font-family: 'Outfit'; font-weight: 950; font-size: 2.4rem; letter-spacing: -2px; color: #1e293b; margin: 0;">Definições de Conta</h1>
        <p style="color: var(--gray-500); font-weight: 500; margin: 0;">Gerencie suas informações privadas e públicas.</p>
    </div>
</div>

<div class="settings-layout">
    <!-- Sidebar -->
    <aside>
        <div class="settings-sidebar">
            <button class="settings-nav-item active" onclick="switchTab('perfil', this)">
                <i class="ph-duotone ph-user-circle"></i> Perfil Público
            </button>
            <button class="settings-nav-item" onclick="switchTab('seguranca', this)">
                <i class="ph-duotone ph-lock-key"></i> Segurança
            </button>
            <button class="settings-nav-item" onclick="switchTab('banco', this)">
                <i class="ph-duotone ph-bank"></i> Dados Bancários
            </button>
            <button class="settings-nav-item" onclick="switchTab('notif', this)">
                <i class="ph-duotone ph-bell-ringing"></i> Notificações
            </button>
            <button class="settings-nav-item" onclick="switchTab('privacidade', this)">
                <i class="ph-duotone ph-shield-check"></i> Privacidade
            </button>
        </div>
    </aside>

    <!-- Main Content Area -->
    <main class="settings-main">
        <form action="/user/settings" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <!-- TAB: PERFIL PÚBLICO -->
            <div id="tab-perfil" class="tab-content active">
                <h3 style="font-weight: 800; font-family: 'Outfit'; margin-bottom: 2rem; color: #1e293b;">Informação Pessoal</h3>
                
                <!-- Avatar Upload Context -->
                <div style="display: flex; align-items: center; gap: 2rem; margin-bottom: 3rem; padding: 2rem; background: #f8fafc; border-radius: 28px; border: 1px solid var(--gray-100);">
                    <div style="position: relative;">
                        <img id="avatarPreview" src="<?= (isset($profile['photo']) && $profile['photo']) ? base_url($profile['photo']) : 'https://ui-avatars.com/api/?name='.urlencode($user['full_name']).'&background=random' ?>" 
                             style="width: 110px; height: 110px; border-radius: 32px; object-fit: cover; border: 4px solid white; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
                        <button type="button" onclick="document.getElementById('photoInput').click()" 
                                style="position: absolute; bottom: -8px; right: -8px; width: 36px; height: 36px; border-radius: 12px; background: var(--app-primary); color: white; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4); transition: transform 0.2s;">
                            <i class="ph-bold ph-camera" style="font-size: 1.1rem;"></i>
                        </button>
                        <input type="file" name="photo" id="photoInput" style="display: none;" onchange="updatePreview(this)">
                    </div>
                    <div>
                        <h4 style="font-weight: 800; color: #1e293b; margin-bottom: 6px;">Foto de Perfil</h4>
                        <p style="font-size: 0.9rem; color: var(--gray-500); margin-bottom: 0;">Ficheiros suportados: JPG, PNG. Tamanho máximo: 2MB.</p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                    <div class="form-group-app">
                        <label class="form-label-app">Nome Completo</label>
                        <input type="text" name="full_name" class="input-premium" value="<?= esc($user['full_name']) ?>" required>
                    </div>
                    <div class="form-group-app">
                        <label class="form-label-app">Email Público</label>
                        <input type="email" name="email" class="input-premium" value="<?= esc($user['email']) ?>" required>
                    </div>
                </div>

                <div class="form-group-app">
                    <label class="form-label-app">Biografia / Sobre Você</label>
                    <textarea name="bio" class="input-premium" style="min-height: 140px; resize: none;" placeholder="Conte algo sobre você para os potenciais senhorios ou inquilinos..."><?= esc($profile['bio'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- TAB: SEGURANÇA -->
            <div id="tab-seguranca" class="tab-content">
                <h3 style="font-weight: 800; font-family: 'Outfit'; margin-bottom: 2rem; color: #1e293b;">Segurança da Conta</h3>
                
                <div class="form-group-app" style="max-width: 400px;">
                    <label class="form-label-app">Alterar Senha</label>
                    <input type="password" class="input-premium" placeholder="Senha atual">
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; max-width: 800px;">
                    <div class="form-group-app">
                        <label class="form-label-app">Nova Senha</label>
                        <input type="password" class="input-premium" placeholder="Mínimo 8 caracteres">
                    </div>
                    <div class="form-group-app">
                        <label class="form-label-app">Confirmar Nova Senha</label>
                        <input type="password" class="input-premium" placeholder="Repita a nova senha">
                    </div>
                </div>
                
                <div style="background: #f0f7ff; border: 1px solid #d0e7ff; padding: 1.5rem; border-radius: 20px; margin-top: 2.5rem; display: flex; gap: 1.25rem; align-items: center;">
                    <div style="width: 48px; height: 48px; border-radius: 14px; background: white; color: var(--app-primary); display: flex; align-items: center; justify-content: center; font-size: 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
                        <i class="ph-duotone ph-shield-check"></i>
                    </div>
                    <div>
                        <h5 style="font-weight: 800; color: #1e3a8a; margin-bottom: 2px;">Proteção Adicional Ativa</h5>
                        <p style="font-size: 0.85rem; color: #3b82f6; font-weight: 600; margin: 0;">Sua conta está protegida por verificação de dispositivo.</p>
                    </div>
                </div>
            </div>

            <!-- TAB: BANCO -->
            <div id="tab-banco" class="tab-content">
                <h3 style="font-weight: 800; font-family: 'Outfit'; margin-bottom: 2rem; color: #1e293b;">Dados Financeiros</h3>
                <p style="color: var(--gray-500); margin-bottom: 2.5rem; font-size: 0.95rem; font-weight: 500; line-height: 1.5;">Configure seus dados bancários oficiais para receber pagamentos de aluguel e reembolsos de caução de forma segura.</p>

                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem; margin-bottom: 2rem;">
                    <div class="form-group-app">
                        <label class="form-label-app">Instituição Bancária</label>
                        <select name="bank_name" class="input-premium">
                            <option value="">Selecione...</option>
                            <option value="BAI" <?= ($profile['bank_name'] ?? '') === 'BAI' ? 'selected' : '' ?>>BAI</option>
                            <option value="BFA" <?= ($profile['bank_name'] ?? '') === 'BFA' ? 'selected' : '' ?>>BFA</option>
                            <option value="BIC" <?= ($profile['bank_name'] ?? '') === 'BIC' ? 'selected' : '' ?>>BIC (Bancante)</option>
                            <option value="ATLANTICO" <?= ($profile['bank_name'] ?? '') === 'ATLANTICO' ? 'selected' : '' ?>>Banco Atlântico</option>
                            <option value="SOL" <?= ($profile['bank_name'] ?? '') === 'SOL' ? 'selected' : '' ?>>Banco Sol</option>
                        </select>
                    </div>
                    <div class="form-group-app">
                        <label class="form-label-app">IBAN (Nº de Conta de Pagamento)</label>
                        <input type="text" name="iban" class="input-premium" placeholder="AO06 0000 0000 0000 0000 0" value="<?= esc($profile['iban'] ?? '') ?>">
                    </div>
                </div>
                
                <div style="background: #f8fafc; padding: 1.25rem; border-radius: 16px; font-size: 0.8rem; color: var(--gray-500); display: flex; gap: 10px; align-items: center;">
                    <i class="ph-bold ph-info"></i>
                    <span>Os pagamentos são processados pela rede nacional EMIS/Kwik.</span>
                </div>
            </div>

            <!-- TAB: NOTIFICAÇÕES -->
            <div id="tab-notif" class="tab-content">
                <h3 style="font-weight: 800; font-family: 'Outfit'; margin-bottom: 2rem; color: #1e293b;">Preferências de Notificação</h3>
                <!-- Adicionar opções de checkbox premium aqui se necessário -->
                <p style="color: var(--gray-500);">Configure como deseja receber atualizações sobre seus contratos e imóveis.</p>
            </div>

            <!-- Footer com Ações -->
            <div style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid var(--gray-100); display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary" style="width: auto; padding: 1.1rem 3.5rem; border-radius: 18px; font-weight: 800; font-size: 1rem; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.25);">
                    <i class="ph-bold ph-check-circle" style="margin-right: 8px;"></i> Guardar Alterações
                </button>
            </div>
        </form>
    </main>
</div>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    function switchTab(tabId, el) {
        // Nav Update
        document.querySelectorAll('.settings-nav-item').forEach(item => item.classList.remove('active'));
        el.classList.add('active');
        
        // Content Update
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        const target = document.getElementById('tab-' + tabId);
        if (target) {
            target.classList.add('active');
        }

        // URL Update
        window.history.replaceState(null, null, '#' + tabId);
    }

    function updatePreview(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Auto-load tab from Hash
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash.substring(1);
        if (hash) {
            const btn = document.querySelector(`button[onclick*="'${hash}'"]`);
            if (btn) btn.click();
        }
    });
</script>
<?php $this->endSection(); ?>
