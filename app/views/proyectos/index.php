<section class="seccion">
    <div class="container">
        <h1 class="seccion-titulo">Portafolio de proyectos</h1>

        <div class="filtros-categoria mb-4">
            <button class="btn active" data-id="">Todos</button>
            <?php foreach ($categorias as $categoria): ?>
                <button class="btn" data-id="<?= $categoria['id_categoria'] ?>">
                    <?= htmlspecialchars($categoria['nombre']) ?>
                </button>
            <?php endforeach; ?>
        </div>

        <div class="row g-4" id="lista-proyectos">
            <?php foreach ($proyectos as $proyecto): ?>
                <div class="col-md-6 col-lg-4 tarjeta-proyecto" data-categoria="<?= $proyecto['id_categoria'] ?>">
                    <div class="card-conarte">
                        <span class="badge-categoria"><?= htmlspecialchars($proyecto['categoria_nombre']) ?></span>
                        <h3><?= htmlspecialchars($proyecto['nombre']) ?></h3>
                        <p class="card-ubicacion mb-2">📍 <?= htmlspecialchars($proyecto['ubicacion']) ?></p>
                        <p><?= htmlspecialchars($proyecto['descripcion']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <p class="text-muted mt-3" id="mensaje-vacio" style="display:none;">No hay proyectos en esta categoría todavía.</p>
    </div>
</section>

<script>
// Filtro dinámico en el cliente (sin recargar la página), como pide el requerimiento funcional #2.
document.querySelectorAll('.filtros-categoria .btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.filtros-categoria .btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const idSeleccionado = btn.dataset.id;
        let visibles = 0;

        document.querySelectorAll('.tarjeta-proyecto').forEach(tarjeta => {
            const coincide = !idSeleccionado || tarjeta.dataset.categoria === idSeleccionado;
            tarjeta.style.display = coincide ? '' : 'none';
            if (coincide) visibles++;
        });

        document.getElementById('mensaje-vacio').style.display = visibles === 0 ? 'block' : 'none';
    });
});
</script>
