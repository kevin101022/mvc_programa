// Instructor Edit JavaScript
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('instructorForm');
    const sedeSelect = document.getElementById('sede_id');
    const instId = document.getElementById('inst_id').value;
    const submitBtn = document.getElementById('submitBtn');

    const loadData = async () => {
        try {
            // Load sedes first
            const sedesRes = await fetch('../../routing.php?controller=instructor&action=getSedes');
            const sedes = await sedesRes.json();

            sedes.forEach(sede => {
                const option = document.createElement('option');
                option.value = sede.sede_id;
                option.textContent = sede.sede_nombre;
                sedeSelect.appendChild(option);
            });

            // Load instructor data
            const response = await fetch(`../../routing.php?controller=instructor&action=show&id=${instId}`);
            const inst = await response.json();

            if (response.ok) {
                document.getElementById('inst_nombres').value = inst.inst_nombres;
                document.getElementById('inst_apellidos').value = inst.inst_apellidos;
                document.getElementById('inst_correo').value = inst.inst_correo;
                document.getElementById('inst_telefono').value = inst.inst_telefono;
                sedeSelect.value = inst.centro_formacion_cent_id;
            }
        } catch (error) {
            console.error('Error:', error);
            NotificationService.showError('Error al cargar datos del instructor');
        }
    };

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        submitBtn.disabled = true;
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => data[key] = value);

        try {
            const response = await fetch('../../routing.php?controller=instructor&action=update', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok) {
                NotificationService.showSuccess('Instructor actualizado con éxito');
                setTimeout(() => window.location.href = `ver.php?id=${instId}`, 1500);
            } else {
                NotificationService.showError(result.error || 'Error al actualizar instructor');
                submitBtn.disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
            NotificationService.showError('Error de conexión');
            submitBtn.disabled = false;
        }
    });

    loadData();
});
