/**
 * Valida el formulario de login mediante una solicitud asincrónica.
 * 
 * @async
 * @param {string} idForm - ID del formulario de login que se validará.
 * @returns {Promise<void>} No retorna un valor explícito, pero realiza operaciones sobre la UI y puede enviar el formulario si es válido.
 */
async function validarLogin(idForm) {
    // Obtiene el formulario por su ID y crea un objeto FormData con su contenido.
    const formulario = document.getElementById(idForm);
    const dataForm = new FormData(formulario);
    const inputs = formulario.getElementsByTagName("input");
    let res = 0;

    // Configuración del modal de error.
    const modal = document.getElementById("modalErrorLogin");
    const vtnModal = new bootstrap.Modal(modal);
    const encabezadoModal = document.getElementById("modalErrorLoginLabel");
    const cuerpoModal = modal.getElementsByTagName("p")[0];

    // Agrega un indicador para manejar la solicitud en el backend.
    dataForm.append("modal", true);

    if(inputs[0].value === "" || inputs[1].value === ""){
        encabezadoModal.textContent = "Campos vacios";
        cuerpoModal.textContent = "Debe llenar todos los campos";
        vtnModal.show();
        
    }else{
        try {
            // Envía los datos del formulario al servidor mediante una solicitud POST.
            const response = await fetch('index.php', {
                method: "POST",
                body: dataForm
            });

            // Procesa la respuesta del servidor en formato JSON.
            const respuesta = await response.json();

            // Maneja los posibles casos de respuesta.
            if (respuesta == -1) {
                encabezadoModal.textContent = "Error al hacer la consulta";
                cuerpoModal.textContent = "Hubo un error al comprobar tus datos";
                vtnModal.show();
            } else if (respuesta == 0) {
                encabezadoModal.textContent = "Credenciales incorrectas";
                cuerpoModal.textContent = "La matrícula o la contraseña son incorrectos";
                vtnModal.show();
            } else {
                res = respuesta;
            }

            // Si la respuesta es válida (res == 1), envía el formulario.
            if (res == 1) {
                console.log("Envía el formulario");
                formulario.submit();
            }

        } catch (error) {
            // Captura y registra cualquier error durante la solicitud o el procesamiento.
            console.error('Error al obtener respuesta:', error);
        }
    }
}

/**
 * Muestra un cuadro de confirmación al usuario para verificar si desea realizar una acción.
 * 
 * @returns {boolean} Devuelve `true` si el usuario confirma la acción, o `false` si la cancela.
 */
function confirmacionAccion() {
    // Muestra un cuadro de confirmación con un mensaje.
    const resultado = confirm("¿Desea realizar esta acción?");
    
    // Retorna el resultado de la confirmación: true si el usuario aceptó, false si lo rechazó.
    return resultado;
}

// *********************** ProfAsign ***********************
/**
 * Agrega una asignatura seleccionada en un campo de selección (select) a una tabla,
 * creando una fila con el nombre de la asignatura y un botón para eliminarla.
 * 
 * @param {string} idTabla - El ID de la tabla donde se añadirá la asignatura.
 * @param {string} idSelect - El ID del elemento <select> que contiene las asignaturas disponibles.
 */
function agregarAsignatura(idTabla, idSelect) {
    const tabla = document.getElementById(idTabla);
    const tbody = tabla.getElementsByTagName("tbody")[0];
    const select = document.getElementById(idSelect);

    const filas = tbody.getElementsByTagName("tr");

    // Crea una nueva fila para la asignatura seleccionada.
    const tr = document.createElement("tr");
    const td1 = document.createElement("td");
    const td2 = document.createElement("td");

    const opcSelect = select.selectedIndex;
    let flag = false;

    // Si la opción seleccionada no es la inicial (vacía).
    if (opcSelect != 0) {
        // Verifica si la asignatura ya está en la tabla.
        if (filas.length > 0) {
            for (let i = 0; i < filas.length; i++) {
                const celdas = filas[i].getElementsByTagName("td");
                const asignatura = celdas[0].getElementsByTagName("input")[0];
                if (asignatura.value == select.value) {
                    flag = true; // Marca que la asignatura ya está en la tabla.
                    break;
                }
            }
        }

        // Si la asignatura no estaba en la tabla, la agrega.
        if (!flag) {
            const inputHidden = document.createElement("input");
            inputHidden.type = "hidden";
            inputHidden.name = "asignaturas[]";
            inputHidden.value = select.value;

            const input = document.createElement("input");
            input.type = "text";
            input.name = "nomAsignatura";
            input.value = select.options[opcSelect].textContent;
            input.readOnly = true;

            const boton = document.createElement("button");
            boton.type = "button";
            boton.textContent = "Eliminar";
            boton.onclick = () => eliminarAsigProfesor(boton);

            td1.appendChild(inputHidden);
            td1.appendChild(input);
            td2.appendChild(boton);
            tr.appendChild(td1);
            tr.appendChild(td2);

            tbody.appendChild(tr);
        }
    }
}

