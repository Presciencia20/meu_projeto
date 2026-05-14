<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Checkout Seguro | CasaSegura<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div style="max-width: 600px; margin: 40px auto 100px; padding: 0 20px;">
    <div style="background: white; border-radius: 32px; padding: 40px; border: 1px solid var(--gray-100); box-shadow: 0 20px 60px rgba(0,0,0,0.06);">
        <h2 style="font-family: 'Outfit'; font-weight: 900; font-size: 1.75rem; color: var(--gray-800); margin-bottom: 8px;">Método de Pagamento</h2>
        <p style="color: var(--gray-500); font-weight: 500; margin-bottom: 32px;"><?= $title ?></p>

        <div style="background: #f8fafc; padding: 24px; border-radius: 24px; margin-bottom: 32px; display: flex; justify-content: space-between; align-items: center;">
            <span style="font-weight: 700; color: var(--gray-600);">Total a pagar</span>
            <span style="font-family: 'Outfit'; font-weight: 900; font-size: 1.5rem; color: var(--app-primary);"><?= number_format($amount, 0, ',', '.') ?> KZ</span>
        </div>

        <form action="/payment/process" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="type" value="<?= $type ?>">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="hidden" name="amount" value="<?= $amount ?>">
            
            <div style="display: grid; gap: 16px; margin-bottom: 32px;">
                <label style="cursor: pointer;">
                    <input type="radio" name="method" value="express" checked style="display: none;" id="method_express">
                    <div class="method-card" onclick="selectMethod('express')" id="card_express" style="border: 2px solid var(--app-primary); background: #eff6ff;">
                        <div style="width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: var(--app-primary);">
                            <i class="ph-bold ph-credit-card"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 800; color: var(--gray-800);">Multicaixa Express</div>
                            <div style="font-size: 0.75rem; color: var(--gray-500); font-weight: 600;">Pagamento imediato via referência</div>
                        </div>
                        <i class="ph-fill ph-check-circle" style="font-size: 1.5rem; color: var(--app-primary);"></i>
                    </div>
                </label>

                <label style="cursor: pointer;">
                    <input type="radio" name="method" value="paypay" style="display: none;" id="method_paypay">
                    <div class="method-card" onclick="selectMethod('paypay')" id="card_paypay" style="border: 2px solid var(--gray-100);">
                        <div style="width: 48px; height: 48px; background: white; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; color: #6366f1;">
                            <i class="ph-bold ph-device-mobile"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: 800; color: var(--gray-800);">PayPay</div>
                            <div style="font-size: 0.75rem; color: var(--gray-500); font-weight: 600;">Transferência direta PayPay</div>
                        </div>
                        <i class="ph-bold ph-circle" style="font-size: 1.5rem; color: var(--gray-200);"></i>
                    </div>
                </label>
            </div>

            <button type="submit" class="btn-app-primary" style="width: 100%; height: 56px; border-radius: 18px; font-weight: 900; box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);">
                Confirmar e Seguir <i class="ph-bold ph-arrow-right"></i>
            </button>
        </form>
    </div>
</div>

<style>
    .method-card {
        padding: 20px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: all 0.2s;
    }
    .method-card:hover { transform: scale(1.02); }
</style>

<script>
    function selectMethod(m) {
        document.getElementById('method_' + m).checked = true;
        
        // Visual update
        const express = document.getElementById('card_express');
        const paypay = document.getElementById('card_paypay');
        
        if (m === 'express') {
            express.style.border = '2px solid var(--app-primary)';
            express.style.background = '#eff6ff';
            express.querySelector('.ph-check-circle, .ph-circle').className = 'ph-fill ph-check-circle';
            
            paypay.style.border = '2px solid var(--gray-100)';
            paypay.style.background = 'transparent';
            paypay.querySelector('.ph-check-circle, .ph-circle').className = 'ph-bold ph-circle';
        } else {
            paypay.style.border = '2px solid var(--app-primary)';
            paypay.style.background = '#eff6ff';
            paypay.querySelector('.ph-check-circle, .ph-circle').className = 'ph-fill ph-check-circle';
            
            express.style.border = '2px solid var(--gray-100)';
            express.style.background = 'transparent';
            express.querySelector('.ph-check-circle, .ph-circle').className = 'ph-bold ph-circle';
        }
    }
</script>
<?= $this->endSection() ?>
