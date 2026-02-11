<?php
/**
 * Vista: Detalle de Sede (ver.php)
 *
 * Variables esperadas del controlador:
 *   $sede — Array con datos de la sede ['sede_id' => 1, 'sede_nombre' => '...']
 *   $rol  — 'coordinador' | 'instructor'
 */

// --- Datos de prueba (eliminar cuando el controlador los proporcione) ---
$rol = $rol ?? 'coordinador';
$sede = $sede ?? ['sede_id' => 1, 'sede_nombre' => 'Centro de Gestión Industrial'];
// --- Fin datos de prueba ---

$title = 'Detalle de Sede';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Sedes', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../layout/header.php';
?>

        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">Detalle de Sede</h1>
        </div>

        <!-- Detail Card -->
        <div class="detail-card">
            <div class="detail-card-body">
                <div class="detail-row">
                    <div class="detail-label">ID de la Sede</div>
                    <div class="detail-value"><?php echo htmlspecialchars($sede['sede_id']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Nombre de la Sede</div>
                    <div class="detail-value"><?php echo htmlspecialchars($sede['sede_nombre']); ?></div>
                </div>
            </div>
            <div class="detail-card-footer">
                <a href="index.php" class="btn btn-secondary">
                    <i data-lucide="arrow-left"></i>
                    Volver al Listado
                </a>
            </div>
        </div>

<?php include __DIR__ . '/../layout/footer.php'; ?>
