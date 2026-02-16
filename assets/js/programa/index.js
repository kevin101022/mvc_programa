class ProgramaView {
    constructor() {
        this.programas = [];
        this.filteredProgramas = [];
        this.currentPage = 1;
        this.recordsPerPage = 5;
        this.programaIdToDelete = null;

        this.init();
    }

    async init() {
        this.cacheDOM();
        this.bindEvents();
        await this.loadProgramas();
    }

    cacheDOM() {
        this.tableBody = document.getElementById('programasTableBody');
        this.searchInput = document.getElementById('searchInput');
        this.totalProgramasEl = document.getElementById('totalProgramas');
        this.showingFrom = document.getElementById('showingFrom');
        this.showingTo = document.getElementById('showingTo');
        this.totalRecords = document.getElementById('totalRecords');
        this.paginationNumbers = document.getElementById('paginationNumbers');
        this.prevBtn = document.getElementById('prevBtn');
        this.nextBtn = document.getElementById('nextBtn');
        this.deleteModal = document.getElementById('deleteModal');
        this.programaToDeleteLabel = document.getElementById('programaToDelete');
        this.confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    }

    bindEvents() {
        this.searchInput.addEventListener('input', () => this.handleSearch());
        this.prevBtn.addEventListener('click', () => this.changePage(this.currentPage - 1));
        this.nextBtn.addEventListener('click', () => this.changePage(this.currentPage + 1));
        this.confirmDeleteBtn.addEventListener('click', () => this.confirmDelete());
    }

    async loadProgramas() {
        try {
            const response = await fetch('../../routing.php?controller=programa&action=index');
            this.programas = await response.json();
            this.filteredProgramas = [...this.programas];
            this.render();
        } catch (error) {
            console.error('Error loading programas:', error);
            if (window.NotificationService) {
                NotificationService.show('Error al cargar los programas', 'error');
            }
        }
    }

    handleSearch() {
        const query = this.searchInput.value.toLowerCase();
        this.filteredProgramas = this.programas.filter(p =>
            p.prog_codigo.toString().includes(query) ||
            p.prog_denominacion.toLowerCase().includes(query) ||
            p.titpro_nombre.toLowerCase().includes(query)
        );
        this.currentPage = 1;
        this.render();
    }

    render() {
        this.renderTable();
        this.renderStats();
        this.renderPagination();
    }

    renderStats() {
        this.totalProgramasEl.textContent = this.programas.length;
        this.totalRecords.textContent = this.filteredProgramas.length;

        const start = this.filteredProgramas.length === 0 ? 0 : (this.currentPage - 1) * this.recordsPerPage + 1;
        const end = Math.min(this.currentPage * this.recordsPerPage, this.filteredProgramas.length);

        this.showingFrom.textContent = start;
        this.showingTo.textContent = end;
    }

    renderTable() {
        const start = (this.currentPage - 1) * this.recordsPerPage;
        const end = start + this.recordsPerPage;
        const paginatedProgramas = this.filteredProgramas.slice(start, end);

        if (paginatedProgramas.length === 0) {
            this.tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-12 text-gray-500">
                <div class="flex flex-col items-center gap-2">
                    <ion-icon src="../../assets/ionicons/search-outline.svg" class="text-4xl text-gray-300"></ion-icon>
                    <p>No se encontraron programas</p>
                </div>
            </td></tr>`;
            return;
        }

        this.tableBody.innerHTML = '';
        paginatedProgramas.forEach(p => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-green-50/50 dark:hover:bg-emerald-900/10 transition-colors cursor-pointer group';
            row.onclick = () => {
                window.location.href = `ver.php?id=${p.prog_id}`;
            };

            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-sena-green">
                    ${String(p.prog_id).padStart(3, '0')}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-sena-green/10 text-sena-green border border-sena-green/20">
                        ${p.prog_codigo}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm font-bold text-slate-900 dark:text-white group-hover:text-sena-green transition-colors leading-tight">
                        ${p.prog_denominacion}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <ion-icon src="../../assets/ionicons/ribbon-outline.svg" class="text-sena-green"></ion-icon>
                        <span class="truncate max-w-[200px]" title="${p.titpro_nombre}">${p.titpro_nombre}</span>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300">
                        ${p.prog_tipo || 'N/A'}
                    </span>
                </td>
            `;
            this.tableBody.appendChild(row);
        });
    }

    renderPagination() {
        const totalPages = Math.ceil(this.filteredProgramas.length / this.recordsPerPage);
        this.paginationNumbers.innerHTML = '';

        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement('button');
            btn.className = `pagination-btn ${i === this.currentPage ? 'active' : ''}`;
            btn.textContent = i;
            btn.onclick = () => this.changePage(i);
            this.paginationNumbers.appendChild(btn);
        }

        this.prevBtn.disabled = this.currentPage === 1;
        this.nextBtn.disabled = this.currentPage === totalPages || totalPages === 0;
    }

    changePage(page) {
        if (page < 1 || page > Math.ceil(this.filteredProgramas.length / this.recordsPerPage)) return;
        this.currentPage = page;
        this.render();
    }

    openDeleteModal(id, nombre) {
        this.programaIdToDelete = id;
        this.programaToDeleteLabel.textContent = nombre;
        this.deleteModal.classList.add('active');
    }

    closeDeleteModal() {
        this.deleteModal.classList.remove('active');
        this.programaIdToDelete = null;
    }

    async confirmDelete() {
        if (!this.programaIdToDelete) return;

        try {
            const response = await fetch(`../../routing.php?controller=programa&action=destroy&id=${this.programaIdToDelete}`, {
                method: 'DELETE'
            });
            const result = await response.json();

            if (result.message) {
                if (window.NotificationService) {
                    NotificationService.show(result.message, 'success');
                }
                this.closeDeleteModal();
                await this.loadProgramas();
            } else {
                throw new Error(result.error || 'Error desconocido');
            }
        } catch (error) {
            console.error('Error deleting programa:', error);
            if (window.NotificationService) {
                NotificationService.show(error.message, 'error');
            }
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.programaView = new ProgramaView();
});

// Helper functions for global scope (onclick attributes)
window.closeDeleteModal = () => window.programaView.closeDeleteModal();
window.confirmDelete = () => window.programaView.confirmDelete();
