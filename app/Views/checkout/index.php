<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Pagamento Seguro<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .checkout-container {
        max-width: 1100px;
        margin: 60px auto;
        display: grid;
        grid-template-columns: 1fr;
        gap: 48px;
        padding: 0 20px;
    }

    @media (min-width: 992px) {
        .checkout-container { grid-template-columns: 1fr 380px; }
    }

    .checkout-main {
        background: white;
        padding: 56px;
        border-radius: 48px;
        border: 1px solid var(--slate-100);
        box-shadow: var(--shadow-xl);
    }

    .summary-card {
        background: white;
        padding: 40px;
        border-radius: 40px;
        border: 1px solid var(--slate-100);
        box-shadow: var(--shadow-xl);
        height: fit-content;
        position: sticky;
        top: 100px;
    }

    .step-indicator {
        display: flex;
        gap: 12px;
        margin-bottom: 48px;
    }

    .step {
        height: 8px;
        flex: 1;
        background: var(--slate-100);
        border-radius: 10px;
        transition: all 0.3s;
    }

    .step.active {
        background: var(--primary);
    }

    .payment-option {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 24px;
        border: 2px solid var(--slate-100);
        border-radius: 24px;
        margin-bottom: 20px;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        background: white;
    }

    .payment-option:hover {
        border-color: var(--primary-100);
        transform: translateY(-2px);
    }

    .payment-option.active {
        border-color: var(--primary);
        background: var(--primary-50);
        box-shadow: 0 10px 20px rgba(26, 86, 219, 0.1);
    }

    .payment-option .icon-box {
        width: 56px;
        height: 40px;
        background: var(--slate-900);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 900;
        font-size: 0.8rem;
    }

    .trust-badge-box {
        background: var(--slate-50);
        padding: 32px;
        border-radius: 32px;
        margin: 48px 0;
        border: 1px solid var(--slate-100);
        position: relative;
        overflow: hidden;
    }

    .trust-badge-box::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        background: var(--primary);
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="checkout-container animate-fade-in">
        <div class="checkout-main">
            <div class="step-indicator">
                <div class="step active"></div>
                <div class="step active"></div>
                <div class="step"></div>
            </div>

            <header style="margin-bottom: 40px;">
                <h1 style="font-size: 1.75rem; font-weight: 800; color: var(--slate-900);">Finalizar Reserva</h1>
                <p style="color: var(--slate-500);">O seu pagamento será retido com total segurança.</p>
            </header>

            <h3 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 24px;">Método de Pagamento</h3>
            
            <div class="payment-option active" id="btn-mcx" onclick="selectPayment('mcx')">
                <div style="width: 60px; height: 40px; background: linear-gradient(135deg, #1e3a8a, #3b82f6); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 0.8rem; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">MCX</div>
                <div style="flex: 1;">
                    <div style="font-weight: 800; color: var(--slate-900); font-size: 1.1rem; margin-bottom: 2px;">Multicaixa Express</div>
                    <div style="font-size: 0.9rem; color: var(--slate-500); font-weight: 500;">Pagamento instantâneo e verificado</div>
                </div>
                <i data-lucide="check-circle" class="check-icon" style="color: var(--primary); width: 28px; height: 28px;"></i>
            </div>

            <div class="payment-option" id="btn-iban" onclick="selectPayment('iban')">
                <div style="width: 60px; height: 40px; background: var(--slate-800); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; box-shadow: 0 4px 10px rgba(0,0,0,0.1);"><i data-lucide="landmark"></i></div>
                <div style="flex: 1;">
                    <div style="font-weight: 800; color: var(--slate-900); font-size: 1.1rem; margin-bottom: 2px;">Transferência Bancária</div>
                    <div style="font-size: 0.9rem; color: var(--slate-500); font-weight: 500;">Submissão de comprovativo manual</div>
                </div>
                <i data-lucide="check-circle" class="check-icon" style="color: var(--slate-300); width: 28px; height: 28px; opacity: 0;"></i>
            </div>

            <div class="trust-badge-box animate-fade-in">
               <div style="display: flex; gap: 20px; align-items: flex-start;">
                    <div style="width: 48px; height: 48px; background: var(--primary-100); color: var(--primary); border-radius: 16px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i data-lucide="shield-check" style="width: 28px; height: 28px;"></i>
                    </div>
                    <div style="flex: 1;">
                        <h4 style="font-weight: 800; color: var(--slate-900); margin-bottom: 8px; font-size: 1.05rem;">Garantia Anti-Burla CasaSegura</h4>
                        <p style="font-size: 0.95rem; color: var(--slate-600); line-height: 1.6; font-weight: 500;">
                            O seu dinheiro fica retido em segurança até que confirme a recepção das chaves. Caso o imóvel não corresponda ao anúncio, devolvemos o valor imediatamente.
                        </p>
                    </div>
               </div>
            </div>

            <form action="/checkout/process/<?= $property['id'] ?>" method="POST">
                <input type="hidden" name="payment_method" id="payment_method" value="mcx">
                <button type="submit" class="btn-primary" style="width: 100%; padding: 20px; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 12px;">
                    <i data-lucide="lock" style="width: 20px;"></i> Continuar Para Pagar Seguro
                </button>
            </form>
        </div>

        <aside class="summary-card animate-fade-in">
            <div style="color: var(--slate-400); font-weight: 800; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 24px;">Resumo do Pagamento</div>
            <div style="display: flex; gap: 16px; margin-bottom: 32px; padding-bottom: 24px; border-bottom: 1px solid var(--slate-100);">
                <img src="<?= $property['main_image'] ?? 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&q=80&w=2070' ?>" style="width: 80px; height: 80px; border-radius: 20px; object-fit: cover; box-shadow: var(--shadow-md);">
                <div>
                    <div style="font-weight: 800; font-size: 1rem; color: var(--slate-900); line-height: 1.3; margin-bottom: 4px;"><?= $property['title'] ?></div>
                    <div style="font-size: 0.85rem; color: var(--slate-500); font-weight: 600;"><?= $property['neighborhood'] ?></div>
                </div>
            </div>

            <div style="display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 1rem; font-weight: 600; color: var(--slate-600);">
                <span>Primeira Renda</span>
                <span style="color: var(--slate-900);"><?= number_format($property['price'], 0, ',', '.') ?> KZ</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 32px; font-size: 1rem; font-weight: 600; color: var(--slate-600);">
                <span>Caução (1 mês)</span>
                <span style="color: var(--slate-900);"><?= number_format($property['price'], 0, ',', '.') ?> KZ</span>
            </div>

            <div style="background: var(--slate-50); padding: 32px; border-radius: 28px; border: 1px solid var(--slate-100);">
                <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <div>
                        <span style="font-weight: 800; font-size: 0.8rem; color: var(--slate-400); text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 4px;">Total a Pagar</span>
                        <div style="font-size: 2rem; font-weight: 950; color: var(--primary); line-height: 1;"><?= number_format($property['price'] * 2, 0, ',', '.') ?></div>
                    </div>
                    <span style="font-size: 1rem; color: var(--slate-400); font-weight: 900; margin-bottom: 4px;">KZ</span>
                </div>
            </div>
        </aside>
    </div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function selectPayment(method) {
    document.getElementById('payment_method').value = method;
    
    // Reset buttons
    document.getElementById('btn-mcx').classList.remove('active');
    document.getElementById('btn-iban').classList.remove('active');
    document.querySelectorAll('.check-icon').forEach(i => { i.style.opacity = '0'; i.style.color = 'var(--slate-300)'; });
    
    // Set active
    const btn = document.getElementById('btn-' + method);
    btn.classList.add('active');
    const icon = btn.querySelector('.check-icon');
    icon.style.opacity = '1';
    icon.style.color = 'var(--primary)';
}
</script>
<?= $this->endSection() ?>
