<?php if (!empty($carrusel)): ?>
<section class="hero-carrusel">
    <div id="carruselHero" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="4000">
        <div class="carousel-indicators">
            <?php foreach ($carrusel as $i => $img): ?>
                <button type="button" data-bs-target="#carruselHero" data-bs-slide-to="<?= $i ?>" class="<?= $i === 0 ? 'active' : '' ?>" aria-label="Imagen <?= $i + 1 ?>"></button>
            <?php endforeach; ?>
        </div>
        <div class="carousel-inner">
            <?php foreach ($carrusel as $i => $img): ?>
                <div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars(ltrim($img['ruta_archivo'], '/')) ?>"
                         alt="<?= htmlspecialchars($img['texto_alt'] ?? 'Obra de ConArte Construcciones') ?>">
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="hero-overlay">
        <div class="container">
            <h1>Construyendo un Mañana Sustentable</h1>
            <p class="lead">Empresa 100% mexicana de origen colimense, dedicada a proyectar y construir obras de infraestructura urbana y vivienda residencial desde 1998.</p>
            <a href="<?= BASE_URL ?>/proyectos" class="btn btn-oliva">Ver portafolio de proyectos</a>
        </div>
    </div>
</section>
<?php else: ?>
<section class="hero-conarte">
    <div class="container">
        <h1>Construyendo un Mañana Sustentable</h1>
        <p class="lead">Empresa 100% mexicana de origen colimense, dedicada a proyectar y construir obras de infraestructura urbana y vivienda residencial desde 1998.</p>
        <a href="<?= BASE_URL ?>/proyectos" class="btn btn-oliva">Ver portafolio de proyectos</a>
    </div>
</section>
<?php endif; ?>

<section class="seccion seccion-alterna">
    <div class="container">
        <h2 class="seccion-titulo">Género arquitectónico</h2>
        <div class="row g-3">
            <?php foreach ($categorias as $categoria): ?>
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="card-conarte text-center<?= $categoria['nombre'] === 'Obras en proceso' ? ' card-nueva' : '' ?>">
                        <h5><?= htmlspecialchars($categoria['nombre']) ?></h5>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="seccion">
    <div class="container">
        <h2 class="seccion-titulo">Proyectos destacados</h2>
        <?php if (empty($proyectosDestacados)): ?>
            <p class="text-muted">Aún no hay proyectos marcados como destacados.</p>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($proyectosDestacados as $proyecto): ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card-conarte">
                            <span class="badge-categoria"><?= htmlspecialchars($proyecto['categoria_nombre']) ?></span>
                            <h3><?= htmlspecialchars($proyecto['nombre']) ?></h3>
                            <p class="card-ubicacion mb-2"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($proyecto['ubicacion']) ?></p>
                            <p><?= htmlspecialchars($proyecto['descripcion']) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <div class="text-center mt-4">
            <a href="<?= BASE_URL ?>/proyectos" class="btn btn-conarte">Ver todo el portafolio</a>
        </div>
    </div>
</section>

<section class="banda-cta fondo-plano">
    <div class="container d-flex flex-wrap align-items-center justify-content-between gap-4">
        <div>
            <h2>¿Tienes un proyecto en mente?</h2>
            <a href="<?= BASE_URL ?>/contacto" class="btn btn-oliva">Contáctanos</a>
        </div>
        <svg width="260" height="96" viewBox="0 0 220 80" fill="none" stroke="#6B8190" stroke-width="1" aria-hidden="true">
            <line x1="4" y1="72" x2="216" y2="72"/>
            <rect x="14" y="34" width="38" height="38"/>
            <rect x="52" y="14" width="46" height="58"/>
            <line x1="98" y1="14" x2="150" y2="34"/>
            <line x1="150" y1="34" x2="150" y2="72"/>
            <line x1="98" y1="14" x2="98" y2="72"/>
            <rect x="60" y="24" width="8" height="8"/><rect x="76" y="24" width="8" height="8"/>
            <rect x="60" y="42" width="8" height="8"/><rect x="76" y="42" width="8" height="8"/>
            <line x1="162" y1="72" x2="162" y2="40"/>
            <line x1="162" y1="40" x2="206" y2="40"/>
            <line x1="206" y1="40" x2="206" y2="72"/>
            <line x1="14" y1="78" x2="206" y2="78" stroke-dasharray="3 3"/>
        </svg>
    </div>
</section>
