<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Verificar Código - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<link rel="stylesheet" href="/css/auth.css">
<style>
    .otp-inputs { display: flex; gap: 10px; justify-content: center; margin-bottom: 24px; }
    .otp-digit { width: 50px; height: 64px; text-align: center; font-size: 1.8rem; font-weight: 900; background: #f8f9fa; border: 2px solid transparent; border-radius: 18px; outline: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); color: var(--app-secondary); }
    .otp-digit:focus { background: white; border-color: var(--app-primary); box-shadow: 0 8px 20px rgba(255, 107, 53, 0.1); transform: translateY(-3px); }
    .otp-digit.filled { background: #fff7ed; border-color: #ffedd5; }
    
    .timer-container { margin-bottom: 32px; text-align: center; }
    .timer-bar { height: 6px; background: #f0f2f5; border-radius: 10px; margin-bottom: 12px; overflow: hidden; }
    .timer-fill { height: 100%; background: var(--app-primary); border-radius: 10px; transition: width 1s linear; width: 100%; }
    .timer-text { font-size: 0.9rem; color: var(--gray-500); font-weight: 700; }
    .timer-text span { color: var(--app-primary); font-weight: 900; }
</style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="auth-card">
    <a href="/" class="logo-app">
        <img src="/img/logo.png" alt="CasaSegura">
        <span>CasaSegura</span>
    </a>
    <h2 class="auth-title">Verificar Código</h2>
    <p style="color: var(--gray-500); margin-bottom: 24px; font-weight: 500;">
        Introduza o código de 6 dígitos enviado para<br>
        <strong style="color: var(--app-secondary); font-weight: 800;"><?= esc($identifier ?? session()->get('reg_identifier')) ?></strong>
    </p>

    <?php if (session()->getFlashdata('dev_otp_code')): ?>
        <div style="background: #fffbeb; border: 1px solid #fef3c7; color: #92400e; padding: 14px; border-radius: 12px; font-size: 0.85rem; font-weight: 700; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
            <i class="ph-bold ph-terminal-window"></i>
            [DEV] Código: <?= session()->getFlashdata('dev_otp_code') ?>
        </div>
    <?php endif; ?>

    <div class="timer-container">
        <div class="timer-bar"><div class="timer-fill" id="timerFill"></div></div>
        <p class="timer-text">Expira em <span id="countdown">5:00</span></p>
    </div>

    <form action="/auth/verify-otp" method="POST" class="auth-form" id="otpForm">
        <?= csrf_field() ?>
        <input type="hidden" name="codigo" id="codigoHidden">
        
        <div class="otp-inputs" id="otpInputs">
            <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" id="d1">
            <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" id="d2">
            <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" id="d3">
            <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" id="d4">
            <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" id="d5">
            <input type="text" class="otp-digit" maxlength="1" inputmode="numeric" id="d6">
        </div>
        
        <button type="submit" class="btn btn-primary btn-large" id="submitBtn" disabled>
            Validar Código <i class="ph-bold ph-check"></i>
        </button>
    </form>
    
    <form action="<?= site_url('auth/step1') ?>" method="POST" id="resendForm" style="display:none;">
        <?= csrf_field() ?>
        <input type="hidden" name="identifier" value="<?= esc(session()->get('reg_identifier')) ?>">
        <input type="hidden" name="method" value="<?= esc(session()->get('reg_method')) ?>">
    </form>

    <div class="auth-links" style="justify-content: center; margin-top: 24px;">
        <span style="color: var(--gray-500); font-weight: 600;">Não recebeu?</span>
        <a href="javascript:void(0)" onclick="document.getElementById('resendForm').submit()" class="link-primary" style="font-weight: 800;">Reenviar Agora</a>
    </div>
</div>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
(function () {
    const digits = document.querySelectorAll('.otp-digit');
    const hidden = document.getElementById('codigoHidden');
    const btn    = document.getElementById('submitBtn');
    
    digits.forEach((el, idx) => {
        el.addEventListener('input', () => {
            el.value = el.value.replace(/\D/g, '');
            if (el.value && idx < 5) digits[idx + 1].focus();
            el.classList.toggle('filled', !!el.value);
            sync();
        });
        el.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !el.value && idx > 0) {
                digits[idx - 1].focus();
                digits[idx - 1].value = ''; // Clean previous on backspace for better UX
                digits[idx - 1].classList.remove('filled');
            }
        });
    });

    function sync() {
        const val = Array.from(digits).map(d => d.value).join('');
        hidden.value = val;
        btn.disabled = val.length !== 6;
    }

    const TOTAL = 5 * 60;
    let remaining = <?= $remainingSeconds ?? (5 * 60) ?>;
    const fill = document.getElementById('timerFill');
    const display = document.getElementById('countdown');

    function tick() {
        if (remaining <= 0) return;
        remaining--;
        const m = Math.floor(remaining / 60);
        const s = remaining % 60;
        display.textContent = m + ':' + String(s).padStart(2, '0');
        fill.style.width = ((remaining / TOTAL) * 100) + '%';
        setTimeout(tick, 1000);
    }
    setTimeout(tick, 1000);
    digits[0].focus();
})();
</script>
<?php $this->endSection(); ?>
