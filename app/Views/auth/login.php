<?= $this->extend('templates/auth') ?>

<?= $this->section('title') ?>Entrar<?= $this->endSection() ?>

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
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--slate-700);
        margin-bottom: 8px;
    }

    .forgot-link {
        font-size: 0.75rem;
        color: var(--primary);
        font-weight: 600;
        text-decoration: none;
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
    <div class="auth-header animate-fade-in">
        <h1>Bem-vindo de volta</h1>
        <p style="color: var(--slate-500)">Aceda à sua conta para gerir os seus imóveis.</p>
    </div>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error">
            <i data-lucide="alert-circle" style="width: 18px;"></i>
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success" style="background: #ECFDF5; color: #059669; border: 1px solid rgba(5, 150, 105, 0.1);">
            <i data-lucide="check-circle" style="width: 18px;"></i>
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <form action="/auth/login" method="POST" class="animate-fade-in" style="animation-delay: 0.1s;">
        <?= csrf_field() ?>
        <div class="form-group">
            <label>Nº de Telemóvel</label>
            <input type="tel" name="phone" class="input-modern" placeholder="9xx xxx xxx" required>
        </div>

        <div class="form-group">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                <label style="margin-bottom: 0;">Palavra-passe</label>
                <a href="#" class="forgot-link">Esqueceu-se?</a>
            </div>
            <input type="password" name="password" class="input-modern" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; margin-top: 8px;">Entrar no Portal</button>
    </form>

    <p class="footer-link animate-fade-in" style="animation-delay: 0.2s;">
        Não tem conta? <a href="/signup">Registar agora</a>
    </p>
<?= $this->endSection() ?>

<?= $this->section('info') ?>
    <div class="info-item">
        <div class="info-icon"><i data-lucide="shield-check"></i></div>
        <div class="info-text">
            <h4>Segurança em Primeiro Lugar</h4>
            <p>Todos os utilizadores passam por um processo de verificação rigoroso para evitar burlas.</p>
        </div>
    </div>
    <div class="info-item">
        <div class="info-icon"><i data-lucide="lock"></i></div>
        <div class="info-text">
            <h4>Contas Escrow</h4>
            <p>O seu dinheiro fica protegido até que o contrato seja validado e ambas as partes estejam satisfeitas.</p>
        </div>
    </div>
    <div class="info-item">
        <div class="info-icon"><i data-lucide="help-circle"></i></div>
        <div class="info-text">
            <h4>Suporte 24/7</h4>
            <p>A nossa equipa está pronta para ajudar em qualquer fase da sua negociação imobiliária.</p>
        </div>
    </div>
<?= $this->endSection() ?>
