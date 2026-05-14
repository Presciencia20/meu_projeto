<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Criar Conta | CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .auth-title { font-size: 2.2rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 8px; color: var(--app-secondary); }
    .auth-subtitle { font-size: 1rem; color: #64748b; font-weight: 500; margin-bottom: 32px; }
    
    .form-group { margin-bottom: 24px; text-align: left; }
    .form-group label { display: block; font-weight: 800; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; color: #64748b; margin-bottom: 10px; margin-left: 4px; }
    
    /* Step Display Logic */
    .register-step { display: none; }
    .register-step.active { display: block; animation: slideUp 0.4s ease-out; }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .step-header { display: flex; align-items: center; gap: 8px; margin-bottom: 16px; justify-content: center; }
    .step-dot { width: 8px; height: 8px; border-radius: 50%; background: #e2e8f0; }
    .step-dot.active { background: var(--app-primary); width: 24px; border-radius: 4px; }

    /* Role Cards */
    .role-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 32px; }
    .role-card { 
        background: #f8fafc; 
        border: 2px solid transparent; 
        border-radius: 24px; 
        padding: 24px 16px; 
        text-align: center; 
        cursor: pointer; 
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        position: relative;
    }
    .role-card:hover { background: #f1f5f9; transform: translateY(-4px); }
    .role-card.selected { border-color: var(--app-primary); background: #eff6ff; }
    
    .role-card input { position: absolute; opacity: 0; }
    .role-icon { font-size: 2.5rem; color: var(--app-primary); opacity: 0.4; transition: 0.3s; }
    .role-card.selected .role-icon { opacity: 1; transform: scale(1.1); }
    .role-name { font-weight: 800; font-size: 0.9rem; color: #334155; }
    .role-card.selected .role-name { color: var(--app-primary); }

    .kyc-notice { 
        background: #fffbeb; 
        border: 1px solid #fef3c7; 
        color: #92400e; 
        padding: 16px; 
        border-radius: 18px; 
        font-size: 0.85rem; 
        margin-bottom: 24px;
        display: none;
        align-items: flex-start;
        gap: 10px;
        text-align: left;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div style="text-align: center; margin-bottom: 24px;">
        <img src="/img/logo.png" alt="CasaSegura" style="height: 48px; margin-bottom: 16px;">
        <div class="step-header">
            <div class="step-dot active" id="dot-1"></div>
            <div class="step-dot" id="dot-2"></div>
        </div>
    </div>

    <form action="<?= site_url('auth/step2') ?>" method="POST" id="registerForm">
        <?= csrf_field() ?>

        <!-- STEP 1: Personal Info -->
        <div class="register-step active" id="step-1">
            <h1 class="auth-title">Crie a sua conta</h1>
            <p class="auth-subtitle">Comece hoje a sua jornada segura.</p>

            <div class="form-group">
                <label>Nome Completo</label>
                <input type="text" name="full_name" class="input-modern" placeholder="Ex: João Silva" required>
            </div>

            <div class="form-group">
                <label>E-mail</label>
                <input type="email" name="email" class="input-modern" placeholder="Ex: joao@email.com" required>
            </div>

            <div class="form-group">
                <label>Telemóvel</label>
                <input type="tel" name="phone" class="input-modern" placeholder="Ex: 923 000 000" required>
            </div>

            <div class="form-group">
                <label>Palavra-passe</label>
                <input type="password" name="password" class="input-modern" placeholder="Mínimo 8 caracteres" required>
            </div>

            <button type="button" onclick="nextStep()" class="btn-app-primary">
                Continuar <i class="ph-bold ph-arrow-right" style="font-size: 18px;"></i>
            </button>
        </div>

        <!-- STEP 2: Role Selection -->
        <div class="register-step" id="step-2">
            <h1 class="auth-title">Quem é você?</h1>
            <p class="auth-subtitle">Escolha o tipo de conta mais adequado para si.</p>

            <div class="role-grid">
                <label class="role-card selected" id="card-inquilino">
                    <input type="radio" name="user_type" value="Inquilino" checked>
                    <div class="role-icon"><i class="ph-duotone ph-house"></i></div>
                    <span class="role-name">Cliente / Inquilino</span>
                </label>

                <label class="role-card" id="card-proprietario">
                    <input type="radio" name="user_type" value="Proprietário">
                    <div class="role-icon"><i class="ph-duotone ph-briefcase"></i></div>
                    <span class="role-name">Proprietário / Agente</span>
                </label>
            </div>

            <div id="kycNotice" class="kyc-notice">
                <i class="ph-bold ph-info" style="font-size: 20px;"></i>
                <span>Como proprietário, precisará de realizar uma verificação de identidade (KYC) para publicar imóveis.</span>
            </div>

            <button type="submit" class="btn-app-primary">
                Finalizar Registo <i class="ph-bold ph-check-circle" style="font-size: 20px;"></i>
            </button>
            
            <button type="button" onclick="prevStep()" style="margin-top: 16px; background: none; border: none; color: #94a3b8; font-weight: 700; cursor: pointer;">Voltar ao passo anterior</button>
        </div>
    </form>

    <div style="text-align: center; margin-top: 32px;">
        Já tem uma conta? <a href="/login" style="color: var(--app-primary); font-weight: 800; text-decoration: none;">Faça Login</a>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    function nextStep() {
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const dot2 = document.getElementById('dot-2');
        
        // Simple client-side validation for Step 1
        const inputs = step1.querySelectorAll('input[required]');
        let valid = true;
        inputs.forEach(input => {
            if (!input.value) {
                valid = false;
                input.style.borderColor = '#ef4444';
            } else {
                input.style.borderColor = '';
            }
        });

        if (valid) {
            step1.classList.remove('active');
            step2.classList.add('active');
            dot2.classList.add('active');
        }
    }

    function prevStep() {
        document.getElementById('step-1').classList.add('active');
        document.getElementById('step-2').classList.remove('active');
        document.getElementById('dot-2').classList.remove('active');
    }

    // Role selection logic
    const cards = {
        'Inquilino': document.getElementById('card-inquilino'),
        'Proprietário': document.getElementById('card-proprietario')
    };
    const kycNotice = document.getElementById('kycNotice');

    document.querySelectorAll('input[name="user_type"]').forEach(radio => {
        radio.addEventListener('change', () => {
            Object.values(cards).forEach(c => c.classList.remove('selected'));
            cards[radio.value].classList.add('selected');
            kycNotice.style.display = (radio.value === 'Proprietário') ? 'flex' : 'none';
        });
    });
</script>
<?= $this->endSection() ?>
