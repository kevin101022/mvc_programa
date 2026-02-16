<?php
$pageTitle = "Detalle del Instructor - SENA";
$id = $_GET['id'] ?? null;
$activeNavItem = 'instructores';
require_once '../layouts/head.php';
require_once '../layouts/sidebar.php';
?>

<main class="main-content">
    <header class="main-header">
        <div class="header-content">
            <nav class="breadcrumb">
                <a href="index.php">Instructores</a>
                <ion-icon src="../../assets/ionicons/chevron-forward-outline.svg"></ion-icon>
                <span>Detalle</span>
            </nav>
            <h1 class="page-title">Detalle del Instructor</h1>
        </div>
        <div class="header-actions">
            <a href="index.php" class="btn-secondary">
                <ion-icon src="../../assets/ionicons/arrow-back-outline.svg"></ion-icon>
                Regresar
            </a>
            <a id="editLink" href="#" class="btn-primary">
                <ion-icon src="../../assets/ionicons/create-outline.svg"></ion-icon>
                Editar
            </a>
        </div>
    </header>

    <div class="content-wrapper">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar Info -->
            <div class="lg:col-span-1 space-y-6">
                <div class="form-card overflow-hidden">
                    <div class="p-8 text-center bg-gray-50 border-b border-gray-100">
                        <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center text-green-600 font-bold text-3xl mx-auto mb-4 border-4 border-white shadow-sm" id="instInitial">
                            --
                        </div>
                        <h2 class="text-xl font-bold text-gray-900" id="instNombreCompleto">Cargando...</h2>
                        <p class="text-sm text-gray-500">Instructor ID: <span id="instIdDisplay">---</span></p>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="detail-item">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Correo Electrónico</span>
                            <div class="flex items-center gap-2 text-gray-700">
                                <ion-icon src="../../assets/ionicons/mail-outline.svg" class="text-lg text-gray-400"></ion-icon>
                                <span id="instCorreo">---</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Teléfono</span>
                            <div class="flex items-center gap-2 text-gray-700">
                                <ion-icon src="../../assets/ionicons/call-outline.svg" class="text-lg text-gray-400"></ion-icon>
                                <span id="instTelefono">---</span>
                            </div>
                        </div>
                        <div class="detail-item">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Centro de Formación</span>
                            <div class="flex items-center gap-2">
                                <ion-icon src="../../assets/ionicons/business-outline.svg" class="text-lg text-gray-400"></ion-icon>
                                <span class="status-badge status-active" id="instSede">---</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-card p-6">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <ion-icon src="../../assets/ionicons/warning-outline.svg" class="text-red-500"></ion-icon>
                    Zona de Peligro
                </h3>
                <p class="text-sm text-gray-500 mb-4">La eliminación de un instructor eliminará todas sus asociaciones.</p>
                <button id="deleteBtn" class="btn-danger w-full justify-center">
                    <ion-icon src="../../assets/ionicons/trash-outline.svg"></ion-icon>
                    Eliminar Instructor
                </button>
            </div>
        </div>

        <!-- Content Area -->
        <div class="lg:col-span-2 space-y-6">
            <div class="form-card p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2 border-b border-gray-100 pb-4">
                    <ion-icon src="../../assets/ionicons/briefcase-outline.svg" class="text-green-600"></ion-icon>
                    Asignaciones del Instructor
                </h3>
                <div id="asignacionesContainer" class="py-12 text-center text-gray-500">
                    <ion-icon src="../../assets/ionicons/calendar-outline.svg" class="text-4xl mb-2 opacity-20"></ion-icon>
                    <p>No hay asignaciones registradas para este instructor.</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</main>

<!-- Delete Modal -->
<div id="deleteModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirmar Eliminación</h3>
            <button class="modal-close" id="cancelDeleteX">
                <ion-icon src="../../assets/ionicons/close-outline.svg"></ion-icon>
            </button>
        </div>
        <div class="modal-body">
            <p>¿Está seguro que desea eliminar a este instructor?</p>
            <p class="text-sm text-gray-600">Esta acción no se puede deshacer y afectará a las fichas relacionadas.</p>
        </div>
        <div class="modal-footer">
            <button class="btn-secondary" id="cancelDelete">Cancelar</button>
            <button class="btn-danger" id="confirmDelete">Eliminar</button>
        </div>
    </div>
</div>

<script src="../../assets/js/instructor/ver.js"></script>
</body>

</html>