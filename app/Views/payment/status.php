<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Estado do Pagamento | CasaSegura<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div style="max-width: 600px; margin: 40px auto 100px; padding: 0 20px;">
    <div style="background: white; border-radius: 32px; padding: 48px; border: 1px solid var(--gray-100); text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.06);">
        
        <?php if ($payment['status'] === 'pending'): ?>
            <div style="width: 100px; height: 100px; background: #eff6ff; color: var(--app-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto 32px;">
                <i class="ph-bold ph-magnifying-glass"></i>
            </div>
            <h2 style="font-family: 'Outfit'; font-weight: 900; font-size: 2rem; color: var(--gray-800); margin-bottom: 12px;">Em Validação</h2>
            <p style="color: var(--gray-500); font-weight: 500; font-size: 1.1rem; line-height: 1.6; margin-bottom: 40px;">
                O seu comprovativo foi recebido com sucesso. A nossa equipa financeira está a validar o pagamento. Este processo demora normalmente menos de 2 horas.
            </p>
        <?php elseif ($payment['status'] === 'approved'): ?>
            <div style="width: 100px; height: 100px; background: #ecfdf5; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto 32px;">
                <i class="ph-bold ph-check-circle"></i>
            </div>
            <h2 style="font-family: 'Outfit'; font-weight: 900; font-size: 2rem; color: var(--gray-800); margin-bottom: 12px;">Pagamento Confirmado!</h2>
            <p style="color: var(--gray-500); font-weight: 500; font-size: 1.1rem; line-height: 1.6; margin-bottom: 40px;">
                O seu pagamento foi aprovado. O seu plano ou reserva já está ativo no sistema.
            </p>
        <?php else: ?>
            <div style="width: 100px; height: 100px; background: #fff1f2; color: #e11d48; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 3rem; margin: 0 auto 32px;">
                <i class="ph-bold ph-warning-circle"></i>
            </div>
            <h2 style="font-family: 'Outfit'; font-weight: 900; font-size: 2rem; color: var(--gray-800); margin-bottom: 12px;">Pagamento Rejeitado</h2>
            <p style="color: var(--gray-500); font-weight: 500; font-size: 1.1rem; line-height: 1.6; margin-bottom: 24px;">
                Infelizmente não conseguimos validar o seu pagamento. Por favor, verifique se o comprovativo está correto ou contacte o suporte.
            </p>
            <?php if (!empty($payment['admin_note'])): ?>
                <div style="background: #fef2f2; border: 1px solid #fee2e2; padding: 16px; border-radius: 16px; color: #991b1b; font-size: 0.9rem; font-weight: 600; margin-bottom: 32px;">
                    Motivo: <?= $payment['admin_note'] ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div style="display: grid; gap: 16px;">
            <a href="/dashboard" class="btn-app-primary" style="width: 100%; height: 56px; border-radius: 18px; display: flex; align-items: center; justify-content: center; text-decoration: none; font-weight: 800;">
                Ir para o Painel <i class="ph-bold ph-house" style="margin-left: 8px;"></i>
            </a>
            <a href="https://wa.me/244900000000" class="btn btn-secondary" style="height: 56px; border-radius: 18px; font-weight: 800;">
                Falar com Suporte <i class="ph-bold ph-whatsapp-logo"></i>
            </a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
