<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Novo Anúncio - CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .form-container {
        max-width: 800px;
        margin: 40px auto 80px;
        background: white;
        border-radius: 40px;
        padding: 48px;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--slate-100);
    }
    
    .form-header {
        margin-bottom: 40px;
        text-align: center;
    }
    
    .form-header h1 {
        font-size: 2rem;
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 8px;
        letter-spacing: -1px;
    }

    .form-section {
        background: var(--slate-50);
        padding: 32px;
        border-radius: 24px;
        border: 1px solid var(--slate-100);
        margin-bottom: 32px;
    }

    .form-section-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--slate-900);
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .grid-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 24px;
    }

    .image-preview-area {
        border: 2px dashed var(--slate-300);
        border-radius: 20px;
        padding: 40px;
        text-align: center;
        cursor: pointer;
        transition: 0.2s;
        background: white;
    }

    .image-preview-area:hover {
        border-color: var(--primary);
        background: var(--primary-50);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="form-container animate-fade-in">
    <div class="form-header">
        <h1>Publicar Imóvel</h1>
        <p style="color: var(--slate-500); font-size: 1.1rem; font-weight: 500;">Preencha os detalhes do imóvel que pretende arrendar ou vender.</p>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div style="background: #fef2f2; color: #ef4444; padding: 16px; border-radius: 16px; margin-bottom: 32px; font-weight: 700;">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <form action="/property/store" method="POST" enctype="multipart/form-data">
        <?= csrf_field() ?>

        <div class="form-section">
            <div class="form-section-title"><i data-lucide="info" style="color: var(--primary);"></i> Detalhes Principais</div>
            
            <div class="form-group" style="margin-bottom: 24px;">
                <label class="form-label">Título do Anúncio (ex: Casa T3 Mobilada no Talatona)</label>
                <input type="text" name="title" class="input-modern" required placeholder="Seja claro e descritivo...">
            </div>

            <div class="grid-2" style="margin-bottom: 24px;">
                <div class="form-group">
                    <label class="form-label">Preço (KZ)</label>
                    <input type="number" name="price" class="input-modern" required placeholder="Ex: 150000">
                </div>
                <!-- TODO: Future expansion for type: rent vs sell -->
            </div>

            <div class="form-group">
                <label class="form-label">Descrição Longa</label>
                <textarea name="description" class="input-modern" rows="5" required placeholder="Descreva o estado do imóvel, condomínio, facilidades..."></textarea>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title"><i data-lucide="map-pin" style="color: var(--primary);"></i> Localização Inteligente</div>
            <div style="background: #e0f2fe; padding: 16px; border-radius: 12px; margin-bottom: 24px; color: #0369a1; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 12px;">
                <i data-lucide="camera" style="width: 24px;"></i>
                Se tirar fotografias à casa com a localização ligada (GPS) no seu telemóvel, os campos de morada serão preenchidos automaticamente!
            </div>
            <input type="hidden" name="latitude" id="latInput">
            <input type="hidden" name="longitude" id="lngInput">
            <div class="grid-3">
                <div class="form-group">
                    <label class="form-label">Província</label>
                    <select name="province" class="input-modern" required>
                        <option value="Luanda">Luanda</option>
                        <option value="Benguela">Benguela</option>
                        <option value="Huíla">Huíla</option>
                        <option value="Huambo">Huambo</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Município</label>
                    <input type="text" name="municipality" id="municipalityInput" class="input-modern" required placeholder="Ex: Talatona">
                </div>
                <div class="form-group">
                    <label class="form-label">Bairro</label>
                    <input type="text" name="neighborhood" id="neighborhoodInput" class="input-modern" required placeholder="Ex: Benfica">
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title"><i data-lucide="home" style="color: var(--primary);"></i> Características</div>
            <div class="grid-2">
                <div class="form-group">
                    <label class="form-label">Nº Quartos</label>
                    <input type="number" name="bedrooms" class="input-modern" required min="0" value="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Nº Casas de Banho</label>
                    <input type="number" name="bathrooms" class="input-modern" required min="0" value="1">
                </div>
            </div>
        </div>

        <div class="form-section">
            <div class="form-section-title"><i data-lucide="image" style="color: var(--primary);"></i> Fotografias (Até 5)</div>
            
            <label class="image-preview-area" for="images">
                <i data-lucide="upload-cloud" style="width: 48px; height: 48px; color: var(--primary); margin-bottom: 16px;"></i>
                <h4 style="font-weight: 800; color: var(--slate-900); font-size: 1.1rem; margin-bottom: 8px;">Clique para selecionar imagens</h4>
                <p style="color: var(--slate-500); font-size: 0.9rem;">Formatos aceites: JPG, PNG. Primeira imagem será a capa.</p>
            </label>
            <input type="file" name="images[]" id="images" multiple accept="image/*" style="display: none;" required>
            
            <div id="file-list" style="margin-top: 16px; font-size: 0.9rem; color: var(--slate-600); font-weight: 600;"></div>
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; padding: 20px; font-size: 1.25rem;">
            Publicar Imóvel para Aprovação <i data-lucide="arrow-right"></i>
        </button>
    </form>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/exif-js"></script>
<script>
    document.getElementById('images').addEventListener('change', function(e) {
        const fileList = document.getElementById('file-list');
        fileList.innerHTML = '';
        
        if (this.files.length > 5) {
            alert('Apenas pode enviar até 5 imagens!');
            this.value = '';
            return;
        }

        const files = Array.from(this.files);
        const names = files.map(f => `• ${f.name}`);
        fileList.innerHTML = names.join('<br>');

        // Extrair GPS da Primeira Foto
        if (files[0]) {
            EXIF.getData(files[0], function() {
                var lat = EXIF.getTag(this, "GPSLatitude");
                var lon = EXIF.getTag(this, "GPSLongitude");
                var latRef = EXIF.getTag(this, "GPSLatitudeRef");
                var lonRef = EXIF.getTag(this, "GPSLongitudeRef");

                if (lat && lon && latRef && lonRef) {
                    // Converter graus/minutos/segundos em decimal
                    var latDec = lat[0].numerator/lat[0].denominator + (lat[1].numerator/lat[1].denominator)/60 + (lat[2].numerator/lat[2].denominator)/3600;
                    var lonDec = lon[0].numerator/lon[0].denominator + (lat[1].numerator/lon[1].denominator)/60 + (lon[2].numerator/lon[2].denominator)/3600;
                    
                    if (latRef == "S") latDec = latDec * -1;
                    if (lonRef == "W") lonDec = lonDec * -1;
                    
                    document.getElementById('latInput').value = latDec;
                    document.getElementById('lngInput').value = lonDec;

                    reverseGeocode(latDec, lonDec);
                }
            });
        }
    });

    async function reverseGeocode(lat, lon) {
        try {
            fileList.innerHTML += `<br><span style="color:var(--primary);">A detetar localização por satélite...</span>`;
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`);
            const data = await response.json();
            
            if (data && data.address) {
                // Populate Inputs
                const ad = data.address;
                
                // Mapeamento simples
                const prov = document.querySelector('select[name="province"]');
                if (ad.state || ad.province) {
                    const found = Array.from(prov.options).find(o => o.value.includes((ad.state || ad.province).replace('Province','').trim()));
                    if(found) found.selected = true;
                }

                if (ad.city || ad.town || ad.county) {
                    document.getElementById('municipalityInput').value = ad.city || ad.town || ad.county;
                }
                
                if (ad.suburb || ad.neighbourhood || ad.village) {
                    document.getElementById('neighborhoodInput').value = ad.suburb || ad.neighbourhood || ad.village;
                }

                fileList.innerHTML += `<br><span style="color:#10b981; font-weight: 800;">✓ Localização detetada automaticamente!</span>`;
            }
        } catch (e) {
            console.error('Erro na geocodificação:', e);
        }
    }
</script>
<?= $this->endSection() ?>
