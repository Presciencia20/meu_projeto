<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Completar Registo<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .auth-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 80px 0;
    }

    .auth-card {
        background: white;
        width: 100%;
        max-width: 520px;
        padding: 60px 48px;
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
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 12px;
        letter-spacing: -1.5px;
    }

    .form-group {
        margin-bottom: 24px;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        font-size: 0.9rem;
        color: var(--slate-700);
        margin-bottom: 10px;
    }

    .form-control {
        width: 100%;
        padding: 16px 20px;
        background: var(--slate-50);
        border: 1px solid var(--slate-100);
        border-radius: 16px;
        font-size: 0.95rem;
        font-weight: 500;
        transition: all 0.2s;
        outline: none;
        color: var(--slate-900);
    }

    .form-control:focus {
        background: white;
        border-color: var(--brand-600);
        box-shadow: 0 0 0 4px var(--brand-50);
    }

    .step-indicator {
        display: flex;
        justify-content: center;
        gap: 10px;
        margin-bottom: 40px;
    }

    .step-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--slate-100);
        transition: all 0.3s;
    }

    .step-dot.active {
        background: var(--primary);
        width: 32px;
        border-radius: 6px;
    }

    .step-dot.done {
        background: var(--primary-200);
    }

    .account-type-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
        margin-bottom: 32px;
    }

    .type-card {
        border: 2px solid var(--slate-100);
        border-radius: 24px;
        padding: 24px 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        background: white;
        position: relative;
    }

    .type-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        inset: 0;
        cursor: pointer;
    }

    .type-card:hover {
        border-color: var(--primary-100);
        transform: translateY(-4px);
    }

    .type-card.selected {
        border-color: var(--primary);
        background: var(--primary-50);
        box-shadow: 0 10px 20px rgba(26, 86, 219, 0.1);
    }

    .type-card .type-icon {
        font-size: 2rem;
        margin-bottom: 10px;
        display: block;
        filter: grayscale(1);
        transition: all 0.3s;
    }

    .type-card.selected .type-icon {
        filter: grayscale(0); transform: scale(1.1);
    }

    .type-card .type-label {
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--slate-400);
        transition: all 0.3s;
    }

    .type-card.selected .type-label {
        color: var(--primary);
    }

    .password-wrapper {
        position: relative;
    }

    .password-toggle {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--slate-400);
        padding: 4px;
        display: flex;
    }

    .strength-bar {
        height: 4px;
        border-radius: 4px;
        background: var(--slate-100);
        margin-top: 8px;
        overflow: hidden;
    }

    .strength-fill {
        height: 100%;
        border-radius: 4px;
        transition: all 0.3s;
    }

    .strength-text {
        font-size: 0.75rem;
        margin-top: 4px;
        font-weight: 600;
    }

    .alert {
        padding: 16px;
        border-radius: 16px;
        margin-bottom: 24px;
        font-size: 0.9rem;
        font-weight: 500;
    }

    .alert-error { background: #fef2f2; color: #dc2626; border: 1px solid #fee2e2; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="auth-container">
        <div class="auth-card animate-fade-in">

            <div class="step-indicator">
                <div class="step-dot done"></div>
                <div class="step-dot done"></div>
                <div class="step-dot active"></div>
            </div>

            <div class="auth-header">
                <div class="logo-icon" style="margin: 0 auto 24px; background: var(--primary-50); color: var(--primary);">
                    <i data-lucide="user-plus" style="width: 32px; height: 32px;"></i>
                </div>
                <h1>🎉 Quase lá!</h1>
                <p style="color: var(--slate-500); font-weight: 500;">Conclua o seu perfil para começar a usar a CasaSegura.</p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
            <?php endif; ?>

            <form action="/auth/step2" method="POST">
                <?= csrf_field() ?>

                <div class="form-group">
                    <label for="full_name">Nome Completo</label>
                    <input type="text" id="full_name" name="full_name" class="input-modern"
                           placeholder="Ex: João Baptista Silva" required
                           value="<?= old('full_name') ?>">
                </div>

                <div class="form-group">
                    <label>Tipo de conta</label>
                    <div class="account-type-grid">
                        <label class="type-card" id="card-inquilino">
                            <input type="radio" name="user_type" value="Inquilino" checked>
                            <span class="type-icon">🏠</span>
                            <span class="type-label">Inquilino</span>
                        </label>
                        <label class="type-card" id="card-proprietario">
                            <input type="radio" name="user_type" value="Proprietário">
                            <span class="type-icon">🔑</span>
                            <span class="type-label">Proprietário</span>
                        </label>
                        <label class="type-card" id="card-intermediario">
                            <input type="radio" name="user_type" value="Intermediário">
                            <span class="type-icon">💼</span>
                            <span class="type-label">Agente</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Crie uma Senha Forte</label>
                    <div class="password-wrapper">
                        <input type="password" id="password" name="password" class="input-modern"
                               placeholder="Mínimo 8 caracteres" required style="padding-right: 60px;">
                        <button type="button" class="password-toggle" id="togglePwd">
                            <i data-lucide="eye" id="eyeIcon" style="width:20px;height:20px;"></i>
                        </button>
                    </div>
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <p class="strength-text" id="strengthText" style="color: var(--slate-400);">Use letras, números e símbolos.</p>
                </div>

                <div id="ownerNotice" style="display:none; background: var(--primary-50); border: 1px solid var(--primary-100); border-radius:20px; padding:20px; margin-bottom:24px; font-size:0.9rem; color: var(--primary); font-weight: 500; line-height: 1.5;">
                    <i data-lucide="info" style="width:18px; height:18px; vertical-align:middle; margin-right:8px"></i>
                    <strong>Proprietários e Agentes</strong> devem realizar a verificação BI + Selfie após o registo para publicar imóveis.
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; font-size: 1rem; padding: 16px;">
                    Criar a Minha Conta
                </button>
            </form>

        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function () {
    // ---- Password strength ----
    const pwd = document.getElementById('password');
    const fill = document.getElementById('strengthFill');
    const text = document.getElementById('strengthText');
    const toggle = document.getElementById('togglePwd');
    const eyeIcon = document.getElementById('eyeIcon');

    pwd.addEventListener('input', () => {
        const v = pwd.value;
        let score = 0;
        if (v.length >= 8) score++;
        if (/[A-Z]/.test(v)) score++;
        if (/[0-9]/.test(v)) score++;
        if (/[^A-Za-z0-9]/.test(v)) score++;

        const colors = ['#ef4444', '#f97316', '#eab308', '#22c55e'];
        const labels = ['Fraca', 'Razoável', 'Boa', 'Forte'];
        const widths = ['25%', '50%', '75%', '100%'];

        if (v.length === 0) {
            fill.style.width = '0'; text.textContent = '';
        } else {
            const i = Math.max(0, score - 1);
            fill.style.width = widths[i];
            fill.style.background = colors[i];
            text.textContent = labels[i];
            text.style.color = colors[i];
        }
    });

    toggle.addEventListener('click', () => {
        if (pwd.type === 'password') {
            pwd.type = 'text';
            eyeIcon.setAttribute('data-lucide', 'eye-off');
        } else {
            pwd.type = 'password';
            eyeIcon.setAttribute('data-lucide', 'eye');
        }
        lucide.createIcons();
    });

    // ---- Account type cards ----
    const cards = {
        'Inquilino':      document.getElementById('card-inquilino'),
        'Proprietário':   document.getElementById('card-proprietario'),
        'Intermediário':  document.getElementById('card-intermediario'),
    };
    const ownerNotice = document.getElementById('ownerNotice');

    document.querySelectorAll('input[name="user_type"]').forEach(radio => {
        radio.addEventListener('change', () => {
            Object.values(cards).forEach(c => c.classList.remove('selected'));
            cards[radio.value]?.classList.add('selected');
            ownerNotice.style.display = ['Proprietário','Intermediário'].includes(radio.value) ? 'block' : 'none';
        });
    });

    // Mark default as selected
    cards['Inquilino'].classList.add('selected');
})();
</script>
<?= $this->endSection() ?>
