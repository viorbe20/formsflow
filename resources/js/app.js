import './bootstrap';
import './application-requests';

document.addEventListener('DOMContentLoaded', () => {

    // Retrieve the request detail modal.
    const modal = document.getElementById('request-detail-modal');

    // Stop execution if the modal does not exist on the current page.
    if (!modal) {
        return;
    }

    // Retrieve all buttons used to open the request detail modal.
    const detailButtons = document.querySelectorAll('.request-detail-button');

    // Retrieve all buttons used to close the modal.
    const closeButtons = modal.querySelectorAll('.request-modal-close');


    // Retrieve the elements where request information will be displayed.
    const modalReference = document.getElementById('modal-reference');
    const modalOrganization = document.getElementById('modal-organization');
    const modalUnit = document.getElementById('modal-unit');
    const modalSubject = document.getElementById('modal-subject');
    const modalStatus = document.getElementById('modal-status');
    const modalCategory = document.getElementById('modal-category');
    const modalPriority = document.getElementById('modal-priority');
    const modalProcessedAt = document.getElementById('modal-processed-at');
    const modalText = document.getElementById('modal-text');


    // Add a click event to each request detail button.
    detailButtons.forEach((button) => {

        button.addEventListener('click', () => {

            // Read the request data stored in the button's data attributes.
            modalReference.textContent = button.dataset.reference;
            modalOrganization.textContent = button.dataset.organization;
            modalUnit.textContent = button.dataset.unit;
            modalSubject.textContent = button.dataset.subject;
            modalProcessedAt.textContent = button.dataset.processedAt;
            modalText.textContent = button.dataset.text;
            // Convert the NLP category into a user-friendly label.
            const categoryLabels = {
                informacion: 'Información',
                incidencia: 'Incidencia',
                documentacion: 'Documentación',
            };

            const category = button.dataset.category;

            modalCategory.textContent =
                categoryLabels[category] ?? '—';

            modalCategory.classList.remove(
                'nlp-badge',
                'nlp-category'
            );

            if (category) {
                modalCategory.classList.add(
                    'nlp-badge',
                    'nlp-category'
                );
            }


            // Convert the NLP priority into a user-friendly label.
            const priorityLabels = {
                baja: 'Baja',
                media: 'Media',
                alta: 'Alta',
            };

            const priority = button.dataset.priority;

            modalPriority.textContent =
                priorityLabels[priority] ?? '—';

            modalPriority.classList.remove(
                'nlp-badge',
                'priority-low',
                'priority-medium',
                'priority-high'
            );

            if (priority === 'baja') {
                modalPriority.classList.add(
                    'nlp-badge',
                    'priority-low'
                );
            } else if (priority === 'media') {
                modalPriority.classList.add(
                    'nlp-badge',
                    'priority-medium'
                );
            } else if (priority === 'alta') {
                modalPriority.classList.add(
                    'nlp-badge',
                    'priority-high'
                );
            }

            // Convert the internal status value into a user-friendly label.
            const statusLabels = {
                pending: 'Pendiente',
                archived: 'Archivada',
            };

            const status = button.dataset.status;

            modalStatus.textContent =
                statusLabels[status] ?? status;


            // Reuse the same status classes used by the main request table.
            modalStatus.classList.remove(
                'status-pending',
                'status-archived'
            );

            if (status === 'pending') {
                modalStatus.classList.add('status-pending');
            } else if (status === 'archived') {
                modalStatus.classList.add('status-archived');
            }

            // Display the modal.
            modal.classList.add('is-visible');

            // Update the accessibility state of the modal.
            modal.setAttribute('aria-hidden', 'false');
        });

    });


    // Add a click event to each close button.
    closeButtons.forEach((button) => {

        button.addEventListener('click', () => {

            // Hide the modal.
            modal.classList.remove('is-visible');

            // Update the accessibility state of the modal.
            modal.setAttribute('aria-hidden', 'true');
        });

    });


    // Close the modal when the user clicks on the background overlay.
    modal.addEventListener('click', (event) => {

        if (event.target === modal) {

            // Hide the modal.
            modal.classList.remove('is-visible');

            // Update the accessibility state of the modal.
            modal.setAttribute('aria-hidden', 'true');
        }

    });


    // Allow the user to close the modal by pressing the Escape key.
    document.addEventListener('keydown', (event) => {

        if (event.key === 'Escape') {

            // Hide the modal.
            modal.classList.remove('is-visible');

            // Update the accessibility state of the modal.
            modal.setAttribute('aria-hidden', 'true');
        }

    });

});