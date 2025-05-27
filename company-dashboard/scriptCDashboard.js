const sidebar = document.getElementById('sidebar');
const menuToggle = document.getElementById('menuToggle');
const menuLinks = document.querySelectorAll('.menu-link');
const contentSection = document.getElementById('contentSection');
const openModalButton = document.getElementById('openModalButton');
const closeModalButton = document.getElementById('closeModalButton');
const modal = document.getElementById('modal');
const jobForm = document.getElementById('jobForm');

// Alternar menú
menuToggle.addEventListener('click', function() {
    sidebar.classList.toggle('collapsed');
});

// Navegación y carga de contenido
menuLinks.forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        
        // Remover clase active de todos los enlaces
        menuLinks.forEach(l => l.classList.remove('active'));
        
        // Añadir clase active al enlace clickeado
        this.classList.add('active');
        
        // Obtener el ID de la sección a mostrar
        const sectionId = this.getAttribute('href').substring(1);
        
        // Simular carga de contenido (en un caso real, esto cargaría otra página)
      
        
        // Para un menú colapsado, ocultar el tooltip después de hacer clic
        if (sidebar.classList.contains('collapsed')) {
            const tooltip = this.querySelector('.menu-text');
            if (tooltip) {
                tooltip.style.opacity = '0';
            }
        }
    });
});

// Añadir data-tooltip para el menú colapsado
menuLinks.forEach(link => {
    const text = link.querySelector('.menu-text').textContent;
    link.setAttribute('data-tooltip', text);
});

// Abrir la ventana modal
openModalButton.addEventListener('click', () => {
    modal.style.display = 'flex';
});

// Cerrar la ventana modal
closeModalButton.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Cerrar la ventana modal al hacer clic fuera del contenido
window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});

// Manejar el envío del formulario
jobForm.addEventListener('submit', (e) => {
    e.preventDefault();

    // Obtener los valores del formulario
    const title = document.getElementById('job-title').value;
    const company = document.getElementById('job-company').value;
    const category = document.getElementById('job-category').value;
    const type = document.getElementById('job-type').value;
    const salary = document.getElementById('job-salary').value;
    const duration = document.getElementById('job-duration').value;
    const location = document.getElementById('job-location').value;
    const requirements = document.getElementById('job-requirements').value;
    const description = document.getElementById('job-description').value;

    // Crear una nueva job-card
    const jobCard = document.createElement('div');
    jobCard.classList.add('job-card');
    jobCard.innerHTML = `
        <div class="job-header">
            <h1 class="job-title">${title}</h1>
            <p class="job-company">${company}</p>
            <div class="job-meta">
                <span class="job-meta-item"><i>📅</i> Publicado: Hoy</span>
                <span class="job-meta-item"><i>⏳</i> Duración: ${duration}</span>
                <span class="job-meta-item"><i>📍</i> ${location}</span>
                <span class="job-meta-item"><i>💰</i> <span class="job-salary">${salary}</span></span>
                <span class="job-meta-item"><i>🏢</i> Tipo: ${type}</span>
            </div>
        </div>
        <div class="job-category">
            <span class="category-label">Categoría:</span>
            <span class="category-value">${category}</span>
        </div>
        <div class="job-section">
            <h3 class="job-section-title">Requisitos</h3>
            <p class="job-section-content">${requirements}</p>
        </div>
        <div class="job-section">
            <h3 class="job-section-title">Descripción</h3>
            <p class="job-section-content">${description}</p>
        </div>
    `;

    // Agregar la nueva job-card al contenido principal
    contentSection.appendChild(jobCard);

    // Cerrar la ventana modal
    modal.style.display = 'none';

    // Limpiar el formulario
    jobForm.reset();
});

