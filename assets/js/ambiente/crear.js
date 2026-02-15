document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('ambienteForm');
    const sedeSelect = document.getElementById('sede_sede_id');

    // Load sedes into select
    fetch('../../routing.php?controller=sede&action=index')
        .then(res => {
            if (!res.ok) throw new Error('Network response was not ok');
            return res.json();
        })
        .then(sedes => {
            sedes.forEach(s => {
                const opt = document.createElement('option');
                opt.value = s.sede_id;
                opt.textContent = s.sede_nombre;
                sedeSelect.appendChild(opt);
            });
        })
        .catch(err => console.error('Error loading sedes:', err));

    form.onsubmit = (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        formData.append('controller', 'ambiente');
        formData.append('action', 'store');

        fetch('../../routing.php', {
            method: 'POST',
            body: formData,
            headers: {
                'Accept': 'application/json'
            }
        })
            .then(res => {
                if (!res.ok) return res.json().then(err => { throw err; });
                return res.json();
            })
            .then(data => {
                if (data.message) {
                    document.getElementById('successModal').classList.add('show');
                } else {
                    alert('Error: ' + (data.error || 'Ocurrió un error inesperado'));
                }
            })
            .catch(err => {
                console.error('Error saving ambiente:', err);
                const detail = err.description || err.message || '';
                alert('Error al guardar: ' + (err.error || 'Error en el servidor') + (detail ? '\n\nDetalle: ' + detail : ''));
            });
    };

    window.closeSuccessModal = () => {
        document.getElementById('successModal').classList.remove('show');
        form.reset();
    };
});
