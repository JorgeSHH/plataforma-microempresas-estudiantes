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

