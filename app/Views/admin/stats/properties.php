<?php $this->extend('templates/main'); ?>
<?php $this->section('title'); ?>Estatísticas: properties - CasaSegura Admin<?php $this->endSection(); ?>
<?php $this->section('styles'); ?><link rel="stylesheet" href="/css/admin.css"><?php $this->endSection(); ?>
<?php $this->section('content'); ?>
<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>
    <main class="admin-main">
        <h2 style="font-weight: 800; font-family: 'Outfit';">Estatísticas: <?= ucfirst('properties') ?></h2>
        <div class="table-container" style="margin-top: 2rem; text-align: center; padding: 5rem;">
            <i class="ph-duotone ph-chart-bar" style="font-size: 4rem; color: #10b981; opacity: 0.2; margin-bottom: 2rem; display: block;"></i>
            <h3 style="color: var(--gray-400);">Módulo em desenvolvimento.</h3>
        </div>
    </main>
</div>
<?php $this->endSection(); ?>
