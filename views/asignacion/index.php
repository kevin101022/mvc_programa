<?php
$pageTitle = "Gestión de Asignaciones - SENA";
$activeNavItem = 'asignaciones';
require_once '../layouts/head.php';
require_once '../layouts/sidebar.php';
?>

<main class="main-content">
    <header class="main-header">
        <div class="header-content">
            <nav class="breadcrumb">
                <a href="#">Inicio</a>
                <ion-icon src="../../assets/ionicons/chevron-forward-outline.svg"></ion-icon>
                <span>Asignaciones</span>
            </nav>
            <h1 class="page-title">Asignaciones Académicas</h1>
        </div>
    </header>

    <div class="content-wrapper">
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-card-header">
                    <span class="stat-card-label">TOTAL ASIGNACIONES</span>
                    <div class="stat-card-icon green">
                        <ion-icon src="../../assets/ionicons/calendar-outline.svg"></ion-icon>
                    </div>
                </div>
                <div class="stat-card-body">
                    <span class="stat-card-number" id="totalAsignaciones">0</span>
                    <span class="stat-card-desc">periodos asignados</span>
                </div>
            </div>
        </div>

        <div class="action-bar">
            <div class="search-container flex-1">
                <ion-icon src="../../assets/ionicons/search-outline.svg" class="search-icon"></ion-icon>
                <input type="text" id="searchInput" placeholder="Buscar por instructor, ficha o ambiente..." class="search-input">
            </div>
            <button id="addBtn" class="btn-primary">
                <ion-icon src="../../assets/ionicons/add-outline.svg"></ion-icon>
                Nueva Asignación
            </button>
        </div>

        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th class="w-20">Asig. N°</th>
                        <th>Instructor</th>
                        <th>Ficha</th>
                        <th>Ambiente / Competencia</th>
                        <th>Periodo</th>
                    </tr>
                </thead>
                <tbody id="asignacionTableBody">
                    <tr>
                        <td colspan="5" class="text-center py-8">Cargando asignaciones...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>

<!-- Create/Edit Modal -->
<?php require_once 'modal_edit.php'; ?>

<script src="../../assets/js/asignacion/index.js?v=<?php echo time(); ?>"></script>
</body>

</html>