<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Entrar | CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .auth-title { font-size: 2.5rem; font-weight: 800; font-family: 'Outfit'; letter-spacing: -0.04em; margin-bottom: 8px; color: var(--app-text); }
    .auth-subtitle { font-size: 1rem; color: var(--gray-500); font-weight: 500; margin-bottom: 40px; }
    
    .form-group { margin-bottom: 24px; text-align: left; }
    .form-group label { display: block; font-weight: 700; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--gray-500); margin-bottom: 10px; margin-left: 4px; }
    
    .register-footer { margin-top: 32px; font-weight: 600; color: var(--gray-400); font-size: 0.95rem; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div style="text-align: center; margin-bottom: 40px;">
        <div style="margin-bottom: 24px; display: flex; justify-content: center;">
            <a href="/" class="logo-app" style="justify-content: center; transform: scale(1.2);">
                <img src="/img/logo.png" alt="CasaSegura" onerror="this.src='/img/logo_alt.png'">
                <span>CasaSegura</span>
            </a>
        </div>
        <h1 class="auth-title">Entrar na Conta</h1>
        <p class="auth-subtitle">Escolha o modo seguro de viver e investir.</p>
    </div>

    <form action="/auth/login" method="POST">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label>E-mail ou Telefone</label>
            <div style="position: relative;">
                <i class="ph-duotone ph-user" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); font-size: 20px; color: #94a3b8;"></i>
                <input type="text" name="email" class="input-modern" placeholder="Ex: exemplo@email.com" required autofocus style="padding-left: 48px;">
            </div>
        </div>

        <div class="form-group">
            <label>Palavra-passe</label>
            <div style="position: relative;">
                <i class="ph-duotone ph-lock" style="position: absolute; left: 16px; top: 50%; transform: translateY(-50%); font-size: 20px; color: #94a3b8;"></i>
                <input type="password" name="password" class="input-modern" placeholder="••••••••" required style="padding-left: 48px;">
            </div>
        </div>

        <button type="submit" class="btn-app-primary" style="margin-top: 8px;">
            Entrar agora <i class="ph-bold ph-arrow-right" style="font-size: 18px;"></i>
        </button>
    </form>

    <div style="text-align: center; margin-top: 32px; display: flex; flex-direction: column; gap: 12px;">
        <a href="/signup" style="color: var(--app-primary); font-weight: 800; text-decoration: none; font-size: 1rem;">Criar conta agora</a>
        <a href="/forgot-password" style="color: #94a3b8; font-weight: 600; text-decoration: none; font-size: 0.9rem;">Esqueci a senha</a>
    </div>
<?= $this->endSection() ?>

<?= $this->section('info') ?>
    <div class="info-item">
        <div class="info-icon"><i class="ph-duotone ph-user-circle-check"></i></div>
        <div class="info-text">
            <h4>Verificação Real</h4>
            <p>Usamos reconhecimento facial e BI para manter a comunidade livre de burladores.</p>
        </div>
    </div>
    <div class="info-item">
        <div class="info-icon"><i class="ph-duotone ph-file-text"></i></div>
        <div class="info-text">
            <h4>Contratos Legais</h4>
            <p>Geramos documentos juridicamente válidos em Angola com apenas alguns cliques.</p>
        </div>
    </div>
<?= $this->endSection() ?>
