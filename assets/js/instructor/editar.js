// Instructor Edit JavaScript
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('instructorForm');
    const sedeSelect = document.getElementById('sede_id');
    const centroSelect = document.getElementById('sede_id'); // Assuming sede_id element will now hold centro data
    const instId = document.getElementById('inst_id').value;
    const submitBtn = document.getElementById('submitBtn');

    const loadData = async () => {
        try {
            // Load centros first
            const centrosRes = await fetch('../../routing.php?controller=instructor&action=getCentros');
            const centros = await centrosRes.json();

            centros.forEach(centro => {
                const option = document.createElement('option');
                option.value = centro.cent_id;
                option.textContent = centro.cent_nombre;
                centroSelect.appendChild(option);
            });

            // Load instructor data
            const instructorRes = await fetch(`../../routing.php?controller=instructor&action=show&id=${instId}`);

            if (!instructorRes.ok) {
                throw new Error('Error al cargar datos del instructor');
            }

            const instructor = await instructorRes.json();

            if (instructorRes.ok) {
                document.getElementById('inst_nombres').value = instructor.inst_nombres;
                document.getElementById('inst_apellidos').value = instructor.inst_apellidos;
                document.getElementById('inst_correo').value = instructor.inst_correo;
                document.getElementById('inst_telefono').value = instructor.inst_telefono;
                sedeSelect.value = instructor.centro_formacion_cent_id;
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
