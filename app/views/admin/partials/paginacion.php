<?php
// Variables: $pagina, $paginas, $rutaBase (ej. '/admin/proyectos'), $consulta (array con los demás filtros de la URL)
if ($paginas > 1):
    $enlace = function (int $n) use ($rutaBase, $consulta) {
        return BASE_URL . $rutaBase . '?' . http_build_query($consulta + ['pagina' => $n]);
    };
?>
<nav aria-label="Paginación">
    <ul class="pagination pagination-sm justify-content-center mb-0 mt-3">
        <li class="page-item <?= $pagina <= 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $enlace(max(1, $pagina - 1)) ?>">Anterior</a>
        </li>
        <?php for ($i = 1; $i <= $paginas; $i++): ?>
            <li class="page-item <?= $i === $pagina ? 'active' : '' ?>">
                <a class="page-link" href="<?= $enlace($i) ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
        <li class="page-item <?= $pagina >= $paginas ? 'disabled' : '' ?>">
            <a class="page-link" href="<?= $enlace(min($paginas, $pagina + 1)) ?>">Siguiente</a>
        </li>
    </ul>
</nav>
<?php endif; ?>
