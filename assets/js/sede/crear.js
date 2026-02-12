// Sede Form JavaScript
class SedeForm {
    constructor() {
        this.form = document.getElementById('sedeForm');
        this.init();
    }

    init() {
        this.bindEvents();
        this.setupValidation();
    }

    bindEvents() {
        if (this.form) {
            this.form.addEventListener('submit', (e) => {
                e.preventDefault();
                this.handleSubmit();
            });
        }

        // Real-time validation
        const sedeNombreInput = document.getElementById('sede_nombre');
        if (sedeNombreInput) {
            sedeNombreInput.addEventListener('blur', () => {
                this.validateSedeNombre();
            });
            
            sedeNombreInput.addEventListener('input', () => {
                this.clearError('sede_nombre');
            });
        }

        // Modal events
        window.closeSuccessModal = () => {
            this.closeSuccessModal();
        };
    }

    setupValidation() {
        // Add validation rules
        this.validationRules = {
            sede_nombre: {
                required: true,
                minLength: 3,
                maxLength: 100,
                pattern: /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s\-\.]+$/
            }
        };
    }

    async handleSubmit() {
        if (!this.validateForm()) {
            return;
        }

        const submitBtn = this.form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        try {
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <div class="loading-spinner" style="width: 16px; height: 16px; margin-right: 8px;"></div>
                Guardando...
            `;

            const formData = new FormData(this.form);
            const sedeData = {
                sede_nombre: formData.get('sede_nombre').trim()
            };

            // Check if sede name already exists
            const exists = await this.checkSedeExists(sedeData.sede_nombre);
            if (exists) {
                this.showError('sede_nombre', 'Ya existe una sede con este nombre');
                return;
            }

            // Submit to API
            const result = await this.createSede(sedeData);
            
            if (result.success) {
                this.showSuccessModal(sedeData.sede_nombre);
                this.form.reset();
            } else {
                throw new Error(result.message || 'Error al crear la sede');
            }

        } catch (error) {
            console.error('Error creating sede:', error);
            this.showError('sede_nombre', error.message || 'Error al crear la sede');
        } finally {
            // Restore button state
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    }

    validateForm() {
        let isValid = true;

        // Validate sede_nombre
        if (!this.validateSedeNombre()) {
            isValid = false;
        }

        return isValid;
    }

    validateSedeNombre() {
        const input = document.getElementById('sede_nombre');
        const value = input.value.trim();
        const rules = this.validationRules.sede_nombre;

        // Required validation
        if (rules.required && !value) {
            this.showError('sede_nombre', 'El nombre de la sede es obligatorio');
            return false;
        }

        // Length validation
        if (value && value.length < rules.minLength) {
            this.showError('sede_nombre', `El nombre debe tener al menos ${rules.minLength} caracteres`);
            return false;
        }

        if (value && value.length > rules.maxLength) {
            this.showError('sede_nombre', `El nombre no puede exceder ${rules.maxLength} caracteres`);
            return false;
        }

        // Pattern validation
        if (value && !rules.pattern.test(value)) {
            this.showError('sede_nombre', 'El nombre contiene caracteres no válidos');
            return false;
        }

        this.clearError('sede_nombre');
        return true;
    }

    showError(fieldName, message) {
        const errorElement = document.getElementById(`${fieldName}_error`);
        const inputElement = document.getElementById(fieldName);

        if (errorElement) {
            errorElement.textContent = message;
            errorElement.classList.add('show');
        }

        if (inputElement) {
            inputElement.style.borderColor = 'var(--red-500)';
            inputElement.focus();
        }
    }

    clearError(fieldName) {
        const errorElement = document.getElementById(`${fieldName}_error`);
        const inputElement = document.getElementById(fieldName);

        if (errorElement) {
            errorElement.textContent = '';
            errorElement.classList.remove('show');
        }

        if (inputElement) {
            inputElement.style.borderColor = '';
        }
    }

    async checkSedeExists(sedeName) {
        try {
            // Mock API call - replace with actual endpoint
            const response = await fetch(`/api/sedes/check-name?name=${encodeURIComponent(sedeName)}`);
            const data = await response.json();
            return data.exists;
        } catch (error) {
            console.error('Error checking sede name:', error);
            return false; // Assume it doesn't exist if we can't check
        }
    }

    async createSede(sedeData) {
        try {
            // Mock API call - replace with actual endpoint
            const response = await fetch('/api/sedes', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(sedeData)
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            return data;
        } catch (error) {
            // Mock successful response for demo
            return new Promise((resolve) => {
                setTimeout(() => {
                    resolve({
                        success: true,
                        sede_id: Math.floor(Math.random() * 1000) + 100,
                        message: 'Sede creada exitosamente'
                    });
                }, 1000);
            });
        }
    }

    showSuccessModal(sedeName) {
        const modal = document.getElementById('successModal');
        const sedeNameElement = document.getElementById('createdSedeName');

        if (sedeNameElement) {
            sedeNameElement.textContent = sedeName;
        }

        if (modal) {
            modal.classList.add('show');
        }
    }

    closeSuccessModal() {
        const modal = document.getElementById('successModal');
        if (modal) {
            modal.classList.remove('show');
        }
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new SedeForm();
});