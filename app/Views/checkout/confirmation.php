<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Confirmar Pagamento<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .confirm-container {
        max-width: 600px;
        margin: 60px auto;
        padding: 0 20px;
    }

    .confirm-card {
        background: white;
        border-radius: 40px;
        padding: 48px;
        box-shadow: var(--shadow-xl);
        text-align: center;
        border: 1px solid var(--slate-100);
    }

    .phone-simulation {
        width: 240px;
        height: 480px;
        background: #111;
        border-radius: 40px;
        margin: 0 auto 32px;
        border: 8px solid #222;
        position: relative;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 40px 80px rgba(0,0,0,0.2);
    }

    .phone-screen {
        flex: 1;
        background: #f8fafc;
        margin: 4px;
        border-radius: 32px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .mcx-logo {
        width: 80px;
        height: 50px;
        background: #1e3a8a;
        border-radius: 8px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 900;
        font-size: 0.9rem;
    }

    .notification-ring {
        width: 100%;
        background: white;
        padding: 16px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-top: 20px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .countdown {
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--slate-900);
        margin: 24px 0;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="confirm-container">
        <?php if (($payment['method'] ?? 'mcx') === 'iban'): ?>
            <div class="confirm-card animate-fade-in" style="max-width: 600px; margin: 0 auto; text-align: left;">
                <header style="margin-bottom: 32px; text-align: center;">
                    <h1 style="font-weight: 800; color: var(--slate-900); margin-bottom: 8px;">Transferência Bancária</h1>
                    <p style="color: var(--slate-500);">Efetue a transferência usando os dados abaixo e anexe o comprovativo.</p>
                </header>

                <div style="background: var(--slate-50); padding: 32px; border-radius: 24px; border: 1px dashed var(--slate-200); margin-bottom: 32px;">
                    <div style="font-weight: 800; color: var(--slate-900); font-size: 1.1rem; margin-bottom: 16px;">Dados para Transferência</div>
                    <div style="display: flex; flex-direction: column; gap: 12px; font-size: 1.1rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--slate-500);">Banco:</span>
                            <span style="font-weight: 700; color: var(--slate-900);">Banco Angolano de Investimentos (BAI)</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--slate-500);">Favorecido:</span>
                            <span style="font-weight: 700; color: var(--slate-900);">Prestech - CasaSegura Escrow</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--slate-500);">IBAN:</span>
                            <span style="font-family: monospace; font-weight: 800; color: var(--primary);">AO06 0000 0000 0000 0000 0000 0</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; border-top: 1px solid var(--slate-200); padding-top: 12px; margin-top: 4px;">
                            <span style="color: var(--slate-500);">Montante Exato:</span>
                            <span style="font-weight: 900; color: var(--slate-900); font-size: 1.25rem;"><?= number_format($r['total_amount'], 0, ',', '.') ?> KZ</span>
                        </div>
                    </div>
                </div>

                <?php if (($payment['status'] ?? '') === 'verifying_receipt'): ?>
                    <div style="background: var(--primary-50); color: var(--primary); padding: 24px; border-radius: 20px; text-align: center; border: 1px solid rgba(26, 86, 219, 0.2);">
                        <i data-lucide="clock" style="width: 48px; height: 48px; margin-bottom: 16px;"></i>
                        <h3 style="font-weight: 800; margin-bottom: 8px;">Comprovativo Recebido!</h3>
                        <p style="font-weight: 500; opacity: 0.9;">A nossa equipa financeira está a analisar o documento. O seu arrendamento será libertado nas próximas 24h.</p>
                        <!-- We keep the JS polling running below so it will redirect when admin confirms -->
                        <div class="countdown" id="timer" style="font-size: 1.5rem; margin-top: 16px;">Em processamento...</div>
                    </div>
                <?php else: ?>
                    <form action="/checkout/uploadProof/<?= $r['id'] ?>" method="POST" enctype="multipart/form-data" style="background: white; padding: 32px; border-radius: 24px; border: 1px solid var(--secondary); box-shadow: 0 10px 25px rgba(5, 150, 105, 0.1);">
                        <div style="font-weight: 800; color: var(--secondary); margin-bottom: 16px; font-size: 1.05rem;">
                            1. Já efetuou a transferência?
                        </div>
                        <div style="margin-bottom: 24px;">
                            <label style="display: block; font-weight: 600; color: var(--slate-700); margin-bottom: 8px;">Anexar Comprovativo (PDF / Imagem)</label>
                            <input type="file" name="proof_receipt" required accept=".pdf,image/png,image/jpeg" style="width: 100%; padding: 12px; border: 2px dashed var(--slate-200); border-radius: 12px; color: var(--slate-600); cursor: pointer;">
                        </div>
                        <button type="submit" class="btn-primary" style="width: 100%; background: var(--secondary); padding: 16px; font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 8px;">
                            <i data-lucide="upload-cloud"></i> Enviar Comprovativo
                        </button>
                    </form>
                <?php endif; ?>
            </div>

        <?php else: ?>
            <div class="confirm-card animate-fade-in">
                <header style="margin-bottom: 40px;">
                    <h1 style="font-weight: 800; color: var(--slate-900); margin-bottom: 8px;">Aguardando Pagamento</h1>
                    <p style="color: var(--slate-500);">Abra a aplicação <strong>Multicaixa Express</strong> no seu telemóvel para confirmar a transação.</p>
                </header>

                <div class="phone-simulation">
                    <div class="phone-screen">
                        <div class="mcx-logo">MCX</div>
                        <div style="font-weight: 700; color: var(--slate-800); font-size: 0.9rem;">Pedido de Pagamento</div>
                        <div style="font-size: 1.1rem; font-weight: 800; color: var(--primary); margin: 12px 0; display: flex; flex-direction: column; gap: 4px;">
                            <div>Entidade: <span style="color: var(--slate-900); font-family: monospace; font-size: 1.25rem;"><?= $payment['entity'] ?? 'A aguardar...' ?></span></div>
                            <div>Referência: <span style="color: var(--slate-900); font-family: monospace; font-size: 1.25rem;"><?= $payment['reference'] ?? '...' ?></span></div>
                            <div style="margin-top: 8px;">Montante: <span style="color: var(--slate-900); font-size: 1.25rem;"><?= number_format($r['total_amount'], 0, ',', '.') ?> KZ</span></div>
                        </div>
                        
                        <div class="notification-ring">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i data-lucide="bell" style="width: 16px; color: var(--accent);"></i>
                                <div style="font-size: 0.75rem; font-weight: 800; text-align: left;">CasaSegura: Confirmar Reserva?</div>
                            </div>
                        </div>

                        <div style="margin-top: auto; width: 100%;">
                            <div style="display: flex; gap: 8px;">
                                <div style="flex: 1; height: 32px; background: #ef4444; border-radius: 8px;"></div>
                                <div style="flex: 1; height: 32px; background: #22c55e; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 0.6rem; font-weight: 800;">CONFIRMAR</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="countdown" id="timer">02:00</div>
                
                <form action="/checkout/complete/<?= $r['id'] ?>" method="POST" id="completeForm" style="display: none;">
                    <button type="submit" class="btn-primary" style="width: 100%; padding: 20px;">
                        Pagamento Confirmado
                    </button>
                </form>

                <p style="color: var(--slate-400); font-size: 0.85rem; margin-top: 24px;">
                    O sistema irá detectar automaticamente o pagamento em alguns segundos.
                </p>
            </div>
        <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Real-time payment verification (Long-polling)
    const timerElement = document.getElementById('timer');
    const requestId = <?= $r['id'] ?>;
    
    if (timerElement) {
        // Animação de relógio simples
        let seconds = 0;
        setInterval(() => {
            seconds++;
            timerElement.style.opacity = (seconds % 2 === 0) ? 0.5 : 1;
        }, 1000);

        // Call checkout/status API every 3 seconds
        const interval = setInterval(async () => {
            try {
                const res = await fetch(`/checkout/status/${requestId}`);
                const data = await res.json();
                
                if (data.status === 'paid') {
                    clearInterval(interval);
                    timerElement.style.color = 'var(--secondary)';
                    timerElement.style.opacity = 1;
                    timerElement.innerText = "Pago! ✅";
                    
                    setTimeout(() => {
                        window.location.href = '/checkout/success';
                    }, 1500);
                }
            } catch (err) {
                console.error("Erro a verificar pagamento:", err);
            }
        }, 3000);
    }
</script>
<?= $this->endSection() ?>