/**
 * Actualiza la lista de asignaturas asociadas a un profesor,
 * creando filas en una tabla con los datos obtenidos desde el servidor.
 * 
 * @param {string} idTabla - El ID de la tabla donde se mostrarán las asignaturas.
 * @param {string} matriculaProf - La matrícula del profesor cuya lista de asignaturas se consultará.
 */
function generarProfAsig_Actualizar(idTabla, matriculaProf) {
    const tabla = document.getElementById(idTabla);
    const tbody = tabla.getElementsByTagName("tbody")[0];
    const filas = tbody.getElementsByTagName("tr");

    tbody.innerHTML = ''; // Limpia las filas existentes de la tabla.

    // Si no hay filas en la tabla, hace una solicitud para obtener las asignaturas.
    if (filas.length < 1) {
        fetch('index.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "opc=consultarAsignaturasProf&matricula=" + encodeURIComponent(matriculaProf)
        })
        .then(response => response.json())
        .then(Asignaturas => {
            // Para cada asignatura obtenida, se crea una fila en la tabla.
            Asignaturas.forEach(asignatura => {
                const tr = document.createElement("tr");
                const td1 = document.createElement("td");
                const td2 = document.createElement("td");

                const inputHidden = document.createElement("input");
                inputHidden.type = "hidden";
                inputHidden.name = "asignaturas[]";
                inputHidden.value = asignatura['idAsignatura'];

                const input = document.createElement("input");
                input.type = "text";
                input.name = "nomAsignatura";
                input.value = asignatura['nombre'];
                input.readOnly = true;

                const boton = document.createElement("button");
                boton.type = "button";
                boton.textContent = "Eliminar";
                boton.onclick = () => eliminarAsigProfesor(boton);

                td1.appendChild(inputHidden);
                td1.appendChild(input);
                td2.appendChild(boton);
                tr.appendChild(td1);
                tr.appendChild(td2);

                tbody.appendChild(tr);
            });
        })
        .catch(error => console.error('Error al obtener productos:', error)); // Maneja cualquier error durante la solicitud.
    }
}


/**
 * Actualiza las asignaturas de un profesor, enviando los datos al servidor para su actualización.
 * 
 * @param {string} idLabelMatricula - El ID del elemento que contiene la matrícula del profesor.
 * @param {string} idTabla - El ID de la tabla que contiene las asignaturas del profesor.
 * @param {Event} event - El evento que dispara la acción, utilizado para prevenir el envío del formulario si la tabla está vacía.
 */
function actualizarProfAsig(idLabelMatricula, idTabla, event) {
    const matricula = document.getElementById(idLabelMatricula).textContent;
    const tabla = document.getElementById(idTabla);
    const tbody = tabla.getElementsByTagName("tbody")[0];
    const filas = tbody.getElementsByTagName("tr");

    const dataForm = new FormData();

    dataForm.append("matricula", matricula);
    dataForm.append("opc", "actualizarProfAsig");

    // Verifica si la tabla de asignaturas del profesor no está vacía.
    if (tablaProfAsigVacia(idTabla, event) != false) {
        // Recorre las filas de la tabla y agrega los IDs de las asignaturas al formulario.
        for (let i = 0; i < filas.length; i++) {
            const celda = filas[i].getElementsByTagName("td")[0];
            const idAsignatura = celda.getElementsByTagName("input")[0].value;

            dataForm.append("asignaturas[]", idAsignatura);
        }

        // Envía los datos al servidor mediante un POST.
        fetch("index.php", {
            method: "POST",
            body: dataForm
        })
        .then(response => response.json())
        .then(respuesta => {
            if (respuesta == 1) {
                alert("Se actualizó exitosamente");
            } else if (respuesta == 0) {
                alert("No se actualizó");
            } else {
                alert("Hubo algún error al actualizar");
            }
        })
        .catch(error => console.error('Error al obtener el resultado:', error));
    }
}

/**
 * Elimina una asignatura de la tabla de asignaturas del profesor.
 * 
 * @param {HTMLElement} boton - El botón que fue clickeado para eliminar la asignatura.
 */
function eliminarAsigProfesor(boton) {
    const fila = boton.parentNode.parentNode;
    fila.remove();
}

/**
 * Verifica si la tabla de asignaturas del profesor está vacía.
 * Si lo está, previene la acción y muestra un mensaje de alerta.
 * 
 * @param {string} idTabla - El ID de la tabla que contiene las asignaturas del profesor.
 * @param {Event} event - El evento que disparó la acción.
 * @returns {boolean} - Devuelve true si la tabla tiene asignaturas, de lo contrario devuelve false.
 */
