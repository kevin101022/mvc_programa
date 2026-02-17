// Instructor Edit JavaScript
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('instructorForm');
    const centroSelect = document.getElementById('centro_id');
    const especialidadSelect = document.getElementById('especialidad_id');
    const instId = document.getElementById('inst_id').value;
    const submitBtn = document.getElementById('submitBtn');

    const loadData = async () => {
        try {
            const [centrosRes, competenciasRes, instructorRes] = await Promise.all([
                fetch('../../routing.php?controller=instructor&action=getCentros'),
                fetch('../../routing.php?controller=competencia&action=index'),
                fetch(`../../routing.php?controller=instructor&action=show&id=${instId}`)
            ]);

            const centros = await centrosRes.json();
            centros.forEach(centro => {
                const option = document.createElement('option');
                option.value = centro.cent_id;
                option.textContent = centro.cent_nombre;
                centroSelect.appendChild(option);
            });

            const competencias = await competenciasRes.json();
            if (especialidadSelect) {
                especialidadSelect.innerHTML = '<option value="">Seleccione competencia...</option>';
                competencias.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.comp_nombre_corto;
                    opt.textContent = c.comp_nombre_corto;
                    especialidadSelect.appendChild(opt);
                });
            }

            if (!instructorRes.ok) throw new Error('Error al cargar datos del instructor');
            const instructor = await instructorRes.json();

            document.getElementById('inst_nombres').value = instructor.inst_nombres;
            document.getElementById('inst_apellidos').value = instructor.inst_apellidos;
            document.getElementById('inst_correo').value = instructor.inst_correo;
            document.getElementById('inst_telefono').value = instructor.inst_telefono || '';
            centroSelect.value = instructor.centro_formacion_cent_id;
            if (especialidadSelect) especialidadSelect.value = instructor.especialidad || '';
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
