<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Novo Anúncio - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<style>
    .publish-shell {
        max-width: 650px;
        margin: 2rem auto 8rem;
        background: white;
        border-radius: 32px;
        padding: 3rem;
        box-shadow: 0 20px 60px rgba(0,0,0,0.06);
        border: 1px solid var(--gray-100);
        position: relative;
    }

    @media (max-width: 640px) {
        .publish-shell {
            padding: 2rem 1.5rem;
            margin: 0;
            border-radius: 0;
            box-shadow: none;
            border: none;
        }
    }

    /* Wizard Progress V2 */
    .p-wizard-nav {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 3rem;
        align-items: center;
    }

    .p-nav-line {
        height: 6px;
        flex: 1;
        background: var(--gray-100);
        border-radius: 10px;
        overflow: hidden;
    }

    .p-nav-fill {
        height: 100%;
        width: 25%;
        background: var(--app-primary);
        transition: width 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        border-radius: 10px;
    }

    .p-step-badge {
        font-size: 0.75rem;
        font-weight: 800;
        color: var(--app-primary);
        background: var(--app-primary-50);
        padding: 6px 14px;
        border-radius: 50px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Step Logic */
    .p-step { display: none; }
    .p-step.active { display: block; animation: stepFadeIn 0.5s ease; }

    @keyframes stepFadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .p-step-title {
        font-family: 'Outfit';
        font-weight: 900;
        font-size: 1.75rem;
        color: var(--gray-800);
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }

    .p-step-subtitle {
        font-size: 1rem;
        color: var(--gray-500);
        margin-bottom: 2.5rem;
        font-weight: 500;
    }

    /* Inputs V2 */
    .p-input-group { margin-bottom: 1.5rem; }
    
    .p-label {
        display: block;
        font-weight: 800;
        font-size: 0.75rem;
        color: var(--gray-400);
        text-transform: uppercase;
        margin-bottom: 0.75rem;
        letter-spacing: 0.5px;
        padding-left: 0.5rem;
    }

    /* Action Buttons */
    .p-actions {
        display: flex;
        gap: 1rem;
        margin-top: 3rem;
        padding-top: 2rem;
        border-top: 1px solid var(--gray-100);
    }

    /* Image Dropzone */
    .p-dropzone {
        border: 2px dashed var(--gray-200);
        background: #fcfdfe;
        border-radius: 24px;
        padding: 3.5rem 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
    }

    .p-dropzone:hover {
        border-color: var(--app-primary);
        background: var(--app-primary-50);
    }

    .p-dropzone i {
        font-size: 2.5rem;
        color: var(--app-primary);
        margin-bottom: 1rem;
    }

    .p-preview-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.75rem;
        margin-top: 1.5rem;
    }

    .p-preview-item {
        aspect-ratio: 1;
        border-radius: 16px;
        object-fit: cover;
        background: var(--gray-100);
    }
