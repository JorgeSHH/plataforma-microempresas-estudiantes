document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad de las pestañas
    const tabEstudiantes = document.getElementById('tab-estudiantes');
    const tabEmpresas = document.getElementById('tab-empresas');
    const contentEstudiantes = document.getElementById('content-estudiantes');
    const contentEmpresas = document.getElementById('content-empresas');

    tabEstudiantes.addEventListener('click', function() {
        tabEstudiantes.classList.add('tab-active');
        tabEstudiantes.classList.remove('text-gray-500');
        tabEmpresas.classList.remove('tab-active');
        tabEmpresas.classList.add('text-gray-500');
        contentEstudiantes.classList.remove('hidden');
        contentEmpresas.classList.add('hidden');
    });

    tabEmpresas.addEventListener('click', function() {
        tabEmpresas.classList.add('tab-active');
        tabEmpresas.classList.remove('text-gray-500');
        tabEstudiantes.classList.remove('tab-active');
        tabEstudiantes.classList.add('text-gray-500');
        contentEmpresas.classList.remove('hidden');
        contentEstudiantes.classList.add('hidden');
    });

    // Botones de inscripción
    const inscripcionBtns = document.querySelectorAll('button.bg-blue-600');
    inscripcionBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            alert('¡Gracias por tu interés! Te has inscrito correctamente.');
            this.textContent = 'Inscrito';
            this.classList.add('bg-green-600');
            this.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        });
    });

    // Formulario de suscripción
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = form.querySelector('input[type="email"]').value;
        if (email) {
            alert('¡Gracias por suscribirte! Pronto recibirás nuestras actualizaciones.');
            form.reset();
        } else {
            alert('Por favor, ingresa tu correo electrónico.');
        }
    });
});