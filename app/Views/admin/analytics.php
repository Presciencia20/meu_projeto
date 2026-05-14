<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Analytics Avançado - CasaSegura Admin<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="/css/admin.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
    .analytics-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        margin-top: 2rem;
    }
    .chart-card {
        background: white;
        padding: 2rem;
        border-radius: 24px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        border: 1px solid #f1f5f9;
        min-height: 400px;
    }
    .kpi-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    .kpi-card {
        background: var(--app-primary);
        color: white;
        padding: 1.5rem;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    .kpi-card::after {
        content: '';
        position: absolute;
        right: -20px;
        top: -20px;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="admin-layout">
    <?= $this->include('templates/admin_sidebar') ?>

    <main class="admin-main">
        <header class="admin-header">
            <h1 style="font-weight: 900; font-family: 'Outfit';">📊 Analytics Detalhado</h1>
            <p style="color: var(--gray-500);">Acompanhe o crescimento e a saúde da plataforma.</p>
        </header>

        <div class="kpi-row">
            <div class="kpi-card" style="background: linear-gradient(135deg, #10b981, #059669);">
                <div style="font-size: 0.8rem; opacity: 0.8;">Receita Total Estimada</div>
                <div style="font-size: 2rem; font-weight: 800; font-family: 'Outfit';">Kz <?= number_format($totalRevenue, 0, ',', '.') ?></div>
            </div>
            <div class="kpi-card" style="background: linear-gradient(135deg, #6366f1, #4f46e5);">
                <div style="font-size: 0.8rem; opacity: 0.8;">Crescimento Mensal</div>
                <div style="font-size: 2rem; font-weight: 800; font-family: 'Outfit';">+15.4%</div>
            </div>
            <div class="kpi-card" style="background: linear-gradient(135deg, #f59e0b, #d97706);">
                <div style="font-size: 0.8rem; opacity: 0.8;">Taxa de Conversão</div>
                <div style="font-size: 2rem; font-weight: 800; font-family: 'Outfit';">4.2%</div>
            </div>
        </div>

        <div class="analytics-grid">
            <div class="chart-card">
                <h3 style="margin-bottom: 2rem; font-weight: 700;">Tendência de Novos Registros</h3>
                <canvas id="registrationChart"></canvas>
            </div>
            <div class="chart-card">
                <h3 style="margin-bottom: 2rem; font-weight: 700;">Distribuição de Imóveis</h3>
                <canvas id="propertyDistChart"></canvas>
            </div>
        </div>
    </main>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Registration Chart
    const regCtx = document.getElementById('registrationChart').getContext('2d');
    new Chart(regCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode(array_column($registrationTrend, 'date')) ?>,
            datasets: [{
                label: 'Novos Usuários',
                data: <?= json_encode(array_column($registrationTrend, 'total')) ?>,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { display: false } },
                x: { grid: { display: false } }
            }
        }
    });

    // Property Distribution Chart
    const distCtx = document.getElementById('propertyDistChart').getContext('2d');
    new Chart(distCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode(array_column($propertyStatusDist, 'status')) ?>,
            datasets: [{
                data: <?= json_encode(array_column($propertyStatusDist, 'total')) ?>,
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444', '#6366f1'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            },
            cutout: '70%'
        }
    });
</script>
<?= $this->endSection() ?>
