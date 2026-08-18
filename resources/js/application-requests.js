// Define the available units for each organization.
const units = {
    "Economía, Hacienda y Fondos Europeos": [
        "Dirección General de Contratación",
        "Dirección General de Patrimonio",
        "Dirección General de Presupuestos"
    ],
    "Educación": [
        "Dirección General del Profesorado y Gestión de Recursos Humanos",
        "Dirección General de Innovación y Formación del Profesorado",
        "Dirección General de Planificación, Centros y Enseñanza Concertada"
    ],
    "IA, Desarrollo Digital y Administración Pública": [
        "Dirección General de Desarrollo y Estrategia Digital",
        "Dirección General de Inteligencia Artificial",
        "Dirección General de Planificación y Evaluación del Sector Público"
    ],
    "Presidencia, Sanidad y Emergencias": [
        "Dirección General de Salud Digital y Ordenación Farmacéutica",
        "Dirección General de Investigación, Innovación y Formación",
        "Dirección General de Consumo"
    ]
};

// Get references to the organization and unit select elements.
const organizationSelect = document.getElementById('organization');
const unitSelect = document.getElementById('unit');

// Update the available units when the selected organization changes.
if (organizationSelect && unitSelect) {
    // Store the previously selected unit after a validation error.
    const oldUnit = unitSelect.dataset.old;

    // Update the available units when the selected organization changes.
    organizationSelect.addEventListener('change', function () {
        const selectedOrganization = this.value;

        // Reset the unit options.
        unitSelect.innerHTML = '<option value="">Seleccione una unidad</option>';

        // Add the units associated with the selected organization.
        if (units[selectedOrganization]) {
            units[selectedOrganization].forEach(function (unit) {
                const option = document.createElement('option');

                option.value = unit;
                option.textContent = unit;

                // Restore the previously selected unit.
                if (unit === oldUnit) {
                    option.selected = true;
                }

                unitSelect.appendChild(option);
            });
        }
    });

    // Load the units when a previously selected organization is available.
    if (organizationSelect.value) {
        organizationSelect.dispatchEvent(new Event('change'));
    }
}