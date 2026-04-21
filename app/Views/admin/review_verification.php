<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Revisão de Documentos: <?= $s['full_name'] ?><?= $this->endSection() ?>

<?= $this->section('styles') ?>
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
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--slate-100);
        margin-bottom: 24px;
    }

    .doc-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--slate-100);
    }

    .doc-title {
        font-weight: 800;
        font-size: 1.25rem;
        color: var(--slate-900);
    }

    .image-preview {
        width: 100%;
        border-radius: 16px;
        cursor: pointer;
        transition: transform 0.3s;
        border: 1px solid var(--slate-200);
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
        color: var(--slate-500);
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .info-value {
        font-size: 1rem;
        font-weight: 700;
        color: var(--slate-900);
    }

    .action-panel {
        position: sticky;
        top: 140px;
    }

    .btn-approve {
        width: 100%;
        background: var(--secondary);
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
    }

    .btn-reject {
        width: 100%;
        background: white;
        color: var(--danger);
        padding: 16px;
        border-radius: 12px;
        border: 1px solid var(--danger);
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .rejection-form {
        display: none;
        margin-top: 16px;
        padding-top: 16px;
        border-top: 1px solid var(--slate-100);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="review-container">
    <div style="margin-bottom: 24px;">
        <a href="/admin/verifications" style="text-decoration: none; color: var(--primary); font-weight: 600; display: flex; align-items: center; gap: 4px;">
            <i data-lucide="arrow-left" style="width: 18px;"></i>
            Voltar à Fila
        </a>
    </div>

    <div class="review-grid">
        <!-- Documentos -->
        <div>
            <div class="doc-card animate-fade-in">
                <div class="doc-header">
                    <span class="doc-title">Bilhete de Identidade (BI)</span>
                    <span class="status-badge status-pending">Pendente</span>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                    <div>
                        <p class="info-label">Foto Frente</p>
                        <img src="/admin/view-bi/<?= $s['foto_frente'] ?>" class="image-preview" onclick="window.open(this.src)">
                    </div>
                    <div>
                        <p class="info-label">Foto Verso</p>
                        <img src="/admin/view-bi/<?= $s['foto_verso'] ?>" class="image-preview" onclick="window.open(this.src)">
                    </div>
                </div>
            </div>

            <div class="doc-card animate-fade-in" style="animation-delay: 0.1s;">
                <div class="doc-header">
                    <span class="doc-title">Selfie de Verificação</span>
                </div>
                <div style="max-width: 400px; margin: 0 auto;">
                    <img src="/admin/view-bi/<?= $s['selfie'] ?>" class="image-preview" onclick="window.open(this.src)">
                </div>
            </div>
        </div>

        <!-- Dados e Controlo -->
        <div class="action-panel">
            <div class="doc-card">
                <h3 style="margin-bottom: 24px; color: var(--slate-900);">Dados do Utilizador</h3>
                
                <div class="info-item">
                    <p class="info-label">Nome Completo</p>
                    <p class="info-value"><?= $s['full_name'] ?></p>
                </div>

                <div class="info-item">
                    <p class="info-label">Número de Telemóvel</p>
                    <p class="info-value"><?= $s['phone'] ?></p>
                </div>

                <div class="info-item">
                    <p class="info-label">Número do BI</p>
                    <p class="info-value"><?= $s['bi_number'] ?? 'Não informado' ?></p>
                </div>

                <hr style="margin: 24px 0; border: none; border-top: 1px solid var(--slate-100);">

                <form action="/admin/approve-verification/<?= $s['id'] ?>" method="POST" id="approveForm">
                    <button type="submit" class="btn-approve">
                        <i data-lucide="check-circle"></i>
                        Aprovar Utilizador
                    </button>
                    <p style="font-size: 0.75rem; color: var(--slate-500); text-align: center; margin-bottom: 16px;">
                        Isto irá atribuir o selo de verificação ⭐
                    </p>
                </form>

                <button class="btn-reject" onclick="toggleRejection()">
                    <i data-lucide="x-circle"></i>
                    Rejeitar Submissão
                </button>

                <div class="rejection-form" id="rejectionForm">
                    <form action="/admin/reject-verification/<?= $s['id'] ?>" method="POST">
                        <p class="info-label">Motivo da Rejeição</p>
                        <select name="motivo" class="input-modern" style="margin-bottom: 16px; padding: 12px;" required>
                            <option value="">Seleccione um motivo...</option>
                            <option value="Imagens pouco legíveis">Imagens pouco legíveis</option>
                            <option value="BI expirado">BI expirado</option>
                            <option value="Selfie não corresponde ao BI">Selfie não corresponde ao BI</option>
                            <option value="Dados não conferem">Dados não conferem</option>
                            <option value="Outro">Outro (Especifique na mensagem)</option>
                        </select>
                        <button type="submit" class="btn-primary" style="background: var(--danger); width: 100%; border-radius: 8px; padding: 12px;">Confirmar Rejeição</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function toggleRejection() {
        const form = document.getElementById('rejectionForm');
        form.style.display = form.style.display === 'block' ? 'none' : 'block';
    }
</script>
<?= $this->endSection() ?>
