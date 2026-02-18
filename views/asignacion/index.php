<?php
$pageTitle = "Asignaciones Académicas - SENA";
$activeNavItem = 'asignaciones';
require_once '../layouts/head.php';
?>
<!-- FullCalendar CDN -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
<style>
    .fc {
        font-family: 'Public Sans', sans-serif;
    }

    .fc .fc-toolbar-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a2e;
    }

    .fc .fc-button {
        background: #39a900;
        border-color: #39a900;
        font-size: 0.8rem;
        text-transform: capitalize;
    }

    .fc .fc-button:hover {
        background: #2d8a00;
        border-color: #2d8a00;
    }

    .fc .fc-button-active {
        background: #1e6b00 !important;
        border-color: #1e6b00 !important;
    }

    .fc .fc-daygrid-day-number {
        font-weight: 600;
        color: #4a5568;
    }

    .fc .fc-event {
        border-radius: 6px;
        padding: 2px 6px;
        font-size: 0.75rem;
        border: none;
    }

    .fc .fc-daygrid-day.fc-day-today {
        background: #f0fdf4;
    }

    .ficha-selector {
        max-width: 400px;
    }

    .calendar-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 400px;
        color: #9ca3af;
    }

    .calendar-placeholder ion-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }
</style>

<?php require_once '../layouts/sidebar.php'; ?>

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
                    <span class="stat-card-desc">asignaciones de la ficha</span>
                </div>
            </div>
        </div>

        <!-- Ficha selector -->
        <div class="action-bar">
            <div class="ficha-selector">
                <select id="fichaSelector" class="search-input" style="padding-left: 12px !important;">
                    <option value="">Seleccione una ficha para ver su calendario...</option>
                </select>
            </div>
            <button id="addBtn" class="btn-primary" disabled>
                <ion-icon src="../../assets/ionicons/add-outline.svg"></ion-icon>
                Nueva Asignación
            </button>
        </div>

        <!-- Calendar area -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-4">
            <div id="calendarPlaceholder" class="calendar-placeholder">
                <ion-icon src="../../assets/ionicons/calendar-outline.svg"></ion-icon>
                <p class="text-lg font-semibold">Seleccione una ficha</p>
                <p class="text-sm">El calendario se cargará con las asignaciones de la ficha seleccionada</p>
            </div>
            <div id="calendar" style="display: none;"></div>
        </div>
    </div>
</main>

<!-- Create/Edit Modal -->
<?php require_once 'modal_edit.php'; ?>

<script src="../../assets/js/asignacion/index.js?v=<?php echo time(); ?>"></script>
</body>

</html>