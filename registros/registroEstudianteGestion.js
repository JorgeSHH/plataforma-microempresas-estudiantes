const registroEstuddiante = document.getElementById('registroEstudiante');

// Campos para cursos dinámicos
const addCursoBtn = document.getElementById('addCurso');
const tablaCursosBody = document.querySelector('#tablaCursos tbody');
const cursoNombreInput = document.getElementById('cursoNombre');
const cursoInstitucionInput = document.getElementById('cursoInstitucion');
const cursoDuracionInput = document.getElementById('cursoDuracion');

let cursosData = []; // Array para almacenar los cursos

// Campos para empleos dinámicos
const addEmpleoBtn = document.getElementById('addEmpleo');
const tablaEmpleosBody = document.querySelector('#tablaEmpleos tbody');
const empleoEmpresaInput = document.getElementById('empleoEmpresa');
const empleoPuestoInput = document.getElementById('empleoPuesto');
const empleoDuracionInput = document.getElementById('empleoDuracion');

let empleosData = []; // Array para almacenar los empleos

// --- Funcionalidad para Cursos Dinámicos ---

addCursoBtn.addEventListener('click', () => {
    const nombreCurso = cursoNombreInput.value.trim();
    const institucionCurso = cursoInstitucionInput.value.trim();
    const duracionCurso = cursoDuracionInput.value.trim();

    if (nombreCurso === "" || institucionCurso === "" || duracionCurso === "") {
        Swal.fire({
            title: "Campos de curso vacíos",
            text: "Por favor, complete todos los campos para agregar un curso.",
            icon: "warning",
            draggable: true
        });
        return;
    }

    const newCurso = {
        nombre: nombreCurso,
        institucion: institucionCurso,
        duracion: duracionCurso
    };

    cursosData.push(newCurso);
    renderCursosTable();
    clearCursoInputs();
});

function renderCursosTable() {
    tablaCursosBody.innerHTML = ''; // Limpiar la tabla
    cursosData.forEach((curso, index) => {
        const row = tablaCursosBody.insertRow();
        row.innerHTML = `
            <td>${curso.nombre}</td>
            <td>${curso.institucion}</td>
            <td>${curso.duracion}</td>
            <td><button type="button" class="btn-eliminar" data-index="${index}" data-type="curso">Eliminar</button></td>
        `;
    });
    addDeleteListeners('curso');
}

function clearCursoInputs() {
    cursoNombreInput.value = '';
    cursoInstitucionInput.value = '';
    cursoDuracionInput.value = '';
}

// --- Funcionalidad para Empleos Dinámicos ---

addEmpleoBtn.addEventListener('click', () => {
    const empresaEmpleo = empleoEmpresaInput.value.trim();
    const puestoEmpleo = empleoPuestoInput.value.trim();
    const duracionEmpleo = empleoDuracionInput.value.trim();

    if (empresaEmpleo === "" || puestoEmpleo === "" || duracionEmpleo === "") {
        Swal.fire({
            title: "Campos de empleo vacíos",
            text: "Por favor, complete todos los campos para agregar un empleo.",
            icon: "warning",
            draggable: true
        });
        return;
    }

    const newEmpleo = {
        empresa: empresaEmpleo,
        puesto: puestoEmpleo,
        duracion: duracionEmpleo
    };

    empleosData.push(newEmpleo);
    renderEmpleosTable();
    clearEmpleoInputs();
});

function renderEmpleosTable() {
    tablaEmpleosBody.innerHTML = ''; // Limpiar la tabla
    empleosData.forEach((empleo, index) => {
        const row = tablaEmpleosBody.insertRow();
        row.innerHTML = `
            <td>${empleo.empresa}</td>
            <td>${empleo.puesto}</td>
            <td>${empleo.duracion}</td>
            <td><button type="button" class="btn-eliminar" data-index="${index}" data-type="empleo">Eliminar</button></td>
        `;
    });
    addDeleteListeners('empleo');
}

