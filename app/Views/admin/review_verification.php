<?= $this->extend('templates/main') ?>

<?php $this->section('title') ?>Revisão de Documentos: <?= esc($user['full_name']) ?><?php $this->endSection() ?>

<?php $this->section('styles') ?>
<style>
    .review-container {
        max-width: 1200px;
        margin: 40px auto;
        padding: 0 20px;
    }

    .review-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 32px;
    }

    @media (max-width: 992px) {
        .review-grid { grid-template-columns: 1fr; }
    }

    .doc-card {
        background: white;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
        border: 1px solid var(--gray-200);
        margin-bottom: 24px;
    }

    .doc-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--gray-100);
    }

    .doc-title {
        font-weight: 800;
        font-size: 1.25rem;
        color: #1e293b;
    }

    .image-preview {
        width: 100%;
        border-radius: 16px;
        cursor: pointer;
        transition: transform 0.3s;
        border: 1px solid var(--gray-200);
    }

    .image-preview:hover {
        transform: scale(1.02);
    }

    .info-item {
        margin-bottom: 20px;
    }

    .info-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--gray-500);
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 700;
        color: #1e293b;
    }

    .action-panel {
        position: sticky;
        top: 140px;
    }

    .btn-approve {
        width: 100%;
        background: #10b981;
        color: white;
        padding: 16px;
        border-radius: 12px;
        border: none;
        font-weight: 700;
        margin-bottom: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .btn-reject {
        width: 100%;
        background: white;
        color: #ef4444;
        padding: 16px;
        border-radius: 12px;
        border: 1px solid #ef4444;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
    }

    .status-badge {
        padding: 4px 12px;
        border-radius: 99px;
        font-size: 0.75rem;
        font-weight: 700;
        background: #fef9c3;
        color: #854d0e;
    }
</style>
<?php $this->endSection() ?>

<?php $this->section('content') ?>
<div class="review-container">
    <div style="margin-bottom: 24px;">
        <a href="/admin/dashboard" style="text-decoration: none; color: var(--app-primary); font-weight: 600; display: flex; align-items: center; gap: 4px;">
            <i class="ph ph-arrow-left"></i>
            Voltar ao Painel
        </a>
    </div>

    <div class="review-grid">
        <!-- Documentos -->
        <div>
            <div class="doc-card">
                <div class="doc-header">
                    <span class="doc-title">Bilhete de Identidade (BI)</span>
                    <span class="status-badge">Pendente</span>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <p class="info-label">Foto Frente</p>
                        <img src="/admin/view-bi/<?= basename($user['bi_foto_frente']) ?>" class="image-preview" onclick="window.open(this.src)">
                    </div>
                    <div>
                        <p class="info-label">Foto Verso</p>
                        <img src="/admin/view-bi/<?= basename($user['bi_foto_verso']) ?>" class="image-preview" onclick="window.open(this.src)">
                    </div>
                </div>
            </div>

            <div class="doc-card">
                <div class="doc-header">
                    <span class="doc-title">Selfie de Verificação</span>
                </div>
                <div style="max-width: 400px; margin: 0 auto;">
                    <img src="/admin/view-bi/<?= basename($user['selfie_path']) ?>" class="image-preview" onclick="window.open(this.src)">
                </div>
            </div>
        </div>

        <!-- Dados e Controlo -->
        <div class="action-panel">
            <div class="doc-card">
                <h3 style="margin-bottom: 24px; color: #1e293b; font-weight: 800;">Dados do Utilizador</h3>
                
                <div class="info-item">
                    <p class="info-label">Nome Completo</p>
                    <p class="info-value"><?= esc($user['full_name']) ?></p>
                </div>

                <div class="info-item">
                    <p class="info-label">Número de Telemóvel</p>
                    <p class="info-value"><?= esc($user['phone']) ?></p>
                </div>

                <div class="info-item">
                    <p class="info-label">Número do BI</p>
                    <p class="info-value"><?= esc($user['bi_number'] ?: 'Não informado') ?></p>
                </div>

                <hr style="margin: 24px 0; border: none; border-top: 1px solid var(--gray-100);">

                <form action="/admin/approve-verification/<?= $verification['id'] ?>" method="POST">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-approve">
                        <i class="ph-bold ph-check-circle"></i>
                        Aprovar Utilizador
                    </button>
                    <p style="font-size: 0.75rem; color: var(--gray-500); text-align: center; margin-bottom: 16px;">
                        Isto irá atribuir o selo de verificação ⭐
                    </p>
                </form>

                <form action="/admin/reject-verification/<?= $verification['id'] ?>" method="POST">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn-reject">
                        <i class="ph-bold ph-x-circle"></i>
                        Rejeitar Submissão
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $this->endSection() ?>


<?= $this->section('scripts') ?>
<script>
    function toggleRejection() {
        const form = document.getElementById('rejectionForm');
        form.style.display = form.style.display === 'block' ? 'none' : 'block';
    }
</script>
<?= $this->endSection() ?>
