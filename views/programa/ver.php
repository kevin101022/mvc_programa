<?php
/**
 * Vista: Detalle de Programa (ver.php)
 */

// --- Datos de prueba ---
$rol = $rol ?? 'coordinador';
$programa = $programa ?? ['prog_codigo' => '228106', 'prog_denominacion' => 'Análisis y Desarrollo de Software', 'prog_tipo' => 'Titulada', 'tibro_nombre' => 'Tecnólogo'];
// --- Fin datos de prueba ---

$title = 'Detalle de Programa';
$breadcrumb = [
    ['label' => 'Inicio', 'url' => '/mvccc/mvc_programa/'],
    ['label' => 'Programas', 'url' => 'index.php'],
    ['label' => 'Detalle'],
];

include __DIR__ . '/../../layout/header.php';
?>

        <div class="page-header">
            <h1 class="page-title">Detalle de Programa</h1>
        </div>

        <div class="detail-card">
            <div class="detail-card-body">
                <div class="detail-row">
                    <div class="detail-label">Código</div>
                    <div class="detail-value"><?php echo htmlspecialchars($programa['prog_codigo']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Denominación</div>
                    <div class="detail-value"><?php echo htmlspecialchars($programa['prog_denominacion']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Tipo de Formación</div>
                    <div class="detail-value"><?php echo htmlspecialchars($programa['prog_tipo']); ?></div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Nivel / Título</div>
                    <div class="detail-value"><?php echo htmlspecialchars($programa['tibro_nombre']); ?></div>
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
