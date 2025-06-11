const sidebar = document.getElementById('sidebar');
const menuToggle = document.getElementById('menuToggle');
const menuLinks = document.querySelectorAll('.menu-link');
const contentSection = document.getElementById('contentSection');

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

document.querySelector('.menu-link').addEventListener('dblclick', function () {
    window.location.href = '../studentProfile.php';
});

document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.querySelector('.search-container input[type="search"]');
    const jobCards = document.querySelectorAll('.job-card');

    // Filtrar las job-card en base al título
    searchInput.addEventListener('input', () => {
        const searchValue = searchInput.value.toLowerCase();
        let firstMatch = null;

        jobCards.forEach(card => {
            const jobTitle = card.querySelector('.job-title').textContent.toLowerCase();
            const normalizedSearchValue = searchValue.replace(/\s+/g, '');
            const normalizedJobTitle = jobTitle.replace(/\s+/g, '');

            let match = true;
            for (const char of normalizedSearchValue) {
                if (!normalizedJobTitle.includes(char)) {
                    match = false;
                    break;
                }
            }

            if (jobTitle.includes(searchValue)) {
                card.style.display = 'block'; // Mostrar la tarjeta si coincide
                if (!firstMatch) {
                    firstMatch = card; // Guardar la primera coincidencia
                }
            } else {
                card.style.display = 'none'; // Ocultar la tarjeta si no coincide
            }
        });

        // Hacer scroll hacia la primera coincidencia
        if (firstMatch) {
            firstMatch.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = document.querySelectorAll('.filter-button');
    const jobCards = document.querySelectorAll('.job-card');

    // Manejar el clic en los botones de filtro
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const category = button.getAttribute('data-category');
            let firstMatch = null;

            jobCards.forEach(card => {
                const cardCategory = card.getAttribute('data-category');

                if (category === 'all' || cardCategory === category) {
                    card.style.display = 'block'; // Mostrar la tarjeta si coincide
                    if (!firstMatch) {
                        firstMatch = card; // Guardar la primera coincidencia
                    }
                } else {
                    card.style.display = 'none'; // Ocultar la tarjeta si no coincide
                }
            });

            // Hacer scroll hacia la primera coincidencia
            if (firstMatch) {
                firstMatch.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        });
    });
});

