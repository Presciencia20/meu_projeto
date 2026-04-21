<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Vender Imóvel em Angola<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    /* Hero */
    .page-hero {
        padding: 100px 0 60px;
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
    }

    .page-hero h1 {
        font-size: 3.8rem;
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 24px;
        letter-spacing: -3px;
        line-height: 1;
    }

    .page-hero p {
        color: var(--slate-500);
        font-size: 1.35rem;
        margin-bottom: 48px;
        line-height: 1.6;
        font-weight: 500;
    }

    /* Steps */
    .steps-section {
        margin: 60px 0 100px;
    }

    .steps-section h2 {
        text-align: center;
        font-size: 2.5rem;
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 64px;
        letter-spacing: -1px;
    }

    .steps-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 32px;
        position: relative;
    }

    .step-item {
        text-align: center;
        padding: 40px 32px;
        background: white;
        border: 1px solid var(--slate-100);
        border-radius: 32px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .step-item:hover { transform: translateY(-10px); box-shadow: var(--shadow-xl); border-color: var(--primary-100); }

    .step-circle {
        width: 80px;
        height: 80px;
        background: var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.75rem;
        font-weight: 900;
        margin: 0 auto 24px;
        box-shadow: 0 12px 28px rgba(26, 86, 219, 0.2);
    }

    .step-item h3 { font-size: 1.25rem; font-weight: 800; margin-bottom: 12px; color: var(--slate-900); }
    .step-item p { color: var(--slate-500); font-size: 1rem; line-height: 1.7; }

    /* Benefits */
    .benefits-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
        margin-bottom: 100px;
    }

    .benefit-card {
        background: white;
        border-radius: 32px;
        border: 1px solid var(--slate-100);
        padding: 40px;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 24px;
    }

    .benefit-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-xl); border-color: var(--primary-100); }

    .benefit-icon {
        width: 64px;
        height: 64px;
        flex-shrink: 0;
        background: var(--primary-50);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
    }

    .benefit-icon i { width: 32px !important; height: 32px !important; }
    .benefit-card h3 { font-size: 1.3rem; font-weight: 800; color: var(--slate-900); }
    .benefit-card p { color: var(--slate-500); font-size: 1.05rem; line-height: 1.7; }

    /* CTA Form */
    .cta-form-section {
        background: white;
        border-radius: 40px;
        border: 1px solid var(--slate-100);
        padding: 80px 64px;
        margin-bottom: 100px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
        box-shadow: var(--shadow-xl);
    }

    @media (max-width: 992px) { .cta-form-section { grid-template-columns: 1fr; padding: 60px 40px; } }

    .cta-form-section h2 { font-size: 2.8rem; font-weight: 900; color: var(--slate-900); margin-bottom: 20px; letter-spacing: -1.5px; }
    .cta-form-section p { color: var(--slate-500); line-height: 1.8; margin-bottom: 40px; font-size: 1.15rem; }

    .contact-form { display: flex; flex-direction: column; gap: 24px; }

    .form-field label { font-size: 0.9rem; font-weight: 700; color: var(--slate-700); margin-bottom: 8px; display: block; }

    /* Pricing */
    .pricing-section { margin-bottom: 100px; text-align: center; }
    .pricing-section h2 { font-size: 2.8rem; font-weight: 900; margin-bottom: 16px; letter-spacing: -1px; }
    .pricing-section p { color: var(--slate-500); margin-bottom: 64px; font-size: 1.15rem; font-weight: 500; }

    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
    }

    .pricing-card {
        background: white;
        border: 2px solid var(--slate-100);
        border-radius: 40px;
        padding: 60px 40px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
        text-align: left;
    }

    .pricing-card:hover { transform: translateY(-12px); box-shadow: var(--shadow-xl); border-color: var(--primary-100); }

    .pricing-card.featured { border-color: var(--primary); background: var(--primary-50); }

    .featured-badge {
        position: absolute;
        top: 24px;
        right: 24px;
        background: var(--primary);
        color: white;
        font-size: 0.8rem;
        font-weight: 800;
        padding: 6px 14px;
        border-radius: 99px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .pricing-card h3 { font-size: 1.5rem; font-weight: 800; margin-bottom: 24px; color: var(--slate-900); }

    .pricing-price { font-size: 3.5rem; font-weight: 900; color: var(--slate-900); margin-bottom: 8px; letter-spacing: -2px; }
    .pricing-price sup { font-size: 1.5rem; font-weight: 800; vertical-align: top; margin-top: 15px; color: var(--slate-400); }
    .pricing-period { color: var(--slate-400); font-size: 1rem; font-weight: 600; margin-bottom: 40px; }

    .pricing-features { list-style: none; display: flex; flex-direction: column; gap: 16px; margin-bottom: 48px; }

    .pricing-features li {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 1.05rem;
        color: var(--slate-600);
        font-weight: 500;
    }

    .pricing-features li::before {
        content: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='18' height='18' viewBox='0 0 24 24' fill='none' stroke='%231A56DB' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='20 6 9 17 4 12'%3E%3C/polyline%3E%3C/svg%3E");
        display: inline-block;
        margin-top: 4px;
    }

    .btn-pricing {
        display: block;
        width: 100%;
        text-align: center;
        padding: 18px;
        border-radius: 20px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.3s;
    }

    .pricing-card:not(.featured) .btn-pricing { background: white; border: 2px solid var(--primary); color: var(--primary); }
    .pricing-card.featured .btn-pricing { background: var(--primary); color: white; }

    .btn-pricing:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }

    .page-footer {
        padding: 48px 0; border-top: 1px solid var(--slate-200);
        display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <section class="page-hero animate-fade-in">
        <div class="badge-verified" style="margin-bottom: 24px;">
            <i data-lucide="trending-up" style="width:16px;height:16px"></i>
            Publicar Imóvel em Angola
        </div>
        <h1>Venda ou arrende com <span style="color: var(--primary)">máxima exposição</span><br>e total segurança.</h1>
        <p>Publique o seu imóvel e alcance milhares de compradores e inquilinos verificados na maior rede imobiliária segura de Angola.</p>
        <a href="/dashboard" class="btn-primary" style="padding: 18px 48px; font-size: 1.1rem; border-radius: 20px;">
            Começar Agora Grátis
        </a>
    </section>

    <!-- How to sell steps -->
    <div class="steps-section animate-fade-in">
        <h2>Como Funciona?</h2>
        <div class="steps-grid">
            <div class="step-item">
                <div class="step-circle">1</div>
                <h3>Crie a Sua Conta</h3>
                <p>Registe-se e verifique a sua identidade com o seu BI angolano para ganhar confiança dos compradores.</p>
            </div>
            <div class="step-item">
                <div class="step-circle">2</div>
                <h3>Publique o Imóvel</h3>
                <p>Adicione fotos, preço, localização e descrição detalhada. É simples e demora menos de 5 minutos.</p>
            </div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <h3>Receba Contactos</h3>
                <p>Interessados entram em contacto pelo chat seguro. Marque visitas e responda a perguntas.</p>
            </div>
            <div class="step-item">
                <div class="step-circle">4</div>
                <h3>Feche o Negócio</h3>
                <p>O pagamento é processado com segurança e o contrato assinado digitalmente. Simples e seguro.</p>
            </div>
        </div>
    </div>

    <!-- Benefits -->
    <div class="benefits-grid animate-fade-in">
        <div class="benefit-card">
            <div class="benefit-icon"><i data-lucide="users"></i></div>
            <h3>Audiência Verificada</h3>
            <p>Todos os potenciais compradores e inquilinos passam por verificação rigorosa, garantindo negócios sérios e sem perdas de tempo.</p>
        </div>
        <div class="benefit-card">
            <div class="benefit-icon"><i data-lucide="eye"></i></div>
            <h3>Alta Visibilidade</h3>
            <p>O seu imóvel é promovido nas categorias relevantes e alcança milhares de utilizadores ativos diariamente em todas as províncias.</p>
        </div>
        <div class="benefit-card">
            <div class="benefit-icon"><i data-lucide="shield-check"></i></div>
            <h3>Pagamento Garantido</h3>
            <p>Receba o seu dinheiro de forma segura via custódia digital. O valor é libertado assim que o negócio for confirmado.</p>
        </div>
        <div class="benefit-card">
            <div class="benefit-icon"><i data-lucide="file-signature"></i></div>
            <h3>Contratos Digitais</h3>
            <p>Gere e assine contratos com validade jurídica diretamente na plataforma, eliminando burocracias e idas desnecessárias a cartórios.</p>
        </div>
        <div class="benefit-card">
            <div class="benefit-icon"><i data-lucide="star"></i></div>
            <h3>Reputação Online</h3>
            <p>Construa o seu perfil de proprietário. Avaliações positivas aumentam drasticamente a velocidade de fecho de novos negócios.</p>
        </div>
        <div class="benefit-card">
            <div class="benefit-icon"><i data-lucide="headphones"></i></div>
            <h3>Suporte Dedicado</h3>
            <p>A nossa equipa de especialistas está pronta para o ajudar em qualquer dúvida técnica ou jurídica durante a publicação.</p>
        </div>
    </div>

    <!-- CTA Form Section -->
    <div class="cta-form-section animate-fade-in">
        <div>
            <h2>Pronto para anunciar o seu imóvel?</h2>
            <p>Diga-nos o que pretende vender ou arrendar. Um dos nossos especialistas entrará em contacto para o ajudar a maximizar o seu lucro.</p>
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div class="benefit-icon" style="width: 52px; height: 52px;"><i data-lucide="phone" style="width: 24px; height: 24px;"></i></div>
                    <div>
                        <div style="font-weight: 800; font-size: 1.1rem; color: var(--slate-900);">+244 923 456 789</div>
                        <div style="color: var(--slate-500); font-weight: 600;">Linha do Proprietário</div>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 20px;">
                    <div class="benefit-icon" style="width: 52px; height: 52px;"><i data-lucide="mail" style="width: 24px; height: 24px;"></i></div>
                    <div>
                        <div style="font-weight: 800; font-size: 1.1rem; color: var(--slate-900);">venda@arrendaseguro.ao</div>
                        <div style="color: var(--slate-500); font-weight: 600;">Resposta Prioritária</div>
                    </div>
                </div>
            </div>
        </div>
        <form class="contact-form" action="/dashboard" method="get">
            <div class="form-field">
                <label>Nome Completo</label>
                <input type="text" class="input-modern" placeholder="Ex: João da Silva" required>
            </div>
            <div class="form-field">
                <label>Telefone</label>
                <input type="tel" class="input-modern" placeholder="+244 9XX XXX XXX" required>
            </div>
            <div class="form-field">
                <label>Tipo de Imóvel</label>
                <select class="input-modern" required>
                    <option value="">Selecione o tipo...</option>
                    <option>Apartamento</option>
                    <option>Vivenda / Casa</option>
                    <option>Terreno</option>
                    <option>Escritório / Loja</option>
                </select>
            </div>
            <div class="form-field">
                <label>Breve Descrição</label>
                <textarea class="input-modern" placeholder="Localização, número de quartos, etc..." style="min-height: 120px;"></textarea>
            </div>
            <button type="submit" class="btn-primary" style="padding: 18px; border-radius: 16px; font-size: 1rem; width: 100%;">
                Enviar Pedido de Contacto
            </button>
        </form>
    </div>

    <!-- Pricing -->
    <div class="pricing-section animate-fade-in">
        <h2>Planos de Divulgação</h2>
        <p>Soluções escaláveis para proprietários individuais e agências imobiliárias.</p>
        <div class="pricing-grid">
            <div class="pricing-card">
                <h3>Básico</h3>
                <div class="pricing-price"><sup>KZ</sup>0</div>
                <div class="pricing-period">Grátis para sempre</div>
                <ul class="pricing-features">
                    <li>1 anúncio ativo</li>
                    <li>5 fotos por imóvel</li>
                    <li>Chat seguro</li>
                    <li>Verificação BI/Selfie</li>
                </ul>
                <a href="/signup" class="btn-pricing">Começar Grátis</a>
            </div>
            <div class="pricing-card featured">
                <div class="featured-badge">Mais Popular</div>
                <h3>Profissional</h3>
                <div class="pricing-price"><sup>KZ</sup>15.000</div>
                <div class="pricing-period">Pagamento mensal</div>
                <ul class="pricing-features">
                    <li>12 anúncios ativos</li>
                    <li>20 fotos por imóvel</li>
                    <li>Destaque em categorias</li>
                    <li>Notificações por SMS</li>
                    <li>Relatórios de tráfego</li>
                </ul>
                <a href="/signup" class="btn-pricing">Escolher Profissional</a>
            </div>
            <div class="pricing-card">
                <h3>Agência</h3>
                <div class="pricing-price"><sup>KZ</sup>45.000</div>
                <div class="pricing-period">Pagamento mensal</div>
                <ul class="pricing-features">
                    <li>Anúncios ilimitados</li>
                    <li>Vídeos e Tours 3D</li>
                    <li>Gestor de conta VIP</li>
                    <li>Exportação de leads</li>
                    <li>Destaque Premium Home</li>
                </ul>
                <a href="/sobre" class="btn-pricing">Falar com Equipa</a>
            </div>
        </div>
    </div>

    <div class="page-footer" style="padding: 60px 0; border-top: 1px solid var(--slate-100); margin-top: 40px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 40px;">
        <div class="logo">
            <img src="/img/logo.png" alt="CasaSegura" style="height: 48px;">
        </div>
        <p style="color: var(--slate-400); font-size: 0.9rem; font-weight: 500;">© <?= date('Y') ?> CasaSegura Angola. Todos os direitos reservados.</p>
    </div>

<?= $this->endSection() ?>
