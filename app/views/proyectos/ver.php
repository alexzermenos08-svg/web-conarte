<section class="hero-conarte" style="padding: 2.5rem 1.5rem;">
    <div class="container">
        <a class="enlace-hero" href="<?= BASE_URL ?>/proyectos"><i class="bi bi-arrow-left"></i> Portafolio</a>
        <h1 class="mt-3"><?= Html::e($proyecto['nombre']) ?></h1>
        <p class="lead mb-0">
            <span class="badge-categoria"><?= Html::e($proyecto['categoria_nombre']) ?></span>
            <?php if ($proyecto['ubicacion']): ?><span class="ms-2"><i class="bi bi-geo-alt"></i> <?= Html::e($proyecto['ubicacion']) ?></span><?php endif; ?>
            <?php if ($proyecto['fecha_proyecto']): ?><span class="ms-2"><i class="bi bi-calendar3"></i> <?= Html::e(Html::mesAnio($proyecto['fecha_proyecto'])) ?></span><?php endif; ?>
        </p>
    </div>
</section>

<section class="seccion">
    <div class="container">
        <?php if ($proyecto['descripcion']): ?>
            <p class="detalle-descripcion"><?= nl2br(Html::e($proyecto['descripcion'])) ?></p>
        <?php endif; ?>

        <?php if (!empty($imagenes)): ?>
            <h2 class="seccion-titulo mt-4">Galería</h2>
            <div class="row g-3">
                <?php foreach ($imagenes as $img): ?>
                    <div class="col-6 col-lg-4">
                        <a href="#" class="d-block" data-bs-toggle="modal" data-bs-target="#visor"
                           data-src="<?= BASE_URL . '/' . Html::e($img['ruta_archivo']) ?>" data-alt="<?= Html::e($img['texto_alt'] ?: $proyecto['nombre']) ?>">
                            <img class="galeria-publica" loading="lazy" src="<?= BASE_URL . '/' . Html::e($img['ruta_archivo']) ?>" alt="<?= Html::e($img['texto_alt'] ?: $proyecto['nombre']) ?>">
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="text-center mt-5">
            <p class="mb-2">¿Tienes un proyecto parecido en mente?</p>
            <a href="<?= BASE_URL ?>/contacto" class="btn btn-conarte">Contáctanos</a>
        </div>
    </div>
</section>

<?php if (!empty($imagenes)): ?>
<div class="modal fade visor" id="visor" tabindex="-1" aria-label="Foto ampliada" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content bg-transparent border-0">
            <div class="text-end"><button type="button" class="btn-close btn-close-white mb-2" data-bs-dismiss="modal" aria-label="Cerrar"></button></div>
            <img id="visorImagen" class="mx-auto" src="" alt="">
        </div>
    </div>
</div>
<script>
// Muestra la foto seleccionada en grande dentro de la ventana emergente.
document.getElementById('visor').addEventListener('show.bs.modal', function (evento) {
    var enlace = evento.relatedTarget;
    var img = document.getElementById('visorImagen');
    img.src = enlace.dataset.src;
    img.alt = enlace.dataset.alt;
});
</script>
<?php endif; ?>
