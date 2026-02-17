document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('fichaTableBody');
    const searchInput = document.getElementById('searchInput');
    const totalLabel = document.getElementById('totalFichas');
    const addBtn = document.getElementById('addBtn');
    const modal = document.getElementById('fichaModal');
    const form = document.getElementById('fichaForm');
    const closeBtn = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const programaSelect = document.getElementById('programa_id');
    const instructorSelect = document.getElementById('instructor_id');
    const coordinacionSelect = document.getElementById('coordinacion_id');

    let fichas = [];

    const loadData = async () => {
        try {
            const headers = { 'Accept': 'application/json' };

            // Load Programas
            const progRes = await fetch('../../routing.php?controller=programa&action=index', { headers });
            if (progRes.ok) {
                const programas = await progRes.json();
                if (programaSelect) {
                    programaSelect.innerHTML = '<option value="">Seleccione programa...</option>';
                    programas.forEach(p => {
                        const opt = document.createElement('option');
                        opt.value = p.prog_id;
                        opt.textContent = p.prog_nombre || p.prog_denominacion;
                        programaSelect.appendChild(opt);
                    });
                }
            }

            // Load Instructores
            const instRes = await fetch('../../routing.php?controller=instructor&action=index', { headers });
            if (instRes.ok) {
                const instructores = await instRes.json();
                if (instructorSelect) {
                    instructorSelect.innerHTML = '<option value="">Seleccione instructor líder...</option>';
                    instructores.forEach(i => {
                        const opt = document.createElement('option');
                        opt.value = i.inst_id;
                        opt.textContent = `${i.inst_nombres} ${i.inst_apellidos}`;
                        instructorSelect.appendChild(opt);
                    });
                }
            }

            // Load Coordinaciones
            const coordRes = await fetch('../../routing.php?controller=coordinacion&action=index', { headers });
            if (coordRes.ok) {
                const coordinaciones = await coordRes.json();
                if (coordinacionSelect) {
                    coordinacionSelect.innerHTML = '<option value="">Seleccione coordinación...</option>';
                    coordinaciones.forEach(c => {
                        const opt = document.createElement('option');
                        opt.value = c.coord_id;
                        opt.textContent = c.coord_nombre;
                        coordinacionSelect.appendChild(opt);
                    });
                }
            }

            // Load Fichas
            const fichaRes = await fetch('../../routing.php?controller=ficha&action=index', { headers });
            const data = await fichaRes.json();

            if (!fichaRes.ok) {
                throw new Error(data.details || data.error || 'Error al cargar fichas');
            }

            fichas = Array.isArray(data) ? data : [];
            renderFichas(fichas);
            if (totalLabel) totalLabel.textContent = fichas.length;
        } catch (error) {
            console.error('Error:', error);
            if (tableBody) {
                tableBody.innerHTML = `<tr><td colspan="5" class="text-center py-8 text-red-500">Error: ${error.message}</td></tr>`;
            }
        }
    };

    const renderFichas = (data) => {
        if (!tableBody) return;
        tableBody.innerHTML = '';

        if (!Array.isArray(data) || data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-8 text-gray-500">No se encontraron fichas</td></tr>';
            return;
        }

        data.forEach(f => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-green-50/50 transition-colors cursor-pointer group';
            row.onclick = () => window.location.href = `ver.php?id=${f.fich_id}`;
            row.innerHTML = `
                <td class="px-6 py-4">
                    <span class="text-sena-green font-bold text-sm tracking-wider">
                        ${f.fich_id}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="text-gray-900 font-semibold text-sm">${f.titpro_nombre || 'N/A'}</div>
                </td>
                <td class="px-6 py-4 text-gray-600 text-sm">
                    ${f.coord_nombre || 'No asignada'}
                </td>
                <td class="px-6 py-4 text-gray-600 text-sm">${f.inst_nombres || ''} ${f.inst_apellidos || ''}</td>
                <td class="px-6 py-4">
                    <span class="status-badge status-active">${f.fich_jornada || 'N/A'}</span>
                </td>
            `;
            tableBody.appendChild(row);
        });

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.onclick = () => {
                const id = btn.dataset.id;
                const ficha = fichas.find(f => f.fich_id == id);
                if (ficha) openModal(ficha);
            };
        });
    };

    const openModal = (ficha = null) => {
        if (!form) return;
        form.reset();

        const modalTitle = document.getElementById('modalTitle');
        const fichIdInput = document.getElementById('fich_id');
        const fichIdOldInput = document.getElementById('fich_id_old');

        if (ficha) {
            if (modalTitle) modalTitle.textContent = 'Editar Ficha';
            if (fichIdInput) {
                fichIdInput.value = ficha.fich_id;
                fichIdInput.readOnly = true; // No permitir cambiar el ID primario en edición
            }
            if (fichIdOldInput) fichIdOldInput.value = ficha.fich_id;

            if (document.getElementById('programa_id')) document.getElementById('programa_id').value = ficha.programa_prog_id || '';
            if (document.getElementById('instructor_id')) document.getElementById('instructor_id').value = ficha.instructor_inst_id || '';
            if (document.getElementById('coordinacion_id')) document.getElementById('coordinacion_id').value = ficha.coordinacion_coord_id || '';
            if (document.getElementById('fich_jornada')) document.getElementById('fich_jornada').value = ficha.fich_jornada || '';
        } else {
            if (modalTitle) modalTitle.textContent = 'Nueva Ficha';
            if (fichIdInput) {
                fichIdInput.value = '';
                fichIdInput.readOnly = false;
            }
            if (fichIdOldInput) fichIdOldInput.value = '';
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
            const idOld = document.getElementById('fich_id_old').value;
            const action = idOld ? 'update' : 'store';

            const data = {
                fich_id: document.getElementById('fich_id').value,
                programa_prog_id: document.getElementById('programa_id').value,
                instructor_inst_id: document.getElementById('instructor_id').value,
                coordinacion_id: document.getElementById('coordinacion_id').value,
                fich_jornada: document.getElementById('fich_jornada').value
            };

            try {
                const response = await fetch(`../../routing.php?controller=ficha&action=${action}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    NotificationService.showSuccess(idOld ? 'Ficha actualizada' : 'Ficha creada');
                    closeModal();
                    loadData();
                } else {
                    NotificationService.showError(result.details || result.error || 'Error al guardar ficha');
                }
            } catch (error) {
                console.error('Error al guardar:', error);
                NotificationService.showError('Error de conexión con el servidor');
            }
        };
    }

    window.deleteFicha = async (id) => {
        if (window.NotificationService) {
            NotificationService.showConfirm('¿Está seguro de eliminar esta ficha?', async () => {
                try {
                    const response = await fetch(`../../routing.php?controller=ficha&action=destroy&id=${id}`, {
                        headers: { 'Accept': 'application/json' }
                    });

                    if (response.ok) {
                        NotificationService.showSuccess('Ficha eliminada');
                        loadData();
                    } else {
                        const data = await response.json();
                        NotificationService.showError(data.details || data.error || 'Error al eliminar');
                    }
                } catch (error) {
                    NotificationService.showError('Error de conexión');
                }
            });
        } else {
            if (!confirm('¿Está seguro?')) return;
            // ... (legacy handling)
        }
    };

    if (searchInput) {
        searchInput.oninput = () => {
            const term = searchInput.value.toLowerCase();
            const filtered = fichas.filter(f =>
                String(f.fich_id).toLowerCase().includes(term) ||
                (f.titpro_nombre || '').toLowerCase().includes(term) ||
                (f.inst_nombres || '').toLowerCase().includes(term) ||
                (f.inst_apellidos || '').toLowerCase().includes(term)
            );
            renderFichas(filtered);
        };
    }

    loadData();
});
