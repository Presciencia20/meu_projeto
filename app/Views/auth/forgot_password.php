<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Recuperar Palavra-passe<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 40px 0;
        min-height: calc(100vh - 400px);
    }

    .auth-card {
        background: white;
        width: 100%;
        max-width: 480px;
        padding: 48px;
        border-radius: 40px;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--slate-100);
    }

    .auth-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .auth-header h1 {
        font-size: 2.2rem;
        font-weight: 800;
        color: var(--slate-900);
        margin-bottom: 12px;
        letter-spacing: -1px;
    }

    .logo-icon {
        width: 64px;
        height: 64px;
        background: var(--primary-50);
        color: var(--primary);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 24px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        font-size: 0.85rem;
        color: var(--slate-600);
        margin-bottom: 10px;
        margin-left: 4px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="auth-container">
        <div class="auth-card animate-fade-in">
            <div class="auth-header">
                <div class="logo-icon"><i data-lucide="key"></i></div>
                <h1>Recuperar acesso</h1>
                <p style="color: var(--slate-500)">Introduza o seu número de telemóvel para receber um código de recuperação.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    <i data-lucide="alert-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('info')): ?>
                <div class="alert alert-success" style="background: var(--primary-50); color: var(--primary); border-color: rgba(26, 86, 219, 0.1);">
                    <i data-lucide="info"></i>
                    <?= session()->getFlashdata('info') ?>
                </div>
            <?php endif; ?>

            <form action="/auth/forgot-password" method="POST">
                <div class="form-group">
                    <label>Telemóvel (Nº Registado)</label>
                    <input type="tel" name="phone" class="input-modern" placeholder="9xx xxx xxx" required value="<?= old('phone') ?>">
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; font-size: 1rem; padding: 18px; border-radius: 16px;">
                    Enviar Código SMS
                    <i data-lucide="send" style="width: 18px;"></i>
                </button>
            </form>

            <p style="text-align: center; margin-top: 32px; color: var(--slate-500); font-size: 0.9rem;">
                Lembrou-se da senha? <a href="/login" style="color: var(--primary); font-weight: 700; text-decoration: none;">Voltar ao Login</a>
            </p>
        </div>
    </div>
<?= $this->endSection() ?>
