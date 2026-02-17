document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const asigId = urlParams.get('id');
    const tableBody = document.getElementById('detalleTableBody');
    const addDetailBtn = document.getElementById('addDetailBtn');
    const modal = document.getElementById('detalleModal');
    const form = document.getElementById('detalleForm');
    const closeBtn = document.getElementById('closeModal');
    const cancelBtn = document.getElementById('cancelBtn');

    if (!asigId) {
        window.location.href = 'index.php';
        return;
    }

    const loadHeaderInfo = async () => {
        try {
            const response = await fetch(`../../routing.php?controller=asignacion&action=show&id=${asigId}`);
            const asig = await response.json();
            if (response.ok) {
                document.getElementById('infoInstructor').textContent = `${asig.inst_nombres} ${asig.inst_apellidos}`;
                document.getElementById('infoFicha').textContent = `Ficha: ${asig.fich_id}`;
                document.getElementById('infoAmbiente').textContent = asig.amb_nombre;
                document.getElementById('infoPeriodo').textContent = `Del ${asig.asig_fecha_ini} al ${asig.asig_fecha_fin}`;
            }
        } catch (error) {
            console.error('Error al cargar info:', error);
        }
    };

    const loadDetalles = async () => {
        try {
            const response = await fetch(`../../routing.php?controller=detalle_asignacion&action=index&asig_id=${asigId}`);
            const detalles = await response.json();
            renderDetalles(detalles);
        } catch (error) {
            tableBody.innerHTML = '<tr><td colspan="3" class="text-center py-8 text-red-500">Error al cargar datos</td></tr>';
        }
    };

    const renderDetalles = (data) => {
        tableBody.innerHTML = '';
        if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="3" class="text-center py-8 text-gray-500">No hay franjas registradas para esta asignación</td></tr>';
            return;
        }

        data.forEach(d => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-green-50/50 transition-colors';
            row.innerHTML = `
                <td class="px-6 py-4 font-bold text-gray-900">${d.detasig_hora_ini}</td>
                <td class="px-6 py-4 font-bold text-gray-900">${d.detasig_hora_fin}</td>
                <td class="px-6 py-4 text-right flex justify-end gap-2">
                    <button class="action-btn edit-btn" data-id="${d.detasig_id}" title="Editar">
                        <ion-icon src="../../assets/ionicons/create-outline.svg"></ion-icon>
                    </button>
                    <button class="action-btn text-red-500 hover:bg-red-50" onclick="deleteDetalle(${d.detasig_id})" title="Eliminar">
                        <ion-icon src="../../assets/ionicons/trash-outline.svg"></ion-icon>
                    </button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Event listeners for edit buttons
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.onclick = () => {
                const id = btn.dataset.id;
                const detail = data.find(item => item.detasig_id == id);
                if (detail) openModal(detail);
            };
        });
    };

    const openModal = (detail = null) => {
        form.reset();
        document.getElementById('asig_id_input').value = asigId;
        if (detail) {
            document.getElementById('modalTitle').textContent = 'Editar Franja Horaria';
            document.getElementById('detasig_id').value = detail.detasig_id;
            document.getElementById('detasig_hora_ini').value = detail.detasig_hora_ini;
            document.getElementById('detasig_hora_fin').value = detail.detasig_hora_fin;
        } else {
            document.getElementById('modalTitle').textContent = 'Nueva Franja Horaria';
            document.getElementById('detasig_id').value = '';
        }
        modal.classList.add('show');
    };

    const closeModal = () => modal.classList.remove('show');

    addDetailBtn.onclick = () => openModal();
    closeBtn.onclick = closeModal;
    cancelBtn.onclick = closeModal;

    form.onsubmit = async (e) => {
        e.preventDefault();
        const id = document.getElementById('detasig_id').value;
        const action = id ? 'update' : 'store';
        const data = {};
        new FormData(form).forEach((v, k) => data[k] = v);

        try {
            const response = await fetch(`../../routing.php?controller=detalle_asignacion&action=${action}`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(data)
            });

            if (response.ok) {
                NotificationService.showSuccess(id ? 'Franja actualizada' : 'Franja creada');
                closeModal();
                loadDetalles();
            } else {
                NotificationService.showError('Error al guardar franja');
            }
        } catch (error) {
            NotificationService.showError('Error de conexión');
        }
    };

    window.deleteDetalle = async (id) => {
        if (!confirm('¿Está seguro de eliminar esta franja horaria?')) return;
        try {
            const response = await fetch(`../../routing.php?controller=detalle_asignacion&action=destroy&id=${id}`);
            if (response.ok) {
                NotificationService.showSuccess('Franja eliminada');
                loadDetalles();
            } else {
                NotificationService.showError('Error al eliminar');
            }
        } catch (error) {
            NotificationService.showError('Error de conexión');
        }
    };

    loadHeaderInfo();
    loadDetalles();
});
