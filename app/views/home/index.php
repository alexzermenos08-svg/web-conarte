<section class="hero-conarte">
    <div class="container">
        <h1>Construyendo un Mañana Sustentable</h1>
        <p class="lead">Empresa 100% mexicana de origen colimense, dedicada a proyectar y construir obras de infraestructura urbana y vivienda residencial desde 1998.</p>
        <a href="<?= BASE_URL ?>/proyectos" class="btn btn-oliva">Ver portafolio de proyectos</a>
    </div>
</section>

<section class="seccion seccion-alterna">
    <div class="container">
        <h2 class="seccion-titulo">Áreas de trabajo</h2>
        <div class="row g-3">
            <?php foreach ($categorias as $categoria): ?>
                <div class="col-md-4 col-lg-2">
                    <div class="card-conarte text-center">
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
                            <p class="card-ubicacion mb-2">📍 <?= htmlspecialchars($proyecto['ubicacion']) ?></p>
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
