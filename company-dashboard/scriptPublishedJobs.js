document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('modal');
    const closeModalButton = document.getElementById('closeModalButton');
    const editJobForm = document.getElementById('editJobForm');
    const jobCards = document.querySelectorAll('.job-card');
    const jobIdInput = document.getElementById('job-id');
    const sidebar = document.getElementById('sidebar');
    const menuToggle = document.getElementById('menuToggle');

    // Alternar la barra lateral
    menuToggle.addEventListener('click', () => {
        sidebar.classList.toggle('collapsed');
    });

    // Abrir la ventana modal para editar
    document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', () => {
            const jobId = button.getAttribute('data-id');
            const jobCard = document.querySelector(`.job-card[data-id="${jobId}"]`);
            
            // Cargar datos en el formulario
            jobIdInput.value = jobId;
            document.getElementById('job-title').value = jobCard.querySelector('.job-title').textContent;
            document.getElementById('job-salary').value = jobCard.querySelector('.job-salary').textContent;
            document.getElementById('job-duration').value = jobCard.querySelector('.job-meta-item:nth-child(2)').textContent.split(': ')[1];
            document.getElementById('job-location').value = jobCard.querySelector('.job-meta-item:nth-child(3)').textContent.split(': ')[1];
            document.getElementById('job-requirements').value = jobCard.querySelector('.job-section-content').textContent;
            document.getElementById('job-description').value = jobCard.querySelector('.job-section-content').textContent;

            modal.style.display = 'block';
        });
    });

    // Cerrar la ventana modal al hacer clic en el botón de cierre
    closeModalButton.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    // Cerrar la ventana modal al hacer clic fuera del contenido
    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Guardar cambios
    editJobForm.addEventListener('submit', (e) => {
        e.preventDefault();
        const formData = new FormData(editJobForm);

        fetch('./updateJob.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            if (data === '1') {
                alert('Trabajo actualizado correctamente.');
                location.reload();
            } else {
                alert('Error al actualizar el trabajo.');
            }
        });
    });

    // Eliminar trabajo
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', () => {
            const jobId = button.getAttribute('data-id');

            if (confirm('¿Estás seguro de que deseas eliminar este trabajo?')) {
                fetch('./deleteJob.php', {
                    method: 'POST',
                    body: JSON.stringify({ id_job: jobId }),
                    headers: { 'Content-Type': 'application/json' }
                })
                .then(response => response.text())
                .then(data => {
                    if (data === '1') {
                        alert('Trabajo eliminado correctamente.');
                        location.reload();
                    } else {
                        alert('Error al eliminar el trabajo.');
                    }
                });
            }
        });
    });
});