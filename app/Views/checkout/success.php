<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Pagamento Efetuado<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    @media (max-width: 768px) {
        .success-container { margin: 60px 24px !important; }
        .success-container h1 { font-size: 2rem !important; }
        .success-box { padding: 32px 24px !important; margin-bottom: 32px !important; border-radius: 32px !important; }
        .success-box h3 { font-size: 1.2rem !important; }
        .action-buttons { flex-direction: column !important; gap: 16px !important; }
        .action-buttons a { width: 100%; justify-content: center; }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div style="max-width: 680px; margin: 100px auto; text-align: center;" class="animate-fade-in success-container">
        <div style="width: 120px; height: 120px; background: var(--secondary-50); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--secondary); margin: 0 auto 40px; box-shadow: 0 20px 40px rgba(16, 185, 129, 0.1);">
            <i data-lucide="shield-check" style="width: 64px; height: 64px;"></i>
        </div>
        
        <h1 style="font-size: 2.75rem; font-weight: 950; color: var(--slate-900); margin-bottom: 16px; letter-spacing: -1.5px;">Pagamento Seguro Retido</h1>
        <p style="color: var(--slate-500); font-size: 1.25rem; line-height: 1.6; margin-bottom: 56px; font-weight: 500;">
            O seu pagamento de reserva foi processado e encontra-se <span style="color: var(--primary); font-weight: 800;">retido no nosso cofre digital</span> até que confirme a recepção das chaves.
        </p>

        <div class="success-box" style="background: white; padding: 56px; border-radius: 48px; border: 1px solid var(--slate-100); text-align: left; margin-bottom: 56px; box-shadow: var(--shadow-xl);">
            <h3 style="font-size: 1.25rem; font-weight: 900; margin-bottom: 32px; display: flex; align-items: center; gap: 16px; color: var(--slate-900); letter-spacing: -0.5px;">
                <i data-lucide="map-pin" style="color: var(--primary)"></i> O que acontece agora?
            </h3>
            <ul style="list-style: none; display: flex; flex-direction: column; gap: 24px;">
                <li style="display: flex; gap: 20px; font-size: 1.05rem; color: var(--slate-600); font-weight: 500; align-items: flex-start;">
                    <span style="width: 32px; height: 32px; background: var(--primary); color: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.9rem; flex-shrink: 0; box-shadow: 0 5px 15px rgba(26, 86, 219, 0.2);">1</span>
                    O proprietário entrará em contacto consigo via chat seguro para agendar a entrega das chaves.
                </li>
                <li style="display: flex; gap: 20px; font-size: 1.05rem; color: var(--slate-600); font-weight: 500; align-items: flex-start;">
                    <span style="width: 32px; height: 32px; background: var(--primary-100); color: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.9rem; flex-shrink: 0;">2</span>
                    Ao chegar ao imóvel, verifique se tudo está conforme o anúncio antes de confirmar a entrada.
                </li>
                <li style="display: flex; gap: 20px; font-size: 1.05rem; color: var(--slate-600); font-weight: 500; align-items: flex-start;">
                    <span style="width: 32px; height: 32px; background: var(--primary-100); color: var(--primary); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.9rem; flex-shrink: 0;">3</span>
                    Aceda ao seu painel e clique em <strong style="color: var(--primary)">Confirmar Recepção das Chaves</strong> para libertar o pagamento.
                </li>
            </ul>
        </div>

        <div class="action-buttons" style="display: flex; gap: 24px; justify-content: center;">
            <a href="/dashboard" class="btn-primary" style="padding: 20px 48px; border-radius: 20px; font-weight: 900; font-size: 1.1rem;">Ver Painel de Controlo</a>
            <a href="/" class="btn-secondary" style="padding: 20px 48px; border-radius: 20px; font-weight: 800; font-size: 1.1rem; display: flex; align-items: center; gap: 12px; background: var(--slate-50); border: 1px solid var(--slate-100);">
                <i data-lucide="home" style="width: 22px;"></i> Voltar ao Início
            </a>
        </div>
    </div>

    <!-- Final spacer -->
    <div style="height: 100px;"></div>
<?= $this->endSection() ?>
