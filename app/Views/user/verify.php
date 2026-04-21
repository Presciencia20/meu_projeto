<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Verificação de Identidade<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .verify-container {
        max-width: 680px;
        margin: 60px auto;
        padding-bottom: 100px;
    }

    .form-card {
        background: white;
        padding: 56px;
        border-radius: 40px;
        border: 1px solid var(--slate-100);
        box-shadow: var(--shadow-xl);
    }

    .info-box {
        background: var(--primary-50);
        padding: 24px;
        border-radius: 24px;
        display: flex;
        gap: 20px;
        margin-bottom: 40px;
        color: var(--primary);
        font-size: 0.95rem;
        font-weight: 500;
        line-height: 1.6;
        border: 1px solid var(--primary-100);
    }

    .upload-zone {
        border: 2px dashed var(--slate-200);
        padding: 60px 40px;
        border-radius: 32px;
        text-align: center;
        margin-bottom: 32px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        background: var(--slate-50);
    }

    .upload-zone:hover {
        border-color: var(--primary);
        background: var(--primary-50);
        transform: translateY(-4px);
    }

    .upload-zone i {
        color: var(--primary);
        margin-bottom: 20px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="verify-container">
        <div class="form-card animate-fade-in">
            <header style="margin-bottom: 32px;">
                <h1 style="font-size: 1.75rem; font-weight: 800; color: var(--slate-900); margin-bottom: 8px;">Verificar Identidade</h1>
                <p style="color: var(--slate-500);">A verificação ajuda a criar um ambiente seguro para todos.</p>
            </header>

            <div class="info-box">
                <i data-lucide="info" style="flex-shrink: 0;"></i>
                <p>Os seus documentos serão analisados pela nossa equipa de segurança em Luanda. Este processo demora normalmente menos de 24 horas úteis.</p>
            </div>

            <form action="/user/verify" method="POST" enctype="multipart/form-data">
                <div class="form-group" style="margin-bottom: 32px;">
                    <label class="form-label">Tipo de Documento</label>
                    <select name="doc_type" class="input-modern" style="cursor: pointer;">
                        <option value="BI">Bilhete de Identidade (BI) - Nacional</option>
                        <option value="Passaporte">Passaporte Internacional</option>
                        <option value="CartaPosse">Carta de Posse / Registo Predial</option>
                    </select>
                </div>

                <div class="upload-zone" onclick="document.getElementById('bi_file').click()">
                    <i data-lucide="upload-cloud" style="width: 56px; height: 56px;"></i>
                    <div style="font-weight: 800; color: var(--slate-900); font-size: 1.1rem; margin-bottom: 8px;">Carregar Documento</div>
                    <p style="color: var(--slate-500); font-size: 0.9rem; font-weight: 500;">
                        Arraste ou clique para selecionar<br>
                        <span style="font-size: 0.8rem; opacity: 0.7;">PDF, JPG ou PNG (Máx 5MB)</span>
                    </p>
                    <input type="file" id="bi_file" name="bi_file" style="display: none;" onchange="updateUploadText(this)">
                </div>

                <div class="form-group" style="margin-bottom: 40px;">
                    <label style="display: flex; gap: 16px; cursor: pointer; padding: 16px; background: var(--slate-50); border-radius: 16px; border: 1px solid var(--slate-100);">
                        <input type="checkbox" required style="width: 24px; height: 24px; accent-color: var(--primary);">
                        <span style="font-size: 0.9rem; color: var(--slate-600); line-height: 1.5; font-weight: 500;">
                            Confirmo sob compromisso de honra que as informações fornecidas são verdadeiras e o documento pertence à minha pessoa.
                        </span>
                    </label>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; padding: 20px; font-size: 1.1rem; font-weight: 800; border-radius: 20px; box-shadow: 0 10px 30px rgba(26, 86, 219, 0.2);">
                    Enviar para Verificação →
                </button>
            </form>
        </div>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function updateUploadText(input) {
        const uploadZone = input.closest('.upload-zone');
        const textElement = uploadZone.querySelector('div');
        const subtextElement = uploadZone.querySelector('p');
        const iconElement = uploadZone.querySelector('i');
        
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            textElement.textContent = fileName;
            textElement.style.color = 'var(--primary)';
            subtextElement.textContent = 'Ficheiro selecionado com sucesso.';
            iconElement.setAttribute('data-lucide', 'check-circle');
            iconElement.style.color = 'var(--secondary)';
            
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        }
    }
</script>
<?= $this->endSection() ?>
