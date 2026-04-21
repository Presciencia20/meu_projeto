<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Sobre o CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    /* Hero */
    .about-hero {
        padding: 100px 0 80px;
        text-align: center;
        max-width: 900px;
        margin: 0 auto;
    }

    .about-hero h1 {
        font-size: 3.8rem;
        font-weight: 900;
        color: var(--slate-900);
        margin-bottom: 24px;
        letter-spacing: -3px;
        line-height: 1;
    }

    .about-hero p {
        color: var(--slate-500);
        font-size: 1.35rem;
        margin-bottom: 48px;
        line-height: 1.6;
        font-weight: 500;
    }

    /* Mission Band */
    .mission-band {
        background: linear-gradient(135deg, var(--primary), #4F46E5);
        border-radius: 40px;
        padding: 80px 64px;
        color: white;
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        gap: 80px;
        align-items: center;
        margin-bottom: 100px;
        position: relative;
        overflow: hidden;
        box-shadow: var(--shadow-xl);
    }

    @media (max-width: 992px) { .mission-band { grid-template-columns: 1fr; padding: 60px 40px; } }

    .mission-band .label {
        font-size: 0.85rem;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        opacity: 0.8;
        margin-bottom: 20px;
    }

    .mission-band h2 { font-size: 2.8rem; font-weight: 900; line-height: 1.1; margin-bottom: 24px; letter-spacing: -1px; }
    .mission-band p { opacity: 0.9; line-height: 1.8; font-size: 1.15rem; font-weight: 500; }

    .mission-stats {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    .mission-stat {
        background: rgba(255, 255, 255, 0.12);
        border-radius: 32px;
        padding: 40px 32px;
        text-align: center;
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: transform 0.3s;
    }

    .mission-stat:hover { transform: translateY(-5px); }
    .mission-stat .num { font-size: 3rem; font-weight: 900; line-height: 1; margin-bottom: 8px; letter-spacing: -2px; }
    .mission-stat .lbl { font-size: 0.95rem; font-weight: 600; opacity: 0.8; }

    /* Story Section */
    .story-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 80px;
        align-items: center;
        margin-bottom: 100px;
    }

    @media (max-width: 900px) { .story-section { grid-template-columns: 1fr; gap: 40px; } }

    .story-img {
        border-radius: 40px;
        overflow: hidden;
        aspect-ratio: 4/3;
        background: var(--slate-100);
        box-shadow: var(--shadow-lg);
    }

    .story-img img { width: 100%; height: 100%; object-fit: cover; }

    .story-text .label {
        font-size: 0.85rem;
        font-weight: 800;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--primary);
        margin-bottom: 20px;
    }

    .story-text h2 { font-size: 2.5rem; font-weight: 900; color: var(--slate-900); margin-bottom: 24px; letter-spacing: -1px; }
    .story-text p { color: var(--slate-600); line-height: 1.8; margin-bottom: 20px; font-size: 1.1rem; }

    /* Values */
    .values-section { margin-bottom: 100px; }
    .values-section h2 { text-align: center; font-size: 2.5rem; font-weight: 900; color: var(--slate-900); margin-bottom: 16px; letter-spacing: -1px; }
    .values-section .subtitle { text-align: center; color: var(--slate-500); margin-bottom: 60px; font-size: 1.15rem; font-weight: 500; }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 32px;
    }

    .value-card {
        background: white;
        border: 1px solid var(--slate-100);
        border-radius: 32px;
        padding: 48px 40px;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .value-card:hover { transform: translateY(-10px); box-shadow: var(--shadow-xl); border-color: var(--primary-100); }

    .value-icon {
        width: 64px;
        height: 64px;
        background: var(--primary-50);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        padding: 16px;
        margin-bottom: 24px;
    }

    .value-icon i { width: 32px !important; height: 32px !important; }
    .value-card h3 { font-size: 1.4rem; font-weight: 800; margin-bottom: 16px; letter-spacing: -0.5px; }
    .value-card p { color: var(--slate-500); line-height: 1.8; font-size: 1.05rem; }

    /* Team */
    .team-section { margin-bottom: 100px; }
    .team-section h2 { text-align: center; font-size: 2.5rem; font-weight: 900; color: var(--slate-900); margin-bottom: 60px; letter-spacing: -1px; }

    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 32px;
    }

    .team-card {
        background: white;
        border: 1px solid var(--slate-100);
        border-radius: 32px;
        overflow: hidden;
        transition: all 0.3s;
        text-align: center;
        padding-bottom: 10px;
    }

    .team-card:hover { transform: translateY(-8px); box-shadow: var(--shadow-xl); }

    .team-avatar {
        width: 100%;
        aspect-ratio: 1;
        background: var(--slate-50);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 4rem;
    }

    .team-info { padding: 32px 24px; }
    .team-info h3 { font-size: 1.25rem; font-weight: 800; margin-bottom: 8px; color: var(--slate-900); }
    .team-info .role { font-size: 0.95rem; color: var(--primary); font-weight: 700; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 1px; }
    .team-info p { font-size: 0.95rem; color: var(--slate-500); line-height: 1.6; }

    /* Timeline */
    .timeline {
        position: relative;
        max-width: 800px;
        margin: 0 auto;
        padding: 40px 0;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 40px;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--primary-100);
        border-radius: 4px;
    }

    .timeline-item {
        display: flex;
        gap: 40px;
        padding-bottom: 60px;
        position: relative;
    }

    .timeline-dot {
        width: 80px;
        height: 80px;
        flex-shrink: 0;
        background: white;
        border: 4px solid var(--primary);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        font-weight: 900;
        font-size: 1.1rem;
        z-index: 10;
        box-shadow: var(--shadow-md);
    }

    .timeline-body {
        background: white;
        border: 1px solid var(--slate-100);
        border-radius: 32px;
        padding: 40px;
        flex: 1;
        box-shadow: var(--shadow-sm);
        transition: all 0.3s;
    }

    .timeline-body:hover { border-color: var(--primary-100); transform: translateX(10px); }
    .timeline-body .year { font-size: 0.9rem; font-weight: 800; color: var(--primary); margin-bottom: 12px; text-transform: uppercase; }
    .timeline-body h3 { font-size: 1.4rem; font-weight: 800; margin-bottom: 12px; color: var(--slate-900); }
    .timeline-body p { font-size: 1rem; color: var(--slate-500); line-height: 1.8; }

    /* FAQ */
    .faq-list { max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 20px; }

    .faq-item {
        background: white;
        border: 1px solid var(--slate-100);
        border-radius: 24px;
        overflow: hidden;
        transition: all 0.3s;
    }

    .faq-item[open] { border-color: var(--primary-200); box-shadow: var(--shadow-md); }

    .faq-question {
        padding: 28px 32px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--slate-900);
        list-style: none;
    }

    .faq-question::-webkit-details-marker { display: none; }
    .faq-question::after { content: '\002B'; font-size: 20px; color: var(--primary); transition: transform 0.3s; }
    .faq-item[open] .faq-question::after { transform: rotate(45deg); }

    .faq-answer { padding: 0 32px 32px; color: var(--slate-500); line-height: 1.8; font-size: 1.05rem; }

    /* Contact CTA */
    .contact-cta {
        background: var(--slate-900);
        border-radius: 40px;
        padding: 100px 48px;
        text-align: center;
        color: white;
        margin: 100px 0;
        position: relative;
        overflow: hidden;
    }

    .contact-cta h2 { font-size: 3rem; font-weight: 900; margin-bottom: 24px; letter-spacing: -1.5px; }
    .contact-cta p { opacity: 0.7; font-size: 1.2rem; margin-bottom: 48px; max-width: 600px; margin-left: auto; margin-right: auto; line-height: 1.6; }

    .btn-white {
        background: white;
        color: var(--slate-900);
        padding: 18px 40px;
        border-radius: 20px;
        font-weight: 800;
        text-decoration: none;
        font-size: 1rem;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }

    .btn-white:hover { transform: translateY(-4px); box-shadow: 0 20px 40px rgba(0,0,0,0.4); }

    .btn-outline-light {
        background: rgba(255,255,255,0.05);
        color: white;
        padding: 18px 40px;
        border-radius: 20px;
        font-weight: 800;
        text-decoration: none;
        font-size: 1rem;
        border: 2px solid rgba(255,255,255,0.1);
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 12px;
    }

    .btn-outline-light:hover { background: rgba(255,255,255,0.1); border-color: rgba(255,255,255,0.2); }

    .page-footer {
        padding: 48px 0; border-top: 1px solid var(--slate-200);
        display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <!-- Hero -->
    <section class="about-hero animate-fade-in">
        <div class="badge-verified" style="margin-bottom: 24px;">
            <i data-lucide="shield" style="width:16px;height:16px"></i>
            Conheça a nossa história
        </div>
        <h1>Nascemos para <span style="color: var(--primary)">eliminar as burlas</span><br>imobiliárias em Angola.</h1>
        <p>Cada angolano merece encontrar um lar com dignidade, segurança e transparência. Essa é a nossa missão e o nosso compromisso com o país.</p>
    </section>

    <!-- Mission Band -->
    <div class="mission-band animate-fade-in">
        <div>
            <div class="label">A Nossa Missão</div>
            <h2>Tornar o mercado imobiliário angolano seguro para todos.</h2>
            <p>Em Angola, milhares de famílias perdem as suas poupanças todos os anos em burlas imobiliárias. O CasaSegura foi criado para pôr fim a isso — combinando tecnologia, verificação de identidade e um sistema de pagamento em custódia que protege compradores e vendedores.</p>
        </div>
        <div class="mission-stats">
            <div class="mission-stat">
                <div class="num">0</div>
                <div class="lbl">Burlas Registadas</div>
            </div>
            <div class="mission-stat">
                <div class="num">18</div>
                <div class="lbl">Províncias Ativas</div>
            </div>
            <div class="mission-stat">
                <div class="num">100%</div>
                <div class="lbl">Proprietários Verificados</div>
            </div>
            <div class="mission-stat">
                <div class="num">24/7</div>
                <div class="lbl">Suporte Disponível</div>
            </div>
        </div>
    </div>

    <!-- Story -->
    <div class="story-section animate-fade-in">
        <div class="story-img">
            <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?auto=format&fit=crop&q=80&w=1200"
                 alt="Luanda Angola cidade">
        </div>
        <div class="story-text">
            <div class="label">A Nossa Jornada</div>
            <h2>Uma ideia nascida da frustração de quem já foi burlado.</h2>
            <p>Em 2023, o fundador do CasaSegura perdeu as suas poupanças numa burla imobiliária em Luanda. Como ele, milhares de angolanos vivem a mesma história todos os dias.</p>
            <p>Decidimos que bastava. Reunimos uma equipa de engenheiros, juristas e especialistas imobiliários para construir a plataforma que garantisse que nenhum outro angolano passasse pelo mesmo.</p>
            <p>Hoje, o CasaSegura é a referência nacional para negócios imobiliários seguros — com verificação rigorosa de identidade e pagamentos protegidos por custódia digital.</p>
        </div>
    </div>

    <!-- Values -->
    <div class="values-section animate-fade-in">
        <h2>Os Nossos Valores</h2>
        <p class="subtitle">Estes são os princípios que guiam cada decisão que tomamos.</p>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon"><i data-lucide="shield-check"></i></div>
                <h3>Segurança em Primeiro</h3>
                <p>Todos os processos são desenhados para proteger os utilizadores acima de qualquer outra consideração.</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i data-lucide="eye"></i></div>
                <h3>Transparência Total</h3>
                <p>Sem taxas escondidas, sem letras pequenas. Sabemos tudo o que acontece na plataforma e partilhamos isso consigo.</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i data-lucide="heart"></i></div>
                <h3>Feito por Angolanos</h3>
                <p>Entendemos o mercado angolano porque vivemos nele. Construímos para a nossa comunidade, com orgulho.</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i data-lucide="zap"></i></div>
                <h3>Inovação Contínua</h3>
                <p>O mercado evolui e nós evoluímos com ele. Lançamos novas funcionalidades todos os meses.</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i data-lucide="users"></i></div>
                <h3>Comunidade</h3>
                <p>O CasaSegura é mais do que uma app — é uma comunidade de angolanos que se ajudam mutuamente.</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i data-lucide="scale"></i></div>
                <h3>Justiça</h3>
                <p>Damos voz aos usuários em disputas. O nosso sistema de arbitragem garante resoluções justas.</p>
            </div>
        </div>
    </div>

    <!-- Team -->
    <div class="team-section animate-fade-in">
        <h2>Quem Somos</h2>
        <p class="subtitle">O CasaSegura é um projeto inovador idealizado e desenvolvido integralmente pela <strong>Prestech</strong> em 2026, com o compromisso de trazer total segurança e transparência ao nosso país.</p>

    </div>

    <!-- Timeline -->
    <div class="timeline-section animate-fade-in">
        <h2>A Nossa Jornada</h2>
        <p class="subtitle">Como a Prestech transformou uma visão num projeto de referência em 2026.</p>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-dot">2026</div>
                <div class="timeline-body">
                    <div class="year">Janeiro 2026</div>
                    <h3>O Início na Prestech</h3>
                    <p>Ao observar os constantes desafios no setor imobiliário, a equipa da Prestech decide criar uma solução tecnológica definitiva para proteger os angolanos contra burlas.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot">2026</div>
                <div class="timeline-body">
                    <div class="year">Fevereiro 2026</div>
                    <h3>Desenvolvimento e Inovação</h3>
                    <p>Os nossos engenheiros na Prestech trabalharam incansavelmente para implementar arquiteturas de segurança avançadas, focando na verificação de identidade local.</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot">2026</div>
                <div class="timeline-body">
                    <div class="year">Abril 2026</div>
                    <h3>Lançamento do CasaSegura</h3>
                    <p>O CasaSegura é oficialmente lançado no mercado angolano pela Prestech, equipado com moderação de qualidade e sistema seguro de pagamentos.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- FAQ -->
    <div class="faq-section animate-fade-in">
        <h2>Perguntas Frequentes</h2>
        <p class="subtitle">Tudo o que precisa de saber sobre o CasaSegura.</p>
        <div class="faq-list">
            <details class="faq-item">
                <summary class="faq-question">Como funciona a verificação de identidade?</summary>
                <div class="faq-answer">
                    Pedimos uma foto do BI angolano e uma selfie. O nosso sistema compara os dois automaticamente e, em caso de dúvida, a nossa equipa humana confirma manualmente. O processo demora menos de 24 horas.
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question">O que é o sistema de pagamento em custódia (escrow)?</summary>
                <div class="faq-answer">
                    Quando um inquilino paga a renda, o dinheiro fica guardado em segurança na plataforma. Só é libertado ao proprietário depois de o inquilino confirmar que entrou no imóvel e que está conforme o descrito. Assim, nenhuma das partes fica prejudicada.
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question">Os contratos digitais têm validade legal em Angola?</summary>
                <div class="faq-answer">
                    Sim. Os contratos gerados pelo CasaSegura são elaborados pelo nosso departamento jurídico e cumprem todos os requisitos da legislação angolana n.º 14/16 sobre transações eletrónicas. São completamente válidos e executáveis em tribunal.
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question">Quanto custa publicar um imóvel?</summary>
                <div class="faq-answer">
                    O plano básico é completamente gratuito e permite publicar 1 imóvel com até 5 fotos. Para múltiplos imóveis ou funcionalidades premium, temos planos a partir de 15.000 KZ/mês. Consulte a nossa página <a href="/vender" style="color: var(--brand-600)">Vender</a> para mais detalhes.
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question">O que acontece se existir um problema com o imóvel?</summary>
                <div class="faq-answer">
                    Se o imóvel não corresponder ao descrito, o inquilino pode rejeitar a entrega dentro de 48 horas após a entrada. O dinheiro é devolvido e a nossa equipa de arbitragem analisa o caso. Proprietários com queixas repetidas são removidos da plataforma.
                </div>
            </details>
            <details class="faq-item">
                <summary class="faq-question">Operam em todas as províncias angolanas?</summary>
                <div class="faq-answer">
                    Atualmente temos maior cobertura em Luanda, Benguela, Huambo, Huíla e Cabinda. Estamos a expandir para todas as 18 províncias durante 2024-2025. Se a sua província não tiver cobertura, pode inscrever-se na lista de espera.
                </div>
            </details>
        </div>
    </div>

    <!-- Contact CTA -->
    <div class="contact-cta animate-fade-in">
        <h2>Ainda tem dúvidas? Fale connosco.</h2>
        <p>A nossa equipa está disponível para responder a todas as suas questões e ajudá-lo em cada passo do processo.</p>
        <div style="display: flex; gap: 20px; justify-content: center; flex-wrap: wrap;">
            <a href="mailto:apoio@arrendaseguro.ao" class="btn-white">
                <i data-lucide="mail"></i> Enviar Email
            </a>
            <a href="https://wa.me/244900000000" target="_blank" class="btn-outline-light">
                <i data-lucide="message-circle"></i> WhatsApp
            </a>
            <a href="/signup" class="btn-outline-light">
                <i data-lucide="user-plus"></i> Criar Conta Grátis
            </a>
        </div>
    </div>

    <div class="page-footer" style="padding: 60px 0; border-top: 1px solid var(--slate-100); margin-top: 40px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 40px;">
        <div class="logo">
            <img src="/img/logo.png" alt="CasaSegura" style="height: 48px;">
        </div>
        <nav style="display:flex; gap:32px; flex-wrap:wrap;">
            <a href="/comprar" style="color:var(--slate-600); text-decoration:none; font-weight: 600;">Comprar</a>
            <a href="/alugar" style="color:var(--slate-600); text-decoration:none; font-weight: 600;">Arrendar</a>
            <a href="/vender" style="color:var(--slate-600); text-decoration:none; font-weight: 600;">Vender</a>
            <a href="/sobre" style="color:var(--slate-600); text-decoration:none; font-weight: 600;">Sobre</a>
        </nav>
        <p style="color: var(--slate-400); font-size: 0.9rem; font-weight: 500;">© <?= date('Y') ?> CasaSegura Angola. Todos os direitos reservados.</p>
    </div>

<?= $this->endSection() ?>
