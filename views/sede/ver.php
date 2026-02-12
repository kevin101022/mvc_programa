<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de Sede - SENA Académico</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "sena-green": "#39A900",
                        "sena-orange": "#FC7323",
                        "primary": "#39A900",
                        "primary-dark": "#2d8500",
                        "background-light": "#f6f7f8",
                        "background-dark": "#101922",
                        "surface-light": "#ffffff",
                        "surface-dark": "#1a2632",
                    },
                    fontFamily: {
                        "display": ["Public Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Public Sans', sans-serif;
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .dark ::-webkit-scrollbar-thumb {
            background: #334155;
        }

        .dark ::-webkit-scrollbar-thumb:hover {
            background: #475569;
        }
    </style>
</head>

<body class="bg-background-light dark:bg-background-dark text-slate-800 dark:text-slate-200 transition-colors duration-300 antialiased font-display h-screen overflow-hidden flex">
    <!-- Sidebar -->
    <aside class="w-64 h-full bg-surface-light dark:bg-surface-dark border-r border-slate-200 dark:border-slate-700 flex flex-col shrink-0 transition-colors duration-300">
        <!-- Logo Area -->
        <div class="h-20 flex items-center px-6 border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-3">
                <img src="../../imagenes/LOGOsena.png" alt="SENA Logo" class="h-14 w-auto object-contain">
                <div class="w-px h-11 bg-slate-300 dark:bg-slate-600 mx-1"></div>
                <span class="font-bold text-lg leading-tight text-slate-900 dark:text-white">Gestión<br>Transversales</span>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1">
            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Principal</p>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 rounded-lg hover:bg-sena-green/10 hover:text-sena-green transition-colors">
                <ion-icon name="grid-outline" class="text-[20px]"></ion-icon>
                Dashboard
            </a>

            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-6 mb-2">Gestión</p>
            <a href="index.php" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium bg-sena-green/10 text-sena-green rounded-lg transition-colors">
                <ion-icon name="business-outline" class="text-[20px]"></ion-icon>
                Sedes
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 rounded-lg hover:bg-sena-green/10 hover:text-sena-green transition-colors">
                <ion-icon name="school-outline" class="text-[20px]"></ion-icon>
                Programas
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 rounded-lg hover:bg-sena-green/10 hover:text-sena-green transition-colors">
                <ion-icon name="people-outline" class="text-[20px]"></ion-icon>
                Instructores
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 rounded-lg hover:bg-sena-green/10 hover:text-sena-green transition-colors">
                <ion-icon name="calendar-outline" class="text-[20px]"></ion-icon>
                Horarios
            </a>

            <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-wider mt-6 mb-2">Configuración</p>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 rounded-lg hover:bg-sena-green/10 hover:text-sena-green transition-colors">
                <ion-icon name="settings-outline" class="text-[20px]"></ion-icon>
                Ajustes
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-slate-600 dark:text-slate-400 rounded-lg hover:bg-sena-green/10 hover:text-sena-green transition-colors">
                <ion-icon name="help-circle-outline" class="text-[20px]"></ion-icon>
                Ayuda
            </a>
        </nav>

        <!-- User Profile -->
        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            <a href="#" class="flex items-center gap-3 w-full hover:bg-slate-50 dark:hover:bg-slate-800 p-2 rounded-lg transition-colors group">
                <img src="../../assets/img/profile.jpg" alt="Coordinador" class="h-9 w-9 rounded-full object-cover border border-slate-200 dark:border-slate-600">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-slate-900 dark:text-white truncate">Carlos Rodriguez</p>
                    <p class="text-xs text-slate-500 truncate">Coordinador Académico</p>
                </div>
                <ion-icon name="log-out-outline" class="text-slate-400 group-hover:text-sena-green"></ion-icon>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 h-full overflow-y-auto relative bg-background-light dark:bg-background-dark">
        <!-- Header -->
        <header class="bg-surface-light/80 dark:bg-surface-dark/80 backdrop-blur-sm sticky top-0 z-20 border-b border-slate-200 dark:border-slate-700 px-8 py-4 flex justify-between items-center">
            <div>
                <nav aria-label="Breadcrumb" class="flex text-sm text-slate-500 dark:text-slate-400 mb-1">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="index.php" class="hover:text-sena-green dark:hover:text-sena-green transition-colors">Sedes</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <ion-icon name="chevron-forward-outline" class="text-base mx-1"></ion-icon>
                                <span class="text-slate-800 dark:text-white font-medium">Detalle de Sede</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h1 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                    <ion-icon name="information-circle-outline" class="text-2xl text-sena-orange"></ion-icon>
                    Información Detallada
                </h1>
            </div>

            <div class="flex items-center gap-4">
                <a href="index.php" class="flex items-center gap-2 text-slate-600 dark:text-slate-300 hover:text-sena-orange transition-colors px-3 py-2 rounded-lg hover:bg-orange-50 dark:hover:bg-orange-900/10 border border-transparent hover:border-sena-orange/20">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    <span class="text-sm font-medium">Regresar</span>
                </a>
            </div>
        </header>

        <div class="p-8 max-w-7xl mx-auto space-y-6">
            <!-- Loading State -->
            <div id="loadingState" class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-12 text-center">
                <div class="w-8 h-8 border-3 border-sena-green border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                <p class="text-slate-600 dark:text-slate-400">Cargando información de la sede...</p>
            </div>

            <!-- Sede Details -->
            <div id="sedeDetails" class="space-y-6" style="display: none;">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Left Column -->
                    <div class="lg:col-span-1 space-y-6">
                        <!-- SENA Regional Card -->
                        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                            <div class="bg-gradient-to-br from-sena-green to-emerald-700 flex flex-col items-center text-center relative overflow-hidden h-64 justify-center">
                                <div id="sedeFotoCard" class="absolute inset-0 hidden">
                                    <img id="sedeFotoImg" src="" alt="Sede Foto" class="w-full h-full object-cover">
                                </div>
                                <div id="sedeDefaultInfo" class="flex flex-col items-center px-6">
                                    <div class="absolute inset-0 opacity-10"></div>
                                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mb-4 shadow-lg relative z-10">
                                        <svg class="w-16 h-16 text-sena-green" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"></path>
                                        </svg>
                                    </div>
                                    <h3 class="text-white font-bold text-lg relative z-10">SENA Regional</h3>
                                    <p class="text-emerald-100 text-sm relative z-10">Centro de Gestión</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <h4 class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Datos del Registro</h4>
                                    <a href="#" id="editLink" class="text-sena-green hover:text-emerald-700 transition-colors flex items-center gap-1 text-sm font-medium">
                                        <ion-icon name="create-outline"></ion-icon>
                                        Editar
                                    </a>
                                </div>
                                <div class="space-y-4">
                                    <div class="py-2 border-b border-slate-100 dark:border-slate-700">
                                        <p class="text-slate-500 dark:text-slate-400 text-xs uppercase mb-1">Nombre de la Sede</p>
                                        <p id="sedeNombreCard" class="text-slate-900 dark:text-white text-sm font-bold leading-tight">Cargando...</p>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700">
                                        <span class="text-slate-500 dark:text-slate-400 text-sm">ID Sede</span>
                                        <span id="sedeId" class="font-mono text-slate-700 dark:text-slate-300 text-sm">-</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700">
                                        <span class="text-slate-500 dark:text-slate-400 text-sm">Fecha Creación</span>
                                        <span class="text-slate-900 dark:text-white text-sm">12 Ene 2022</span>
                                    </div>
                                    <div class="flex justify-between items-center py-2">
                                        <span class="text-slate-500 dark:text-slate-400 text-sm">Última Actualización</span>
                                        <span class="text-slate-900 dark:text-white text-sm">05 Ago 2023</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Coordinator Info -->
                        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                            <div class="flex items-start gap-4">
                                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    <ion-icon name="shield-checkmark-outline" class="text-blue-600 dark:text-blue-400"></ion-icon>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Coordinador Encargado</h4>
                                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                                        Esta sede está actualmente bajo la supervisión de la coordinación académica central.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Statistics Cards -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="bg-surface-light dark:bg-surface-dark p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
                                <div class="p-3 rounded-full bg-orange-100 text-sena-orange dark:bg-orange-900/30">
                                    <ion-icon name="school-outline"></ion-icon>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium uppercase">Programas</p>
                                    <p id="totalProgramas" class="text-xl font-bold text-slate-900 dark:text-white">0</p>
                                </div>
                            </div>
                            <div class="bg-surface-light dark:bg-surface-dark p-4 rounded-xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
                                <div class="p-3 rounded-full bg-purple-100 text-purple-600 dark:bg-purple-900/30">
                                    <ion-icon name="people-outline"></ion-icon>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium uppercase">Instructores</p>
                                    <p id="totalInstructores" class="text-xl font-bold text-slate-900 dark:text-white">0</p>
                                </div>
                            </div>
                        </div>

                        <!-- Programs Card -->
                        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center">
                                <h3 class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                    <ion-icon name="layers-outline" class="text-slate-400"></ion-icon>
                                    Programas Asociados
                                </h3>
                                <button id="verTodosProgramas" class="text-sm text-sena-green hover:text-green-700 font-medium transition-colors">Ver todos</button>
                            </div>
                            <div class="p-6">
                                <!-- Preview Mode -->
                                <div id="programasPreview">
                                    <div id="programasList" class="space-y-4">
                                        <!-- Programs will be loaded here -->
                                    </div>
                                </div>

                                <!-- Full List Mode -->
                                <div id="programasFullList" class="space-y-3" style="display: none;">
                                    <div class="flex justify-between items-center mb-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Total:</span>
                                            <span id="totalProgramasCount" class="text-sm font-bold text-sena-green">0</span>
                                            <span class="text-slate-400">|</span>
                                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Filtrados:</span>
                                            <span id="filteredProgramasCount" class="text-sm font-bold text-sena-orange">0</span>
                                        </div>
                                        <button id="volverProgramasPreview" class="text-sm text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
                                            <ion-icon name="close-outline" class="text-sm"></ion-icon>
                                        </button>
                                    </div>

                                    <!-- Filters -->
                                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 mb-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Search by Name -->
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <ion-icon name="search-outline" class="text-slate-400 text-sm"></ion-icon>
                                                </div>
                                                <input
                                                    type="text"
                                                    id="searchPrograma"
                                                    placeholder="Buscar por nombre..."
                                                    class="block w-full pl-10 pr-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sena-green focus:border-sena-green transition duration-150 ease-in-out">
                                            </div>

                                            <!-- Filter by Nivel -->
                                            <div class="relative">
                                                <select
                                                    id="filterNivelPrograma"
                                                    class="block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sena-green focus:border-sena-green transition duration-150 ease-in-out">
                                                    <option value="">Todos los niveles</option>
                                                </select>
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <ion-icon name="chevron-down-outline" class="text-slate-400 text-sm"></ion-icon>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Active Filters Display -->
                                        <div id="activeProgramaFilters" class="mt-3 flex flex-wrap gap-2" style="display: none;">
                                            <span class="text-xs text-slate-500 dark:text-slate-400">Filtros activos:</span>
                                            <div id="activeProgramaFiltersList" class="flex flex-wrap gap-1">
                                            </div>
                                            <button id="clearProgramaFilters" class="text-xs text-sena-orange hover:text-orange-600 font-medium transition-colors">
                                                Limpiar filtros
                                            </button>
                                        </div>
                                    </div>

                                    <div id="programasListComplete" class="space-y-2 max-h-64 overflow-y-auto">
                                        <!-- Full programs list will be loaded here -->
                                    </div>

                                    <!-- No Results State -->
                                    <div id="noProgramaFilterResults" class="text-center py-8" style="display: none;">
                                        <ion-icon name="filter-outline" class="text-gray-400 text-3xl mb-2"></ion-icon>
                                        <p class="text-gray-500 text-sm">No se encontraron programas con los filtros aplicados</p>
                                        <button id="clearProgramaFiltersBtn" class="mt-2 text-sm text-sena-green hover:text-green-700 font-medium">
                                            Limpiar filtros
                                        </button>
                                    </div>
                                </div>

                                <div id="noProgramas" class="text-center py-8" style="display: none;">
                                    <ion-icon name="school-outline" class="text-gray-400 text-4xl mb-2"></ion-icon>
                                    <p class="text-gray-500">No hay programas asignados a esta sede</p>
                                </div>
                            </div>
                        </div>

                        <!-- Instructors Card -->
                        <div class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-slate-200 dark:border-slate-700">
                            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 flex justify-between items-center">
                                <h3 class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                    <ion-icon name="person-outline" class="text-slate-400"></ion-icon>
                                    Instructores Asignados
                                </h3>
                                <button id="verTodosInstructores" class="text-sm text-sena-green hover:text-green-700 font-medium transition-colors">Ver todos</button>
                            </div>
                            <div class="p-6">
                                <!-- Preview Mode -->
                                <div id="instructoresPreview">
                                    <div class="flex -space-x-3 overflow-hidden mb-4" id="instructoresAvatars">
                                        <!-- Avatars will be loaded here -->
                                    </div>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">
                                        Estos instructores tienen carga académica activa en <strong id="sedeNombreInstructores">esta sede</strong> para el trimestre actual.
                                    </p>
                                </div>

                                <!-- Full List Mode -->
                                <div id="instructoresFullList" class="space-y-3" style="display: none;">
                                    <div class="flex justify-between items-center mb-4">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Total:</span>
                                            <span id="totalInstructoresCount" class="text-sm font-bold text-sena-green">0</span>
                                            <span class="text-slate-400">|</span>
                                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Filtrados:</span>
                                            <span id="filteredInstructoresCount" class="text-sm font-bold text-sena-orange">0</span>
                                        </div>
                                        <button id="volverPreview" class="text-sm text-slate-500 hover:text-slate-700 dark:hover:text-slate-300 transition-colors">
                                            <ion-icon name="close-outline" class="text-sm"></ion-icon>
                                        </button>
                                    </div>

                                    <!-- Filters -->
                                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-lg p-4 mb-4">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <!-- Search by Name -->
                                            <div class="relative">
                                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                    <ion-icon name="search-outline" class="text-slate-400 text-sm"></ion-icon>
                                                </div>
                                                <input
                                                    type="text"
                                                    id="searchInstructor"
                                                    placeholder="Buscar por nombre..."
                                                    class="block w-full pl-10 pr-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sena-green focus:border-sena-green transition duration-150 ease-in-out">
                                            </div>

                                            <!-- Filter by Competencia -->
                                            <div class="relative">
                                                <select
                                                    id="filterCompetencia"
                                                    class="block w-full px-3 py-2 border border-slate-300 dark:border-slate-600 rounded-lg text-sm bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-sena-green focus:border-sena-green transition duration-150 ease-in-out">
                                                    <option value="">Todas las competencias</option>
                                                    <!-- Options will be populated dynamically -->
                                                </select>
                                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                                    <ion-icon name="chevron-down-outline" class="text-slate-400 text-sm"></ion-icon>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Active Filters Display -->
                                        <div id="activeFilters" class="mt-3 flex flex-wrap gap-2" style="display: none;">
                                            <span class="text-xs text-slate-500 dark:text-slate-400">Filtros activos:</span>
                                            <div id="activeFiltersList" class="flex flex-wrap gap-1">
                                                <!-- Active filters will be shown here -->
                                            </div>
                                            <button id="clearFilters" class="text-xs text-sena-orange hover:text-orange-600 font-medium transition-colors">
                                                Limpiar filtros
                                            </button>
                                        </div>
                                    </div>

                                    <div id="instructoresList" class="space-y-2 max-h-64 overflow-y-auto">
                                        <!-- Full instructor list will be loaded here -->
                                    </div>

                                    <!-- No Results State -->
                                    <div id="noFilterResults" class="text-center py-8" style="display: none;">
                                        <ion-icon name="filter-outline" class="text-gray-400 text-3xl mb-2"></ion-icon>
                                        <p class="text-gray-500 text-sm">No se encontraron instructores con los filtros aplicados</p>
                                        <button id="clearFiltersBtn" class="mt-2 text-sm text-sena-green hover:text-green-700 font-medium">
                                            Limpiar filtros
                                        </button>
                                    </div>
                                </div>

                                <!-- Empty State -->
                                <div id="noInstructores" class="text-center py-8" style="display: none;">
                                    <ion-icon name="person-outline" class="text-gray-400 text-4xl mb-2"></ion-icon>
                                    <p class="text-gray-500">No hay instructores asignados a esta sede</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Error Card -->
            <div id="errorCard" class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-red-200 dark:border-red-700 p-12 text-center" style="display: none;">
                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <ion-icon name="alert-circle-outline" class="text-red-600 dark:text-red-400"></ion-icon>
                </div>
                <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Error al Cargar</h3>
                <p id="errorMessage" class="text-slate-600 dark:text-slate-400 mb-6">No se pudo cargar la información de la sede.</p>
                <a href="index.php" class="inline-flex items-center gap-2 bg-sena-green hover:bg-green-700 text-white px-6 py-3 rounded-lg font-medium">
                    <ion-icon name="arrow-back-outline"></ion-icon>
                    Volver a Sedes
                </a>
            </div>

            <footer class="text-center text-xs text-slate-400 dark:text-slate-600 mt-8 mb-4">
                © 2023 Servicio Nacional de Aprendizaje SENA. Todos los derechos reservados.
            </footer>
        </div>
    </main>

    <script src="../../assets/js/sede/ver.js?v=<?php echo time(); ?>"></script>
</body>

</html>