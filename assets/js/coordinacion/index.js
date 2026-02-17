document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('coordinacionTableBody');
    const searchInput = document.getElementById('searchInput');
    const totalLabel = document.getElementById('totalCoordinaciones');
    const addBtn = document.getElementById('addBtn');
    const modal = document.getElementById('coordinacionModal');
    const form = document.getElementById('coordinacionForm');
    const closeBtn = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');
    const centroSelect = document.getElementById('centro_id');

    let coordinaciones = [];

    const loadCentros = async () => {
        try {
            const response = await fetch('../../routing.php?controller=centro_formacion&action=index', {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Error al cargar centros');
            const centros = await response.json();

            if (centroSelect) {
                centroSelect.innerHTML = '<option value="">Seleccione un centro...</option>';
                centros.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.cent_id;
                    opt.textContent = c.cent_nombre;
                    centroSelect.appendChild(opt);
                });
            }
        } catch (error) {
            console.error('Error al cargar centros:', error);
        }
    };

    const loadCoordinaciones = async () => {
        try {
            const response = await fetch('../../routing.php?controller=coordinacion&action=index', {
                headers: { 'Accept': 'application/json' }
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.details || data.error || 'Error del servidor');
            }

            coordinaciones = Array.isArray(data) ? data : [];
            renderCoordinaciones(coordinaciones);
            if (totalLabel) totalLabel.textContent = coordinaciones.length;
        } catch (error) {
            console.error('Error:', error);
            if (tableBody) {
                tableBody.innerHTML = `<tr><td colspan="4" class="text-center py-8 text-red-500">Error: ${error.message}</td></tr>`;
            }
        }
    };

    const renderCoordinaciones = (data) => {
        if (!tableBody) return;
        tableBody.innerHTML = '';
        if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="4" class="text-center py-8 text-gray-500">No se encontraron coordinaciones</td></tr>';
            return;
        }

        data.forEach(c => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-green-50/50 transition-colors cursor-pointer group';
            row.onclick = () => window.location.href = `ver.php?id=${c.coord_id}`;
            row.innerHTML = `
                <td class="px-6 py-4 font-semibold text-sena-green">${String(c.coord_id).padStart(3, '0')}</td>
                <td class="px-6 py-4 font-bold text-gray-900">${c.coord_nombre}</td>
                <td class="px-6 py-4 text-gray-600">${c.cent_nombre || 'N/A'}</td>
            `;
            tableBody.appendChild(row);
        });

        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.onclick = () => {
                const id = btn.dataset.id;
                const coord = coordinaciones.find(c => c.coord_id == id);
                if (coord) openModal(coord);
            };
        });
    };

    const openModal = (coord = null) => {
        if (!form) return;
        form.reset();

        const modalTitle = document.getElementById('modalTitle');
        const coordIdInput = document.getElementById('coord_id');
        const coordNombreInput = document.getElementById('coord_nombre');
        const centroIdInput = document.getElementById('centro_id');

        if (coord) {
            if (modalTitle) modalTitle.textContent = 'Editar Coordinación';
            if (coordIdInput) coordIdInput.value = coord.coord_id;
            if (coordNombreInput) coordNombreInput.value = coord.coord_nombre;
            if (centroIdInput) centroIdInput.value = coord.centro_formacion_cent_id;
        } else {
            if (modalTitle) modalTitle.textContent = 'Nueva Coordinación';
            if (coordIdInput) coordIdInput.value = '';
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
            const id = document.getElementById('coord_id').value;
            const action = id ? 'update' : 'store';
            const data = {
                coord_nombre: document.getElementById('coord_nombre').value,
                centro_formacion_cent_id: document.getElementById('centro_id').value
            };
            if (id) data.coord_id = id;

            try {
                const response = await fetch(`../../routing.php?controller=coordinacion&action=${action}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    NotificationService.showSuccess(id ? 'Coordinación actualizada' : 'Coordinación creada');
                    closeModal();
                    loadCoordinaciones();
                } else {
                    NotificationService.showError(result.details || result.error || 'Error al guardar');
                }
            } catch (error) {
                NotificationService.showError('Error de conexión');
            }
        };
    }

    window.deleteCoordinacion = async (id) => {
        if (!confirm('¿Está seguro de eliminar esta coordinación?')) return;
        try {
            const response = await fetch(`../../routing.php?controller=coordinacion&action=destroy&id=${id}`, {
                headers: { 'Accept': 'application/json' }
            });
            const result = await response.json();

            if (response.ok) {
                NotificationService.showSuccess('Coordinación eliminada');
                loadCoordinaciones();
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
            const filtered = coordinaciones.filter(c =>
                c.coord_nombre.toLowerCase().includes(term) ||
                (c.cent_nombre || '').toLowerCase().includes(term)
            );
            renderCoordinaciones(filtered);
        };
    }

    loadCentros();
    loadCoordinaciones();
});
