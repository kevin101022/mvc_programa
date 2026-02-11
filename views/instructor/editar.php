<?php
/**
 * Vista: Editar Instructor (editar.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$instructor = $instructor ?? ['inst_id' => 1, 'inst_nombre' => 'Juan', 'inst_apellidos' => 'Pérez', 'inst_correo' => 'juan@sena.edu.co', 'inst_telefono' => '3001234567'];
$errores = $errores ?? [];
// --- Fin datos de prueba ---

$title = 'Editar Instructor';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Instructores', 'url' => 'index.php'],
    ['label' => 'Editar'],
];

include __DIR__ . '/../../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Editar Instructor</h1>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form id="formEditarInst" method="POST" action="" novalidate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="inst_id" value="<?php echo htmlspecialchars($instructor['inst_id']); ?>">

                    <div class="form-group">
                        <label for="inst_nombre" class="form-label">
                            Nombres <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="inst_nombre"
                            name="inst_nombre"
                            class="form-input <?php echo isset($errores['inst_nombre']) ? 'input-error' : ''; ?>"
                            value="<?php echo htmlspecialchars($instructor['inst_nombre']); ?>"
                            required
                            maxlength="45"
                        >
                        <div class="form-error <?php echo isset($errores['inst_nombre']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['inst_nombre'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inst_apellidos" class="form-label">
                            Apellidos <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="inst_apellidos"
                            name="inst_apellidos"
                            class="form-input <?php echo isset($errores['inst_apellidos']) ? 'input-error' : ''; ?>"
                            value="<?php echo htmlspecialchars($instructor['inst_apellidos']); ?>"
                            required
                            maxlength="45"
                        >
                        <div class="form-error <?php echo isset($errores['inst_apellidos']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['inst_apellidos'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inst_correo" class="form-label">
                            Correo Electrónico <span class="required">*</span>
                        </label>
                        <input
                            type="email"
                            id="inst_correo"
                            name="inst_correo"
                            class="form-input <?php echo isset($errores['inst_correo']) ? 'input-error' : ''; ?>"
                            value="<?php echo htmlspecialchars($instructor['inst_correo']); ?>"
                            required
                            maxlength="45"
                        >
                        <div class="form-error <?php echo isset($errores['inst_correo']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['inst_correo'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="inst_telefono" class="form-label">
                            Teléfono <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="inst_telefono"
                            name="inst_telefono"
                            class="form-input <?php echo isset($errores['inst_telefono']) ? 'input-error' : ''; ?>"
                            value="<?php echo htmlspecialchars($instructor['inst_telefono']); ?>"
                            required
                            maxlength="45"
                        >
                        <div class="form-error <?php echo isset($errores['inst_telefono']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['inst_telefono'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Actualizar Instructor
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<?php include __DIR__ . '/../../layout/footer.php'; ?>
