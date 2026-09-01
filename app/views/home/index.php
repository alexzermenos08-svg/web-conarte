<div class="container py-5">
    <h1>ConArte Construcciones</h1>
    <p class="text-muted">Estructura MVC funcionando y conectada a la base de datos.</p>

    <h2 class="h4 mt-4">Categorías (<?= count($categorias) ?>)</h2>
    <ul>
        <?php foreach ($categorias as $categoria): ?>
            <li><?= htmlspecialchars($categoria['nombre']) ?></li>
        <?php endforeach; ?>
    </ul>

    <h2 class="h4 mt-4">Proyectos destacados (<?= count($proyectosDestacados) ?>)</h2>
    <?php if (empty($proyectosDestacados)): ?>
        <p class="text-muted">Aún no hay proyectos marcados como destacados en la base de datos.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($proyectosDestacados as $proyecto): ?>
                <li><?= htmlspecialchars($proyecto['nombre']) ?> — <?= htmlspecialchars($proyecto['categoria_nombre']) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>
