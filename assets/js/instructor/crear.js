// Instructor Create JavaScript
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('instructorForm');
    const sedeSelect = document.getElementById('sede_id');
    const submitBtn = document.getElementById('submitBtn');

    const loadCentros = async () => {
        try {
            const response = await fetch('../../routing.php?controller=instructor&action=getCentros', {
                headers: {
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error('Error en la respuesta del servidor');
            }

            const centros = await response.json();

            centros.forEach(centro => {
                const option = document.createElement('option');
                option.value = centro.cent_id;
                option.textContent = centro.cent_nombre;
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
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });

            let result;
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.indexOf("application/json") !== -1) {
                result = await response.json();
            } else {
                const text = await response.text();
                console.error('Servidor devolvió HTML/Texto en lugar de JSON:', text);
                NotificationService.showError('Error interno del servidor. Revisa la consola.');
                submitBtn.disabled = false;
                return;
            }

            if (response.ok) {
                NotificationService.showSuccess('Instructor registrado con éxito');
                setTimeout(() => window.location.href = 'index.php', 1500);
            } else {
                console.error('Error detallado:', result);
                NotificationService.showError(result.error || 'Error al registrar instructor');
                if (result.details) {
                    console.error('Detalles del error:', result.details, 'en', result.file, 'línea', result.line);
                }
                submitBtn.disabled = false;
            }
        } catch (error) {
            console.error('Error:', error);
            NotificationService.showError('Error de conexión con el servidor');
            submitBtn.disabled = false;
        }
    });

    loadCentros();
});
