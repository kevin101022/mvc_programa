<?php
$pageTitle = 'Detalle de Competencia - Gestión de Transversales';
$activeNavItem = 'competencias';
require_once '../layouts/head.php';
require_once '../layouts/sidebar.php';
?>

<main class="main-content">
    <header class="main-header">
        <div class="header-content">
            <div class="breadcrumb">
                <a href="../dashboard/index.php">Principal</a>
                <ion-icon src="../../assets/ionicons/chevron-forward-outline.svg"></ion-icon>
                <a href="index.php">Competencias</a>
                <ion-icon src="../../assets/ionicons/chevron-forward-outline.svg"></ion-icon>
                <span id="breadcrumbCompetencia">Cargando...</span>
            </div>
            <h1 class="page-title" id="pageTitleCompetencia">Cargando Competencia...</h1>
        </div>
        <div class="header-actions">
            <a href="index.php" class="btn-secondary">
                <ion-icon src="../../assets/ionicons/arrow-back-outline.svg"></ion-icon>
                Volver
            </a>
        </div>
    </header>

    <div class="content-wrapper">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Info Card -->
            <div class="lg:col-span-1 space-y-6">
                <div class="form-card p-6">
                    <div class="flex items-center justify-between gap-4 mb-6 pb-6 border-bottom border-gray-100">
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                                <ion-icon src="../../assets/ionicons/bookmarks-outline.svg" class="text-3xl"></ion-icon>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Competencia ID</p>
                                <h2 class="text-2xl font-bold text-gray-900" id="compIdDisplay">---</h2>
                            </div>
                        </div>
                        <a id="editLink" href="#" class="text-sena-green hover:text-emerald-700 transition-colors flex items-center gap-1 text-sm font-medium">
                            <ion-icon src="../../assets/ionicons/create-outline.svg"></ion-icon>
                            Editar
                        </a>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nombre Corto</p>
                            <p class="text-lg font-semibold text-gray-900" id="compNombreDisplay">---</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Total Horas</p>
                            <span class="inline-flex px-3 py-1 rounded-full bg-green-50 text-green-700 font-bold" id="compHorasDisplay">---h</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Unidad de Competencia</p>
                            <p class="text-sm text-gray-600 leading-relaxed" id="compUnidadDisplay">No hay descripción disponible para esta unidad.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Associated Programs -->
            <div class="lg:col-span-2">
                <div class="form-card overflow-hidden">
                    <div class="form-header bg-gray-50 p-6 border-bottom border-gray-200 flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Programas de Formación</h3>
                            <p class="text-sm text-gray-500">Programas que incluyen esta competencia</p>
                        </div>
                        <span class="bg-white border border-gray-200 px-4 py-1.5 rounded-lg text-sm font-bold text-gray-700" id="programCount">0 asociados</span>
                    </div>

                    <div id="associatedProgramasList" class="divide-y divide-gray-100 max-h-[600px] overflow-y-auto">
                        <div class="p-8 text-center text-gray-400 italic">Cargando programas asociados...</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Danger Zone / Delete Button -->
        <div class="flex justify-end pt-4">
            <button id="deleteBtn" class="flex items-center gap-2 bg-white dark:bg-slate-800 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 px-4 py-3 rounded-xl shadow-md border border-red-100 dark:border-red-900/30 transition-all duration-300 hover:translate-y-[-2px] active:translate-y-[0px] group">
                <ion-icon src="../../assets/ionicons/trash-outline.svg" class="text-xl group-hover:shake"></ion-icon>
                <span class="font-bold text-sm">Eliminar Competencia</span>
            </button>
        </div>
    </div>
</main>

<script src="../../assets/js/competencia/ver.js?v=<?php echo time(); ?>"></script>
</body>

</html>