<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Casas Perto de Mim | CasaSegura<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    .near-shell {
        min-height: 600px;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    /* Map view occupies full space - CRITICAL: Must have height */
    #map-view {
        height: 600px;
        width: 100%;
        border-radius: 28px;
        overflow: hidden;
        margin-bottom: 24px;
        z-index: 1;
        background: #f1f5f9; /* Skeleton background */
        border: 1px solid var(--gray-100);
    }

    /* Floating Toggle */
    .view-toggle {
        position: absolute;
        bottom: 40px;
        left: 50%;
        transform: translateX(-50%);
        background: var(--app-secondary);
        color: white;
        padding: 12px 24px;
        border-radius: 50px;
        display: flex;
        gap: 16px;
        font-weight: 800;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        z-index: 1000;
        cursor: pointer;
    }

    .view-toggle span { opacity: 0.5; transition: 0.2s; }
    .view-toggle span.active { opacity: 1; color: var(--app-primary); }

    /* List view (hidden by default) */
    #list-view {
        display: none;
        flex: 1;
        overflow-y: auto;
        padding-bottom: 100px;
    }

    #list-view.active { display: block; }

    /* Radius Chips */
    .radius-nav {
        display: flex;
        gap: 10px;
        padding: 10px 0 24px;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .chip {
        white-space: nowrap;
        padding: 8px 18px;
        background: white;
        border: 1px solid var(--gray-100);
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 800;
        color: var(--gray-500);
        cursor: pointer;
        transition: 0.2s;
    }

    .chip.active {
        background: var(--app-primary);
        color: white;
        border-color: var(--app-primary);
    }

    /* GPS Banner */
    #gps-banner {
        background: #eef2ff;
        padding: 20px;
        border-radius: 20px;
        margin-bottom: 20px;
        text-align: center;
        border: 1px dashed #6366f150;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="near-shell">
    <div style="padding: 0 4px;">
        <h1 style="font-family: 'Outfit'; font-weight: 900; font-size: 1.8rem; color: var(--gray-800); margin-bottom: 4px;">Perto de mim</h1>
        <p style="color: var(--gray-400); font-weight: 600; font-size: 0.9rem; margin-bottom: 12px;">Encontre o imóvel ideal na sua vizinhança.</p>
    </div>

    <!-- Radius Filters -->
    <div class="radius-nav" id="radius-chips">
        <div class="chip active" data-radius="0.5">500m</div>
        <div class="chip" data-radius="1">1km</div>
        <div class="chip" data-radius="5">5km</div>
        <div class="chip" data-radius="20">20km</div>
        <div class="chip" data-radius="100">Angola</div>
    </div>

    <!-- GPS Activation placeholder -->
    <div id="gps-banner">
        <i class="ph-duotone ph-navigation-arrow" style="font-size: 2rem; color: #6366f1; margin-bottom: 10px; display: block;"></i>
        <h4 style="font-family: 'Outfit'; margin-bottom: 4px;">Ativar Localização?</h4>
        <p style="font-size: 0.85rem; color: #4338ca; margin-bottom: 16px;">Precisamos do seu GPS para mostrar imóveis ao seu redor.</p>
        <button class="btn btn-primary" onclick="startProximity()" style="width: auto; padding: 0 32px; height: 48px; border-radius: 12px;">Ativar Agora</button>
    </div>

    <!-- Main Views -->
    <div id="map-view"></div>
    
    <div id="list-view">
        <div id="property-list" class="app-grid">
            <!-- Dynamic items here -->
        </div>
    </div>

    <!-- Toggle Button -->
    <div class="view-toggle" id="mode-toggle" style="display: none;">
        <span id="label-map" class="active"><i class="ph-bold ph-map-trifold"></i> Mapa</span>
        <div style="width: 1px; background: rgba(255,255,255,0.2);"></div>
        <span id="label-list"><i class="ph-bold ph-list-bullets"></i> Lista</span>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    let userLat, userLng;
    let currentRadius = 0.5;
    let map, propertyMarkers = [];
    let isMapView = true;

    document.addEventListener('DOMContentLoaded', () => {
        initMap(); // Init default Luanda
    });

    function startProximity() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                userLat = position.coords.latitude;
                userLng = position.coords.longitude;
                
                document.getElementById('gps-banner').style.display = 'none';
                document.getElementById('mode-toggle').style.display = 'flex';
                
                // Recenter map on user
                map.setView([userLat, userLng], 15);
                L.circle([userLat, userLng], {
                    radius: 50, color: '#2563eb', fillColor: '#60a5fa', fillOpacity: 0.5
                }).addTo(map).bindPopup("Você está aqui");

                fetchData();
            }, () => {
                alert('⚠️ Não foi possível obter sua localização. Verifique as permissões do navegador.');
            });
        }
    }

    function initMap() {
        if (map) return;
        // Default Luanda Center
        map = L.map('map-view').setView([-8.839, 13.289], 12);
        
        const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        });

        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            attribution: 'Tiles &copy; Esri'
        });

        satelliteLayer.addTo(map); // Default Real Map

        L.control.layers({
            "Rua": streetLayer,
            "Satélite (Real)": satelliteLayer
        }).addTo(map);
    }

    async function fetchData() {
        const url = '<?= site_url('api/near-me') ?>?lat=' + userLat + '&lng=' + userLng + '&radius=' + currentRadius;
        const res = await fetch(url);
        const data = await res.json();
        
        renderMapItems(data);
        renderListItems(data);
    }

    function renderMapItems(items) {
        // Clear old markers
        propertyMarkers.forEach(m => map.removeLayer(m));
        propertyMarkers = [];

        items.forEach(h => {
            const marker = L.marker([h.latitude, h.longitude]).addTo(map);
            marker.bindPopup(`
                <div style="font-family: 'Outfit'; min-width: 150px;">
                    <img src="${JSON.parse(h.images)[0] || '/img/placeholder-house.jpg'}" style="width: 100%; height: 80px; object-fit: cover; border-radius: 8px; margin-bottom: 8px;">
                    <strong style="display: block; font-size: 1rem; color: var(--app-primary);">${new Intl.NumberFormat('pt-AO').format(h.price)} KZ</strong>
                    <div style="font-weight: 700; font-size: 0.85rem;">${h.title}</div>
                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 4px;">À ${h.distance.toFixed(2)} km de você</div>
                    <a href="/property/${h.id}" style="display: block; margin-top: 10px; color: #2563eb; font-weight: 800; text-decoration: none; font-size: 0.8rem;">Ver Detalhes →</a>
                </div>
            `);
            propertyMarkers.push(marker);
        });

        // Fit map bounds if items exist
        if (items.length > 0) {
            const group = new L.featureGroup(propertyMarkers);
            map.fitBounds(group.getBounds().pad(0.1));
        }
    }

    function renderListItems(items) {
        const listDiv = document.getElementById('property-list');
        listDiv.innerHTML = '';

        if (items.length === 0) {
            listDiv.innerHTML = '<div style="grid-column: 1/-1; text-align: center; padding: 40px; color: var(--gray-400);">Nenhum imóvel encontrado neste raio.</div>';
            return;
        }

        items.forEach(h => {
            const img = JSON.parse(h.images)[0] || '/img/placeholder-house.jpg';
            listDiv.innerHTML += `
                <a href="/property/${h.id}" class="property-card">
                    <div class="property-card-img">
                        <img src="${img}">
                        <div class="property-card-badge" style="background: var(--app-secondary); color: white;">
                            <i class="ph-fill ph-map-pin"></i> ${h.distance.toFixed(1)} km
                        </div>
                    </div>
                    <div class="property-card-content">
                        <div class="property-card-price">${new Intl.NumberFormat('pt-AO').format(h.price)} <small>KZ</small></div>
                        <h3 class="property-card-title">${h.title}</h3>
                        <div class="property-card-location"><i class="ph-bold ph-map-pin"></i> ${h.neighborhood}</div>
                    </div>
                </a>
            `;
        });
    }

    // Radius UI Logic
    document.querySelectorAll('#radius-chips .chip').forEach(chip => {
        chip.onclick = () => {
            document.querySelectorAll('#radius-chips .chip').forEach(c => c.classList.remove('active'));
            chip.classList.add('active');
            currentRadius = parseFloat(chip.dataset.radius);
            if (userLat) fetchData();
        };
    });

    // Toggle Logic
    document.getElementById('mode-toggle').onclick = () => {
        isMapView = !isMapView;
        
        document.getElementById('map-view').style.display = isMapView ? 'block' : 'none';
        document.getElementById('list-view').classList.toggle('active', !isMapView);
        
        document.getElementById('label-map').classList.toggle('active', isMapView);
        document.getElementById('label-list').classList.toggle('active', !isMapView);
        
        if (isMapView && map) map.invalidateSize();
    };
</script>
<?= $this->endSection() ?>
