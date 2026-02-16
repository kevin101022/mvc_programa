// Instructor Management JavaScript
document.addEventListener('DOMContentLoaded', () => {
    const tableBody = document.getElementById('instructorTableBody');
    const mobileGrid = document.getElementById('instructorMobileGrid');
    const searchInput = document.getElementById('searchInput');
    const sedeFilter = document.getElementById('sedeFilter');
    const totalInstructoresLabel = document.getElementById('totalInstructores');
    const refreshBtn = document.getElementById('refreshBtn');

    let instructores = [];

    const loadSedes = async () => {
        try {
            const response = await fetch('../../routing.php?controller=instructor&action=getSedes');
            const sedes = await response.json();

            sedeFilter.innerHTML = '<option value="">Todas las Sedes</option>';
            sedes.forEach(sede => {
                const option = document.createElement('option');
                option.value = sede.sede_id;
                option.textContent = sede.sede_nombre;
                sedeFilter.appendChild(option);
            });
        } catch (error) {
            console.error('Error al cargar sedes:', error);
        }
    };

    const loadInstructores = async () => {
        try {
            const response = await fetch('../../routing.php?controller=instructor&action=index');
            instructores = await response.json();
            renderInstructores(instructores);
            updateStats(instructores);
        } catch (error) {
            console.error('Error:', error);
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-8 text-red-500">Error al cargar datos</td></tr>';
        }
    };

    const renderInstructores = (data) => {
        tableBody.innerHTML = '';

        if (data.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="5" class="text-center py-8 text-gray-500">No se encontraron instructores</td></tr>';
            return;
        }

        data.forEach(inst => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-green-50/50 transition-colors cursor-pointer group';
            row.onclick = () => window.location.href = `ver.php?id=${inst.inst_id}`;

            row.innerHTML = `
                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-sena-green">
                    ${String(inst.inst_id).padStart(3, '0')}
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-green-50 flex items-center justify-center text-green-600 font-bold">
                            ${inst.inst_nombres[0]}${inst.inst_apellidos[0]}
                        </div>
                        <div>
                            <div class="font-bold text-gray-900">${inst.inst_nombres} ${inst.inst_apellidos}</div>
                            <div class="text-xs text-gray-500">Instructor SENA</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="text-sm text-gray-600">${inst.inst_correo}</div>
                    <div class="text-xs text-gray-400">${inst.inst_telefono || 'Sin teléfono'}</div>
                </td>
                <td class="px-6 py-4">
                    <span class="status-badge status-active">
                        ${inst.sede_nombre || 'Sin sede'}
                    </span>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="table-actions">
                        <button class="action-btn" title="Ver detalles">
                            <ion-icon src="../../assets/ionicons/eye-outline.svg"></ion-icon>
                        </button>
                    </div>
                </td>
            `;
            tableBody.appendChild(row);
        });
    };

    const updateStats = (data) => {
        if (totalInstructoresLabel) totalInstructoresLabel.textContent = data.length;
    };

    const filterData = () => {
        const searchTerm = searchInput.value.toLowerCase();
        const sedeId = sedeFilter.value;

        const filtered = instructores.filter(inst => {
            const matchesSearch =
                inst.inst_nombres.toLowerCase().includes(searchTerm) ||
                inst.inst_apellidos.toLowerCase().includes(searchTerm) ||
                inst.inst_correo.toLowerCase().includes(searchTerm);

            const matchesSede = !sedeId || inst.centro_formacion_cent_id == sedeId;

            return matchesSearch && matchesSede;
        });

        renderInstructores(filtered);
    };

    searchInput.addEventListener('input', filterData);
    sedeFilter.addEventListener('change', filterData);
    if (refreshBtn) refreshBtn.onclick = loadInstructores;

    loadSedes();
    loadInstructores();
});
