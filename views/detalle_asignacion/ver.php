<?php
/**
 * Vista: Detalle de Horario (ver.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$detalle = $detalle ?? ['detasig_id' => 1, 'ASIGNACION_asig_id' => 1, 'detasig_hora_ini' => '08:00', 'detasig_hora_fin' => '12:00'];
// --- Fin datos de prueba ---

$title = 'Detalle de Horario';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Detalles', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Detalle de Horario</h1>
        </div>

        <div class="detail-card">
            <div class="detail-card-body">
                <div class="detail-row">
                    <div class="detail-label">ID Detalle</div>
                    <div class="detail-value"><?php echo htmlspecialchars($detalle['detasig_id']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">ID Asignación</div>
                    <div class="detail-value"><?php echo htmlspecialchars($detalle['ASIGNACION_asig_id']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Hora Inicio</div>
                    <div class="detail-value"><?php echo htmlspecialchars($detalle['detasig_hora_ini']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Hora Fin</div>
                    <div class="detail-value"><?php echo htmlspecialchars($detalle['detasig_hora_fin']); ?></div>
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
