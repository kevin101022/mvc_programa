<?php
/**
 * Vista: Registrar Programa (crear.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$errores = $errores ?? [];
$old = $old ?? [];
$titulos = $titulos ?? [
    ['tibro_id' => 1, 'tibro_nombre' => 'Tecnólogo'],
    ['tibro_id' => 2, 'tibro_nombre' => 'Técnico'],
];
// --- Fin datos de prueba ---

$title = 'Registrar Programa';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Programas', 'url' => 'index.php'],
    ['label' => 'Registrar'],
];

include __DIR__ . '/../../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Registrar Programa</h1>
        </div>

        <div class="form-container">
            <div class="form-card">
                <form id="formCrearProg" method="POST" action="" novalidate>
                    <input type="hidden" name="action" value="create">

                    <div class="form-group">
                        <label for="prog_codigo" class="form-label">
                            Código del Programa <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="prog_codigo"
                            name="prog_codigo"
                            class="form-input <?php echo isset($errores['prog_codigo']) ? 'input-error' : ''; ?>"
                            placeholder="Ej: 228106"
                            value="<?php echo htmlspecialchars($old['prog_codigo'] ?? ''); ?>"
                            required
                            maxlength="20"
                        >
                        <div class="form-error <?php echo isset($errores['prog_codigo']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['prog_codigo'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="prog_denominacion" class="form-label">
                            Denominación <span class="required">*</span>
                        </label>
                        <input
                            type="text"
                            id="prog_denominacion"
                            name="prog_denominacion"
                            class="form-input <?php echo isset($errores['prog_denominacion']) ? 'input-error' : ''; ?>"
                            placeholder="Ej: Análisis y Desarrollo de Software"
                            value="<?php echo htmlspecialchars($old['prog_denominacion'] ?? ''); ?>"
                            required
                            maxlength="200"
                        >
                        <div class="form-error <?php echo isset($errores['prog_denominacion']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['prog_denominacion'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="prog_tipo" class="form-label">
                            Tipo de Formación <span class="required">*</span>
                        </label>
                        <select
                            id="prog_tipo"
                            name="prog_tipo"
                            class="form-input <?php echo isset($errores['prog_tipo']) ? 'input-error' : ''; ?>"
                            required
                        >
                            <option value="">Seleccione...</option>
                            <option value="Titulada" <?php echo(isset($old['prog_tipo']) && $old['prog_tipo'] == 'Titulada') ? 'selected' : ''; ?>>Titulada</option>
                            <option value="Complementaria" <?php echo(isset($old['prog_tipo']) && $old['prog_tipo'] == 'Complementaria') ? 'selected' : ''; ?>>Complementaria</option>
                        </select>
                        <div class="form-error <?php echo isset($errores['prog_tipo']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['prog_tipo'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="TIT_PROGRAMA_tibro_id" class="form-label">
                            Nivel de Formación <span class="required">*</span>
                        </label>
                        <select
                            id="TIT_PROGRAMA_tibro_id"
                            name="TIT_PROGRAMA_tibro_id"
                            class="form-input <?php echo isset($errores['TIT_PROGRAMA_tibro_id']) ? 'input-error' : ''; ?>"
                            required
                        >
                            <option value="">Seleccione...</option>
                            <?php foreach ($titulos as $titulo): ?>
                                <option
                                    value="<?php echo $titulo['tibro_id']; ?>"
                                    <?php echo(isset($old['TIT_PROGRAMA_tibro_id']) && $old['TIT_PROGRAMA_tibro_id'] == $titulo['tibro_id']) ? 'selected' : ''; ?>
                                >
                                    <?php echo htmlspecialchars($titulo['tibro_nombre']); ?>
                                </option>
                            <?php
endforeach; ?>
                        </select>
                         <div class="form-error <?php echo isset($errores['TIT_PROGRAMA_tibro_id']) ? 'visible' : ''; ?>">
                            <i data-lucide="alert-circle"></i>
                            <span><?php echo htmlspecialchars($errores['TIT_PROGRAMA_tibro_id'] ?? 'Requerido.'); ?></span>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="save"></i>
                            Guardar Programa
                        </button>
                        <a href="index.php" class="btn btn-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

<?php include __DIR__ . '/../../layout/footer.php'; ?>
