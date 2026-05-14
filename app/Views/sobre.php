<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Sobre o CasaSegura - Segurança Imobiliária em Angola<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    /* Hero Section */
    .about-hero {
        text-align: center;
        padding: 40px 0 30px;
        max-width: 800px;
        margin: 0 auto;
    }

    .about-hero h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 16px;
        line-height: 1.2;
    }

    .about-hero h1 span {
        color: #FF6B35;
    }

    .about-hero p {
        color: #666;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    /* Mission Section */
    .mission-section {
        background: linear-gradient(135deg, #FF6B35 0%, #E55A2B 100%);
        border-radius: 24px;
        padding: 50px 40px;
        margin: 40px 0;
        color: white;
    }

    .mission-grid {
        display: grid;
        grid-template-columns: 1.5fr 1fr;
        gap: 50px;
        align-items: center;
    }

    .mission-text .label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        opacity: 0.8;
        margin-bottom: 12px;
    }

    .mission-text h2 {
        font-size: 1.8rem;
        margin-bottom: 16px;
    }

    .mission-text p {
        opacity: 0.9;
        line-height: 1.6;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .stat-box {
        background: rgba(255,255,255,0.15);
        border-radius: 20px;
        padding: 25px 20px;
        text-align: center;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: 800;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 0.75rem;
        opacity: 0.8;
    }

    /* Story Section */
    .story-section {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 50px;
        margin: 60px 0;
        align-items: center;
    }

    .story-image {
        background: #f5f5f5;
        border-radius: 24px;
        overflow: hidden;
        aspect-ratio: 4/3;
    }

    .story-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .story-content .label {
        color: #FF6B35;
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 12px;
    }

    .story-content h2 {
        font-size: 1.8rem;
        margin-bottom: 20px;
    }

    .story-content p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 16px;
    }

    /* Values Section */
    .values-section {
        margin: 60px 0;
        text-align: center;
    }

    .values-section h2 {
        font-size: 2rem;
        margin-bottom: 12px;
    }

    .values-subtitle {
        color: #666;
        margin-bottom: 40px;
    }

    .values-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 25px;
    }

    .value-card {
        background: white;
        border: 1px solid #eee;
        border-radius: 20px;
        padding: 30px 25px;
        text-align: center;
        transition: all 0.2s;
    }

    .value-card:hover {
        transform: translateY(-5px);
        border-color: #FF6B35;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }

    .value-icon {
        width: 60px;
        height: 60px;
        background: #FFF0EB;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        color: #FF6B35;
    }

    .value-card h3 {
        font-size: 1.1rem;
        margin-bottom: 12px;
    }

    .value-card p {
        color: #888;
        font-size: 0.85rem;
        line-height: 1.5;
    }

    /* Timeline */
    .timeline-section {
        margin: 60px 0;
        text-align: center;
    }

    .timeline-section h2 {
        font-size: 2rem;
        margin-bottom: 12px;
    }

    .timeline {
        max-width: 700px;
        margin: 40px auto 0;
        position: relative;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 30px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #FF6B35;
    }

    .timeline-item {
        display: flex;
        gap: 25px;
        margin-bottom: 40px;
        text-align: left;
        position: relative;
    }

    .timeline-dot {
        width: 60px;
        height: 60px;
        background: white;
        border: 2px solid #FF6B35;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        color: #FF6B35;
        flex-shrink: 0;
        background: white;
    }

    .timeline-content {
        background: white;
        border: 1px solid #eee;
        border-radius: 20px;
        padding: 20px 25px;
        flex: 1;
    }

    .timeline-year {
        color: #FF6B35;
        font-weight: 700;
        font-size: 0.8rem;
        margin-bottom: 8px;
    }

    .timeline-content h3 {
        font-size: 1.1rem;
        margin-bottom: 8px;
    }

    .timeline-content p {
        color: #666;
        font-size: 0.85rem;
        line-height: 1.5;
    }

    /* FAQ Section */
    .faq-section {
        margin: 60px 0;
        text-align: center;
    }

    .faq-section h2 {
        font-size: 2rem;
        margin-bottom: 12px;
    }

    .faq-grid {
        max-width: 800px;
        margin: 40px auto 0;
        text-align: left;
    }

    .faq-item {
        background: white;
        border: 1px solid #eee;
        border-radius: 16px;
        margin-bottom: 12px;
        overflow: hidden;
    }

    .faq-question {
        width: 100%;
        padding: 18px 20px;
        text-align: left;
        font-weight: 600;
        background: white;
        border: none;
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: all 0.2s;
    }

    .faq-question:hover {
        background: #fafafa;
    }

    .faq-question i {
        transition: transform 0.2s;
        color: #FF6B35;
    }

    .faq-question.active i {
        transform: rotate(180deg);
    }

    .faq-answer {
        padding: 0 20px 20px;
        display: none;
        color: #666;
        line-height: 1.6;
        font-size: 0.9rem;
    }

    .faq-answer.show {
        display: block;
    }

    /* CTA Section */
    .cta-section {
        background: #1a1a2e;
        border-radius: 24px;
        padding: 50px 40px;
        text-align: center;
        margin: 60px 0;
        color: white;
    }

    .cta-section h2 {
        font-size: 1.8rem;
        margin-bottom: 12px;
    }

    .cta-section p {
        opacity: 0.8;
        margin-bottom: 30px;
    }

    .cta-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-cta-primary {
        background: #FF6B35;
        color: white;
        padding: 12px 28px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-cta-primary:hover {
        background: #E55A2B;
        transform: translateY(-2px);
    }

    .btn-cta-secondary {
        background: transparent;
        color: white;
        padding: 12px 28px;
        border-radius: 40px;
        text-decoration: none;
        font-weight: 600;
        border: 1px solid rgba(255,255,255,0.3);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s;
    }

    .btn-cta-secondary:hover {
        background: rgba(255,255,255,0.1);
    }

    /* Responsive */
    @media (max-width: 992px) {
        .mission-grid {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .story-section {
            grid-template-columns: 1fr;
        }
        .values-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .about-hero h1 {
            font-size: 1.8rem;
        }
        .mission-section {
            padding: 35px 25px;
        }
        .mission-text h2 {
            font-size: 1.4rem;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .values-grid {
            grid-template-columns: 1fr;
        }
        .timeline::before {
            left: 20px;
        }
        .timeline-dot {
            width: 40px;
            height: 40px;
            font-size: 0.8rem;
        }
        .cta-section {
            padding: 35px 25px;
        }
        .cta-section h2 {
            font-size: 1.4rem;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<section class="about-hero">
    <h1>Sobre o <span>CasaSegura</span></h1>
    <p>A primeira plataforma imobiliária angolana com segurança total em cada transação</p>
</section>

<!-- Mission Section -->
<div class="container">
    <div class="mission-section">
        <div class="mission-grid">
            <div class="mission-text">
                <div class="label">Nossa Missão</div>
                <h2>Eliminar as burlas imobiliárias em Angola</h2>
                <p>Milhares de famílias angolanas perdem as suas poupanças em negócios fraudulentos todos os anos. O CasaSegura nasceu para mudar essa realidade, combinando tecnologia de ponta com verificação rigorosa de identidade.</p>
            </div>
            <div class="stats-grid">
                <div class="stat-box">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Verificação Garantida</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">14</div>
                    <div class="stat-label">Províncias</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">24/7</div>
                    <div class="stat-label">Suporte</div>
                </div>
                <div class="stat-box">
                    <div class="stat-number">+0</div>
                    <div class="stat-label">Clientes Satisfeitos</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Story Section -->
<div class="container">
    <div class="story-section">
        <div class="story-image">
            <img src="/img/luanda-city.jpg" alt="Luanda, Angola" onerror="this.src='https://placehold.co/600x450/f5f5f5/cccccc?text=Luanda'">
        </div>
        <div class="story-content">
            <div class="label">Nossa História</div>
            <h2>Nascemos para proteger os angolanos</h2>
            <p>O CasaSegura é um projeto desenvolvido pela <strong>Prestech</strong> em 2026, com o objetivo de trazer segurança e transparência ao mercado imobiliário angolano.</p>
            <p>Ao observar os constantes desafios que famílias enfrentam ao procurar um lar - desde anúncios falsos até proprietários fraudulentos - decidimos criar uma solução tecnológica que protegesse ambas as partes.</p>
            <p>Hoje, somos a referência nacional para negócios imobiliários seguros, com verificação rigorosa e sistema de pagamento em custódia.</p>
        </div>
    </div>
</div>

<!-- Values Section -->
<div class="container">
    <div class="values-section">
        <h2>Os Nossos Valores</h2>
        <p class="values-subtitle">Princípios que guiam cada decisão</p>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon"><i data-lucide="shield-check"></i></div>
                <h3>Segurança</h3>
                <p>Protegemos o seu dinheiro e os seus dados em todas as transações</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i data-lucide="eye"></i></div>
                <h3>Transparência</h3>
                <p>Sem taxas escondidas. Você sabe exatamente o que está a pagar</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i data-lucide="heart"></i></div>
                <h3>Angolanidade</h3>
                <p>Feito por angolanos, para angolanos. Conhecemos o nosso mercado</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i data-lucide="zap"></i></div>
                <h3>Inovação</h3>
                <p>Tecnologia de ponta para resolver problemas reais</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i data-lucide="users"></i></div>
                <h3>Comunidade</h3>
                <p>Construímos uma rede de confiança entre angolanos</p>
            </div>
            <div class="value-card">
                <div class="value-icon"><i data-lucide="scale"></i></div>
                <h3>Justiça</h3>
                <p>Sistema de arbitragem justo para resolver disputas</p>
            </div>
        </div>
    </div>
</div>

<!-- Timeline Section -->
<div class="container">
    <div class="timeline-section">
        <h2>A Nossa Jornada</h2>
        <p class="values-subtitle">Como o CasaSegura se tornou realidade</p>
        <div class="timeline">
            <div class="timeline-item">
                <div class="timeline-dot">1</div>
                <div class="timeline-content">
                    <div class="timeline-year">2026 - INÍCIO</div>
                    <h3>O Desafio</h3>
                    <p>A Prestech identifica a necessidade de uma plataforma segura para negócios imobiliários em Angola</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot">2</div>
                <div class="timeline-content">
                    <div class="timeline-year">2026 - DESENVOLVIMENTO</div>
                    <h3>Criação da Solução</h3>
                    <p>Engenheiros e especialistas trabalham na construção de uma plataforma com verificação rigorosa e sistema de custódia</p>
                </div>
            </div>
            <div class="timeline-item">
                <div class="timeline-dot">3</div>
                <div class="timeline-content">
                    <div class="timeline-year">2026 - LANÇAMENTO</div>
                    <h3>CasaSegura no Mercado</h3>
                    <p>A plataforma é lançada oficialmente, oferecendo segurança total para compra, venda e arrendamento</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="container">
    <div class="faq-section">
        <h2>Perguntas Frequentes</h2>
        <p class="values-subtitle">Tire as suas dúvidas sobre o CasaSegura</p>
        <div class="faq-grid" id="faqGrid">
            <div class="faq-item">
                <button class="faq-question">
                    Como funciona a verificação de identidade?
                    <i data-lucide="chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Solicitamos o upload do seu BI e uma selfie. O nosso sistema verifica automaticamente a autenticidade dos documentos e a correspondência com a selfie. O processo leva menos de 24 horas.
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question">
                    O que é o sistema de pagamento em custódia?
                    <i data-lucide="chevron-down"></i>
                </button>
                <div class="faq-answer">
                    O valor do negócio fica retido na plataforma até que o comprador/inquilino confirme que está satisfeito com o imóvel. Só depois libertamos o pagamento ao vendedor/proprietário. Isto elimina completamente o risco de burla.
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question">
                    Os contratos têm validade legal em Angola?
                    <i data-lucide="chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Sim! Todos os contratos gerados pela plataforma seguem a legislação angolana e têm validade jurídica total. Pode assinar digitalmente com a mesma segurança de um contrato físico.
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question">
            Quanto custa usar o CasaSegura?
                    <i data-lucide="chevron-down"></i>
                </button>
                <div class="faq-answer">
                    O registo é gratuito. Para compradores e inquilinos, não há custos adicionais. Para vendedores e proprietários, cobramos uma comissão apenas quando o negócio é concluído com sucesso. Consulte a página "Vender" para mais detalhes.
                </div>
            </div>
            <div class="faq-item">
                <button class="faq-question">
                    Como denunciar um anúncio suspeito?
                    <i data-lucide="chevron-down"></i>
                </button>
                <div class="faq-answer">
                    Todos os anúncios têm um botão "Denunciar". Ao clicar, a nossa equipa analisa o caso em menos de 24 horas. Anúncios fraudulentos são removidos imediatamente e os responsáveis são banidos da plataforma.
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="container">
    <div class="cta-section">
        <h2>Ainda tem dúvidas? Fale connosco</h2>
        <p>A nossa equipa está disponível para ajudar em cada passo do processo</p>
        <div class="cta-buttons">
            <a href="/contacto" class="btn-cta-primary">
                <i data-lucide="mail"></i> Contactar Suporte
            </a>
            <a href="/signup" class="btn-cta-secondary">
                <i data-lucide="user-plus"></i> Criar Conta Grátis
            </a>
        </div>
    </div>
</div>

<script>
// FAQ Accordion
document.querySelectorAll('.faq-question').forEach(button => {
    button.addEventListener('click', () => {
        const faqItem = button.parentElement;
        const answer = button.nextElementSibling;
        const isActive = answer.classList.contains('show');
        
        // Fechar outros
        document.querySelectorAll('.faq-answer').forEach(a => {
            if (a !== answer) a.classList.remove('show');
        });
        document.querySelectorAll('.faq-question').forEach(btn => {
            if (btn !== button) btn.classList.remove('active');
        });
        
        // Alternar atual
        answer.classList.toggle('show');
        button.classList.toggle('active');
    });
});

// Inicializar ícones
document.addEventListener('DOMContentLoaded', () => {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>

<?= $this->endSection() ?>