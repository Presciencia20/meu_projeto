<?= $this->extend('templates/auth') ?>

<?= $this->section('title') ?>Criar Conta | CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .auth-header {
        margin-bottom: 32px;
    }

    .auth-header h1 {
        font-size: 2rem;
        font-weight: 800;
        color: var(--slate-900);
        margin-bottom: 8px;
        letter-spacing: -0.5px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--slate-700);
        margin-bottom: 8px;
    }

    .step-indicator {
        display: flex;
        gap: 8px;
        margin-bottom: 32px;
    }

    .step-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--slate-100);
        transition: all 0.3s;
    }

    .step-dot.active {
        background: var(--primary);
        width: 24px;
        border-radius: 10px;
    }

    .footer-link {
        text-align: center;
        margin-top: 24px;
        color: var(--slate-500);
        font-size: 0.9rem;
    }

    .footer-link a {
        color: var(--primary);
        font-weight: 700;
        text-decoration: none;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="step-indicator animate-fade-in">
        <div class="step-dot active"></div>
        <div class="step-dot"></div>
        <div class="step-dot"></div>
    </div>

    <div class="auth-header animate-fade-in" style="animation-delay: 0.1s;">
        <h1>Criar conta</h1>
        <p style="color: var(--slate-500); font-weight: 500;">O seu primeiro passo para um arrendamento seguro em Angola.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error">
            <i data-lucide="alert-circle" style="width: 18px;"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="/auth/step1" method="POST" class="animate-fade-in" style="animation-delay: 0.2s;">
        <?= csrf_field() ?>
        
        <div class="form-group">
            <label>Nº de Telemóvel</label>
            <div style="position: relative;">
                <span style="position: absolute; left: 20px; top: 50%; transform: translateY(-50%); font-weight: 700; color: var(--slate-400);">+244</span>
                <input type="tel" name="phone" class="input-modern" placeholder="9xx xxx xxx" required 
                       value="<?= old('phone') ?>" style="padding-left: 65px;">
            </div>
            <p style="font-size: 0.8rem; color: var(--slate-400); margin-top: 10px; font-weight: 500;">
                Enviaremos um código SMS para validar o seu acesso.
            </p>
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; margin-top: 8px;">
            Continuar <i data-lucide="arrow-right" style="width: 20px;"></i>
        </button>
    </form>

    <p class="footer-link animate-fade-in" style="animation-delay: 0.3s;">
        Já tem conta? <a href="/login">Entrar</a>
    </p>
<?= $this->endSection() ?>

<?= $this->section('info') ?>
    <div class="info-item">
        <div class="info-icon"><i data-lucide="user-check"></i></div>
        <div class="info-text">
            <h4>Verificação de Identidade</h4>
            <p>Validamos o seu BI para garantir que você é quem diz ser, trazendo confiança para o mercado.</p>
        </div>
    </div>
    <div class="info-item">
        <div class="info-icon"><i data-lucide="file-text"></i></div>
        <div class="info-text">
            <h4>Contratos Digitais</h4>
            <p>Geramos contratos legalmente válidos que protegem tanto o inquilino quanto o senhorio.</p>
        </div>
    </div>
    <div class="info-item">
        <div class="info-icon"><i data-lucide="trending-up"></i></div>
        <div class="info-text">
            <h4>Histórico de Reputação</h4>
            <p>Crie o seu perfil de bom pagador ou senhorio exemplar e ganhe destaque na nossa plataforma.</p>
        </div>
    </div>
<?= $this->endSection() ?>