</style>
<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="publish-shell animate-fade-in">
    <!-- Progress Indicator -->
    <div class="p-wizard-nav">
        <div class="p-step-badge">P<span id="p-currNum">1</span> / 4</div>
        <div class="p-nav-line">
            <div class="p-nav-fill" id="p-fill"></div>
        </div>
    </div>

    <form action="/property/store" method="POST" enctype="multipart/form-data" id="publishFormV2">
        <?= csrf_field() ?>
        <input type="hidden" name="latitude" id="latV2">
        <input type="hidden" name="longitude" id="lngV2">

        <!-- STEP 1: Context -->
        <div class="p-step active" id="p-step1">
            <h2 class="p-step-title">Vamos começar pelo básico</h2>
            <p class="p-step-subtitle">Conte-nos o essencial sobre o seu imóvel.</p>
            
            <div class="p-input-group">
                <label class="p-label">Como chama o seu imóvel?</label>
                <input type="text" name="title" class="input-modern" required placeholder="Ex: Apartamento T2 com vista mar">
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="p-input-group">
                    <label class="p-label">Tipo de Propriedade</label>
                    <select name="type" class="input-modern" required>
                        <option value="Vivenda">Vivenda</option>
                        <option value="Apartamento">Apartamento</option>
                        <option value="Anexo">Anexo</option>
                        <option value="Escritório">Escritório</option>
                    </select>
                </div>
                <div class="p-input-group">
                    <label class="p-label">Preço Final (KZ/mês)</label>
                    <input type="number" name="price" class="input-modern" required placeholder="Ex: 250000">
                </div>
            </div>

            <div class="p-input-group">
                <label class="p-label">Descreva os detalhes importantes</label>
                <textarea name="description" class="input-modern" rows="5" required placeholder="Estado do imóvel, proximidades, segurança..."></textarea>
            </div>
        </div>

        <!-- STEP 2: Media -->
        <div class="p-step" id="p-step2">
            <h2 class="p-step-title">Media Inteligente</h2>
            <p class="p-step-subtitle">Carregue fotos e vídeos. A nossa câmara inteligente valida a localização e hora automaticamente.</p>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <label class="p-dropzone" for="p-imgs" style="padding: 2rem 1rem;">
                    <i class="ph-duotone ph-image"></i>
                    <div style="font-weight: 800; font-size: 0.9rem; color: var(--gray-800);">Fotos e Vídeos</div>
                </label>
                <div class="p-dropzone" onclick="startSmartCamera()" style="background: var(--app-primary-50); border-color: var(--app-primary); padding: 2rem 1rem;">
                    <i class="ph-duotone ph-aperture"></i>
                    <div style="font-weight: 800; font-size: 0.9rem; color: var(--app-primary);">Câmara Smart</div>
                </div>
            </div>

            <input type="file" name="images[]" id="p-imgs" multiple accept="image/*,video/*" style="display: none;" required>
            
            <div id="smart-meta-badge" style="display: none; background: #1e293b; color: white; padding: 12px 20px; border-radius: 16px; margin-bottom: 1.5rem; font-size: 0.8rem; line-height: 1.4;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="ph-fill ph-broadcast" style="color: #60a5fa; animation: pulse 2s infinite;"></i>
                    <div>
                        <strong id="meta-location">Capturando localização...</strong><br>
                        <span id="meta-time" style="opacity: 0.7;">--:-- | --/--/----</span>
                    </div>
                </div>
            </div>

            <div id="p-grid" class="p-preview-grid"></div>
        </div>

        <!-- STEP 3: Geography -->
        <div class="p-step" id="p-step3">
            <h2 class="p-step-title">Onde as chaves estão?</h2>
            <p class="p-step-subtitle">A localização exata garante leads de maior qualidade.</p>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                <div class="p-input-group">
                    <label class="p-label">Província / Município</label>
                    <select name="municipality" class="input-modern" required>
                        <option value="Luanda">Luanda</option>
                        <option value="Talatona">Talatona</option>
                        <option value="Belas">Belas</option>
                        <option value="Viana">Viana</option>
                    </select>
                </div>
                <div class="p-input-group">
                    <label class="p-label">Bairro ou Condomínio</label>
                    <input type="text" name="neighborhood" class="input-modern" required placeholder="Ex: Kilamba">
                </div>
            </div>

            <div style="background: #f8fafc; padding: 2.5rem 1.5rem; border-radius: 28px; border: 1px solid var(--gray-100); text-align: center; margin-top: 1rem;">
                <i class="ph-duotone ph-map-pin" style="font-size: 2.5rem; color: var(--app-primary); margin-bottom: 1rem;"></i>
                <h4 style="font-family: 'Outfit'; font-weight: 800; color: var(--gray-800); margin-bottom: 0.5rem;">Geolocalização Ativa</h4>
                <p style="font-size: 0.85rem; color: var(--gray-500); margin-bottom: 1.5rem; font-weight: 500;">Use o GPS para que os clientes encontrem o imóvel no mapa.</p>
                <button type="button" class="btn btn-secondary" style="border-radius: 16px; font-weight: 800;" onclick="getGeoLocV2()">
                    Fixar Minha Posição <i class="ph-bold ph-crosshair"></i>
                </button>
            </div>
        </div>

        <!-- STEP 4: Technicals -->
        <div class="p-step" id="p-step4">
            <h2 class="p-step-title">Dados técnicos</h2>
            <p class="p-step-subtitle">Quase concluído. Só precisamos de mais alguns números.</p>

            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 2.5rem;">
                <div class="p-input-group" style="text-align: center;">
                    <label class="p-label">Dormitórios</label>
                    <input type="number" name="bedrooms" value="1" min="0" class="input-modern" style="text-align: center; font-weight: 900;">
                </div>
                <div class="p-input-group" style="text-align: center;">
                    <label class="p-label">Banheiros</label>
                    <input type="number" name="bathrooms" value="1" min="0" class="input-modern" style="text-align: center; font-weight: 900;">
                </div>
                <div class="p-input-group" style="text-align: center;">
                    <label class="p-label">Área (m²)</label>
                    <input type="number" name="area" value="120" class="input-modern" style="text-align: center; font-weight: 900;">
                </div>
            </div>

            <div style="background: #ecfdf5; border: 1px solid #10b98120; padding: 1.5rem; border-radius: 24px; color: #065f46; display: flex; gap: 1rem; align-items: center; margin-bottom: 2rem;">
                <i class="ph-fill ph-shield-check" style="font-size: 2rem; opacity: 0.6;"></i>
                <p style="font-size: 0.8rem; font-weight: 700; line-height: 1.5; margin: 0;">
                    AVISO DE SEGURANÇA: O seu anúncio será analisado pela nossa equipa de moderação antes de ser publicado.
                </p>
            </div>

            <div style="background: #f8fafc; padding: 2rem; border-radius: 24px; border: 1px solid var(--gray-200);">
                <h3 style="font-family: 'Outfit'; font-weight: 800; font-size: 1.2rem; color: var(--gray-800); margin-bottom: 1rem;">Documentação Legal</h3>
                <p style="font-size: 0.85rem; color: var(--gray-500); margin-bottom: 1.5rem;">Para garantir a segurança da plataforma, é obrigatório submeter um documento que comprove a legitimidade do imóvel.</p>
                
                <div class="p-input-group">
                    <label class="p-label">Tipo de Documento</label>
                    <select name="doc_type" class="input-modern" required>
                        <option value="titulo_propriedade">Título de Propriedade</option>
                        <option value="contrato_compra_venda">Contrato de Compra e Venda</option>
                        <option value="declaracao_posse">Declaração de Posse</option>
                        <option value="outro">Outro</option>
                    </select>
                </div>
                
                <div class="p-input-group">
                    <label class="p-label">Ficheiro (PDF, JPG, PNG)</label>
                    <input type="file" name="property_doc" class="input-modern" accept=".pdf,image/jpeg,image/png,image/webp" required style="padding: 10px;">
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <div class="p-actions">
            <button type="button" id="p-prev" class="btn btn-secondary" style="flex:1; display: none; height: 56px; border-radius: 18px;" onclick="navV2(-1)">Anterior</button>
            <button type="button" id="p-next" class="btn btn-primary" style="flex:2; height: 56px; border-radius: 18px; font-weight: 800;" onclick="navV2(1)">Próximo Passo <i class="ph-bold ph-arrow-right"></i></button>
            <button type="submit" id="p-submit" class="btn btn-primary" style="flex:2; display: none; height: 56px; border-radius: 18px; background: var(--app-primary); font-weight: 800;">Publicar Agora <i class="ph-bold ph-rocket-launch"></i></button>
        </div>
    </form>
