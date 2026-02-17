document.addEventListener('DOMContentLoaded', () => {
    const loadingState = document.getElementById('loadingState');
    const detailsContainer = document.getElementById('asignacionDetails');
    const errorState = document.getElementById('errorState');
    const errorMessage = document.getElementById('errorMessage');

    const asigId = new URLSearchParams(window.location.search).get('id');

    // UI Elements for Edit Modal (same as index.js)
    const modal = document.getElementById('asignacionModal');
    const form = document.getElementById('asignacionForm');

    const init = async () => {
        if (!asigId) {
            showError('ID de asignación no proporcionado');
            return;
        }

        try {
            // Cargar opciones para los selects (para el modal)
            await loadSelectOptions();

            // Cargar datos de la asignación
            await loadAsignacionData();

        } catch (error) {
            console.error('Error:', error);
            showError('Error al recuperar los datos del servidor');
        }
    };

    const loadSelectOptions = async () => {
        const headers = { 'Accept': 'application/json' };
        try {
            const [instRes, fichRes, ambRes, compRes] = await Promise.all([
                fetch('../../routing.php?controller=instructor&action=index', { headers }),
                fetch('../../routing.php?controller=ficha&action=index', { headers }),
                fetch('../../routing.php?controller=ambiente&action=index', { headers }),
                fetch('../../routing.php?controller=competencia&action=index', { headers })
            ]);

            const [instructores, fichas, ambientes, competencias] = await Promise.all([
                instRes.json(), fichRes.json(), ambRes.json(), compRes.json()
            ]);

            fillSelect('instructor_id', instructores, i => `${i.inst_nombres} ${i.inst_apellidos}`, 'inst_id');
            fillSelect('ficha_id', fichas, f => `Ficha: ${f.fich_id}`, 'fich_id');
            fillSelect('ambiente_id', ambientes, a => a.amb_nombre, 'amb_id');
            fillSelect('competencia_id', competencias, c => c.comp_nombre_corto || c.comp_nombre, 'comp_id');
        } catch (err) {
            console.warn('Error cargando opciones de selects', err);
        }
    };

    const fillSelect = (id, data, labelFn, valueKey) => {
        const select = document.getElementById(id);
        if (!select) return;
        select.innerHTML = '<option value="">Seleccione...</option>';
        if (Array.isArray(data)) {
            data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item[valueKey];
                opt.textContent = labelFn(item);
                select.appendChild(opt);
            });
        }
    };

    const loadAsignacionData = async () => {
        const response = await fetch('../../routing.php?controller=asignacion&action=index', {
            headers: { 'Accept': 'application/json' }
        });
        const data = await response.json();
        const asig = Array.isArray(data) ? data.find(a => a.asig_id == asigId) : null;

        if (!asig) {
            throw new Error('Asignación no encontrada');
        }

        populateUI(asig);
        showDetails();
    };

    const populateUI = (asig) => {
        document.getElementById('detAsigId').textContent = String(asig.asig_id).padStart(3, '0');
        document.getElementById('detInstructor').textContent = `${asig.inst_nombres} ${asig.inst_apellidos}`;
        document.getElementById('detInstInic').textContent = `${asig.inst_nombres[0]}${asig.inst_apellidos[0]}`;
        document.getElementById('detFicha').textContent = `Ficha ${asig.fich_id || asig.ficha_fich_id}`;
        document.getElementById('detAmbiente').textContent = asig.amb_nombre || 'N/A';
        document.getElementById('detCompetencia').textContent = asig.comp_nombre_corto || asig.comp_nombre || 'N/A';
        document.getElementById('detFechaIni').textContent = asig.asig_fecha_ini || '--';
        document.getElementById('detFechaFin').textContent = asig.asig_fecha_fin || '--';

        // Links
        document.getElementById('instLink').href = `../instructor/ver.php?id=${asig.instructor_inst_id}`;
        document.getElementById('fichaLink').href = `../ficha/ver.php?id=${asig.ficha_fich_id || asig.fich_id}`;

        // Buttons
        document.getElementById('deleteBtn').onclick = () => handleDelete(asig.asig_id);
        document.getElementById('editBtn').onclick = () => openEditModal(asig);
    };

    const openEditModal = (asig) => {
        document.getElementById('modalTitle').textContent = 'Editar Asignación';
        document.getElementById('asig_id').value = asig.asig_id;

        document.getElementById('instructor_id').value = asig.instructor_inst_id || '';
        document.getElementById('ficha_id').value = asig.ficha_fich_id || asig.fich_id || '';
        document.getElementById('ambiente_id').value = asig.ambiente_amb_id || '';
        document.getElementById('competencia_id').value = asig.competencia_comp_id || '';
        document.getElementById('asig_fecha_ini').value = asig.asig_fecha_ini || '';
        document.getElementById('asig_fecha_fin').value = asig.asig_fecha_fin || '';

        modal.classList.add('show');
    };

    const handleDelete = async (id) => {
        NotificationService.showConfirm('¿Está seguro de eliminar esta asignación académica?', async () => {
            try {
                const response = await fetch(`../../routing.php?controller=asignacion&action=destroy&id=${id}`, {
                    headers: { 'Accept': 'application/json' }
                });
                if (response.ok) {
                    NotificationService.showSuccess('Asignación eliminada');
                    setTimeout(() => window.location.href = 'index.php', 1500);
                } else {
                    const res = await response.json();
                    NotificationService.showError(res.error || 'Error al eliminar');
                }
            } catch (err) {
                NotificationService.showError('Error de red');
            }
        });
    };

    // Modal Events
    document.getElementById('closeModal').onclick = () => modal.classList.remove('show');
    document.getElementById('cancelBtn').onclick = () => modal.classList.remove('show');

    form.onsubmit = async (e) => {
        e.preventDefault();
        const data = {
            asig_id: document.getElementById('asig_id').value,
            instructor_inst_id: document.getElementById('instructor_id').value,
            ficha_fich_id: document.getElementById('ficha_id').value,
            ambiente_amb_id: document.getElementById('ambiente_id').value,
            competencia_comp_id: document.getElementById('competencia_id').value,
            asig_fecha_ini: document.getElementById('asig_fecha_ini').value,
            asig_fecha_fin: document.getElementById('asig_fecha_fin').value
        };

        try {
            const response = await fetch(`../../routing.php?controller=asignacion&action=update`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                NotificationService.showSuccess('Asignación actualizada');
                modal.classList.remove('show');
                await loadAsignacionData();
            } else {
                const res = await response.json();
                NotificationService.showError(res.error || 'Error al actualizar');
            }
        } catch (err) {
            NotificationService.showError('Error de servidor');
        }
    };

    const showDetails = () => {
        loadingState.style.display = 'none';
        detailsContainer.style.display = 'grid';
        errorState.style.display = 'none';
    };

    const showError = (msg) => {
        loadingState.style.display = 'none';
        detailsContainer.style.display = 'none';
        errorState.style.display = 'block';
        errorMessage.textContent = msg;
    };

    init();
});
