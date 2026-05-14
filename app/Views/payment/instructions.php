<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Instruções de Pagamento | CasaSegura<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div style="max-width: 600px; margin: 40px auto 100px; padding: 0 20px;">
    <div style="background: white; border-radius: 32px; padding: 40px; border: 1px solid var(--gray-100); text-align: center;">
        <div style="width: 80px; height: 80px; background: #ecfdf5; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; margin: 0 auto 24px;">
            <i class="ph-bold ph-hourglass-high"></i>
        </div>
        <h2 style="font-family: 'Outfit'; font-weight: 900; font-size: 1.75rem; color: var(--gray-800); margin-bottom: 8px;">Aguardando Pagamento</h2>
        <p style="color: var(--gray-500); font-weight: 500; margin-bottom: 32px;">Siga as instruções abaixo para completar a sua transação.</p>

        <?php if ($payment['method'] === 'express'): ?>
            <div style="background: #f8fafc; padding: 32px; border-radius: 24px; text-align: left; margin-bottom: 32px; border: 1px dashed var(--gray-200);">
                <div style="text-align: center; margin-bottom: 20px;">
                    <img src="https://upload.wikimedia.org/wikipedia/pt/4/4b/Logo_Multicaixa.png" style="height: 40px; opacity: 0.8;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-weight: 700; color: var(--gray-500);">Entidade</span>
                        <strong style="color: var(--gray-800);">000123</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-weight: 700; color: var(--gray-500);">Referência</span>
                        <strong style="color: var(--app-primary); font-size: 1.25rem; letter-spacing: 1px;"><?= $payment['reference'] ?></strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="font-weight: 700; color: var(--gray-500);">Montante</span>
                        <strong style="color: var(--gray-800);"><?= number_format($payment['amount'], 0, ',', '.') ?> KZ</strong>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div style="background: #f8fafc; padding: 32px; border-radius: 24px; text-align: left; margin-bottom: 32px; border: 1px dashed var(--gray-200);">
                <div style="text-align: center; margin-bottom: 20px;">
                    <span style="font-family: 'Outfit'; font-weight: 900; color: #6366f1; font-size: 1.5rem;">PayPay <small>Angola</small></span>
                </div>
                <p style="font-size: 0.85rem; color: var(--gray-500); text-align: center; margin-bottom: 20px;">Utilize os dados abaixo para o seu pagamento via PayPay.</p>
                <div style="background: white; padding: 24px; border-radius: 16px; text-align: center; border: 1px solid var(--gray-100);">
                    <div style="font-size: 0.75rem; font-weight: 800; color: var(--gray-400); text-transform: uppercase; margin-bottom: 8px;">Número PayPay para Pagamento</div>
                    <div style="font-weight: 900; font-size: 1.8rem; color: #6366f1; letter-spacing: 2px; display: flex; align-items: center; justify-content: center; gap: 15px;">
                        944013345
                        <button type="button" onclick="copyToClipboard('944013345')" style="background: none; border: none; color: #6366f1; cursor: pointer; font-size: 1.2rem;" title="Copiar">
                            <i class="ph-bold ph-copy"></i>
                        </button>
                    </div>

                    <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid #f1f5f9;">
                        <div style="font-size: 0.7rem; font-weight: 800; color: var(--gray-400); text-transform: uppercase;">Referência do Pagamento</div>
                        <div style="font-weight: 800; color: var(--gray-800); font-size: 1.1rem; display: flex; align-items: center; justify-content: center; gap: 10px;">
                            10116
                            <button type="button" onclick="copyToClipboard('10116')" style="background: none; border: none; color: var(--app-primary); cursor: pointer;" title="Copiar">
                                <i class="ph-bold ph-copy"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div style="text-align: center; margin-top: 20px; font-weight: 700; color: var(--gray-600); font-size: 0.85rem;">
                    Destinatário: CasaSegura Angola
                </div>
            </div>
        <?php endif; ?>

        <div style="background: #fffbeb; border: 1px solid #fef3c7; padding: 24px; border-radius: 24px; text-align: left; margin-bottom: 32px;">
            <div style="display: flex; gap: 16px; align-items: flex-start;">
                <i class="ph-fill ph-info" style="font-size: 1.5rem; color: #d97706;"></i>
                <div>
                    <h4 style="font-weight: 800; color: #92400e; margin-bottom: 4px; font-size: 0.9rem;">Próximo Passo: Comprovativo</h4>
                    <p style="font-size: 0.8rem; color: #92400e; margin: 0; line-height: 1.5;">Faça o pagamento e carregue o talão/comprovativo abaixo para que a nossa equipa possa validar a sua transação.</p>
                </div>
            </div>
        </div>

        <form action="/payment/upload/<?= $payment['id'] ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div style="margin-bottom: 20px;">
                <label for="proof" style="display: block; width: 100%; padding: 20px; border: 2px dashed var(--gray-200); border-radius: 20px; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.borderColor='var(--app-primary)'" onmouseout="this.style.borderColor='var(--gray-200)'">
                    <i class="ph-duotone ph-file-arrow-up" style="font-size: 2rem; color: var(--app-primary); margin-bottom: 8px;"></i>
                    <div style="font-weight: 800; color: var(--gray-800); font-size: 0.9rem;">Carregar Comprovativo</div>
                    <div style="font-size: 0.75rem; color: var(--gray-400); font-weight: 600;">PNG, JPG ou PDF (Máx 5MB)</div>
                    <input type="file" name="proof" id="proof" style="display: none;" required onchange="updateFileName(this)">
                </label>
                <div id="file-name" style="margin-top: 10px; font-size: 0.8rem; font-weight: 700; color: #10b981; display: none;"></div>
            </div>

            <button type="submit" class="btn-app-primary" style="width: 100%; height: 56px; border-radius: 18px; font-weight: 900;">
                Enviar Comprovativo <i class="ph-bold ph-paper-plane-right"></i>
            </button>
        </form>
    </div>
</div>

<script>
    function updateFileName(input) {
        const div = document.getElementById('file-name');
        if (input.files.length > 0) {
            div.innerText = '✓ Ficheiro selecionado: ' + input.files[0].name;
            div.style.display = 'block';
        }
    }
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            alert('Copiado para a área de transferência: ' + text);
        });
    }
</script>
<?= $this->endSection() ?>