</div>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
    let currentP = 1;
    const totalP = 4;

    function navV2(dir) {
        if (dir === 1 && !checkP()) return;
        
        document.getElementById(`p-step${currentP}`).classList.remove('active');
        currentP += dir;
        document.getElementById(`p-step${currentP}`).classList.add('active');
        refreshP();
    }

    function refreshP() {
        document.getElementById('p-currNum').innerText = currentP;
        document.getElementById('p-fill').style.width = `${(currentP / totalP) * 100}%`;
        
        document.getElementById('p-prev').style.display = currentP > 1 ? 'block' : 'none';
        document.getElementById('p-next').style.display = currentP < totalP ? 'block' : 'none';
        document.getElementById('p-submit').style.display = currentP === totalP ? 'block' : 'none';
    }

    function checkP() {
        const step = document.getElementById(`p-step${currentP}`);
        const inputs = step.querySelectorAll('input[required], select[required], textarea[required]');
        let ok = true;
        
        inputs.forEach(i => {
            if (!i.value) {
                i.style.borderColor = '#ef4444';
                ok = false;
            } else {
                i.style.borderColor = '';
            }
        });
        return ok;
    }

    function getGeoLocV2() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(pos => {
                document.getElementById('latV2').value = pos.coords.latitude;
                document.getElementById('lngV2').value = pos.coords.longitude;
                alert('📱 Sua localização foi capturada com sucesso!');
            });
        }
    }

    function startSmartCamera() {
        document.getElementById('smart-meta-badge').style.display = 'block';
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(pos => {
                const lat = pos.coords.latitude;
                const lng = pos.coords.longitude;
                // Exemplo simplificado de metadados (em produção usaria reverse geocoding)
                document.getElementById('meta-location').innerText = `Capturado em Memória Local: ${lat.toFixed(4)}, ${lng.toFixed(4)}`;
                const now = new Date();
                document.getElementById('meta-time').innerText = now.toLocaleString('pt-AO');
                
                // Abrir câmara nativa
                document.getElementById('p-imgs').setAttribute('capture', 'environment');
                document.getElementById('p-imgs').click();
                // Reset capture for gallery after use
                setTimeout(() => document.getElementById('p-imgs').removeAttribute('capture'), 1000);
            }, () => {
                alert('⚠️ Para usar a Câmara Smart, permita o acesso à localização.');
            });
        }
    }

    document.getElementById('p-imgs').addEventListener('change', function() {
        const grid = document.getElementById('p-grid');
        grid.innerHTML = '';
        Array.from(this.files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const r = new FileReader();
                r.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'p-preview-item animate-fade-in';
                    grid.appendChild(img);
                };
                r.readAsDataURL(file);
            } else if (file.type.startsWith('video/')) {
                const vid = document.createElement('div');
                vid.className = 'p-preview-item animate-fade-in';
                vid.style.display = 'flex';
                vid.style.alignItems = 'center';
                vid.style.justifyContent = 'center';
                vid.style.background = '#000';
                vid.innerHTML = '<i class="ph-fill ph-video-camera" style="color:white; font-size: 2rem;"></i>';
                grid.appendChild(vid);
            }
        });
    });

    refreshP();
</script>
<?php $this->endSection(); ?>
