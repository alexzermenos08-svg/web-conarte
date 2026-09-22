<section class="hero-conarte" style="padding: 3rem 1.5rem;">
    <div class="container">
        <h1>Contacto</h1>
        <p class="lead">¿Tienes un proyecto en mente? Escríbenos y un asesor te responderá a la brevedad.</p>
    </div>
</section>

<section class="seccion">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-5">
                <h2 class="seccion-titulo" style="font-size:1.4rem;">Información de contacto</h2>

                <div class="info-contacto-item">
                    <div>
                        <strong>Dirección</strong>
                        Calzada Pedro Galván No. 68, Col. Centro, Colima, Col. C.P. 28000
                    </div>
                </div>
                <div class="info-contacto-item">
                    <div>
                        <strong>Teléfono</strong>
                        +52 312 330 4976
                    </div>
                </div>
                <div class="info-contacto-item">
                    <div>
                        <strong>Correo</strong>
                        <a href="mailto:contacto@conarte.net">contacto@conarte.net</a>
                    </div>
                </div>
            </div>

            <div class="col-md-7">
                <?php if ($enviado): ?>
                    <div class="alert-conarte-exito">
                        ¡Gracias! Tu mensaje fue enviado correctamente. Un asesor de ConArte se pondrá en contacto contigo pronto.
                    </div>
                <?php else: ?>
                    <?php if (!empty($errores)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errores as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= BASE_URL ?>/contacto/enviar" method="POST" class="form-conarte">
                        <div class="mb-3">
                            <label for="nombre">Nombre completo</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required
                                   value="<?= htmlspecialchars($_POST['nombre'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="correo">Correo electrónico</label>
                            <input type="email" class="form-control" id="correo" name="correo" required
                                   value="<?= htmlspecialchars($_POST['correo'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label for="telefono">Teléfono (opcional)</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono"
                                   value="<?= htmlspecialchars($_POST['telefono'] ?? '') ?>">
                        </div>
                        <div class="mb-4">
                            <label for="mensaje">Mensaje</label>
                            <textarea class="form-control" id="mensaje" name="mensaje" rows="4" required><?= htmlspecialchars($_POST['mensaje'] ?? '') ?></textarea>
                        </div>
                        <button type="submit" class="btn-conarte">Enviar mensaje</button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
