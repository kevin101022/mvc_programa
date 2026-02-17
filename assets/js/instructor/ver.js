document.addEventListener('DOMContentLoaded', () => {
    const loadingState = document.getElementById('loadingState');
    const instructorDetails = document.getElementById('instructorDetails');
    const errorState = document.getElementById('errorState');
    const errorMessage = document.getElementById('errorMessage');

    const instId = new URLSearchParams(window.location.search).get('id');

    const init = async () => {
        if (!instId) {
            showError('ID de instructor no proporcionado');
            return;
        }

        try {
            const response = await fetch(`../../routing.php?controller=instructor&action=show&id=${instId}`, {
                headers: { 'Accept': 'application/json' }
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || 'Error al cargar los datos');
            }

            // Poblamos los datos básicos
            populateBasicInfo(data);

            // Cargar datos relacionados (Fichas)
            await loadRelatedData();

            showDetails();
        } catch (error) {
            console.error('Error:', error);
            showError(error.message);
        }
    };

    const populateBasicInfo = (inst) => {
        document.getElementById('instNombreCompleto').textContent = `${inst.inst_nombres} ${inst.inst_apellidos}`;
        document.getElementById('instIniciales').textContent = `${inst.inst_nombres[0]}${inst.inst_apellidos[0]}`;
        document.getElementById('instCorreo').textContent = inst.inst_correo || 'Sin correo';
        document.getElementById('instTelefono').textContent = inst.inst_telefono || 'Sin teléfono';
        document.getElementById('instCentro').textContent = inst.cent_nombre || 'Sin centro asignado';
        document.getElementById('instEspecialidad').textContent = inst.especialidad || 'Sin especialidad';

        document.getElementById('editBtn').href = `editar.php?id=${inst.inst_id}`;

        document.getElementById('deleteBtn').onclick = () => deleteInstructor(inst.inst_id);
    };

    const loadRelatedData = async () => {
        try {
            // Buscamos las fichas donde este instructor es líder
            const response = await fetch(`../../routing.php?controller=ficha&action=index`, {
                headers: { 'Accept': 'application/json' }
            });
            const fichas = await response.json();

            const misFichas = Array.isArray(fichas) ? fichas.filter(f => f.instructor_inst_id == instId) : [];

            const listContainer = document.getElementById('fichasList');
            const countLabel = document.getElementById('countFichas');

            countLabel.textContent = misFichas.length;

            if (misFichas.length === 0) {
                listContainer.innerHTML = '<p class="text-sm text-gray-400 text-center py-4">No tiene fichas asignadas como líder.</p>';
                return;
            }

            listContainer.innerHTML = '';
            misFichas.forEach(f => {
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors cursor-pointer group';
                item.onclick = () => window.location.href = `../ficha/ver.php?id=${f.fich_id}`;

                item.innerHTML = `
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center text-sena-green font-bold shadow-sm">
                            ${f.fich_id.toString().slice(-2)}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900">Ficha ${f.fich_id}</p>
                            <p class="text-xs text-gray-500">${f.titpro_nombre || 'Programa no definido'}</p>
                        </div>
                    </div>
                    <ion-icon src="../../assets/ionicons/chevron-forward-outline.svg" class="text-gray-400 group-hover:translate-x-1 transition-transform"></ion-icon>
                `;
                listContainer.appendChild(item);
            });

        } catch (error) {
            console.error('Error cargando relacionados:', error);
            document.getElementById('fichasList').innerHTML = '<p class="text-sm text-red-400 text-center">Error al cargar fichas.</p>';
        }
    };

    const deleteInstructor = async (id) => {
        if (!confirm('¿Está seguro de eliminar a este instructor? Esta acción no se puede deshacer.')) return;

        try {
            const response = await fetch(`../../routing.php?controller=instructor&action=destroy&id=${id}`, {
                headers: { 'Accept': 'application/json' }
            });

            if (response.ok) {
                NotificationService.showSuccess('Instructor eliminado correctamente');
                setTimeout(() => window.location.href = 'index.php', 1500);
            } else {
                const data = await response.json();
                NotificationService.showError(data.error || 'Error al eliminar');
            }
        } catch (error) {
            NotificationService.showError('Error de conexión');
        }
    };

    const showDetails = () => {
        loadingState.style.display = 'none';
        instructorDetails.style.display = 'grid';
        errorState.style.display = 'none';
    };

    const showError = (msg) => {
        loadingState.style.display = 'none';
        instructorDetails.style.display = 'none';
        errorState.style.display = 'block';
        errorMessage.textContent = msg;
    };

    init();
});
