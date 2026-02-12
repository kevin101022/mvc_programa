// Sede Management JavaScript
class SedeManager {
    constructor() {
        this.currentPage = 1;
        this.itemsPerPage = 5;
        this.totalItems = 0;
        this.sedes = [];
        this.filteredSedes = [];
        this.deleteSedeId = null;

        this.init();
    }

    init() {
        this.bindEvents();
        this.loadSedes();
    }

    bindEvents() {
        // Search functionality
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', (e) => {
                this.filterSedes(e.target.value);
            });
        }

        // Pagination
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                if (this.currentPage > 1) {
                    this.currentPage--;
                    this.renderTable();
                    this.updatePagination();
                }
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                const totalPages = Math.ceil(this.filteredSedes.length / this.itemsPerPage);
                if (this.currentPage < totalPages) {
                    this.currentPage++;
                    this.renderTable();
                    this.updatePagination();
                }
            });
        }

        // Modal events
        window.closeDeleteModal = () => {
            this.closeDeleteModal();
        };

        window.confirmDelete = () => {
            this.deleteSede();
        };
    }

    async loadSedes() {
        try {
            // Simulate API call - replace with actual endpoint
            const response = await this.fetchSedes();
            this.sedes = response;
            this.filteredSedes = [...this.sedes];
            this.totalItems = this.sedes.length;

            this.updateStats();
            this.renderTable();
            this.updatePagination();
        } catch (error) {
            console.error('Error loading sedes:', error);
            this.showError('Error al cargar las sedes');
        }
    }

    async fetchSedes() {
        // Mock data - replace with actual API call
        return [
            { sede_id: 1, sede_nombre: 'Centro de la Industria, la Empresa y los Servicios (CIES)' },
            { sede_id: 2, sede_nombre: 'Centro de Formación para el Desarrollo Rural y Minero (CEDRUM)' },
            { sede_id: 3, sede_nombre: 'Tecno Parque, Tecno Academia' },
            { sede_id: 4, sede_nombre: 'Sena - Calzado y Marroquinería' }
        ];
    }

    filterSedes(searchTerm) {
        if (!searchTerm.trim()) {
            this.filteredSedes = [...this.sedes];
        } else {
            this.filteredSedes = this.sedes.filter(sede =>
                sede.sede_nombre.toLowerCase().includes(searchTerm.toLowerCase())
            );
        }

        this.currentPage = 1;
        this.renderTable();
        this.updatePagination();
    }

    renderTable() {
        const tbody = document.getElementById('sedesTableBody');
        if (!tbody) return;

        const startIndex = (this.currentPage - 1) * this.itemsPerPage;
        const endIndex = startIndex + this.itemsPerPage;
        const pageItems = this.filteredSedes.slice(startIndex, endIndex);

        tbody.innerHTML = '';

        if (pageItems.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="3" class="text-center py-8">
                        <div class="flex flex-col items-center">
                            <ion-icon name="search-outline" style="font-size:2rem;color:#9ca3af;margin-bottom:0.5rem;"></ion-icon>
                            <p class="text-gray-500">No se encontraron sedes</p>
                        </div>
                    </td>
                </tr>
            `;
            return;
        }

        pageItems.forEach(sede => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 transition-colors group';

            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="h-10 w-10 rounded-lg overflow-hidden border border-gray-100 shadow-sm flex-shrink-0">
                        ${sede.sede_foto ?
                    `<img src="${sede.sede_foto}" alt="Sede" class="h-full w-full object-cover">` :
                    `<div class="h-full w-full flex items-center justify-center bg-gradient-to-br from-green-500 to-green-600 text-white">
                                <ion-icon name="business-outline" style="font-size: 1.25rem;"></ion-icon>
                            </div>`
                }
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                    ${String(sede.sede_id).padStart(3, '0')}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                    <div class="font-medium">${sede.sede_nombre}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="table-actions">
                        <button class="action-btn" onclick="window.location.href='ver.php?id=${sede.sede_id}'" title="Ver detalles">
                            <ion-icon name="eye-outline"></ion-icon>
                        </button>
                        <button class="action-btn" onclick="window.location.href='editar.php?id=${sede.sede_id}'" title="Editar">
                            <ion-icon name="create-outline"></ion-icon>
                        </button>
                        <button class="action-btn delete" onclick="sedeManager.openDeleteModal(${sede.sede_id}, '${sede.sede_nombre}')" title="Eliminar">
                            <ion-icon name="trash-outline"></ion-icon>
                        </button>
                    </div>
                </td>
            `;

            tbody.appendChild(row);
        });
    }

    getStatusBadge(estado) {
        const statusClasses = {
            'Activo': 'status-badge status-active',
            'Inactivo': 'status-badge status-inactive',
            'Mantenimiento': 'status-badge status-maintenance'
        };

        const className = statusClasses[estado] || 'status-badge';
        return `<span class="${className}">${estado}</span>`;
    }

    updatePagination() {
        const totalPages = Math.ceil(this.filteredSedes.length / this.itemsPerPage);
        const startItem = (this.currentPage - 1) * this.itemsPerPage + 1;
        const endItem = Math.min(this.currentPage * this.itemsPerPage, this.filteredSedes.length);

        // Update pagination info
        const showingFrom = document.getElementById('showingFrom');
        const showingTo = document.getElementById('showingTo');
        const totalRecords = document.getElementById('totalRecords');

        if (showingFrom) showingFrom.textContent = startItem;
        if (showingTo) showingTo.textContent = endItem;
        if (totalRecords) totalRecords.textContent = this.filteredSedes.length;

        // Update pagination buttons
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        if (prevBtn) {
            prevBtn.disabled = this.currentPage === 1;
        }

        if (nextBtn) {
            nextBtn.disabled = this.currentPage === totalPages || totalPages === 0;
        }

        // Update pagination numbers
        const paginationNumbers = document.getElementById('paginationNumbers');
        if (paginationNumbers) {
            paginationNumbers.innerHTML = '';

            for (let i = 1; i <= Math.min(totalPages, 5); i++) {
                const pageBtn = document.createElement('button');
                pageBtn.className = `pagination-number ${i === this.currentPage ? 'active' : ''}`;
                pageBtn.textContent = i;
                pageBtn.addEventListener('click', () => {
                    this.currentPage = i;
                    this.renderTable();
                    this.updatePagination();
                });
                paginationNumbers.appendChild(pageBtn);
            }
        }
    }

    updateStats() {
        const totalSedes = document.getElementById('totalSedes');
        if (totalSedes) {
            totalSedes.textContent = this.sedes.length;
        }
    }

    openDeleteModal(sedeId, sedeNombre) {
        this.deleteSedeId = sedeId;
        const modal = document.getElementById('deleteModal');
        const sedeToDelete = document.getElementById('sedeToDelete');

        if (sedeToDelete) {
            sedeToDelete.textContent = sedeNombre;
        }

        if (modal) {
            modal.classList.add('show');
        }
    }

    closeDeleteModal() {
        const modal = document.getElementById('deleteModal');
        if (modal) {
            modal.classList.remove('show');
        }
        this.deleteSedeId = null;
    }

    async deleteSede() {
        if (!this.deleteSedeId) return;

        try {
            // Simulate API call - replace with actual endpoint
            await this.deleteSedeFetch(this.deleteSedeId);

            // Remove from local array
            this.sedes = this.sedes.filter(sede => sede.sede_id !== this.deleteSedeId);
            this.filteredSedes = this.filteredSedes.filter(sede => sede.sede_id !== this.deleteSedeId);

            this.closeDeleteModal();
            this.updateStats();
            this.renderTable();
            this.updatePagination();

            this.showSuccess('Sede eliminada correctamente');
        } catch (error) {
            console.error('Error deleting sede:', error);
            this.showError('Error al eliminar la sede');
        }
    }

    async deleteSedeFetch(sedeId) {
        // Mock API call - replace with actual endpoint
        return new Promise((resolve) => {
            setTimeout(resolve, 500);
        });
    }

    showSuccess(message) {
        // Simple success notification - can be enhanced with a proper notification system
        alert(message);
    }

    showError(message) {
        // Simple error notification - can be enhanced with a proper notification system
        alert(message);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.sedeManager = new SedeManager();
});