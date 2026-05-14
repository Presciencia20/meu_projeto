<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Escolha o seu Plano | CasaSegura<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div style="max-width: 1000px; margin: 40px auto 100px; padding: 0 20px;">
    <div style="text-align: center; margin-bottom: 56px;">
        <h1 style="font-family: 'Outfit'; font-weight: 950; font-size: 2.6rem; color: var(--gray-800); letter-spacing: -1.5px; margin-bottom: 12px;">Planos de Visibilidade</h1>
        <p style="color: var(--gray-500); font-size: 1.15rem; font-weight: 500; max-width: 600px; margin: 0 auto;">Potencialize as suas vendas com as ferramentas de destaque da CasaSegura. Escolha o plano que melhor se adapta ao seu negócio.</p>
    </div>

    <!-- Pricing Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; align-items: stretch;">
        <?php foreach ($plans as $plan): 
            $isTop = str_contains(strtolower($plan['name']), 'top') || str_contains(strtolower($plan['name']), 'platinum');
            $isFree = $plan['price'] <= 0;
        ?>
            <div style="background: white; border-radius: 32px; padding: 32px; border: 1px solid <?= $isTop ? 'var(--app-primary)' : 'var(--gray-100)' ?>; box-shadow: 0 15px 35px rgba(0,0,0,0.04); position: relative; display: flex; flex-direction: column; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-10px)'" onmouseout="this.style.transform='translateY(0)'">
                
                <?php if ($isTop): ?>
                    <div style="position: absolute; top: -12px; left: 50%; transform: translateX(-50%); background: var(--app-primary); color: white; padding: 6px 16px; border-radius: 50px; font-size: 0.65rem; font-weight: 900; text-transform: uppercase; white-space: nowrap; box-shadow: 0 5px 15px rgba(37, 99, 235, 0.4);">Recomendado</div>
                <?php endif; ?>

                <div style="margin-bottom: 24px;">
                    <h3 style="font-family: 'Outfit'; font-weight: 900; font-size: 1.4rem; color: var(--gray-800); margin-bottom: 4px;"><?= esc($plan['name']) ?></h3>
                </div>

                <div style="margin-bottom: 32px;">
                    <div style="font-size: 2rem; font-weight: 950; color: var(--gray-800); font-family: 'Outfit';">
                        <?= $isFree ? 'Grátis' : number_format($plan['price'], 0, ',', '.') . ' <small style="font-size: 0.9rem; opacity: 0.5;">KZ</small>' ?>
                    </div>
                    <div style="font-size: 0.8rem; font-weight: 700; color: var(--gray-400); text-transform: uppercase; margin-top: 4px;">
                        <?= $plan['duration_days'] ?> dias de validade
                    </div>
                </div>

                <div style="margin-bottom: 40px; flex: 1;">
                    <?php $features = json_decode($plan['features'], true); ?>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 14px;">
                        <?php foreach ($features as $f): ?>
                            <li style="display: flex; gap: 12px; font-weight: 600; color: var(--gray-600); font-size: 0.85rem; line-height: 1.4;">
                                <i class="ph-bold ph-check" style="color: #10b981; margin-top: 2px;"></i>
                                <?= esc($f) ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <a href="/payment/checkout/plan/<?= $plan['id'] ?>" class="btn-app-primary" style="width: 100%; height: 52px; border-radius: 16px; font-size: 0.9rem; <?= $isFree ? 'background: #f1f5f9; color: var(--gray-600); box-shadow: none;' : '' ?>">
                    <?= $isFree ? 'Começar Grátis' : 'Escolher Plano' ?>
                </a>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Assurance -->
    <div style="margin-top: 64px; text-align: center; display: flex; flex-direction: column; align-items: center; gap: 16px;">
        <div style="display: flex; gap: 32px; opacity: 0.4; grayscale: 100%;">
            <img src="https://upload.wikimedia.org/wikipedia/pt/4/4b/Logo_Multicaixa.png" style="height: 30px;">
            <span style="font-family: 'Outfit'; font-weight: 900; font-size: 1.2rem;">PayPay</span>
        </div>
        <p style="color: var(--gray-400); font-size: 0.8rem; font-weight: 600; max-width: 400px; line-height: 1.5;">
            Os pagamentos são processados em conformidade com as normas do BNA. Ativação sujeita a análise de comprovativo.
        </p>
    </div>
</div>
<?= $this->endSection() ?>
