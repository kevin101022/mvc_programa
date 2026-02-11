<?php
/**
 * Vista: Editar Título de Programa (editar.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$titulo = $titulo ?? ['tibro_id' => 1, 'tibro_nombre' => 'Tecnólogo'];
$errores = $errores ?? [];
// --- Fin datos de prueba ---

$title = 'Editar Título';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Títulos', 'url' => 'index.php'],
    ['label' => 'Editar'],
];

include __DIR__ . '/../../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Editar Título</h1>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form id="formEditarTitulo" method="POST" action="" novalidate>
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" name="tibro_id" value="<?php echo htmlspecialchars($titulo['tibro_id']); ?>">

                    <div class="form-group">
                        <label for="tibro_nombre" class="form-label">
                            Nombre del Título <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="tibro_nombre"
                            name="tibro_nombre"
                            class="form-input <?php echo isset($errores['tibro_nombre']) ? 'input-error' : ''; ?>"
                            placeholder="Ej: Tecnólogo"
                            value="<?php echo htmlspecialchars($titulo['tibro_nombre']); ?>"
                            required
                            maxlength="45"
                        >
                        <div class="form-error <?php echo isset($errores['tibro_nombre']) ? 'visible' : ''; ?>" id="errorNombre">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['tibro_nombre'] ?? 'Este campo es obligatorio.'); ?></span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Actualizar Título
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<script>
    document.getElementById('formEditarTitulo').addEventListener('submit', function(e) {
        var input = document.getElementById('tibro_nombre');
        var errorDiv = document.getElementById('errorNombre');

        if (!input.value.trim()) {
            e.preventDefault();
            input.classList.add('input-error');
            errorDiv.classList.add('visible');
            input.focus();
        } else {
            input.classList.remove('input-error');
            errorDiv.classList.remove('visible');
        }
    });

    document.getElementById('tibro_nombre').addEventListener('input', function() {
        if (this.value.trim()) {
            this.classList.remove('input-error');
            document.getElementById('errorNombre').classList.remove('visible');
        }
    });
</script>

<?php include __DIR__ . '/../../layout/footer.php'; ?>
