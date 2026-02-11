<?php
/**
 * Vista: Detalle de Instructor (ver.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$instructor = $instructor ?? ['inst_id' => 1, 'inst_nombre' => 'Juan', 'inst_apellidos' => 'Pérez', 'inst_correo' => 'juan@sena.edu.co', 'inst_telefono' => '3001234567'];
// --- Fin datos de prueba ---

$title = 'Detalle de Instructor';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Instructores', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Detalle de Instructor</h1>
        </div>

        <div class="detail-card">
            <div class="detail-card-body">
                <div class="detail-row">
                    <div class="detail-label">ID</div>
                    <div class="detail-value"><?php echo htmlspecialchars($instructor['inst_id']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Nombres</div>
                    <div class="detail-value"><?php echo htmlspecialchars($instructor['inst_nombre']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Apellidos</div>
                    <div class="detail-value"><?php echo htmlspecialchars($instructor['inst_apellidos']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Correo</div>
                    <div class="detail-value"><?php echo htmlspecialchars($instructor['inst_correo']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Teléfono</div>
                    <div class="detail-value"><?php echo htmlspecialchars($instructor['inst_telefono']); ?></div>
                </div>
            </div>
            <div class="detail-card-footer">
                <a href="index.php" class="btn btn-secondary">
                    <i data-lucide="arrow-left"></i>
                    Volver al Listado
                </a>
            </div>
        </div>

<?php include __DIR__ . '/../../layout/footer.php'; ?>
