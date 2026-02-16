// Instructor Create JavaScript
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('instructorForm');
    const sedeSelect = document.getElementById('sede_id');
    const submitBtn = document.getElementById('submitBtn');

    const loadSedes = async () => {
        try {
            const response = await fetch('../../routing.php?controller=instructor&action=getSedes');
            const sedes = await response.json();

            sedes.forEach(sede => {
                const option = document.createElement('option');
                option.value = sede.sede_id;
                option.textContent = sede.sede_nombre;
                sedeSelect.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar sedes:', error);
            if (typeof NotificationService !== 'undefined') {
                NotificationService.showError('No se pudieron cargar las sedes');
            }
        }
    };

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        submitBtn.disabled = true;
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => data[key] = value);

        try {
            const response = await fetch('../../routing.php?controller=instructor&action=store', {
                method: 'POST',
                body: JSON.stringify(data),
                headers: {
                    'Content-Type': 'application/json'
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

    loadSedes();
});
