<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Verificar Código<?= $this->endSection() ?>

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
        max-width: 480px;
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

    .otp-inputs {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-bottom: 40px;
    }

    .otp-digit {
        width: 52px;
        height: 64px;
        text-align: center;
        font-size: 1.8rem;
        font-weight: 800;
        background: var(--slate-50);
        border: 2px solid var(--slate-100);
        border-radius: 16px;
        outline: none;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        color: var(--slate-900);
    }

    .otp-digit:focus {
        background: white;
        border-color: var(--primary);
        box-shadow: 0 0 0 5px var(--primary-50);
        transform: translateY(-4px);
    }

    .otp-digit.filled {
        border-color: var(--primary-200);
        background: var(--primary-50);
    }

    .timer-container {
        margin-bottom: 40px;
        text-align: center;
    }

    .timer-bar {
        height: 6px;
        background: var(--slate-100);
        border-radius: 10px;
        margin-bottom: 16px;
        overflow: hidden;
    }

    .timer-fill {
        height: 100%;
        background: var(--primary);
        border-radius: 10px;
        transition: width 1s linear;
    }

    .timer-text {
        font-size: 0.95rem;
        color: var(--slate-500);
        font-weight: 600;
    }

    .timer-text span {
        font-weight: 800;
        color: var(--primary);
    }

    .resend-link {
        display: block;
        text-align: center;
        margin-top: 32px;
        font-size: 0.95rem;
        color: var(--slate-500);
        font-weight: 500;
    }

    .resend-link a {
        color: var(--primary);
        font-weight: 800;
        text-decoration: none;
        margin-left: 4px;
    }

    .resend-link a:hover { text-decoration: underline; }

    .dev-badge {
        background: #FFFBEB;
        border: 1px solid #FEF3C7;
        color: #92400E;
        padding: 16px;
        border-radius: 20px;
        font-size: 0.9rem;
        font-weight: 700;
        margin-bottom: 32px;
        display: flex;
        align-items: center;
        gap: 12px;
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
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="auth-container">
        <div class="auth-card animate-fade-in">

            <div class="step-indicator">
                <div class="step-dot done"></div>
                <div class="step-dot active"></div>
                <div class="step-dot"></div>
            </div>

            <div class="auth-header">
                <div class="logo-icon" style="margin: 0 auto 24px; background: var(--secondary-50); color: var(--secondary);">
                    <i data-lucide="shield-check" style="width: 32px; height: 32px;"></i>
                </div>
                <h1>Verificar Identidade</h1>
                <p style="color: var(--slate-500); font-weight: 500;">
                    Introduza o código de 6 dígitos enviado para<br>
                    <strong style="color: var(--slate-900); font-weight: 800;"><?= esc(session()->get('reg_phone')) ?></strong>
                </p>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('info')): ?>
                <div class="alert alert-info">
                    <?= session()->getFlashdata('info') ?>
                </div>
            <?php endif; ?>

            <?php
            $devCode = session()->getFlashdata('dev_otp_code');
            if ($devCode): ?>
                <div class="dev-badge">
                    <i data-lucide="terminal" style="width:18px;height:18px;flex-shrink:0;"></i>
                    <span>[DEV] Código SMS: <strong><?= esc($devCode) ?></strong></span>
                </div>
            <?php endif; ?>

            <div class="timer-container">
                <div class="timer-bar">
                    <div class="timer-fill" id="timerFill"></div>
                </div>
                <p class="timer-text">Expira em <span id="countdown">5:00</span></p>
            </div>

            <form action="/auth/verify-otp" method="POST" id="otpForm">
                <?= csrf_field() ?>
                <input type="hidden" name="codigo" id="codigoHidden">

                <div class="otp-inputs" id="otpInputs">
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" id="d1">
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" id="d2">
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" id="d3">
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" id="d4">
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" id="d5">
                    <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" pattern="[0-9]" id="d6">
                </div>

                <button type="submit" class="btn-primary" id="submitBtn" style="width: 100%; font-size: 1.1rem; padding: 18px; border-radius: 20px; font-weight: 800;" disabled>
                    Validar Código →
                </button>
            </form>

            <p class="resend-link">
                Não recebeu o código?
                <a href="/auth/step1" id="resendLink">Reenviar</a>
            </p>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(function () {
    const digits  = Array.from(document.querySelectorAll('.otp-digit'));
    const hidden  = document.getElementById('codigoHidden');
    const form    = document.getElementById('otpForm');
    const btn     = document.getElementById('submitBtn');
    const fill    = document.getElementById('timerFill');
    const display = document.getElementById('countdown');

    // ---------- Auto-focus & navigation ----------
    digits.forEach((el, idx) => {
        el.addEventListener('input', () => {
            el.value = el.value.replace(/[^0-9]/, '');
            if (el.value && idx < digits.length - 1) digits[idx + 1].focus();
            el.classList.toggle('filled', !!el.value);
            sync();
        });

        el.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !el.value && idx > 0) {
                digits[idx - 1].focus();
                digits[idx - 1].value = '';
                digits[idx - 1].classList.remove('filled');
                sync();
            }
        });

        el.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            pasted.split('').forEach((ch, i) => {
                if (digits[i]) {
                    digits[i].value = ch;
                    digits[i].classList.add('filled');
                }
            });
            if (pasted.length === 6) { digits[5].focus(); sync(); }
        });
    });

    function sync() {
        const code = digits.map(d => d.value).join('');
        hidden.value = code;
        btn.disabled = code.length !== 6;
    }

    digits[0].focus();

    // ---------- Countdown based on server remaining time ----------
    const TOTAL = 5 * 60;
    let remaining = <?= $remainingSeconds ?? (5 * 60) ?>;

    function tick() {
        if (remaining <= 0) {
            display.textContent = '0:00';
            fill.style.width = '0%';
            display.style.color = '#dc2626';
            return;
        }
        remaining--;
        const m = Math.floor(remaining / 60);
        const s = remaining % 60;
        display.textContent = m + ':' + String(s).padStart(2, '0');
        fill.style.width = ((remaining / TOTAL) * 100) + '%';
        setTimeout(tick, 1000);
    }

    fill.style.width = '100%';
    setTimeout(tick, 1000);
})();
</script>
<?= $this->endSection() ?>
