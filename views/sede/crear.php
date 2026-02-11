<?php
/**
 * Vista: Registrar Sede (crear.php)
 *
 * Variables esperadas del controlador:
 *   $rol      — 'coordinador' | 'instructor'
 *   $errores  — (Opcional) Array de errores ['sede_nombre' => 'El nombre es requerido']
 *   $old      — (Opcional) Datos anteriores para repoblar el formulario
 */

// --- Datos de prueba (eliminar cuando el controlador los proporcione) ---
$rol = $rol ?? 'coordinador';
$errores = $errores ?? [];
$old = $old ?? [];
// --- Fin datos de prueba ---

$title = 'Registrar Sede';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Sedes', 'url' => 'index.php'],
    ['label' => 'Registrar'],
];

include __DIR__ . '/../layout/header.php';
?>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Registrar Sede</h1>
        </div>

        <!-- Form -->
        <div class="form-container">
            <div class="form-card">
                <form id="formCrearSede" method="POST" action="" novalidate>
                    <input type="hidden" name="action" value="create">

                    <div class="form-group">
                        <label for="sede_nombre" class="form-label">
                            Nombre de la Sede <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="sede_nombre"
                            name="sede_nombre"
                            class="form-input <?php echo isset($errores['sede_nombre']) ? 'input-error' : ''; ?>"
                            placeholder="Ej: Centro de Gestión Industrial"
                            value="<?php echo htmlspecialchars($old['sede_nombre'] ?? ''); ?>"
                            required
                            maxlength="200"
                            autocomplete="off"
                        >
                        <div class="form-error <?php echo isset($errores['sede_nombre']) ? 'visible' : ''; ?>" id="errorNombre">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['sede_nombre'] ?? 'Este campo es obligatorio.'); ?></span>
                        </div>
                        <div class="form-hint">Ingrese el nombre completo de la sede académica.</div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Guardar Sede
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<script>
    // Client-side visual validation (real validation in controller)
    document.getElementById('formCrearSede').addEventListener('submit', function(e) {
        var input = document.getElementById('sede_nombre');
        var errorDiv = document.getElementById('errorNombre');
        var value = input.value.trim();

        if (!value) {
            e.preventDefault();
            input.classList.add('input-error');
            errorDiv.classList.add('visible');
            input.focus();
        } else {
            input.classList.remove('input-error');
            errorDiv.classList.remove('visible');
        }
    });

    // Remove error state on input
    document.getElementById('sede_nombre').addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('input-error');
            document.getElementById('errorNombre').classList.remove('visible');
        }
    });
</script>

<?php include __DIR__ . '/../layout/footer.php'; ?>
