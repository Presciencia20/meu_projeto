<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Comprovativos Pendentes<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="admin-layout" style="display: grid; grid-template-columns: 280px 1fr; gap: 40px; max-width: 1400px; margin: 40px auto; padding: 0 20px; align-items: start;">
    
    <!-- Sidebar Component -->
    <?= $this->include('templates/admin_sidebar') ?>

    <main class="admin-content animate-fade-in" style="background: white; border-radius: 40px; padding: 48px; box-shadow: var(--shadow-xl); border: 1px solid var(--slate-100);">
        <header style="margin-bottom: 40px; border-bottom: 1px solid var(--slate-100); padding-bottom: 24px;">
            <h1 style="font-size: 2rem; font-weight: 800; color: var(--slate-900); margin-bottom: 8px;">Aprovação de Transferências</h1>
            <p style="color: var(--slate-500); font-size: 1.1rem;">Reveja os comprovativos de pagamento via IBAN enviados pelos inquilinos.</p>
        </header>

        <?php if(session()->getFlashdata('success')): ?>
            <div style="background: var(--primary-50); color: var(--primary); padding: 16px 24px; border-radius: 16px; margin-bottom: 32px; font-weight: 700; display: flex; align-items: center; gap: 12px; border: 1px solid rgba(26, 86, 219, 0.2);">
                <i data-lucide="check-circle" style="width: 20px;"></i>
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>
        <?php if(session()->getFlashdata('error')): ?>
            <div style="background: #fef2f2; color: #ef4444; padding: 16px 24px; border-radius: 16px; margin-bottom: 32px; font-weight: 700; display: flex; align-items: center; gap: 12px; border: 1px solid rgba(239, 68, 68, 0.2);">
                <i data-lucide="alert-circle" style="width: 20px;"></i>
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <?php if(empty($requests)): ?>
            <div style="text-align: center; padding: 64px 20px; background: var(--slate-50); border-radius: 24px; border: 2px dashed var(--slate-200);">
                <i data-lucide="inbox" style="width: 64px; height: 64px; color: var(--slate-300); margin-bottom: 16px;"></i>
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--slate-700); margin-bottom: 8px;">Sem pendências</h3>
                <p style="color: var(--slate-500);">Todos os comprovativos foram analisados.</p>
            </div>
        <?php else: ?>
            <div style="display: grid; gap: 24px;">
                <?php foreach($requests as $req): 
                    $payment = json_decode($req['payment_intent_id'], true);
                ?>
                    <div style="background: white; border: 1px solid var(--slate-200); border-radius: 24px; padding: 24px; display: flex; gap: 32px; align-items: stretch;">
                        
                        <!-- Visualizador do Anexo -->
                        <div style="width: 200px; background: var(--slate-50); border-radius: 16px; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 16px; border: 1px solid var(--slate-100);">
                            <i data-lucide="file-text" style="width: 48px; height: 48px; color: var(--slate-400); margin-bottom: 12px;"></i>
                            <a href="/<?= $payment['receipt_path'] ?>" target="_blank" class="btn-primary" style="font-size: 0.85rem; padding: 8px 16px; border-radius: 8px; text-decoration: none;">
                                Ver Documento
                            </a>
                        </div>
                        
                        <!-- Dados da Reserva -->
                        <div style="flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                            <div>
                                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 16px;">
                                    <div>
                                        <h3 style="font-size: 1.25rem; font-weight: 800; color: var(--slate-900);"><?= esc($req['property_title']) ?></h3>
                                        <div style="font-size: 0.95rem; color: var(--slate-500); font-weight: 600;">Inquilino: <?= esc($req['tenant']) ?></div>
                                    </div>
                                    <div style="background: var(--secondary); color: white; padding: 6px 12px; border-radius: 8px; font-weight: 800; font-size: 0.85rem;">
                                        ID: <?= $payment['sys_ref_id'] ?? 'N/A' ?>
                                    </div>
                                </div>
                                <div style="font-size: 1.5rem; font-weight: 900; color: var(--primary);">
                                    <?= number_format($req['total_amount'], 0, ',', '.') ?> KZ
                                </div>
                            </div>
                            
                            <!-- Ações -->
                            <div style="display: flex; gap: 12px; border-top: 1px solid var(--slate-100); padding-top: 20px; margin-top: 20px;">
                                <a href="/admin/validate-receipt/<?= $req['id'] ?>/approve" onclick="return confirm('Confirma que tem o dinheiro na conta de garantia?');" style="flex: 1; background: var(--secondary); color: white; padding: 12px; border-radius: 12px; font-weight: 800; text-align: center; text-decoration: none; transition: 0.2s;">
                                    Aprovar Dinheiro
                                </a>
                                <a href="/admin/validate-receipt/<?= $req['id'] ?>/reject" onclick="return confirm('Tem certeza que pretende rejeitar este documento?');" style="flex: 1; background: #fef2f2; color: #ef4444; padding: 12px; border-radius: 12px; font-weight: 800; text-align: center; text-decoration: none; border: 1px solid #fecaca; transition: 0.2s;">
                                    Rejeitar Anexo
                                </a>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>
<?= $this->endSection() ?>
