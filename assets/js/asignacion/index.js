document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('asignacionTableBody');
    const searchInput = document.getElementById('searchInput');
    const totalLabel = document.getElementById('totalAsignaciones');
    const addBtn = document.getElementById('addBtn');
    const modal = document.getElementById('asignacionModal');
    const form = document.getElementById('asignacionForm');
    const closeBtn = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');

    let asignaciones = [];

    const loadSelects = async () => {
        try {
            const headers = { 'Accept': 'application/json' };
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

        } catch (error) {
            console.error('Error al cargar opciones:', error);
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

    const loadAsignaciones = async () => {
        try {
            const response = await fetch('../../routing.php?controller=asignacion&action=index', {
                headers: { 'Accept': 'application/json' }
            });
            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.details || data.error || 'Error al cargar asignaciones');
            }

            asignaciones = Array.isArray(data) ? data : [];
            renderAsignaciones(asignaciones);
            if (totalLabel) totalLabel.textContent = asignaciones.length;
        } catch (error) {
            console.error('Error:', error);
            if (tableBody) {
                tableBody.innerHTML = `<tr><td colspan="6" class="text-center py-8 text-red-500">Error: ${error.message}</td></tr>`;
            }
        }
    };

    const renderAsignaciones = (data) => {
        if (!tableBody) return;
        tableBody.innerHTML = '';
        if (!Array.isArray(data) || data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="6" class="text-center py-8 text-gray-500">No se encontraron asignaciones</td></tr>';
            return;
        }

        data.forEach(asig => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-green-50/50 transition-colors cursor-pointer group';
            row.onclick = () => window.location.href = `ver.php?id=${asig.asig_id}`;

            row.innerHTML = `
                <td class="px-6 py-4 font-semibold text-sena-green">${String(asig.asig_id).padStart(3, '0')}</td>
                <td class="px-6 py-4 font-bold text-gray-900">${asig.inst_nombres || ''} ${asig.inst_apellidos || ''}</td>
                <td class="px-6 py-4 text-gray-600">Ficha: ${asig.fich_id || asig.ficha_fich_id}</td>
                <td class="px-6 py-4">
                    <div class="text-sm font-semibold">${asig.amb_nombre || 'N/A'}</div>
                    <div class="text-xs text-gray-500">${asig.comp_nombre_corto || asig.comp_nombre || 'Sin nombre'}</div>
                </td>
                <td class="px-6 py-4 text-sm">
                    <div>Del: ${asig.asig_fecha_ini || ''}</div>
                    <div>Al: ${asig.asig_fecha_fin || ''}</div>
                </td>
            `;
            tableBody.appendChild(row);
        });

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.onclick = (e) => {
                e.stopPropagation();
                const id = btn.dataset.id;
                const asig = asignaciones.find(a => a.asig_id == id);
                if (asig) openModal(asig);
            };
        });
    };

    const openModal = (asig = null) => {
        if (!form) return;
        form.reset();

        const modalTitle = document.getElementById('modalTitle');
        const asigIdInput = document.getElementById('asig_id');

        if (asig) {
            if (modalTitle) modalTitle.textContent = 'Editar Asignación';
            if (asigIdInput) asigIdInput.value = asig.asig_id;

            // Set selects using standard database names or specific mappings
            document.getElementById('instructor_id').value = asig.instructor_inst_id || '';
            document.getElementById('ficha_id').value = asig.ficha_fich_id || asig.fich_id || '';
            document.getElementById('ambiente_id').value = asig.ambiente_amb_id || '';
            document.getElementById('competencia_id').value = asig.competencia_comp_id || '';
            document.getElementById('asig_fecha_ini').value = asig.asig_fecha_ini ? asig.asig_fecha_ini.replace(' ', 'T') : '';
            document.getElementById('asig_fecha_fin').value = asig.asig_fecha_fin ? asig.asig_fecha_fin.replace(' ', 'T') : '';
        } else {
            if (modalTitle) modalTitle.textContent = 'Nueva Asignación';
            if (asigIdInput) asigIdInput.value = '';
        }
        if (modal) modal.classList.add('show');
    };

    const closeModal = () => {
        if (modal) modal.classList.remove('show');
    };

    if (addBtn) addBtn.onclick = () => openModal();
    if (closeBtn) closeBtn.onclick = closeModal;
    if (cancelBtn) cancelBtn.onclick = closeModal;

    if (form) {
        form.onsubmit = async (e) => {
            e.preventDefault();
            const id = document.getElementById('asig_id').value;
            const action = id ? 'update' : 'store';

            const formData = new FormData(form);
            const data = {};
            formData.forEach((v, k) => data[k] = v);

            try {
                const response = await fetch(`../../routing.php?controller=asignacion&action=${action}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    NotificationService.showSuccess(id ? 'Asignación actualizada' : 'Asignación creada');
                    closeModal();
                    loadAsignaciones();
                } else {
                    NotificationService.showError(result.details || result.error || 'Error al guardar');
                }
            } catch (error) {
                console.error('Error al guardar:', error);
                NotificationService.showError('Error de conexión');
            }
        };
    }

    window.deleteAsignacion = async (id) => {
        if (!confirm('¿Está seguro de eliminar esta asignación?')) return;
        try {
            const response = await fetch(`../../routing.php?controller=asignacion&action=destroy&id=${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();

            if (response.ok) {
                NotificationService.showSuccess('Asignación eliminada');
                loadAsignaciones();
            } else {
                NotificationService.showError(result.details || result.error || 'Error al eliminar');
            }
        } catch (error) {
            NotificationService.showError('Error de conexión');
        }
    };

    if (searchInput) {
        searchInput.oninput = () => {
            const term = searchInput.value.toLowerCase();
            const filtered = asignaciones.filter(asig =>
                (asig.inst_nombres || '').toLowerCase().includes(term) ||
                (asig.inst_apellidos || '').toLowerCase().includes(term) ||
                (asig.amb_nombre || '').toLowerCase().includes(term) ||
                String(asig.fich_id || asig.ficha_fich_id || '').includes(term)
            );
            renderAsignaciones(filtered);
        };
    }

    loadSelects();
    loadAsignaciones();
});
