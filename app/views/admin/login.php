<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>Acceso al panel — ConArte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/admin.css">
</head>
<body class="login-pagina">

<main class="login-caja">
    <div class="text-center mb-4">
        <span class="login-logo"><img src="<?= BASE_URL ?>/assets/img/logo.jpeg" alt="ConArte Construcciones"></span>
        <h1 class="login-titulo">Panel de administración</h1>
        <p class="login-subtitulo">Ingresa con tu cuenta para continuar</p>
    </div>

    <?php if ($error): ?>
        <div class="alert alert-danger py-2" role="alert"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="<?= BASE_URL ?>/admin/login" method="POST" autocomplete="on">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf) ?>">

        <div class="mb-3">
            <label for="correo" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" required autofocus
                   value="<?= htmlspecialchars($correo) ?>">
        </div>

        <div class="mb-4">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="contrasena" name="contrasena" required>
        </div>

        <button type="submit" class="btn btn-panel w-100">Iniciar sesión</button>
    </form>

    <p class="text-center mt-4 mb-0"><a href="<?= BASE_URL ?>/" class="enlace-volver"><i class="bi bi-arrow-left"></i> Volver al sitio</a></p>
</main>

</body>
</html>
