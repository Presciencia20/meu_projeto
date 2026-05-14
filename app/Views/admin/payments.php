<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Gestão de Pagamentos | Admin<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div style="padding: 20px 20px 100px; max-width: 1000px; margin: 0 auto;">
    <div style="margin-bottom: 32px;">
        <h1 style="font-family: 'Outfit'; font-weight: 900; font-size: 2rem; color: var(--gray-800);">Fila de Pagamentos</h1>
        <p style="color: var(--gray-500); font-weight: 500;">Valide os comprovativos dos utilizadores para ativar planos e reservas.</p>
    </div>

    <div style="background: white; border-radius: 24px; border: 1px solid var(--gray-100); overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead>
                <tr style="background: #f8fafc; border-bottom: 1px solid var(--gray-100);">
                    <th style="padding: 20px; font-weight: 800; color: var(--gray-500); font-size: 0.75rem; text-transform: uppercase;">Utilizador</th>
                    <th style="padding: 20px; font-weight: 800; color: var(--gray-500); font-size: 0.75rem; text-transform: uppercase;">Tipo / Ref</th>
                    <th style="padding: 20px; font-weight: 800; color: var(--gray-500); font-size: 0.75rem; text-transform: uppercase;">Montante</th>
                    <th style="padding: 20px; font-weight: 800; color: var(--gray-500); font-size: 0.75rem; text-transform: uppercase;">Comprovativo</th>
                    <th style="padding: 20px; font-weight: 800; color: var(--gray-500); font-size: 0.75rem; text-transform: uppercase; text-align: center;">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($payments)): ?>
                    <tr>
                        <td colspan="5" style="padding: 60px; text-align: center; color: var(--gray-400); font-weight: 600;">Nenhum pagamento pendente no momento.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($payments as $p): ?>
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 20px;">
                                <div style="font-weight: 700; color: var(--gray-800);"><?= esc($p['user_name']) ?></div>
                                <div style="font-size: 0.7rem; color: var(--gray-400);"><?= $p['created_at'] ?></div>
                            </td>
                            <td style="padding: 20px;">
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <span style="font-size: 0.7rem; font-weight: 900; color: white; background: <?= $p['related_type'] === 'plan' ? '#6366f1' : '#10b981' ?>; padding: 2px 8px; border-radius: 4px; display: inline-block; width: fit-content; text-transform: uppercase;">
                                        <?= $p['related_type'] ?>
                                    </span>
                                    <div style="font-family: 'monospace'; font-size: 0.85rem; font-weight: 700; color: var(--gray-600);"><?= $p['reference'] ?></div>
                                </div>
                            </td>
                            <td style="padding: 20px; font-weight: 800; color: var(--app-primary);">
                                <?= number_format($p['amount'], 0, ',', '.') ?> KZ
                            </td>
                            <td style="padding: 20px;">
                                <?php if ($p['proof_file']): ?>
                                    <a href="/<?= $p['proof_file'] ?>" target="_blank" style="display: flex; align-items: center; gap: 8px; color: var(--app-primary); text-decoration: none; font-weight: 700; font-size: 0.85rem;">
                                        <i class="ph-bold ph-file-text" style="font-size: 1.2rem;"></i> Ver Ficheiro
                                    </a>
                                <?php else: ?>
                                    <span style="font-size: 0.8rem; color: var(--gray-400); font-weight: 600;">Sem upload</span>
                                <?php endif; ?>
                            </td>
                            <td style="padding: 20px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <form action="/admin/payments/action/<?= $p['id'] ?>/approve" method="POST">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn-circle" style="background: #ecfdf5; color: #10b981; border: none;" title="Aprovar">
                                            <i class="ph-bold ph-check"></i>
                                        </button>
                                    </form>
                                    <button class="btn-circle" style="background: #fff1f2; color: #e11d48; border: none;" title="Rejeitar" onclick="rejectPayment(<?= $p['id'] ?>)">
                                        <i class="ph-bold ph-x"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Rejection Modal (Simple Prompt) -->
<script>
    function rejectPayment(id) {
        const reason = prompt("Indique o motivo da rejeição (será enviado ao utilizador):");
        if (reason) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/payments/action/${id}/reject`;
            
            const csrf = document.createElement('input');
            csrf.type = 'hidden';
            csrf.name = '<?= csrf_token() ?>';
            csrf.value = '<?= csrf_hash() ?>';
            form.appendChild(csrf);

            const note = document.createElement('input');
            note.type = 'hidden';
            note.name = 'note';
            note.value = reason;
            form.appendChild(note);

            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
<?= $this->endSection() ?>
