<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Verificação de Identidade<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .verify-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 20px;
    }

    .verify-card {
        background: white;
        border-radius: 32px;
        padding: 24px;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--slate-100);
    }

    @media (max-width: 768px) {
        .verify-card { padding: 24px; }
        .verify-header h1 { font-size: 1.8rem; }
    }

    .verify-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .verify-header h1 {
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--slate-900);
        margin-bottom: 16px;
        letter-spacing: -1px;
    }

    .upload-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 32px;
    }

    @media (max-width: 768px) {
        .upload-grid { grid-template-columns: 1fr; }
    }

    .upload-box {
        border: 2px dashed var(--slate-200);
        border-radius: 20px;
        padding: 32px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        background: var(--slate-50);
        position: relative;
    }

    .upload-box:hover {
        border-color: var(--primary);
        background: var(--primary-50);
        transform: translateY(-4px);
    }

    .upload-box i {
        font-size: 2rem;
        color: var(--primary);
        margin-bottom: 16px;
        display: block;
    }

    .upload-box span {
        display: block;
        font-weight: 600;
        color: var(--slate-700);
        margin-bottom: 8px;
    }

    .upload-box p {
        font-size: 0.85rem;
        color: var(--slate-500);
    }

    .upload-box input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .preview-img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 12px;
        margin-top: 16px;
        display: none;
    }

    .guide-card {
        background: var(--primary-50);
        border-radius: 20px;
        padding: 24px;
        margin-bottom: 32px;
        display: flex;
        gap: 20px;
        align-items: flex-start;
    }

    .guide-card i {
        color: var(--primary);
        font-size: 1.5rem;
        margin-top: 4px;
    }

    .guide-content h4 {
        margin-bottom: 8px;
        color: var(--primary-700);
    }

    .guide-content p {
        font-size: 0.9rem;
        color: var(--primary-600);
        line-height: 1.5;
    }

    .btn-submit {
        width: 100%;
        padding: 20px;
        font-size: 1.1rem;
        font-weight: 700;
        border-radius: 16px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="verify-container">
    <div class="verify-card animate-fade-in">
        <div class="verify-header">
            <div class="logo-icon" style="margin: 0 auto 24px; background: var(--primary-50); color: var(--primary); width: 64px; height: 64px; border-radius: 20px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="shield-check"></i>
            </div>
            <h1>Verificar Identidade</h1>
            <p style="color: var(--slate-500); font-size: 1.1rem;">Para garantir a segurança de todos, necessitamos de validar o seu BI angolano.</p>
        </div>

        <div class="guide-card">
            <i data-lucide="info"></i>
            <div class="guide-content">
                <h4>Dicas para uma aprovação rápida</h4>
                <p>Certifique-se de que a foto está bem iluminada, sem reflexos e que todos os dados do BI estão perfeitamente legíveis. A selfie deve mostrar o seu rosto claramente.</p>
            </div>
        </div>

        <form action="/auth/verify-bi" method="POST" enctype="multipart/form-data">
            <div class="upload-grid">
                <div class="upload-box" id="box-frente">
                    <i data-lucide="image"></i>
                    <span>BI Frente</span>
                    <p>Clique ou arraste a foto da frente</p>
                    <input type="file" name="bi_frente" accept="image/*" onchange="previewImage(this, 'preview-frente')">
                    <img id="preview-frente" class="preview-img">
                </div>

                <div class="upload-box" id="box-verso">
                    <i data-lucide="image"></i>
                    <span>BI Verso</span>
                    <p>Clique ou arraste a foto do verso</p>
                    <input type="file" name="bi_verso" accept="image/*" onchange="previewImage(this, 'preview-verso')">
                    <img id="preview-verso" class="preview-img">
                </div>
            </div>

            <div class="upload-box" style="margin-bottom: 32px;" id="box-selfie">
                <i data-lucide="camera"></i>
                <span>Selfie</span>
                <p>Uma foto sua segurando o BI (opcional) ou apenas do seu rosto</p>
                <input type="file" name="selfie" accept="image/*" onchange="previewImage(this, 'preview-selfie')">
                <img id="preview-selfie" class="preview-img">
            </div>

            <button type="submit" class="btn-primary btn-submit">
                Submeter para Verificação
                <i data-lucide="arrow-right"></i>
            </button>
        </form>

        <p style="text-align: center; margin-top: 24px; color: var(--slate-400); font-size: 0.85rem;">
            Os seus dados são encriptados e tratados de acordo com a nossa Política de Privacidade.
        </p>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function previewImage(input, previewId) {
        const preview = document.getElementById(previewId);
        const box = input.parentElement;
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                box.querySelector('i').style.display = 'none';
                box.querySelector('span').style.display = 'none';
                box.querySelector('p').style.display = 'none';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?= $this->endSection() ?>
