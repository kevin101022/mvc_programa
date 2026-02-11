<?php
/**
 * Vista: Detalle de Asignación (ver.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$asignacion = $asignacion ?? [
    'asig_id' => 1,
    'fich_id' => '228106-1',
    'inst_nombre' => 'Juan Pérez',
    'amb_nombre' => 'Laboratorio 1',
    'comp_nombre_corto' => 'Promover salud',
    'asig_fecha_ini' => '2023-01-20',
    'asig_fecha_fin' => '2023-06-20'
];
// --- Fin datos de prueba ---

$title = 'Detalle de Asignación';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Asignaciones', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Detalle de Asignación</h1>
        </div>

        <div class="detail-card">
            <div class="detail-card-body">
                <div class="detail-row">
                    <div class="detail-label">ID Asignación</div>
                    <div class="detail-value"><?php echo htmlspecialchars($asignacion['asig_id']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Ficha</div>
                    <div class="detail-value"><?php echo htmlspecialchars($asignacion['fich_id']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Instructor</div>
                    <div class="detail-value"><?php echo htmlspecialchars($asignacion['inst_nombre']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Ambiente</div>
                    <div class="detail-value"><?php echo htmlspecialchars($asignacion['amb_nombre']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Competencia</div>
                    <div class="detail-value"><?php echo htmlspecialchars($asignacion['comp_nombre_corto']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Fecha Inicio</div>
                    <div class="detail-value"><?php echo htmlspecialchars($asignacion['asig_fecha_ini']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Fecha Fin</div>
                    <div class="detail-value"><?php echo htmlspecialchars($asignacion['asig_fecha_fin']); ?></div>
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
