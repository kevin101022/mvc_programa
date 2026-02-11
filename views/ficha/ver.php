<?php
/**
 * Vista: Detalle de Ficha (ver.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$ficha = $ficha ?? ['fich_id' => '228106-1', 'prog_denominacion' => 'Análisis y Desarrollo de Software', 'instructor_nombre' => 'Juan Pérez', 'fich_jornada' => 'Diurna'];
// --- Fin datos de prueba ---

$title = 'Detalle de Ficha';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Fichas', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Detalle de Ficha</h1>
        </div>

        <div class="detail-card">
            <div class="detail-card-body">
                <div class="detail-row">
                    <div class="detail-label">Número de Ficha</div>
                    <div class="detail-value"><?php echo htmlspecialchars($ficha['fich_id']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Programa</div>
                    <div class="detail-value"><?php echo htmlspecialchars($ficha['prog_denominacion']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Jornada</div>
                    <div class="detail-value"><?php echo htmlspecialchars($ficha['fich_jornada']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Instructor Líder</div>
                    <div class="detail-value"><?php echo htmlspecialchars($ficha['instructor_nombre']); ?></div>
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