function tablaProfAsigVacia(idTabla, event) {
    const tabla = document.getElementById(idTabla);
    const filas = tabla.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

    if (filas.length == 0) {
        event.preventDefault();  // Previene la acción si la tabla está vacía.
        alert("El profesor debe tener al menos una asignatura");
        return false;
    }
    return true;
}

/**
 * Selecciona un profesor para crear una cita, mostrando sus asignaturas en un select.
 * 
 * @param {HTMLElement} boton - El botón que fue clickeado para seleccionar el profesor.
 */
function seleccionarProfCrearCita(boton) {
    const contenedor = boton.parentNode.parentNode;
    const select = contenedor.getElementsByTagName("select")[0];

    const indexSelected = select.selectedIndex;
    const matriculaProf = select.options[indexSelected].value;
    const nombreProf = select.options[indexSelected].textContent;

    const inputMatricula = contenedor.getElementsByTagName("input")[0];
    const inputNombre = contenedor.getElementsByTagName("input")[1];

    // Asigna la matrícula y el nombre del profesor a los inputs.
    inputMatricula.value = matriculaProf;
    inputNombre.value = nombreProf;

    // Realiza una consulta al servidor para obtener las asignaturas del profesor seleccionado.
    fetch('index.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "opc=consultarAsignaturasProf&matricula=" + encodeURIComponent(matriculaProf)
    })
    .then(response => response.json())
    .then(Asignaturas => {
        const selectAsignatura = document.getElementById("crearCita-asignatura");

        selectAsignatura.innerHTML = '';  // Limpia las opciones existentes.

        // Agrega las asignaturas obtenidas al select de asignaturas.
        Asignaturas.forEach(asignatura => {
            const option = document.createElement('option');
            option.value = asignatura['idAsignatura'];
            option.textContent = asignatura['nombre'];
            selectAsignatura.appendChild(option);
        });
    })
    .catch(error => console.error('Error al obtener productos:', error));
}


// *********************** Gestion directivos ***********************
/**
 * Envía los datos de un formulario para crear un nuevo directivo.
 * 
 * @param {string} idForm - El ID del formulario que contiene los datos del nuevo directivo.
 */
function crearDirectivo(idForm) {
    const dataForm = new FormData(document.getElementById(idForm));
    console.log(dataForm);

    // Se agrega un campo adicional al FormData para especificar la operación a realizar.
    dataForm.append("opc", "crearDirectivo");

    // Se envían los datos al servidor mediante un POST.
    fetch('index.php', {
        method: "POST",
        body: dataForm
    })
    .catch(error => console.error('Error al obtener productos:', error));
}

/**
 * Envía los datos del formulario para guardar o actualizar notas.
 * 
 * @param {string} idForm - El ID del formulario que contiene los datos de la nota.
 * @param {string} opcion - La opción que define si se va a crear o actualizar una nota.
 */
async function enviarNotas(idForm, opcion) {
    // Obtener el formulario usando el ID proporcionado.
    const formulario = document.getElementById(idForm);
    if (!formulario) {
        console.log(formulario);
        return;
    }

    // Crear un objeto FormData con los datos del formulario.
    const dataForm = new FormData(formulario);
    dataForm.append("opc", opcion);

    let flag = false;

    // Validación si la opción no es 'crearNota' y no se ha completado el campo 'idNota'.
    if (opcion !== "crearNota") {
        if (formulario.querySelector('[name="idNota"]').value.trim() === "") {
            flag = true;
        }
    }

    // Si no hay errores de validación, se envían los datos al servidor.
    if (!flag) {
        try {
            // Enviar los datos al servidor usando fetch.
            const response = await fetch('index.php', {
                method: "POST",
                body: dataForm
            });

            // Obtener la respuesta del servidor en formato texto.
            const respuesta = await response.text();
            console.log(respuesta);

        } catch (error) {
            console.error('Error al obtener respuesta:', error);
        }
    } else {
        alert("No ha creado una nota");
    }
}

/**
 * Genera los datos de una nota, rellenando los campos del formulario con la información obtenida del servidor.
 * 
 * @param {string} idForm - El ID del formulario en el que se mostrarán los datos de la nota.
 */
function generarDatosNota(idForm) {
    const frm = document.getElementById(idForm);
    const inputs = frm.getElementsByTagName("input");
    const dataForm = new FormData(frm);

    // Especifica la operación de consulta.
    dataForm.append('opc', 'consultarUnaNota');
    
    // Realiza la consulta al servidor para obtener los datos de la nota.
    fetch('index.php', {
        method: "POST",
        body: dataForm
    })
    .then(response => response.json())
    .then(Nota => {
        // Si se obtuvieron datos de la nota, se rellenan los campos del formulario.
        if (Nota && Array.isArray(Nota) && Nota.length !== 0) {
            for (let i = 1; i < inputs.length; i++) {
                inputs[i].value = Nota[0][i - 1];
            }
        } else {
            // Si no se obtuvieron datos, se vacían los campos, excepto el de 'nota'.
            for (let i = 1; i < inputs.length; i++) {
                if (i !== 4) {
                    inputs[i].value = "";
                }
            }
        }
    })
    .catch(error => console.error('Error al obtener productos:', error));
}


