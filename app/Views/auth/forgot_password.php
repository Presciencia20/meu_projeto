<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Esqueci a Senha - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<link rel="stylesheet" href="/css/auth.css">
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="auth-card">
    <a href="/" class="logo-app">
        <img src="/img/logo.png" alt="CasaSegura">
        <span>CasaSegura</span>
    </a>
    <h2 class="auth-title">Recuperar Senha</h2>
    <p style="color: var(--gray-500); margin-bottom: 24px;">Insira o seu e-mail para receber um código de recuperação.</p>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('info')): ?>
        <div class="alert alert-success" style="background: var(--app-primary-50); color: var(--app-primary); border-color: var(--app-primary-50);"><?= session()->getFlashdata('info') ?></div>
    <?php endif; ?>

    <form action="/auth/forgot" method="post" class="auth-form">
        <?= csrf_field() ?>
        <div class="form-group">
            <label for="email">Endereço de E-mail</label>
            <input type="email" name="email" id="email" placeholder="seu@email.com" required autofocus>
        </div>
        <button type="submit" class="btn btn-primary btn-large">Enviar Código</button>
    </form>
    
    <div class="auth-links" style="justify-content: center;">
        <a href="/login" class="link-primary">Voltar ao Login</a>
    </div>
</div>
<?php $this->endSection(); ?>
