<div class="container py-5">
    <h1>Portafolio de proyectos</h1>

    <div class="mb-4">
        <button class="btn btn-outline-dark btn-sm filtro-categoria" data-id="">Todos</button>
        <?php foreach ($categorias as $categoria): ?>
            <button class="btn btn-outline-dark btn-sm filtro-categoria" data-id="<?= $categoria['id_categoria'] ?>">
                <?= htmlspecialchars($categoria['nombre']) ?>
            </button>
        <?php endforeach; ?>
    </div>

    <div class="row" id="lista-proyectos">
        <?php foreach ($proyectos as $proyecto): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($proyecto['nombre']) ?></h5>
                        <p class="card-subtitle text-muted mb-2"><?= htmlspecialchars($proyecto['categoria_nombre']) ?></p>
                        <p class="card-text"><?= htmlspecialchars($proyecto['descripcion'] ?? '') ?></p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
// Ejemplo mínimo de filtro dinámico llamando al endpoint ProyectosController::porCategoria
document.querySelectorAll('.filtro-categoria').forEach(btn => {
    btn.addEventListener('click', async () => {
        const id = btn.dataset.id;
        const url = id ? `/proyectos/porCategoria/${id}` : '/proyectos';
        // Aquí iría la llamada fetch real y el renderizado dinámico de tarjetas
        console.log('Filtrar por categoría:', id || 'todas', url);
    });
});
</script>