function clearEmpleoInputs() {
    empleoEmpresaInput.value = '';
    empleoPuestoInput.value = '';
    empleoDuracionInput.value = '';
}

// --- Función para agregar listeners a los botones de eliminar ---
function addDeleteListeners(type) {
    const deleteButtons = document.querySelectorAll(`.btn-eliminar[data-type="${type}"]`);
    deleteButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const indexToDelete = event.target.dataset.index;
            if (type === 'curso') {
                cursosData.splice(indexToDelete, 1);
                renderCursosTable();
            } else if (type === 'empleo') {
                empleosData.splice(indexToDelete, 1);
                renderEmpleosTable();
            }
        });
    });
}

registroEstuddiante.addEventListener('submit', (e) => { 
    e.preventDefault();
    const nombre = document.getElementById('nombre').value;
    const apellido = document.getElementById('apellido').value;
    const correo = document.getElementById('correoEstudiante').value;
    const contrasena = document.getElementById('contresena').value;
    const contrasenaVerificacion = document.getElementById('contresenaVr').value;
    const telefono = document.getElementById('telefono').value;
    const cedula = document.getElementById('cedula').value;
    const estado = document.getElementById('estado').value;
    const parroquia = document.getElementById('parroquia').value;
    const sector = document.getElementById('sectore').value;
    const calle = document.getElementById('calle').value;
    const fechaNacimiento = document.getElementById('fechaNacimiento').value;
    const nivelEducacion = document.getElementById('educacion').value;
  


    // Comprobando que los datos lleguen
    if (contrasena !== contrasenaVerificacion) {
        Swal.fire({
            title: "Las contraseñas no coinciden...",
            icon: "error",
            draggable: true
        });
    }
    if (nombre == "" || apellido == "" || correo == "" || contrasena == "" || contrasenaVerificacion == "" || telefono == "" || cedula == "" || estado == "" || parroquia == "" || sector == "" || calle == "" || fechaNacimiento == "") {
        Swal.fire({
            title: "Campos vacíos...",
            text: "Por favor, rellene todos los campos",
            icon: "error",
            draggable: true
        });
    }

    const registroData = new FormData(registroEstuddiante);


    registroData.append('cursos', JSON.stringify(cursosData));
    registroData.append('empleos', JSON.stringify(empleosData));

    fetch('./registroEstudianteGestionBD.php', {
        method: 'POST',
        body: registroData
    })  
    .then(response => response.text())
    .then(data => {
     console.log(data); // Para ver la respuesta del servidor en la consola
     
        if (data === "0") {
            //error ver la consola, para conocer el error
            console.log(data); 
          } else if(data === "12e"){
            Swal.fire({
              title: "Verifique Rif o el Correo",
              text: "El rif o el correo ya se encuentran registrados en la plataforma",
              icon: "warning",
              draggable: true
            });
          }else if(data === "11e"){
            Swal.fire({
                title: "Error en la imagen",
                text: "Por favor ingrese una imagen con formato jpg, jpeg o png",
                icon: "error",
                draggable: true
              });
          }else if(data === "10e"){
            Swal.fire({
                title: "Error en la imagen",
                text: "Por favor ingrese una imagen mas ligera(menor a 10mb)",
                icon: "error",
                draggable: true
              });
          }else if(data === "1"){
            const delayTime = 1500; 
            Swal.fire({
                title: "Registro exitoso",
                icon: "success",
                draggable: true
              });
              setTimeout(() => {   
                location.href = '../login/login.php';
            }, delayTime);
          }
    })
    .catch(error => {
      console.error('Error en la solicitud Fetch:', error);
      Swal.fire({
          title: "Error de conexión",
          text: "No se pudo comunicar con el servidor. Por favor, revise su conexión a internet.",
          icon: "error",
          draggable: true
      });
  });


});