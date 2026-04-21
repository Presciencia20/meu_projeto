<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .settings-container {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 48px;
        margin-top: 40px;
    }

    .settings-nav {
        background: white;
        border-radius: 32px;
        padding: 32px 24px;
        box-shadow: var(--shadow-xl);
        height: fit-content;
        border: 1px solid var(--slate-100);
        position: sticky;
        top: 100px;
    }

    .settings-nav-item {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 16px 20px;
        border-radius: 20px;
        text-decoration: none;
        color: var(--slate-500);
        font-weight: 700;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        margin-bottom: 8px;
    }

    .settings-nav-item i { width: 22px; height: 22px; }

    .settings-nav-item:hover {
        background: var(--slate-50);
        color: var(--slate-900);
        transform: translateX(4px);
    }

    .settings-nav-item.active {
        background: var(--primary);
        color: white;
        box-shadow: 0 10px 20px rgba(26, 86, 219, 0.2);
    }

    .settings-card {
        background: white;
        border-radius: 40px;
        padding: 48px;
        box-shadow: var(--shadow-xl);
        border: 1px solid var(--slate-100);
    }

    .settings-card h2 {
        font-size: 1.75rem;
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 32px;
        letter-spacing: -1px;
    }

    .photo-upload {
        display: flex;
        align-items: center;
        gap: 32px;
        margin-bottom: 48px;
        padding: 24px;
        background: var(--slate-50);
        border-radius: 32px;
    }

    .photo-preview {
        width: 120px;
        height: 120px;
        border-radius: 40px;
        object-fit: cover;
        background: var(--slate-200);
        border: 4px solid white;
        box-shadow: var(--shadow-md);
    }

    .privacy-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 16px;
        margin-top: 24px;
    }

    .privacy-option {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 24px;
        border-radius: 24px;
        border: 2px solid var(--slate-100);
        cursor: pointer;
        transition: all 0.3s;
    }

    .privacy-option:hover {
        border-color: var(--primary-100);
        background: var(--primary-50);
    }

    .privacy-option input[type="radio"] {
        width: 24px;
        height: 24px;
        accent-color: var(--primary);
    }

    .privacy-option .option-text {
        flex: 1;
    }

    .privacy-option .option-title {
        font-weight: 800;
        font-size: 1.05rem;
        color: var(--slate-900);
        margin-bottom: 4px;
    }

    .privacy-option .option-desc {
        font-size: 0.9rem;
        color: var(--slate-500);
        font-weight: 500;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--slate-900);
        margin-bottom: 24px;
        margin-top: 48px;
    }

    .form-section-title i { color: var(--primary); width: 22px; }

    @media (max-width: 992px) {
        .settings-container { grid-template-columns: 1fr; gap: 32px; }
        .settings-nav { position: static; flex-direction: row; overflow-x: auto; padding: 16px; gap: 12px; }
        .settings-nav-item { margin-bottom: 0; white-space: nowrap; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="animate-fade-in">
    <h1 class="section-title" style="font-size: 1.75rem;"><i data-lucide="settings"></i> Definições de Conta</h1>

    <div class="settings-container">
        <!-- Sidebar Navigation -->
        <div class="settings-nav">
            <a href="#perfil" class="settings-nav-item active"><i data-lucide="user"></i> Perfil Público</a>
            <a href="#seguranca" class="settings-nav-item"><i data-lucide="lock"></i> Segurança</a>
            <a href="#financeiro" class="settings-nav-item"><i data-lucide="landmark"></i> Dados Bancários</a>
            <a href="#notificacoes" class="settings-nav-item"><i data-lucide="bell"></i> Notificações</a>
            <a href="#privacidade" class="settings-nav-item"><i data-lucide="shield"></i> Privacidade</a>
        </div>

        <!-- Content Area -->
        <div class="settings-card">
            <h2>Informação do Perfil</h2>
            
            <form action="/user/settings" method="POST" enctype="multipart/form-data" class="animate-fade-in">
                <?= csrf_field() ?>

                <!-- Photo Section -->
                <div class="photo-upload">
                    <img src="<?= $profile['photo'] ? base_url($profile['photo']) : 'https://ui-avatars.com/api/?name='.urlencode($user['full_name']) ?>" class="photo-preview" id="previewImg">
                    <div>
                        <h4 style="font-weight: 800; color: var(--slate-900); margin-bottom: 8px; font-size: 1.1rem;">Foto de Perfil</h4>
                        <p style="font-size: 0.9rem; color: var(--slate-500); margin-bottom: 16px; font-weight: 500;">Esta imagem será visível em todos os seus anúncios.</p>
                        <input type="file" name="photo" id="photoInput" style="display: none;" onchange="previewFile()">
                        <button type="button" class="btn-secondary" onclick="document.getElementById('photoInput').click()">
                            <i data-lucide="camera" style="width:16px; margin-right:8px"></i> Alterar Imagem
                        </button>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
                    <div class="form-group">
                        <label class="form-label">Nome Completo</label>
                        <input type="text" name="full_name" class="input-modern" value="<?= esc($user['full_name']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email de Contacto</label>
                        <input type="email" name="email" class="input-modern" value="<?= esc($user['email']) ?>" required>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 40px;">
                    <label class="form-label">Sobre Mim / Biografia</label>
                    <textarea name="bio" class="input-modern" rows="5" placeholder="Descreva a sua experiência ou o que procura..."><?= esc($profile['bio']) ?></textarea>
                </div>

                <div id="financeiro" class="form-section-title">
                    <i data-lucide="landmark"></i>
                    Informação Bancária (Para Recebimentos)
                </div>
                <p style="font-size: 1rem; color: var(--slate-500); margin-bottom: 24px; font-weight: 500;">
                    Para receber os fundos retidos no serviço de Escrow após arrendar o seu imóvel, forneça a conta de destino. <br>
                    <strong style="color: var(--secondary);">Nota:</strong> O IBAN deve pertencer ao titular deste perfil e bilhete de identidade.
                </p>

                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 24px; margin-bottom: 40px; background: var(--slate-50); padding: 24px; border-radius: 24px; border: 1px solid var(--slate-100);">
                    <div class="form-group">
                        <label class="form-label">Nome do Banco</label>
                        <select name="bank_name" class="input-modern">
                            <option value="">Selecione...</option>
                            <option value="BAI" <?= ($profile['bank_name'] ?? '') === 'BAI' ? 'selected' : '' ?>>Banco Angolano de Investimentos (BAI)</option>
                            <option value="BFA" <?= ($profile['bank_name'] ?? '') === 'BFA' ? 'selected' : '' ?>>Banco de Fomento Angola (BFA)</option>
                            <option value="BIC" <?= ($profile['bank_name'] ?? '') === 'BIC' ? 'selected' : '' ?>>Banco BIC</option>
                            <option value="ATLANTICO" <?= ($profile['bank_name'] ?? '') === 'ATLANTICO' ? 'selected' : '' ?>>Banco Millennium Atlântico</option>
                            <option value="BPA" <?= ($profile['bank_name'] ?? '') === 'BPA' ? 'selected' : '' ?>>Banco Poupança e Crédito (BPC)</option>
                            <option value="SOL" <?= ($profile['bank_name'] ?? '') === 'SOL' ? 'selected' : '' ?>>Banco Sol</option>
                            <option value="OUTRO" <?= ($profile['bank_name'] ?? '') === 'OUTRO' ? 'selected' : '' ?>>Outro (Mencionar abaixo)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">IBAN</label>
                        <input type="text" name="iban" class="input-modern" placeholder="AO06 0000 0000..." value="<?= esc($profile['iban'] ?? '') ?>">
                        <small style="display:block; margin-top: 8px; color: var(--slate-400);">Insira o IBAN completo com as letras iniciais AO06.</small>
                    </div>
                </div>

                <div class="form-section-title">
                    <i data-lucide="shield-check"></i>
                    Definições de Privacidade
                </div>
                <p style="font-size: 1rem; color: var(--slate-500); margin-bottom: 24px; font-weight: 500;">Escolha quando o seu contacto direto deve ser exibido aos interessados.</p>

                <div class="privacy-grid">
                    <label class="privacy-option">
                        <input type="radio" name="privacy_phone_visibility" value="never" <?= $profile['privacy_phone_visibility'] === 'never' ? 'checked' : '' ?>>
                        <div class="option-text">
                            <div class="option-title">Privacidade Máxima</div>
                            <div class="option-desc">O contacto nunca é revelado. Toda a comunicação é via chat seguro.</div>
                        </div>
                    </label>

                    <label class="privacy-option">
                        <input type="radio" name="privacy_phone_visibility" value="after_visit" <?= $profile['privacy_phone_visibility'] === 'after_visit' ? 'checked' : '' ?>>
                        <div class="option-text">
                            <div class="option-title">Agendamento Pendente</div>
                            <div class="option-desc">Revelado apenas após aceitar um agendamento de visita.</div>
                        </div>
                    </label>

                    <label class="privacy-option">
                        <input type="radio" name="privacy_phone_visibility" value="after_contract" <?= $profile['privacy_phone_visibility'] === 'after_contract' ? 'checked' : '' ?>>
                        <div class="option-text">
                            <div class="option-title">Contrato Iniciado</div>
                            <div class="option-desc">Visível apenas quando o processo de arrendamento for formalizado.</div>
                        </div>
                    </label>
                </div>

                <div style="margin-top: 64px; display: flex; justify-content: flex-end; padding-top: 32px; border-top: 1px solid var(--slate-100);">
                    <button type="submit" class="btn-primary" style="padding: 18px 48px; border-radius: 20px; font-weight: 800; font-size: 1.1rem;">
                        Guardar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function previewFile() {
        const preview = document.getElementById('previewImg');
        const file = document.getElementById('photoInput').files[0];
        const reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
</script>
<?= $this->endSection() ?>
