// Instructor Create JavaScript
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('instructorForm');
    const centroSelect = document.getElementById('centro_id');
    const especialidadSelect = document.getElementById('especialidad_id');
    const submitBtn = document.getElementById('submitBtn');

    if (!centroSelect) {
        console.error('Error: El elemento select con ID "centro_id" no existe en el DOM.');
        return;
    }

    const loadCentros = async () => {
        try {
            const response = await fetch('../../routing.php?controller=instructor&action=getCentros', {
                headers: { 'Accept': 'application/json' }
            });

            if (!response.ok) throw new Error('Error al obtener centros');

            const centros = await response.json();

            centroSelect.innerHTML = '<option value="">Seleccione un centro de formación...</option>';

            centros.forEach(centro => {
                const option = document.createElement('option');
                option.value = centro.cent_id;
                option.textContent = centro.cent_nombre;
                centroSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar centros:', error);
            if (typeof NotificationService !== 'undefined') {
                NotificationService.showError('No se pudieron cargar los centros de formación');
            }
        }
    };

    const loadCompetencias = async () => {
        if (!especialidadSelect) return;
        try {
            const response = await fetch('../../routing.php?controller=competencia&action=index', {
                headers: { 'Accept': 'application/json' }
            });
            if (!response.ok) throw new Error('Error al obtener competencias');
            const competencias = await response.json();
            especialidadSelect.innerHTML = '<option value="">Seleccione competencia...</option>';
            competencias.forEach(c => {
                const opt = document.createElement('option');
                opt.value = c.comp_nombre_corto;
                opt.textContent = c.comp_nombre_corto;
                especialidadSelect.appendChild(opt);
            });
        } catch (error) {
            console.error('Error al cargar competencias:', error);
        }
    };

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        submitBtn.disabled = true;
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => data[key] = value);

        try {
            const response = await fetch('../../routing.php?controller=instructor&action=store', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (response.ok) {
                NotificationService.showSuccess('Instructor registrado con éxito');
                setTimeout(() => window.location.href = 'index.php', 1500);
            } else {
                NotificationService.showError(result.error || 'Error al registrar instructor');
                submitBtn.disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
            NotificationService.showError('Error de conexión con el servidor');
            submitBtn.disabled = false;
        }
    });

    loadCentros();
    loadCompetencias();
});
