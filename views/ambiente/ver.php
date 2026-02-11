<?php
/**
 * Vista: Detalle de Ambiente (ver.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$ambiente = $ambiente ?? ['id_ambiente' => 1, 'amb_nombre' => 'Laboratorio de Software 1', 'sede_nombre' => 'Centro de Gestión Industrial'];
// --- Fin datos de prueba ---

$title = 'Detalle de Ambiente';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Ambientes', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Detalle de Ambiente</h1>
        </div>

        <div class="detail-card">
            <div class="detail-card-body">
                <div class="detail-row">
                    <div class="detail-label">ID</div>
                    <div class="detail-value"><?php echo htmlspecialchars($ambiente['id_ambiente']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Nombre Ambiente</div>
                    <div class="detail-value"><?php echo htmlspecialchars($ambiente['amb_nombre']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Sede</div>
                    <div class="detail-value"><?php echo htmlspecialchars($ambiente['sede_nombre']); ?></div>
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
