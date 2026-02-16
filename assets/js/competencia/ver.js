class DetalleCompetencia {
    constructor() {
        this.compId = new URLSearchParams(window.location.search).get('id');
        if (!this.compId) window.location.href = 'index.php';
        this.init();
    }

    async init() {
        this.cacheDOM();
        this.bindEvents();
        await this.loadData();
    }

    cacheDOM() {
        this.breadcrumbCompetencia = document.getElementById('breadcrumbCompetencia');
        this.pageTitleCompetencia = document.getElementById('pageTitleCompetencia');
        this.editLink = document.getElementById('editLink');
        this.deleteBtn = document.getElementById('deleteBtn');

        this.compIdDisplay = document.getElementById('compIdDisplay');
        this.compNombreDisplay = document.getElementById('compNombreDisplay');
        this.compHorasDisplay = document.getElementById('compHorasDisplay');
        this.compUnidadDisplay = document.getElementById('compUnidadDisplay');

        this.programasList = document.getElementById('associatedProgramasList');
        this.programCount = document.getElementById('programCount');
    }

    bindEvents() {
        this.deleteBtn.addEventListener('click', () => this.handleDelete());
        this.editLink.href = `editar.php?id=${this.compId}`;
    }

    async loadData() {
        try {
            const response = await fetch(`../../routing.php?controller=competencia&action=show&id=${this.compId}`);
            const data = await response.json();

            if (data.error) throw new Error(data.error);

            this.renderCompetencia(data);
            this.renderProgramas(data.programas);
        } catch (error) {
            console.error('Error loading competency info:', error);
            if (window.NotificationService) {
                NotificationService.show('No se pudo cargar la información de la competencia', 'error');
            }
        }
    }

    renderCompetencia(data) {
        this.breadcrumbCompetencia.textContent = data.comp_nombre_corto;
        this.pageTitleCompetencia.textContent = data.comp_nombre_corto;

        this.compIdDisplay.textContent = `#${String(data.comp_id).padStart(3, '0')}`;
        this.compNombreDisplay.textContent = data.comp_nombre_corto;
        this.compHorasDisplay.textContent = `${data.comp_horas}h`;
        this.compUnidadDisplay.textContent = data.comp_nombre_unidad_competencia || 'Sin descripción detallada.';
    }

    renderProgramas(programas) {
        this.programasList.innerHTML = '';
        this.programCount.textContent = `${programas.length} asociados`;

        if (programas.length === 0) {
            this.programasList.innerHTML = `
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-300">
                        <ion-icon src="../../assets/ionicons/school-outline.svg" class="text-3xl"></ion-icon>
                    </div>
                    <p class="text-gray-500 font-medium">Esta competencia no está asociada a ningún programa todavía.</p>
                </div>
            `;
            return;
        }

        programas.forEach(p => {
            const item = document.createElement('div');
            item.className = 'p-6 hover:bg-gray-50 transition-colors flex items-center justify-between cursor-pointer';
            item.onclick = () => window.location.href = `../programa/ver.php?id=${p.prog_id}`;

            item.innerHTML = `
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                        <ion-icon src="../../assets/ionicons/school-outline.svg"></ion-icon>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-900">${p.prog_denominacion}</h4>
                        <p class="text-sm text-gray-500">${p.titpro_nombre}</p>
                    </div>
                </div>
                <div class="text-right">
                    <ion-icon src="../../assets/ionicons/chevron-forward-outline.svg" class="text-gray-300"></ion-icon>
                </div>
            `;
            this.programasList.appendChild(item);
        });
    }

    async handleDelete() {
        if (typeof NotificationService === 'undefined' && !window.NotificationService) {
            if (!confirm('¿Estás seguro de eliminar esta competencia? Se borrarán todas sus asociaciones y esta acción no se puede deshacer.')) return;
            this.executeDelete();
        } else {
            const service = window.NotificationService || NotificationService;
            service.showConfirm(
                '¿Estás seguro de eliminar esta competencia? Se borrarán todas sus asociaciones con programas y esta acción no se puede deshacer.',
                () => this.executeDelete()
            );
        }
    }

    async executeDelete() {
        try {
            const response = await fetch(`../../routing.php?controller=competencia&action=destroy&id=${this.compId}`);
            const result = await response.json();

            if (result.message) {
                if (window.NotificationService) {
                    NotificationService.showSuccess(result.message, () => {
                        window.location.href = 'index.php';
                    });
                } else {
                    alert(result.message);
                    window.location.href = 'index.php';
                }
            } else {
                throw new Error(result.error || 'Error al eliminar');
            }
        } catch (error) {
            if (window.NotificationService) {
                NotificationService.showError(error.message);
            } else {
                alert(error.message);
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    new DetalleCompetencia();
});
