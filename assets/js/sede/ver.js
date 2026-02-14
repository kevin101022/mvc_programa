// Sede View JavaScript
class SedeView {
    constructor() {
        this.sedeId = this.getSedeIdFromUrl();
        this.sedeData = null;
        this.instructores = [];
        this.filteredInstructores = [];
        this.filteredProgramas = [];
        this.currentFilters = {
            search: '',
            competencia: ''
        };
        this.programaFilters = {
            search: '',
            nivel: ''
        };
        this.ambientes = [];
        this.filteredAmbientes = [];
        this.ambienteFilters = {
            search: ''
        };
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadSedeData();
        this.initDeleteModal();
    }

    bindEvents() {
        // Instructores toggle functionality
        const verTodosBtn = document.getElementById('verTodosInstructores');
        const volverBtn = document.getElementById('volverPreview');

        if (verTodosBtn) {
            verTodosBtn.addEventListener('click', () => {
                this.showFullInstructorsList();
            });
        }

        if (volverBtn) {
            volverBtn.addEventListener('click', () => {
                this.showInstructoresPreview();
            });
        }

        // Programas toggle functionality
        const verTodosProgramasBtn = document.getElementById('verTodosProgramas');
        const volverProgramasBtn = document.getElementById('volverProgramasPreview');

        if (verTodosProgramasBtn) {
            verTodosProgramasBtn.addEventListener('click', () => {
                this.showFullProgramasList();
            });
        }

        if (volverProgramasBtn) {
            volverProgramasBtn.addEventListener('click', () => {
                this.showProgramasPreview();
            });
        }

        // Instructor filter events
        const searchInput = document.getElementById('searchInstructor');
        const competenciaSelect = document.getElementById('filterCompetencia');
        const clearFiltersBtn = document.getElementById('clearFilters');
        const clearFiltersBtn2 = document.getElementById('clearFiltersBtn');

        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.currentFilters.search = e.target.value;
                this.applyFilters();
            });
        }

        if (competenciaSelect) {
            competenciaSelect.addEventListener('change', (e) => {
                this.currentFilters.competencia = e.target.value;
                this.applyFilters();
            });
        }

        if (clearFiltersBtn) {
            clearFiltersBtn.addEventListener('click', () => {
                this.clearAllFilters();
            });
        }

        if (clearFiltersBtn2) {
            clearFiltersBtn2.addEventListener('click', () => {
                this.clearAllFilters();
            });
        }

        // Programa filter events
        const searchPrograma = document.getElementById('searchPrograma');
        const filterNivel = document.getElementById('filterNivelPrograma');
        const clearProgramaFilters = document.getElementById('clearProgramaFilters');
        const clearProgramaFiltersBtn = document.getElementById('clearProgramaFiltersBtn');

        if (searchPrograma) {
            searchPrograma.addEventListener('input', (e) => {
                this.programaFilters.search = e.target.value;
                this.applyProgramaFilters();
            });
        }

        if (filterNivel) {
            filterNivel.addEventListener('change', (e) => {
                this.programaFilters.nivel = e.target.value;
                this.applyProgramaFilters();
            });
        }

        if (clearProgramaFilters) {
            clearProgramaFilters.addEventListener('click', () => {
                this.clearAllProgramaFilters();
            });
        }

        if (clearProgramaFiltersBtn) {
            clearProgramaFiltersBtn.addEventListener('click', () => {
                this.clearAllProgramaFilters();
            });
        }

        // Ambientes toggle functionality
        const verTodosAmbientesBtn = document.getElementById('verTodosAmbientes');
        const volverAmbientesBtn = document.getElementById('volverAmbientesPreview');

        if (verTodosAmbientesBtn) {
            verTodosAmbientesBtn.addEventListener('click', () => {
                this.showFullAmbientesList();
            });
        }

        if (volverAmbientesBtn) {
            volverAmbientesBtn.addEventListener('click', () => {
                this.showAmbientesPreview();
            });
        }

        // Ambiente filter events
        const searchAmbiente = document.getElementById('searchAmbiente');
        if (searchAmbiente) {
            searchAmbiente.addEventListener('input', (e) => {
                this.ambienteFilters.search = e.target.value;
                this.applyAmbienteFilters();
            });
        }

        // Delete button
        const deleteSedeBtn = document.getElementById('deleteSedeBtn');
        if (deleteSedeBtn) {
            deleteSedeBtn.addEventListener('click', () => {
                this.openDeleteModal();
            });
        }
    }

    initDeleteModal() {
        this.modal = document.getElementById('deleteModal');
        this.modalContent = document.getElementById('modalContent');
        this.modalOverlay = document.getElementById('modalOverlay');
        this.cancelBtn = document.getElementById('cancelDeleteBtn');
        this.confirmBtn = document.getElementById('confirmDeleteBtn');
        this.sedeNameSpan = document.getElementById('sedeToDeleteName');

        if (this.cancelBtn) {
            this.cancelBtn.addEventListener('click', () => this.closeDeleteModal());
        }

        if (this.modalOverlay) {
            this.modalOverlay.addEventListener('click', () => this.closeDeleteModal());
        }

        if (this.confirmBtn) {
            this.confirmBtn.addEventListener('click', () => this.confirmDelete());
        }

        // Close on Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.modal && !this.modal.classList.contains('hidden')) {
                this.closeDeleteModal();
            }
        });
    }

    openDeleteModal() {
        if (!this.modal || !this.sedeData) return;

        if (this.sedeNameSpan) {
            this.sedeNameSpan.textContent = this.sedeData.sede_nombre;
        }

        this.modal.classList.remove('hidden');
        // Small delay for animation
        setTimeout(() => {
            if (this.modalContent) {
                this.modalContent.classList.remove('scale-95', 'opacity-0');
                this.modalContent.classList.add('scale-100', 'opacity-100');
            }
        }, 10);
    }

    closeDeleteModal() {
        if (!this.modal || !this.modalContent) return;

        this.modalContent.classList.remove('scale-100', 'opacity-100');
        this.modalContent.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            this.modal.classList.add('hidden');
        }, 300);
    }

    async confirmDelete() {
        if (!this.sedeId) return;

        try {
            this.confirmBtn.disabled = true;
            this.confirmBtn.innerHTML = '<div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>';

            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('sede_id', this.sedeId);

            const response = await fetch('../controller/sedeController.php', {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            if (!response.ok || data.error) {
                throw new Error(data.error || 'Error al eliminar la sede');
            }

            this.showSuccessFeedback();

            setTimeout(() => {
                window.location.href = 'index.php';
            }, 2000);

        } catch (error) {
            console.error('Error deleting sede:', error);
            alert(error.message || 'Hubo un error al intentar eliminar la sede. Por favor, intente de nuevo.');
            this.confirmBtn.disabled = false;
            this.confirmBtn.textContent = 'Sí, eliminar';
        }
    }

    showSuccessFeedback() {
        const overlay = document.getElementById('successOverlay');
        if (overlay) {
            overlay.classList.remove('hidden');
            this.closeDeleteModal();
        }
    }

    getSedeIdFromUrl() {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get('id');
    }

    async loadSedeData() {
        if (!this.sedeId) {
            this.showError('ID de sede no válido');
            return;
        }

        try {
            const sede = await this.fetchSede(this.sedeId);

            if (sede) {
                this.sedeData = sede;
                await this.loadRelatedData();
                this.populateSedeInfo();
                this.showDetails();
            } else {
                this.showError('Sede no encontrada');
            }
        } catch (error) {
            console.error('Error loading sede:', error);
            this.showError('Error al cargar la información de la sede');
        }
    }

    async fetchSede(sedeId) {
        const response = await fetch(`../controller/sedeController.php?action=get&id=${sedeId}`);
        if (!response.ok) {
            return null;
        }
        return await response.json();
    }

    async loadRelatedData() {
        try {
            const [programas, instructores, ambientes] = await Promise.all([
                this.fetchProgramas(this.sedeId),
                this.fetchInstructores(this.sedeId),
                this.fetchAmbientes(this.sedeId)
            ]);

            this.sedeData.programas = programas;
            this.filteredProgramas = [...programas];
            this.instructores = instructores;
            this.filteredInstructores = [...instructores];
            this.ambientes = ambientes;
            this.filteredAmbientes = [...ambientes];
        } catch (error) {
            console.error('Error loading related data:', error);
            this.sedeData.programas = [];
            this.instructores = [];
            this.filteredInstructores = [];
            this.ambientes = [];
            this.filteredAmbientes = [];
        }
    }

    async fetchProgramas(sedeId) {
        return new Promise((resolve) => {
            setTimeout(() => {
                const mockProgramas = {
                    1: [
                        { programa_id: 1, programa_nombre: 'ADSO - Análisis y Desarrollo de Software', fichas_count: '2556812' },
                        { programa_id: 2, programa_nombre: 'Mantenimiento de Equipos de Cómputo', fichas_count: '2611902' },
                        { programa_id: 3, programa_nombre: 'Gestión de Redes de Datos', fichas_count: '2450091' }
                    ],
                    2: [
                        { programa_id: 4, programa_nombre: 'Diseño Gráfico', fichas_count: '2445678' },
                        { programa_id: 5, programa_nombre: 'Manufactura Industrial', fichas_count: '2334567' }
                    ],
                    3: [
                        { programa_id: 6, programa_nombre: 'Administración Empresarial', fichas_count: '2223456' }
                    ]
                };
                resolve(mockProgramas[sedeId] || []);
            }, 300);
        });
    }

    async fetchInstructores(sedeId) {
        return new Promise((resolve) => {
            setTimeout(() => {
                const mockInstructores = {
                    1: [
                        { instructor_id: 1, nombre: 'Juan Carlos Díaz', especialidad: 'Desarrollo de Software', competencia_transversal: 'Programación', estado: 'Activo', email: 'juan.diaz@sena.edu.co' },
                        { instructor_id: 2, nombre: 'María Patricia López', especialidad: 'Bases de Datos', competencia_transversal: 'Gestión de Datos', estado: 'Activo', email: 'maria.lopez@sena.edu.co' },
                        { instructor_id: 3, nombre: 'Andrés Roberto Martínez', especialidad: 'Redes y Telecomunicaciones', competencia_transversal: 'Infraestructura TI', estado: 'Activo', email: 'andres.martinez@sena.edu.co' },
                        { instructor_id: 4, nombre: 'Laura Carolina Pérez', especialidad: 'Programación Web', competencia_transversal: 'Programación', estado: 'Activo', email: 'laura.perez@sena.edu.co' },
                        { instructor_id: 5, nombre: 'Carlos Eduardo Ramírez', especialidad: 'Sistemas Operativos', competencia_transversal: 'Infraestructura TI', estado: 'Activo', email: 'carlos.ramirez@sena.edu.co' },
                        { instructor_id: 6, nombre: 'Ana Sofía González', especialidad: 'Ingeniería de Software', competencia_transversal: 'Análisis y Diseño', estado: 'Activo', email: 'ana.gonzalez@sena.edu.co' },
                        { instructor_id: 7, nombre: 'Miguel Ángel Torres', especialidad: 'Seguridad Informática', competencia_transversal: 'Ciberseguridad', estado: 'Activo', email: 'miguel.torres@sena.edu.co' },
                        { instructor_id: 8, nombre: 'Diana Patricia Ruiz', especialidad: 'Análisis de Sistemas', competencia_transversal: 'Análisis y Diseño', estado: 'Inactivo', email: 'diana.ruiz@sena.edu.co' },
                        { instructor_id: 9, nombre: 'Roberto Silva Mendoza', especialidad: 'Desarrollo Mobile', competencia_transversal: 'Programación', estado: 'Activo', email: 'roberto.silva@sena.edu.co' },
                        { instructor_id: 10, nombre: 'Carmen Elena Vargas', especialidad: 'Testing y QA', competencia_transversal: 'Calidad de Software', estado: 'Activo', email: 'carmen.vargas@sena.edu.co' }
                    ],
                    2: [
                        { instructor_id: 11, nombre: 'Roberto Carlos Mendoza', especialidad: 'Diseño Gráfico', competencia_transversal: 'Diseño Visual', estado: 'Activo', email: 'roberto.mendoza@sena.edu.co' },
                        { instructor_id: 12, nombre: 'Sandra Milena Castro', especialidad: 'Manufactura', competencia_transversal: 'Procesos Industriales', estado: 'Activo', email: 'sandra.castro@sena.edu.co' },
                        { instructor_id: 13, nombre: 'Fernando José Vargas', especialidad: 'Procesos Industriales', competencia_transversal: 'Procesos Industriales', estado: 'Activo', email: 'fernando.vargas@sena.edu.co' }
                    ],
                    3: [
                        { instructor_id: 14, nombre: 'Claudia Patricia Herrera', especialidad: 'Administración', competencia_transversal: 'Gestión Empresarial', estado: 'Activo', email: 'claudia.herrera@sena.edu.co' },
                        { instructor_id: 15, nombre: 'Jorge Luis Morales', especialidad: 'Gestión Empresarial', competencia_transversal: 'Gestión Empresarial', estado: 'Activo', email: 'jorge.morales@sena.edu.co' }
                    ]
                };
                resolve(mockInstructores[sedeId] || []);
            }, 400);
        });
    }

    async fetchAmbientes(sedeId) {
        return new Promise((resolve) => {
            setTimeout(() => {
                const mockAmbientes = {
                    1: [
                        { id_ambiente: 101, amb_nombre: 'Laboratorio de Software 1' },
                        { id_ambiente: 102, amb_nombre: 'Laboratorio de Redes' },
                        { id_ambiente: 103, amb_nombre: 'Ambiente de Mantenimiento' },
                        { id_ambiente: 104, amb_nombre: 'Sala de Conferencias B' },
                        { id_ambiente: 105, amb_nombre: 'Laboratorio de Software 2' }
                    ],
                    2: [
                        { id_ambiente: 201, amb_nombre: 'Taller de Diseño' },
                        { id_ambiente: 202, amb_nombre: 'Planta de Producción' }
                    ],
                    3: [
                        { id_ambiente: 301, amb_nombre: 'Sala de Emprendimiento' }
                    ]
                };
                resolve(mockAmbientes[sedeId] || []);
            }, 350);
        });
    }

    populateSedeInfo() {
        // Basic info
        const sedeNombreCard = document.getElementById('sedeNombreCard');
        const sedeId = document.getElementById('sedeId');
        const sedeNombreInstructores = document.getElementById('sedeNombreInstructores');

        if (sedeNombreCard) {
            sedeNombreCard.textContent = this.sedeData.sede_nombre;
        }

        if (sedeNombreInstructores) {
            sedeNombreInstructores.textContent = this.sedeData.sede_nombre;
        }

        if (sedeId) {
            sedeId.textContent = String(this.sedeData.sede_id).padStart(3, '0');
        }

        // Sede Photo in Regional Card
        const sedeFotoCard = document.getElementById('sedeFotoCard');
        const sedeFotoImg = document.getElementById('sedeFotoImg');
        const sedeDefaultInfo = document.getElementById('sedeDefaultInfo');

        if (sedeFotoCard && sedeFotoImg && sedeDefaultInfo) {
            if (this.sedeData.sede_foto) {
                sedeFotoImg.src = this.sedeData.sede_foto;
                sedeFotoCard.classList.remove('hidden');
                sedeDefaultInfo.classList.add('hidden');
            } else {
                sedeFotoCard.classList.add('hidden');
                sedeDefaultInfo.classList.remove('hidden');
            }
        }

        // Statistics
        const totalProgramas = document.getElementById('totalProgramas');
        const totalInstructores = document.getElementById('totalInstructores');

        if (totalProgramas) {
            totalProgramas.textContent = this.sedeData.programas_count || 0;
        }

        const totalAmbientes = document.getElementById('totalAmbientes');
        if (totalAmbientes) {
            totalAmbientes.textContent = this.ambientes.length || 0;
        }

        if (totalInstructores) {
            totalInstructores.textContent = this.sedeData.instructores_count || 0;
        }

        // Edit link
        const editLink = document.getElementById('editLink');
        if (editLink) {
            editLink.href = `editar.php?id=${this.sedeData.sede_id}`;
        }

        // Populate programs, instructors and environments
        this.populateProgramas();
        this.populateAmbientes();
        this.populateInstructores();
        this.setupCompetenciaFilter();
        this.setupNivelFilter();
    }

    getStatusBadgeClass(estado) {
        // Method removed as it's no longer used
        return '';
    }

    populateProgramas() {
        const programasList = document.getElementById('programasList');
        const noProgramas = document.getElementById('noProgramas');

        if (!this.sedeData.programas || this.sedeData.programas.length === 0) {
            if (programasList) programasList.style.display = 'none';
            if (noProgramas) noProgramas.style.display = 'block';
            return;
        }

        if (noProgramas) noProgramas.style.display = 'none';
        if (programasList) {
            programasList.style.display = 'block';
            programasList.innerHTML = '';

            // Show first 3 programs in preview mode
            const programsToShow = this.sedeData.programas.slice(0, 3);

            programsToShow.forEach(programa => {
                const programaItem = document.createElement('div');
                programaItem.className = 'flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer group';

                const iconType = this.getProgramIcon(programa.programa_nombre);

                programaItem.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded bg-white dark:bg-slate-700 flex items-center justify-center text-slate-400 shadow-sm group-hover:text-sena-orange transition-colors">
                            <ion-icon src="../../assets/ionicons/${iconType}"></ion-icon>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">${programa.programa_nombre}</p>
                            <p class="text-xs text-slate-500">Ficha: ${programa.fichas_count}</p>
                        </div>
                    </div>
                    <ion-icon src="../../assets/ionicons/chevron-forward-outline.svg" class="text-slate-400 group-hover:translate-x-1 transition-transform"></ion-icon>
                `;
                programasList.appendChild(programaItem);
            });

            // Add additional programs indicator if more than 3
            if (this.sedeData.programas.length > 3) {
                const additionalDiv = document.createElement('div');
                additionalDiv.className = 'mt-4 text-center';
                additionalDiv.innerHTML = `
                    <div class="inline-flex items-center justify-center px-4 py-2 border border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-500 dark:text-slate-400 w-full bg-slate-50/50 dark:bg-slate-800/30">
                        + ${this.sedeData.programas.length - 3} programas adicionales vinculados a esta sede
                    </div>
                `;
                programasList.appendChild(additionalDiv);
            }
        }

        // Populate complete programs list
        this.renderProgramasCompleteList();
    }

    populateAmbientes() {
        const ambientesList = document.getElementById('ambientesList');
        const noAmbientes = document.getElementById('noAmbientes');

        if (!this.ambientes || this.ambientes.length === 0) {
            if (ambientesList) ambientesList.style.display = 'none';
            if (noAmbientes) noAmbientes.style.display = 'block';
            return;
        }

        if (noAmbientes) noAmbientes.style.display = 'none';
        if (ambientesList) {
            ambientesList.style.display = 'block';
            ambientesList.innerHTML = '';

            // Show first 3 ambientes in preview mode
            const ambientesToShow = this.ambientes.slice(0, 3);

            ambientesToShow.forEach(ambiente => {
                const ambienteItem = document.createElement('div');
                ambienteItem.className = 'flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer group';

                ambienteItem.innerHTML = `
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded bg-white dark:bg-slate-700 flex items-center justify-center text-slate-400 shadow-sm group-hover:text-sena-orange transition-colors">
                            <ion-icon src="../../assets/ionicons/cube-outline.svg"></ion-icon>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">${ambiente.amb_nombre}</p>
                            <p class="text-xs text-slate-500">ID: ${String(ambiente.id_ambiente).padStart(3, '0')}</p>
                        </div>
                    </div>
                    <ion-icon src="../../assets/ionicons/chevron-forward-outline.svg" class="text-slate-400 group-hover:translate-x-1 transition-transform"></ion-icon>
                `;
                ambientesList.appendChild(ambienteItem);
            });

            // Add additional indicator if more than 3
            if (this.ambientes.length > 3) {
                const additionalDiv = document.createElement('div');
                additionalDiv.className = 'mt-4 text-center';
                additionalDiv.innerHTML = `
                    <div class="inline-flex items-center justify-center px-4 py-2 border border-dashed border-slate-300 dark:border-slate-600 rounded-lg text-sm text-slate-500 dark:text-slate-400 w-full bg-slate-50/50 dark:bg-slate-800/30">
                        + ${this.ambientes.length - 3} ambientes registrados en esta sede
                    </div>
                `;
                ambientesList.appendChild(additionalDiv);
            }
        }

        // Populate complete list
        this.renderAmbientesCompleteList();
    }

    renderAmbientesCompleteList() {
        const ambientesListComplete = document.getElementById('ambientesListComplete');
        const totalAmbientesCount = document.getElementById('totalAmbientesCount');
        const noAmbienteFilterResults = document.getElementById('noAmbienteFilterResults');

        if (!ambientesListComplete) return;

        if (totalAmbientesCount) {
            totalAmbientesCount.textContent = this.ambientes.length;
        }

        this.updateFilteredAmbientesCount();

        // Show/hide no results message
        if (this.filteredAmbientes.length === 0 && this.ambienteFilters.search) {
            ambientesListComplete.style.display = 'none';
            if (noAmbienteFilterResults) noAmbienteFilterResults.style.display = 'block';
            return;
        } else {
            ambientesListComplete.style.display = 'block';
            if (noAmbienteFilterResults) noAmbienteFilterResults.style.display = 'none';
        }

        ambientesListComplete.innerHTML = '';

        this.filteredAmbientes.forEach(ambiente => {
            const ambienteItem = document.createElement('div');
            ambienteItem.className = 'flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer group';

            ambienteItem.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded bg-white dark:bg-slate-700 flex items-center justify-center text-slate-400 shadow-sm group-hover:text-sena-orange transition-colors">
                        <ion-icon src="../../assets/ionicons/cube-outline.svg"></ion-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-900 dark:text-white">${ambiente.amb_nombre}</p>
                        <p class="text-xs text-slate-500">ID: ${String(ambiente.id_ambiente).padStart(3, '0')}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="text-slate-400 hover:text-sena-green transition-colors" title="Ver detalles">
                        <ion-icon src="../../assets/ionicons/eye-outline.svg" class="text-sm"></ion-icon>
                    </button>
                </div>
            `;

            ambientesListComplete.appendChild(ambienteItem);
        });
    }

    showFullAmbientesList() {
        const preview = document.getElementById('ambientesPreview');
        const fullList = document.getElementById('ambientesFullList');

        if (preview) preview.style.display = 'none';
        if (fullList) fullList.style.display = 'block';

        // Reset filters when opening full list
        this.filteredAmbientes = [...this.ambientes];
        this.renderAmbientesCompleteList();
    }

    showAmbientesPreview() {
        const preview = document.getElementById('ambientesPreview');
        const fullList = document.getElementById('ambientesFullList');

        if (preview) preview.style.display = 'block';
        if (fullList) fullList.style.display = 'none';

        // Clear filters when going back to preview
        this.clearAllAmbienteFilters();
    }

    applyAmbienteFilters() {
        const searchTerm = this.ambienteFilters.search.toLowerCase();

        this.filteredAmbientes = this.ambientes.filter(ambiente => {
            return !searchTerm ||
                ambiente.amb_nombre.toLowerCase().includes(searchTerm) ||
                String(ambiente.id_ambiente).includes(searchTerm);
        });

        this.renderAmbientesCompleteList();
    }

    updateFilteredAmbientesCount() {
        const filteredCount = document.getElementById('filteredAmbientesCount');
        if (filteredCount) {
            filteredCount.textContent = this.filteredAmbientes.length;
        }
    }

    clearAllAmbienteFilters() {
        this.ambienteFilters = { search: '' };
        const searchInput = document.getElementById('searchAmbiente');
        if (searchInput) searchInput.value = '';
        this.applyAmbienteFilters();
    }

    renderProgramasCompleteList() {
        const programasListComplete = document.getElementById('programasListComplete');
        const totalProgramasCount = document.getElementById('totalProgramasCount');
        const noProgramaFilterResults = document.getElementById('noProgramaFilterResults');

        if (!programasListComplete) return;

        if (totalProgramasCount) {
            totalProgramasCount.textContent = this.sedeData.programas.length;
        }

        this.updateFilteredProgramasCount();

        // Show/hide no results message
        if (this.filteredProgramas.length === 0 && (this.programaFilters.search || this.programaFilters.nivel)) {
            programasListComplete.style.display = 'none';
            if (noProgramaFilterResults) noProgramaFilterResults.style.display = 'block';
            return;
        } else {
            programasListComplete.style.display = 'block';
            if (noProgramaFilterResults) noProgramaFilterResults.style.display = 'none';
        }

        programasListComplete.innerHTML = '';

        this.filteredProgramas.forEach(programa => {
            const programaItem = document.createElement('div');
            programaItem.className = 'flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer group';

            const iconType = this.getProgramIcon(programa.programa_nombre);

            programaItem.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded bg-white dark:bg-slate-700 flex items-center justify-center text-slate-400 shadow-sm group-hover:text-sena-orange transition-colors">
                        <ion-icon src="../../assets/ionicons/${iconType}"></ion-icon>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-900 dark:text-white">${programa.programa_nombre}</p>
                        <p class="text-xs text-slate-500">Ficha: ${programa.fichas_count}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="text-slate-400 hover:text-sena-green transition-colors" title="Ver detalles">
                        <ion-icon src="../../assets/ionicons/eye-outline.svg" class="text-sm"></ion-icon>
                    </button>
                </div>
            `;

            programasListComplete.appendChild(programaItem);
        });
    }

    showFullProgramasList() {
        const preview = document.getElementById('programasPreview');
        const fullList = document.getElementById('programasFullList');

        if (preview) preview.style.display = 'none';
        if (fullList) fullList.style.display = 'block';

        // Reset filters when opening full list
        this.filteredProgramas = [...this.sedeData.programas];
        this.renderProgramasCompleteList();
    }

    showProgramasPreview() {
        const preview = document.getElementById('programasPreview');
        const fullList = document.getElementById('programasFullList');

        if (preview) preview.style.display = 'block';
        if (fullList) fullList.style.display = 'none';

        // Clear filters when going back to preview
        this.clearAllProgramaFilters();
    }

    applyProgramaFilters() {
        const searchTerm = this.programaFilters.search.toLowerCase();
        const nivelFilter = this.programaFilters.nivel;

        this.filteredProgramas = this.sedeData.programas.filter(programa => {
            const matchesSearch = !searchTerm ||
                programa.programa_nombre.toLowerCase().includes(searchTerm);

            const matchesNivel = !nivelFilter ||
                programa.programa_nombre.toLowerCase().includes(nivelFilter.toLowerCase());

            return matchesSearch && matchesNivel;
        });

        this.renderProgramasCompleteList();
        this.updateActiveProgramaFilters();
    }

    updateFilteredProgramasCount() {
        const filteredCount = document.getElementById('filteredProgramasCount');
        if (filteredCount) {
            filteredCount.textContent = this.filteredProgramas.length;
        }
    }

    updateActiveProgramaFilters() {
        const activeFilters = document.getElementById('activeProgramaFilters');
        const activeFiltersList = document.getElementById('activeProgramaFiltersList');

        if (!activeFilters || !activeFiltersList) return;

        const hasActiveFilters = this.programaFilters.search || this.programaFilters.nivel;

        if (hasActiveFilters) {
            activeFilters.style.display = 'flex';
            activeFiltersList.innerHTML = '';

            if (this.programaFilters.search) {
                const filterTag = document.createElement('span');
                filterTag.className = 'inline-flex items-center gap-1 px-2 py-1 bg-sena-green/10 text-sena-green text-xs rounded-full';
                filterTag.innerHTML = `
                    Nombre: "${this.programaFilters.search}"
                    <button onclick="sedeView.removeProgramaFilter('search')" class="hover:text-green-700">
                        <ion-icon src="../../assets/ionicons/close-outline.svg" class="text-xs"></ion-icon>
                    </button>
                `;
                activeFiltersList.appendChild(filterTag);
            }

            if (this.programaFilters.nivel) {
                const filterTag = document.createElement('span');
                filterTag.className = 'inline-flex items-center gap-1 px-2 py-1 bg-sena-orange/10 text-sena-orange text-xs rounded-full';
                filterTag.innerHTML = `
                    Nivel: "${this.programaFilters.nivel}"
                    <button onclick="sedeView.removeProgramaFilter('nivel')" class="hover:text-orange-700">
                        <ion-icon src="../../assets/ionicons/close-outline.svg" class="text-xs"></ion-icon>
                    </button>
                `;
                activeFiltersList.appendChild(filterTag);
            }
        } else {
            activeFilters.style.display = 'none';
        }
    }

    removeProgramaFilter(filterType) {
        this.programaFilters[filterType] = '';

        if (filterType === 'search') {
            const searchInput = document.getElementById('searchPrograma');
            if (searchInput) searchInput.value = '';
        } else if (filterType === 'nivel') {
            const nivelSelect = document.getElementById('filterNivelPrograma');
            if (nivelSelect) nivelSelect.value = '';
        }

        this.applyProgramaFilters();
    }

    clearAllProgramaFilters() {
        this.programaFilters = { search: '', nivel: '' };

        const searchInput = document.getElementById('searchPrograma');
        const nivelSelect = document.getElementById('filterNivelPrograma');

        if (searchInput) searchInput.value = '';
        if (nivelSelect) nivelSelect.value = '';

        this.applyProgramaFilters();
    }

    setupNivelFilter() {
        const nivelSelect = document.getElementById('filterNivelPrograma');
        if (!nivelSelect || !this.sedeData.programas) return;

        nivelSelect.innerHTML = '<option value="">Todos los niveles</option>';

        const niveles = ['Tecnólogo', 'Técnico', 'Complementaria', 'Especialización'];
        niveles.forEach(nivel => {
            const option = document.createElement('option');
            option.value = nivel;
            option.textContent = nivel;
            nivelSelect.appendChild(option);
        });
    }

    setupCompetenciaFilter() {
        const competenciaSelect = document.getElementById('filterCompetencia');
        if (!competenciaSelect) return;

        // Get unique competencias
        const competencias = [...new Set(this.instructores.map(instructor => instructor.competencia_transversal))];
        competencias.sort();

        // Clear existing options (except the first one)
        competenciaSelect.innerHTML = '<option value="">Todas las competencias</option>';

        // Add competencia options
        competencias.forEach(competencia => {
            const option = document.createElement('option');
            option.value = competencia;
            option.textContent = competencia;
            competenciaSelect.appendChild(option);
        });
    }

    populateInstructores() {
        const noInstructores = document.getElementById('noInstructores');
        const instructoresPreview = document.getElementById('instructoresPreview');

        if (!this.instructores || this.instructores.length === 0) {
            if (instructoresPreview) instructoresPreview.style.display = 'none';
            if (noInstructores) noInstructores.style.display = 'block';
            return;
        }

        if (noInstructores) noInstructores.style.display = 'none';
        if (instructoresPreview) instructoresPreview.style.display = 'block';

        this.renderInstructoresAvatars();
        this.renderInstructoresList();
    }

    applyFilters() {
        const searchTerm = this.currentFilters.search.toLowerCase();
        const competenciaFilter = this.currentFilters.competencia;

        this.filteredInstructores = this.instructores.filter(instructor => {
            const matchesSearch = !searchTerm ||
                instructor.nombre.toLowerCase().includes(searchTerm) ||
                instructor.especialidad.toLowerCase().includes(searchTerm);

            const matchesCompetencia = !competenciaFilter ||
                instructor.competencia_transversal === competenciaFilter;

            return matchesSearch && matchesCompetencia;
        });

        this.renderInstructoresList();
        this.updateActiveFilters();
        this.updateFilteredCount();
    }

    updateFilteredCount() {
        const filteredCount = document.getElementById('filteredInstructoresCount');
        if (filteredCount) {
            filteredCount.textContent = this.filteredInstructores.length;
        }
    }

    updateActiveFilters() {
        const activeFilters = document.getElementById('activeFilters');
        const activeFiltersList = document.getElementById('activeFiltersList');

        if (!activeFilters || !activeFiltersList) return;

        const hasActiveFilters = this.currentFilters.search || this.currentFilters.competencia;

        if (hasActiveFilters) {
            activeFilters.style.display = 'flex';
            activeFiltersList.innerHTML = '';

            if (this.currentFilters.search) {
                const filterTag = document.createElement('span');
                filterTag.className = 'inline-flex items-center gap-1 px-2 py-1 bg-sena-green/10 text-sena-green text-xs rounded-full';
                filterTag.innerHTML = `
                    Nombre: "${this.currentFilters.search}"
                    <button onclick="sedeView.removeFilter('search')" class="hover:text-green-700">
                        <ion-icon src="../../assets/ionicons/close-outline.svg" class="text-xs"></ion-icon>
                    </button>
                `;
                activeFiltersList.appendChild(filterTag);
            }

            if (this.currentFilters.competencia) {
                const filterTag = document.createElement('span');
                filterTag.className = 'inline-flex items-center gap-1 px-2 py-1 bg-sena-orange/10 text-sena-orange text-xs rounded-full';
                filterTag.innerHTML = `
                    Competencia: "${this.currentFilters.competencia}"
                    <button onclick="sedeView.removeFilter('competencia')" class="hover:text-orange-700">
                        <ion-icon src="../../assets/ionicons/close-outline.svg" class="text-xs"></ion-icon>
                    </button>
                `;
                activeFiltersList.appendChild(filterTag);
            }
        } else {
            activeFilters.style.display = 'none';
        }
    }

    removeFilter(filterType) {
        this.currentFilters[filterType] = '';

        if (filterType === 'search') {
            const searchInput = document.getElementById('searchInstructor');
            if (searchInput) searchInput.value = '';
        } else if (filterType === 'competencia') {
            const competenciaSelect = document.getElementById('filterCompetencia');
            if (competenciaSelect) competenciaSelect.value = '';
        }

        this.applyFilters();
    }

    clearAllFilters() {
        this.currentFilters = { search: '', competencia: '' };

        const searchInput = document.getElementById('searchInstructor');
        const competenciaSelect = document.getElementById('filterCompetencia');

        if (searchInput) searchInput.value = '';
        if (competenciaSelect) competenciaSelect.value = '';

        this.applyFilters();
    }

    renderInstructoresAvatars() {
        const avatarsContainer = document.getElementById('instructoresAvatars');
        if (!avatarsContainer) return;

        avatarsContainer.innerHTML = '';

        // Show first 4 instructors as avatars
        const instructoresToShow = this.instructores.slice(0, 4);
        const colors = ['blue', 'green', 'purple', 'orange', 'red', 'indigo'];

        instructoresToShow.forEach((instructor, index) => {
            const color = colors[index % colors.length];
            const initials = this.getInitials(instructor.nombre);

            const avatar = document.createElement('div');
            avatar.className = `inline-block h-10 w-10 rounded-full ring-2 ring-white dark:ring-surface-dark bg-gradient-to-r from-${color}-400 to-${color}-600 flex items-center justify-center text-white text-sm font-medium cursor-pointer hover:scale-110 transition-transform`;
            avatar.title = `${instructor.nombre} - ${instructor.competencia_transversal}`;
            avatar.textContent = initials;

            avatarsContainer.appendChild(avatar);
        });

        // Add counter if more instructors
        if (this.instructores.length > 4) {
            const counter = document.createElement('div');
            counter.className = 'h-10 w-10 rounded-full ring-2 ring-white dark:ring-surface-dark bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-xs font-medium text-slate-500 cursor-pointer hover:bg-slate-200 dark:hover:bg-slate-700 transition-colors';
            counter.textContent = `+${this.instructores.length - 4}`;
            counter.title = `Ver todos los ${this.instructores.length} instructores`;

            avatarsContainer.appendChild(counter);
        }
    }

    renderInstructoresList() {
        const instructoresList = document.getElementById('instructoresList');
        const totalCount = document.getElementById('totalInstructoresCount');
        const noFilterResults = document.getElementById('noFilterResults');

        if (!instructoresList) return;

        if (totalCount) {
            totalCount.textContent = this.instructores.length;
        }

        // Show/hide no results message
        if (this.filteredInstructores.length === 0 && (this.currentFilters.search || this.currentFilters.competencia)) {
            instructoresList.style.display = 'none';
            if (noFilterResults) noFilterResults.style.display = 'block';
            return;
        } else {
            instructoresList.style.display = 'block';
            if (noFilterResults) noFilterResults.style.display = 'none';
        }

        instructoresList.innerHTML = '';

        this.filteredInstructores.forEach(instructor => {
            const instructorItem = document.createElement('div');
            instructorItem.className = 'flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors';

            const initials = this.getInitials(instructor.nombre);
            const statusClass = instructor.estado === 'Activo' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';

            instructorItem.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-blue-600 flex items-center justify-center text-white text-xs font-medium">
                        ${initials}
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-slate-900 dark:text-white">${instructor.nombre}</p>
                        <p class="text-xs text-slate-500">${instructor.especialidad}</p>
                        <p class="text-xs text-sena-green font-medium">${instructor.competencia_transversal}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium ${statusClass}">
                        ${instructor.estado}
                    </span>
                    <button class="text-slate-400 hover:text-sena-green transition-colors" title="Ver detalles">
                        <ion-icon src="../../assets/ionicons/eye-outline.svg" class="text-sm"></ion-icon>
                    </button>
                </div>
            `;

            instructoresList.appendChild(instructorItem);
        });

        this.updateFilteredCount();
    }

    showFullInstructorsList() {
        const preview = document.getElementById('instructoresPreview');
        const fullList = document.getElementById('instructoresFullList');

        if (preview) preview.style.display = 'none';
        if (fullList) fullList.style.display = 'block';

        // Reset filters when opening full list
        this.filteredInstructores = [...this.instructores];
        this.renderInstructoresList();
    }

    showInstructoresPreview() {
        const preview = document.getElementById('instructoresPreview');
        const fullList = document.getElementById('instructoresFullList');

        if (preview) preview.style.display = 'block';
        if (fullList) fullList.style.display = 'none';

        // Clear filters when going back to preview
        this.clearAllFilters();
    }

    getInitials(name) {
        return name.split(' ')
            .map(word => word.charAt(0))
            .join('')
            .substring(0, 2)
            .toUpperCase();
    }

    getProgramIcon(programName) {
        const name = programName.toLowerCase();
        if (name.includes('software') || name.includes('desarrollo')) return 'code-slash-outline.svg';
        if (name.includes('redes') || name.includes('network')) return 'wifi-outline.svg';
        if (name.includes('mantenimiento') || name.includes('equipos')) return 'hardware-chip-outline.svg';
        if (name.includes('diseño')) return 'color-palette-outline.svg';
        if (name.includes('manufactura')) return 'construct-outline.svg';
        if (name.includes('administración')) return 'briefcase-outline.svg';
        return 'school-outline.svg';
    }

    showDetails() {
        const loadingState = document.getElementById('loadingState');
        const sedeDetails = document.getElementById('sedeDetails');

        if (loadingState) {
            loadingState.style.display = 'none';
        }

        if (sedeDetails) {
            sedeDetails.style.display = 'block';
        }
    }

    showError(message) {
        const loadingState = document.getElementById('loadingState');
        const errorCard = document.getElementById('errorCard');
        const errorMessage = document.getElementById('errorMessage');

        if (loadingState) {
            loadingState.style.display = 'none';
        }

        if (errorMessage) {
            errorMessage.textContent = message;
        }

        if (errorCard) {
            errorCard.style.display = 'block';
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.sedeView = new SedeView();
});