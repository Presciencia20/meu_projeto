<?php $this->extend('templates/main'); ?>

<?php $this->section('title'); ?>Comprovativos Pendentes - CasaSegura<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<link rel="stylesheet" href="/css/admin.css">
<style>
    /* Layout centralizado no admin.css */

    .receipt-card {
        background: white;
        border-radius: 28px;
        padding: 2rem;
        display: grid;
        grid-template-columns: 180px 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
        border: 1px solid #f1f5f9;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .receipt-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    }

    .document-preview {
        background: #f8fafc;
        border-radius: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        border: 2px dashed #e2e8f0;
        transition: all 0.2s;
    }

    .receipt-card:hover .document-preview {
        border-color: var(--app-primary);
        background: var(--app-primary-50);
    }

    .btn-validate {
        padding: 0.85rem 1.5rem;
        border-radius: 14px;
        font-weight: 700;
        text-decoration: none;
        font-size: 0.9rem;
        text-align: center;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .btn-approve {
        background: #10b981;
        color: white;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.2);
    }

    .btn-approve:hover {
        background: #059669;
        box-shadow: 0 8px 16px rgba(16, 185, 129, 0.3);
    }

    .btn-reject {
        background: #fef2f2;
        color: #ef4444;
        border: 1px solid #fee2e2;
    }

    .btn-reject:hover {
        background: #fee2e2;
    }
</style>

<?php $this->endSection(); ?>

<?php $this->section('content'); ?>
<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>

    <main class="admin-main">
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-weight: 800; font-family: 'Outfit';">Validação de Comprovativos</h2>
            <p style="color: var(--gray-500);">Aprove pagamentos via IBAN para ativar contratos.</p>
        </div>

        <?php if (empty($requests)): ?>
            <div style="text-align: center; padding: 4rem 0; background: white; border-radius: 24px; border: 1px solid var(--gray-200);">
                <i class="ph-duotone ph-receipt" style="font-size: 4rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
                <h3 style="font-weight: 700; color: #1e293b;">Sem pendências</h3>
                <p style="color: var(--gray-500);">Todos os comprovativos foram processados.</p>
            </div>
        <?php else: ?>
            <div class="receipts-list">
                <?php foreach($requests as $req): 
                    $payment = json_decode($req['payment_intent_id'], true);
                ?>
                <div class="receipt-card">
                    <div class="document-preview">
                        <i class="ph-duotone ph-file-pdf" style="font-size: 3rem; color: var(--gray-400); margin-bottom: 1rem;"></i>
                        <a href="/<?= $payment['receipt_path'] ?>" target="_blank" style="color: var(--app-primary); font-weight: 700; font-size: 0.75rem; text-decoration: none;">
                            ABRIR FICHEIRO
                        </a>
                    </div>
                    
                    <div style="display: flex; flex-direction: column; justify-content: space-between;">
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                <div>
                                    <h3 style="font-weight: 800; color: #1e293b; margin-bottom: 0.25rem;"><?= esc($req['property_title']) ?></h3>
                                    <p style="color: var(--gray-500); font-weight: 600; font-size: 0.9rem;">Inquilino: <?= esc($req['tenant']) ?></p>
                                </div>
                                <div style="background: #f1f5f9; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 0.7rem; color: var(--gray-600);">
                                    REF: <?= $payment['sys_ref_id'] ?? 'N/A' ?>
                                </div>
                            </div>
                            
                            <div style="font-size: 1.5rem; font-weight: 950; color: var(--app-primary);">
                                <?= number_format($req['total_amount'], 0, ',', '.') ?> KZ
                            </div>
                        </div>

                        <div style="display: flex; gap: 1rem; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-100);">
                            <a href="/admin/validate-receipt/<?= $req['id'] ?>/approve" onclick="return confirm('Confirmar receção do valor?');" class="btn-validate btn-approve" style="flex: 1;">
                                <i class="ph-bold ph-check"></i> Aprovar Pagamento
                            </a>
                            <a href="/admin/validate-receipt/<?= $req['id'] ?>/reject" onclick="return confirm('Rejeitar este comprovativo?');" class="btn-validate btn-reject" style="flex: 1;">
                                <i class="ph-bold ph-x"></i> Rejeitar
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>
<?php $this->endSection(); ?>

