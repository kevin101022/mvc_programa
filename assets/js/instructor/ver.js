// Instructor Detail JavaScript
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const instId = urlParams.get('id');

    if (!instId) {
        window.location.href = 'index.php';
        return;
    }

    const loadInstructor = async () => {
        try {
            const response = await fetch(`../../routing.php?controller=instructor&action=show&id=${instId}`);
            const inst = await response.json();

            if (response.ok) {
                // UI Elements
                document.getElementById('instIdDisplay').textContent = String(inst.inst_id).padStart(3, '0');
                document.getElementById('instNombreCompleto').textContent = `${inst.inst_nombres} ${inst.inst_apellidos}`;
                document.getElementById('instCorreo').textContent = inst.inst_correo;
                document.getElementById('instTelefono').textContent = inst.inst_telefono || 'No registrado';
                document.getElementById('instSede').textContent = inst.sede_nombre || 'Sin sede asignada';
                document.getElementById('instInitial').textContent = `${inst.inst_nombres[0]}${inst.inst_apellidos[0]}`;

                document.getElementById('editLink').href = `editar.php?id=${inst.inst_id}`;
            } else {
                NotificationService.showError('Instructor no encontrado');
                setTimeout(() => window.location.href = 'index.php', 2000);
            }
        } catch (error) {
            console.error('Error:', error);
            NotificationService.showError('Error al cargar detalle');
        }
    };

    // Modal logic
    const deleteBtn = document.getElementById('deleteBtn');
    const deleteModal = document.getElementById('deleteModal');
    const cancelDelete = document.getElementById('cancelDelete');
    const cancelDeleteX = document.getElementById('cancelDeleteX');
    const confirmDelete = document.getElementById('confirmDelete');

    if (deleteBtn) {
        deleteBtn.onclick = () => deleteModal.classList.add('show');
    }

    if (deleteModal) {
        const closeModal = () => deleteModal.classList.remove('show');
        if (cancelDelete) cancelDelete.onclick = closeModal;
        if (cancelDeleteX) cancelDeleteX.onclick = closeModal;

        if (confirmDelete) {
            confirmDelete.onclick = async () => {
                try {
                    const response = await fetch(`../../routing.php?controller=instructor&action=destroy&id=${instId}`, {
                        method: 'GET'
                    });

                    if (response.ok) {
                        NotificationService.showSuccess('Instructor eliminado correctamente');
                        setTimeout(() => window.location.href = 'index.php', 1500);
                    } else {
                        NotificationService.showError('Error al eliminar instructor');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    NotificationService.showError('Error de red');
                }
                closeModal();
            };
        }
    }

    loadInstructor();
});
