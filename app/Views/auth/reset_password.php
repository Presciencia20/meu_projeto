<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Redefinir Palavra-passe<?= $this->endSection() ?>

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

    .otp-input-group {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        justify-content: center;
    }

    .otp-input {
        width: 100%;
        text-align: center;
        font-size: 1.5rem;
        font-weight: 800;
        letter-spacing: 4px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="auth-container">
        <div class="auth-card animate-fade-in">
            <div class="auth-header">
                <div class="logo-icon"><i data-lucide="lock"></i></div>
                <h1>Nova Palavra-passe</h1>
                <p style="color: var(--slate-500)">Introduza o código recebido por SMS e a sua nova senha.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    <i data-lucide="alert-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="/auth/reset" method="POST">
                <div class="form-group">
                    <label>Código de Verificação (6 dígitos)</label>
                    <input type="text" name="codigo" class="input-modern otp-input" maxlength="6" placeholder="000000" required>
                </div>

                <div class="form-group">
                    <label>Nova Palavra-passe</label>
                    <input type="password" name="password" class="input-modern" placeholder="Mínimo 8 caracteres" required>
                </div>

                <div class="form-group">
                    <label>Confirmar Palavra-passe</label>
                    <input type="password" name="password_confirm" class="input-modern" placeholder="Repita a senha" required>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; font-size: 1rem; padding: 18px; border-radius: 16px;">
                    Actualizar Palavra-passe
                    <i data-lucide="check-circle" style="width: 18px;"></i>
                </button>
            </form>

            <p style="text-align: center; margin-top: 32px; color: var(--slate-500); font-size: 0.9rem;">
                Não recebeu o código? <button type="button" onclick="history.back()" style="background: none; border: none; color: var(--primary); font-weight: 700; cursor: pointer; padding: 0;">Tentar novamente</button>
            </p>
        </div>
    </div>
<?= $this->endSection() ?>
