<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Criar Conta | CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .auth-title { font-size: 2.2rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 8px; color: var(--app-secondary); }
    .auth-subtitle { font-size: 0.95rem; color: var(--app-gray-500); font-weight: 500; margin-bottom: 32px; }
    
    .step-indicator { display: flex; gap: 8px; margin-bottom: 32px; justify-content: center; }
    .step-pill { width: 40px; height: 6px; border-radius: 10px; background: var(--app-gray-100); transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1); }
    .step-pill.active { background: var(--app-primary); width: 80px; }
    
    .form-group { margin-bottom: 24px; text-align: left; }
    .form-group label { display: block; font-weight: 800; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: var(--app-gray-500); margin-bottom: 10px; margin-left: 4px; }
    
    .auth-tabs { display: flex; gap: 10px; margin-bottom: 24px; background: #f0f2f5; padding: 6px; border-radius: 20px; }
    .auth-tab { flex: 1; padding: 12px; border: none; background: none; font-weight: 800; font-size: 0.85rem; color: #888; cursor: pointer; border-radius: 16px; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 8px; }
    .auth-tab.active { background: white; color: var(--app-primary); box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    .auth-tab.disabled { opacity: 0.5; cursor: not-allowed; }

    .badge-soon { font-size: 0.6rem; background: #e2e8f0; color: #64748b; padding: 2px 8px; border-radius: 6px; text-transform: uppercase; font-weight: 900; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="step-indicator">
        <div class="step-pill active"></div>
        <div class="step-pill"></div>
        <div class="step-pill"></div>
    </div>

    <div style="text-align: center;">
        <h1 class="auth-title">Criar conta</h1>
        <p class="auth-subtitle">Junte-se à maior rede de arrendamento seguro.</p>
    </div>

    <div class="auth-tabs">
        <button type="button" class="auth-tab active">
            <i class="ph-duotone ph-envelope" style="font-size: 20px;"></i> Email
        </button>
        <button type="button" class="auth-tab disabled">
            <i class="ph-duotone ph-device-mobile" style="font-size: 20px;"></i> Smartphone 
            <span class="badge-soon">Brevemente</span>
        </button>
    </div>

    <form action="/auth/step1" method="POST">
        <?= csrf_field() ?>
        <input type="hidden" name="method" value="email">
        
        <div class="form-group">
            <label>Endereço de Email</label>
            <input type="email" name="identifier" class="input-modern" placeholder="exemplo@email.com" required value="<?= old('identifier') ?>" autofocus>
            <p style="font-size: 0.8rem; color: var(--app-gray-500); margin-top: 12px; font-weight: 500; padding: 0 4px;">
                Iremos enviar um código de verificação para validar o seu acesso inicial.
            </p>
        </div>

        <button type="submit" class="btn-app-primary">
            Próximo Passo <i class="ph-bold ph-arrow-right" style="font-size: 20px;"></i>
        </button>
    </form>

    <div style="text-align: center; margin-top: 32px; font-weight: 600; color: var(--app-gray-500); font-size: 0.95rem;">
        Já tem conta? <a href="/login" style="color: var(--app-primary); font-weight: 800; text-decoration: none;">Entrar agora</a>
    </div>
<?= $this->endSection() ?>

<?= $this->section('info') ?>
    <div class="info-item">
        <div class="info-icon"><i data-lucide="user-check"></i></div>
        <div class="info-text">
            <h4>Verificação Real</h4>
            <p>Usamos reconhecimento facial e BI para manter a comunidade livre de burladores.</p>
        </div>
    </div>
    <div class="info-item">
        <div class="info-icon"><i data-lucide="file-check"></i></div>
        <div class="info-text">
            <h4>Contratos Legais</h4>
            <p>Geramos documentos juridicamente válidos em Angola com apenas alguns cliques.</p>
        </div>
    </div>
<?= $this->endSection() ?>
