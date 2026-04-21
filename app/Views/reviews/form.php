<?= $this->extend('templates/main') ?>

<?= $this->section('title') ?>Avaliar Experiência<?= $this->endSection() ?>

<?= $this->section('styles') ?>
    .review-container {
        max-width: 680px;
        margin: 60px auto;
        padding-bottom: 100px;
    }

    .form-card {
        background: white;
        padding: 56px;
        border-radius: 48px;
        border: 1px solid var(--slate-100);
        box-shadow: var(--shadow-xl);
    }

    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
        gap: 16px;
        margin: 32px 0 48px;
    }

    .star-rating input {
        display: none;
    }

    .star-rating label {
        color: var(--slate-100);
        font-size: 3.5rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #fbbf24;
        filter: drop-shadow(0 0 10px rgba(251, 191, 36, 0.3));
        transform: scale(1.1);
    }

    .category-rating {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding: 24px;
        background: var(--slate-50);
        border-radius: 20px;
        border: 1px solid var(--slate-100);
        transition: all 0.3s;
    }

    .category-rating:hover {
        border-color: var(--primary-100);
        background: white;
        box-shadow: var(--shadow-md);
    }
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="review-container">
        <div class="form-card animate-fade-in">
            <header style="text-align: center; margin-bottom: 32px;">
                <h1 style="font-size: 1.75rem; font-weight: 800; color: var(--slate-900);">Avaliar Experiência</h1>
                <p style="color: var(--slate-500); margin-top: 8px;">A sua opinião ajuda a manter a comunidade CasaSegura honesta e eficiente.</p>
            </header>

            <form action="/review/submit/<?= $request['id'] ?>" method="POST">
                <?= csrf_field() ?>
                
                <h3 style="text-align: center; font-size: 0.8rem; font-weight: 800; color: var(--slate-400); text-transform: uppercase; letter-spacing: 2px; margin-bottom: 0;">Avaliação Geral</h3>
                <div class="star-rating">
                    <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="Excelente">★</label>
                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Muito bom">★</label>
                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Bom">★</label>
                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Razoável">★</label>
                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Fraco">★</label>
                </div>

                <div style="margin-bottom: 48px;">
                    <h3 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 24px; color: var(--slate-900); letter-spacing: -0.5px;">Critérios de Confiança</h3>
                    
                    <div class="category-rating">
                        <div>
                            <span style="font-weight: 800; display: block; color: var(--slate-900); margin-bottom: 4px;">Comunicação</span>
                            <small style="color: var(--slate-500); font-weight: 500;">Rapidez e clareza no contacto.</small>
                        </div>
                        <select name="rating_communication" class="input-modern" style="width: auto; padding: 10px 20px; margin-bottom: 0; font-size: 1.25rem;" required>
                            <option value="5">⭐⭐⭐⭐⭐</option>
                            <option value="4">⭐⭐⭐⭐</option>
                            <option value="3">⭐⭐⭐</option>
                            <option value="2">⭐⭐</option>
                            <option value="1">⭐</option>
                        </select>
                    </div>

                    <div class="category-rating">
                        <div>
                            <span style="font-weight: 800; display: block; color: var(--slate-900); margin-bottom: 4px;">Fiabilidade</span>
                            <small style="color: var(--slate-500); font-weight: 500;">Cumprimento integral do acordado.</small>
                        </div>
                        <select name="rating_trust" class="input-modern" style="width: auto; padding: 10px 20px; margin-bottom: 0; font-size: 1.25rem;" required>
                            <option value="5">⭐⭐⭐⭐⭐</option>
                            <option value="4">⭐⭐⭐⭐</option>
                            <option value="3">⭐⭐⭐</option>
                            <option value="2">⭐⭐</option>
                            <option value="1">⭐</option>
                        </select>
                    </div>

                    <div class="category-rating">
                        <div>
                            <span style="font-weight: 800; display: block; color: var(--slate-900); margin-bottom: 4px;">Veracidade</span>
                            <small style="color: var(--slate-500); font-weight: 500;">Fidelidade entre o anúncio e a realidade.</small>
                        </div>
                        <select name="rating_accuracy" class="input-modern" style="width: auto; padding: 10px 20px; margin-bottom: 0; font-size: 1.25rem;" required>
                            <option value="5">⭐⭐⭐⭐⭐</option>
                            <option value="4">⭐⭐⭐⭐</option>
                            <option value="3">⭐⭐⭐</option>
                            <option value="2">⭐⭐</option>
                            <option value="1">⭐</option>
                        </select>
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 32px;">
                    <label class="form-label" style="font-weight: 800; margin-bottom: 12px; display: block;">Comentário Detalhado</label>
                    <textarea name="comment" class="input-modern" rows="5" placeholder="Partilhe a sua experiência real..." required style="min-height: 120px;"></textarea>
                </div>

                <div style="background: var(--primary-50); padding: 24px; border-radius: 20px; margin-top: 32px; font-size: 0.95rem; color: var(--primary); font-weight: 600; display: flex; gap: 16px; border: 1px solid var(--primary-100);">
                    <i data-lucide="shield-check" style="width: 24px; height: 24px; flex-shrink: 0;"></i>
                    <span>Toda a informação será validada pelo sistema Anti-Burla para garantir selos de confiança ⭐ autênticos.</span>
                </div>

                <button type="submit" class="btn-primary" style="width: 100%; padding: 22px; font-size: 1.15rem; margin-top: 40px; font-weight: 900; border-radius: 20px; box-shadow: 0 10px 30px rgba(26, 86, 219, 0.2);">
                    Publicar Avaliação Certificada
                </button>
            </form>
        </div>
    </div>
<?= $this->endSection() ?>