// *********************** Gestion Disponibilidad ***********************
/**
 * Valida si las horas ingresadas en el formulario tienen un rango correcto.
 * La hora debe estar en el formato HH:MM-HH:MM y el rango debe ser válido (hora de inicio menor a hora de fin).
 * 
 * @param {string} idForm - El ID del formulario que contiene los campos de hora a validar.
 * @returns {boolean} - Devuelve `true` si las horas son válidas, de lo contrario `false` y muestra un mensaje de error.
 */
function crearDisponibilidad_validarHora(idForm) {
    // Expresión regular para validar el formato de la hora.
    var expreHora = /^(0[7-9]|1[0-9]|2[0]):([0-5][0-9])-(0[7-9]|1[0-9]|2[0]):([0-5][0-9])$/;

    // Obtener el formulario por su ID.
    const formulario = document.getElementById(idForm);

    // Obtener todos los inputs dentro del formulario.
    const inputs = formulario.getElementsByTagName("input");

    // Iterar a través de los inputs comenzando desde el segundo (index 1).
    for (let i = 1; i < inputs.length; i++) {
        // Eliminar espacios extra en el valor de la hora y almacenarlo.
        let horaCompleta = inputs[i].value.replace(/\s+/g, "");

        // Verificar si el formato de la hora es válido utilizando la expresión regular.
        if (!expreHora.test(horaCompleta)) {
            alert("Ingrese un rango de horas correcto");
            inputs[i].focus();
            return false;
        }

        // Dividir la hora en partes: hora y minutos de inicio y fin.
        let index = horaCompleta.indexOf("-");
        let horaMinI = horaCompleta.slice(0, index);
        let horaMinF = horaCompleta.slice(index + 1);
        let horaI = horaMinI.slice(0, 2);
        let minI = horaMinI.slice(3);
        let horaF = horaMinF.slice(0, 2);
        let minF = horaMinF.slice(3);

        // Verificar si la hora de inicio es mayor que la hora de fin.
        if (horaI > horaF) {
            alert("Ingrese un rango de horas correcto");
            inputs[i].focus();
            return false;
        }

        // Verificar si las horas son iguales, en ese caso los minutos de inicio no deben ser mayores que los minutos de fin.
        if (horaI == horaF) {
            if (minI > minF) {
                alert("Ingrese un rango de horas correcto");
                inputs[i].focus();
                return false;
            }
        }

        // Asignar el valor limpio (sin espacios adicionales) al campo de entrada.
        inputs[i].value = horaCompleta;
    }

    // Si todos los campos son válidos, devolver true.
    return true;
}


// *********************** Gestion Material compartido ***********************
/**
 * Realiza una solicitud para descargar un archivo desde el servidor.
 * La función envía una petición al servidor para obtener el archivo como un objeto `blob` y luego lo descarga.
 *
 * @param {string} url - La URL del archivo que se quiere descargar.
 */
function descargarArchivo(url) {
    fetch('index.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: "opc=descargarArchivo&url=" + encodeURIComponent(url)
    })
    .then(response => response.blob()) // Obtener el archivo como un blob
    .then(respuesta => {
        // Obtener el nombre del archivo
        const nombre = url.split('/').pop();
        const index = nombre.indexOf('_');
        const nombreDoc = nombre.slice(index + 1);

        // Crear un enlace temporal para descargar el archivo
        const link = document.createElement('a');
        link.href = URL.createObjectURL(respuesta); // Crear una URL para el blob
        link.download = nombreDoc; // Nombre con el que se descargará el archivo
        link.click(); // Simular el clic para descargar
        URL.revokeObjectURL(link.href); // Revocar la URL creada
    })
    .catch(error => console.error('Error al obtener el archivo:', error)); // Manejo de errores
}


/**
 * Verifica si la cita puede ser editada antes de permitir que el evento continúe.
 * Si el estado de la cita no es "Pendiente", evita que se edite y muestra un mensaje de alerta.
 *
 * @param {Event} event - El evento que desencadenó la acción de editar.
 * @param {string} estado - El estado actual de la cita.
 */
function verificarEdicionCita(event, estado) {
    if (estado != "Pendiente") {
        event.preventDefault(); // Evitar la acción si el estado no es "Pendiente"
        alert("Una vez aceptada o rechazada la cita ya no se puede editar");
    }
}

