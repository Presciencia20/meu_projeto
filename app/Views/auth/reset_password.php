<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Redefinir Senha - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<link rel="stylesheet" href="/css/auth.css">
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="auth-card">
    <a href="/" class="logo-app">
        <img src="/img/logo.png" alt="CasaSegura">
        <span>CasaSegura</span>
    </a>
    <h2 class="auth-title">Nova Senha</h2>
    <p style="color: var(--gray-500); margin-bottom: 24px;">Insira o código enviado para o seu e-mail e escolha uma nova senha.</p>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('dev_otp_code')): ?>
        <div style="background: #fffbeb; padding: 10px; border-radius: 8px; margin-bottom: 20px; font-weight: 700; color: #92400e; font-size: 0.8rem;">
            [MODO DEV] Código: <?= session()->getFlashdata('dev_otp_code') ?>
        </div>
    <?php endif; ?>

    <form action="/auth/reset" method="post" class="auth-form">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="codigo">Código de Verificação</label>
            <input type="text" name="codigo" id="codigo" placeholder="6 dígitos" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">Nova Palavra-passe</label>
            <input type="password" name="password" id="password" placeholder="Mínimo 8 caracteres" required>
        </div>
        <div class="form-group">
            <label for="password_confirm">Confirmar Palavra-passe</label>
            <input type="password" name="password_confirm" id="password_confirm" placeholder="Repita a nova senha" required>
        </div>
        <button type="submit" class="btn btn-primary btn-large">Redefinir Senha</button>
    </form>
</div>
<?php $this->endSection(); ?>
