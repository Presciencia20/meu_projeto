<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Estatísticas Gerais - CasaSegura Admin<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<link rel="stylesheet" href="/css/admin.css">
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    .data-card {
        background: white;
        padding: 1.5rem;
        border-radius: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
    }
    .data-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        border-bottom: 1px solid #f8fafc;
    }
    .data-row:last-child { border-bottom: none; }
</style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>
    <main class="admin-main">
        <header class="admin-header">
            <h2 style="font-weight: 800; font-family: 'Outfit';">📊 Estatísticas Globais</h2>
            <p style="color: var(--gray-500);">Resumo analítico por categorias e tipos.</p>
        </header>

        <div class="stats-grid">
            <!-- Usuários por Tipo -->
            <div class="data-card">
                <h3 style="margin-bottom: 1.5rem; color: #1e293b;"><i class="ph-duotone ph-users" style="color: #6366f1;"></i> Distribuição de Usuários</h3>
                <?php foreach($usersByType as $u): ?>
                <div class="data-row">
                    <span style="font-weight: 600;"><?= esc($u['user_type']) ?></span>
                    <span style="font-weight: 800; color: #6366f1;"><?= $u['total'] ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Imóveis por Categoria -->
            <div class="data-card">
                <h3 style="margin-bottom: 1.5rem; color: #1e293b;"><i class="ph-duotone ph-house-line" style="color: #10b981;"></i> Imóveis por Categoria</h3>
                <?php foreach($propertyCategories as $c): ?>
                <div class="data-row">
                    <span style="font-weight: 600;"><?= esc(ucfirst($c['type'])) ?></span>
                    <span style="font-weight: 800; color: #10b981;"><?= $c['total'] ?></span>
                </div>
                <?php endforeach; ?>
            </div>

            <!-- Outras métricas rápidas -->
            <div class="data-card">
                <h3 style="margin-bottom: 1.5rem; color: #1e293b;"><i class="ph-duotone ph-activity" style="color: #f59e0b;"></i> Atividade Recente</h3>
                <div class="data-row">
                    <span>Taxa de Verificação</span>
                    <span style="font-weight: 800; color: #f59e0b;">84%</span>
                </div>
                <div class="data-row">
                    <span>Tempo Médio Aprovação</span>
                    <span style="font-weight: 800;">4h</span>
                </div>
                <div class="data-row">
                    <span>Tickets Resolvidos</span>
                    <span style="font-weight: 800;">92%</span>
                </div>
            </div>
        </div>
    </main>
</div>
<?php $this->endSection(); ?>
