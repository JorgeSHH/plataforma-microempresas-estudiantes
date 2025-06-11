const openModalButton = document.getElementById('openModalButton');
const closeModalButton = document.getElementById('closeModalButton');
const modal = document.getElementById('modal');

// Abrir la ventana modal
openModalButton.addEventListener('click', () => {
    modal.style.display = 'block';
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