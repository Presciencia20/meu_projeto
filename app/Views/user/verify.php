<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Verificação de Identidade - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<style>
    .verify-page {
        max-width: 650px;
        margin: 2rem auto 80px;
        padding: 0 1rem;
    }

    .hero-box {
        text-align: center;
        margin-bottom: 3rem;
    }

    .form-card-premium {
        background: white;
        border-radius: 40px;
        padding: 3.5rem;
        box-shadow: 0 20px 40px -10px rgba(0,0,0,0.05);
        border: 1px solid var(--gray-200);
    }

    .alert-info-app {
        background: var(--app-primary-50);
        padding: 1.5rem;
        border-radius: 20px;
        display: flex;
        gap: 1rem;
        align-items: flex-start;
        margin-bottom: 2.5rem;
        border: 1px solid rgba(37, 99, 235, 0.1);
        color: var(--app-primary);
        font-weight: 600;
        line-height: 1.5;
    }

    .upload-area {
        border: 3px dashed var(--gray-200);
        background: #f8fafc;
        border-radius: 28px;
        padding: 4rem 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        margin-bottom: 2rem;
    }

    .upload-area:hover {
        border-color: var(--app-primary);
        background: var(--app-primary-50);
        transform: translateY(-5px);
    }

    .upload-icon {
        font-size: 4rem;
        color: var(--app-primary);
        margin-bottom: 1.5rem;
        display: block;
    }

    .input-label {
        font-weight: 800;
        font-size: 0.8rem;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.75rem;
        display: block;
    }

    .select-premium {
        width: 100%;
        padding: 1rem 1.25rem;
        border-radius: 16px;
        border: 1px solid var(--gray-200);
        background: #f8fafc;
        font-weight: 800;
        font-family: 'Outfit';
        color: var(--gray-800);
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='currentColor'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1.25rem center;
        background-size: 1.25rem;
    }

    .checkbox-row {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 1.25rem;
        background: #f8fafc;
        border-radius: 16px;
        cursor: pointer;
        margin-bottom: 2.5rem;
        transition: all 0.2s;
    }

    .checkbox-row:hover { background: #f1f5f9; }

    .checkbox-row input {
        width: 24px;
        height: 24px;
        accent-color: var(--app-primary);
        cursor: pointer;
    }

    .checkbox-row span {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--gray-600);
        line-height: 1.5;
    }
</style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="verify-page">
    <div class="hero-box">
        <h1 style="font-family: 'Outfit'; font-weight: 950; font-size: 2.5rem; letter-spacing: -2px; color: #1e293b; margin-bottom: 0.5rem;">Selo de Confiança</h1>
        <p style="color: var(--gray-500); font-weight: 600; font-size: 1.1rem;">Verifique sua identidade para operar com segurança em Angola.</p>
    </div>

    <div class="form-card-premium">
        <div class="alert-info-app">
            <i class="ph-duotone ph-info" style="font-size: 1.5rem;"></i>
            <span>Seus dados são criptografados e analisados exclusivamente pela nossa equipa de segurança operacional.</span>
        </div>

        <form action="/user/verify" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            
            <div style="margin-bottom: 2rem;">
                <label class="input-label">Tipo de Documento</label>
                <select name="doc_type" class="select-premium">
                    <option value="BI">Bilhete de Identidade (Nacional)</option>
                    <option value="Passaporte">Passaporte Internacional</option>
                    <option value="CartaPosse">Registo de Imóvel / Carta de Posse</option>
                </select>
            </div>

            <div class="upload-area" onclick="document.getElementById('bi_file').click()">
                <i class="ph-duotone ph-cloud-arrow-up upload-icon"></i>
                <h4 style="font-family: 'Outfit'; font-weight: 900; font-size: 1.25rem; margin-bottom: 8px;" id="uploadTitle">Submeter Documento</h4>
                <p style="color: var(--gray-500); font-weight: 600; font-size: 0.9rem;" id="uploadText">Toque para selecionar ou arraste o ficheiro aqui.</p>
                <span style="font-size: 0.75rem; color: var(--gray-400); font-weight: 800; margin-top: 12px; display: block;">PDF, JPG ou PNG • MÁX 5MB</span>
                <input type="file" name="bi_file" id="bi_file" style="display: none;" onchange="handleFile(this)">
            </div>

            <label class="checkbox-row">
                <input type="checkbox" required>
                <span>Declaro estar ciente de que as informações fornecidas são autênticas e que o uso de documentos falsos é passível de sanções legais.</span>
            </label>

            <button type="submit" class="btn btn-primary" style="width: 100%; border-radius: 20px; padding: 1.25rem; font-weight: 900; font-size: 1.1rem; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.3);">
                Enviar para Análise <i class="ph-bold ph-arrow-right" style="margin-left: 8px;"></i>
            </button>
        </form>
    </div>
</div>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    function handleFile(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
            
            document.getElementById('uploadTitle').innerText = fileName;
            document.getElementById('uploadText').innerText = `Tamanho: ${fileSize} MB • Carregado em cache.`;
            document.querySelector('.upload-area').style.borderColor = 'var(--app-primary)';
            document.querySelector('.upload-icon').className = 'ph-duotone ph-check-circle upload-icon';
            document.querySelector('.upload-icon').style.color = '#10b981';
        }
    }
</script>
<?php $this->endSection(); ?>

