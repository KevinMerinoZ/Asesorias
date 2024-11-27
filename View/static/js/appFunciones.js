async function validarLogin(idForm){
    const formulario = document.getElementById(idForm);
    const dataForm = new FormData(formulario);
    let res = 0;
    

    const modal = document.getElementById("modalErrorLogin");
    const vtnModal = new bootstrap.Modal(modal);

    const encabezadoModal = document.getElementById("modalErrorLoginLabel");
    const cuerpoModal = modal.getElementsByTagName("p")[0];

    dataForm.append("modal", true);

    try {
        const response = await fetch('index.php', {
            method: "POST",
            body: dataForm
        });
        const respuesta = await response.json();

        if (respuesta == -1) {
            encabezadoModal.textContent = "Error al hacer la consulta";
            cuerpoModal.textContent = "Hubo un error al comprobar tus datos";
            vtnModal.show();
        } else if (respuesta == 0) {
            encabezadoModal.textContent = "Credenciales incorrectas";
            cuerpoModal.textContent = "La matricula o la contraseña son incorrectos";
            vtnModal.show();
        } else {
            res = respuesta;
        }

        if (res == 1) {
            console.log("Envía el formulario");
            formulario.submit();
        }

    } catch (error) {
        console.error('Error al obtener respuesta:', error);
    }
}

function confirmacionAccion(){
    const resultado = confirm("¿Desea realizar esta acción?");

    return resultado;
}

// *********************** ProfAsign ***********************
function agregarAsignatura(idTabla, idSelect){
    const tabla = document.getElementById(idTabla);
    const tbody = tabla.getElementsByTagName("tbody")[0];
    const select = document.getElementById(idSelect);

    const filas = tbody.getElementsByTagName("tr");

    const tr = document.createElement("tr");
    const td1 = document.createElement("td");
    const td2 = document.createElement("td");

    const opcSelect = select.selectedIndex;

    let flag = false;

    if(opcSelect != 0){
        if(filas.length > 0){
            for(let i=0; i < filas.length; i++){
                const celdas = filas[i].getElementsByTagName("td");
                const asignatura = celdas[0].getElementsByTagName("input")[0];
                if(asignatura.value == select.value){
                    flag = true;
                    break;
                }
            }
        }

        if(!flag){
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
            // Es lo mismo de arriva, pero abreviado
            // boton.onclick = function() {
            //     eliminarAsigProfesor(this);
            // };
            td1.appendChild(inputHidden);
            td1.appendChild(input);
            td2.appendChild(boton);
            tr.appendChild(td1);
            tr.appendChild(td2);

            tbody.appendChild(tr);
        }
    }
}

function generarProfAsig_Actualizar(idTabla, matriculaProf){
    const tabla = document.getElementById(idTabla);
    const tbody = tabla.getElementsByTagName("tbody")[0];
    const filas = tbody.getElementsByTagName("tr");

    tbody.innerHTML = '';
    
    if(filas.length < 1){
        fetch('index.php', {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },

            body: "opc=consultarAsignaturasProf&matricula="+encodeURIComponent(matriculaProf)
        })
        .then(response => response.json())
        .then(Asignaturas => {

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
        .catch(error => console.error('Error al obtener productos:', error));
    }
}

function actualizarProfAsig(idLabelMatricula, idTabla, event){
    const matricula = document.getElementById(idLabelMatricula).textContent;
    const tabla = document.getElementById(idTabla);
    const tbody = tabla.getElementsByTagName("tbody")[0];
    const filas = tbody.getElementsByTagName("tr");

    const dataForm = new FormData();

    dataForm.append("matricula", matricula);
    dataForm.append("opc", "actualizarProfAsig");
    if(tablaProfAsigVacia(idTabla, event) != false){
        for(let i=0; i<filas.length; i++){
            const celda = filas[i].getElementsByTagName("td")[0];
            const idAsignatura = celda.getElementsByTagName("input")[0].value;

            dataForm.append("asignaturas[]", idAsignatura);
        }

        fetch("index.php", {
            method: "POST",
            body: dataForm
        })
        .then(response => response.json())
        .then(respuesta => {
            if(respuesta == 1){
                alert("Se actualizó exitosamente");
            }else if(respuesta == 0){
                alert("No se actualizó");
            }else{
                alert("Hubo algún error al actualizar");
            }
        })
        .catch(error => console.error('Error al obtener el resultado:', error));
    }
}

function eliminarAsigProfesor(boton){
    const fila = boton.parentNode.parentNode;
    fila.remove();
}

function tablaProfAsigVacia(idTabla, event){
    const tabla = document.getElementById(idTabla);
    const filas = tabla.getElementsByTagName("tbody")[0].getElementsByTagName("tr");

    if(filas.length == 0){
        event.preventDefault();
        alert("El profesor deve tener al menos una asignatura");
        return false;
    }
    return true;
}

function seleccionarProfCrearCita(boton){
    const contenedor = boton.parentNode.parentNode;
    const select = contenedor.getElementsByTagName("select")[0];

    const indexSelected = select.selectedIndex;
    const matriculaProf = select.options[indexSelected].value;
    const nombreProf = select.options[indexSelected].textContent;

    const inputMatricula = contenedor.getElementsByTagName("input")[0];
    const inputNombre = contenedor.getElementsByTagName("input")[1];

    inputMatricula.value = matriculaProf;
    inputNombre.value = nombreProf

    fetch('index.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },

        body: "opc=consultarAsignaturasProf&matricula="+encodeURIComponent(matriculaProf)
    })
        .then(response => response.json())
        .then(Asignaturas => {
            const selectAsignatura = document.getElementById("crearCita-asignatura");
            
            selectAsignatura.innerHTML = '';

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
function crearDirectivo(idForm){
    const dataForm = new FormData(document.getElementById(idForm));
    console.log(dataForm);

    dataForm.append("opc", "crearDirectivo");

    fetch('index.php', {
        method: "POST",
        body: dataForm
    })
    .catch(error => console.error('Error al obtener productos:', error));
}

async function enviarNotas(idForm, opcion) {
    // Obtener el formulario usando el ID proporcionado
    const formulario = document.getElementById(idForm);
    if (!formulario) {
        console.log(formulario);
        return;
    }

    // Crear un objeto FormData con los datos del formulario
    const dataForm = new FormData(formulario);
    dataForm.append("opc",opcion);
    let flag = false;
    if(opcion !== "crearNota"){
        if(formulario.querySelector('[name="idNota"]').value.trim() === ""){
            flag = true;
        }
    }

    if(!flag){
        try {
            // Enviar los datos al servidor usando fetch
            const response = await fetch('index.php', {
                method: "POST",
                body: dataForm
            });

            // Comprobar si la respuesta es JSON
            // const respuesta = await response.json();
            const respuesta = await response.text();
            console.log(respuesta);

        } catch (error) {
            console.error('Error al obtener respuesta:', error);
        }
    }else{
        alert("No ha creado una nota");
    }
}

function generarDatosNota(idForm){
    const frm = document.getElementById(idForm);
    const inputs = frm.getElementsByTagName("input");
    const dataForm = new FormData(frm);

    dataForm.append('opc', 'consultarUnaNota');
    
    fetch('index.php', {
        method: "POST",

        body: dataForm
    })
    .then(response => response.json())
    .then(Nota => {
        if(Nota && Array.isArray(Nota) && Nota.length !== 0){
            for(let i=1; i<inputs.length; i++){
                inputs[i].value = Nota[0][i-1];
            }
        }else{
            for(let i=1; i<inputs.length; i++){
                if(i!=4){
                    inputs[i].value = "";
                }
            }
        }

    })
    .catch(error => console.error('Error al obtener productos:', error));

}

// *********************** Gestion Disponibilidad ***********************
function crearDisponibilidad_validarHora(idForm){
    var expreHora = /^(0[7-9]|1[0-9]|2[0]):([0-5][0-9])-(0[7-9]|1[0-9]|2[0]):([0-5][0-9])$/;

    const formulario = document.getElementById(idForm);

    const inputs = formulario.getElementsByTagName("input");

    for(let i=1; i<inputs.length; i++){
        let horaCompleta = inputs[i].value.replace(/\s+/g, "");
        if(!expreHora.test(horaCompleta)){
            alert("Ingrese un rango de horas correcto");
            inputs[i].focus();
            return false;
        }
        let index = horaCompleta.indexOf("-");
        let horaMinI = horaCompleta.slice(0, index);
        let horaMinF = horaCompleta.slice(index+1);
        let horaI = horaMinI.slice(0, 2);
        let minI = horaMinI.slice(3);
        let horaF = horaMinF.slice(0, 2);
        let minF = horaMinF.slice(3);

        if(horaI > horaF){
            alert("Ingrese un rango de horas correcto");
            inputs[i].focus();
            return false;
        }
        
        if(horaI == horaF){
            if(minI > minF){
                alert("Ingrese un rango de horas correcto");
                inputs[i].focus();
                return false;
            }
        }

        inputs[i].value = horaCompleta;
    }

    return true;
}

// *********************** Gestion Material compartido ***********************
function descargarArchivo(url){
    fetch('index.php', {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },

        body: "opc=descargarArchivo&url="+encodeURIComponent(url)
    })
    .then(response => response.blob())
    .then(respuesta => {
        const nombre = url.split('/').pop();
        const index = nombre.indexOf('_');
        const nombreDoc = nombre.slice(index+1);

        const link = document.createElement('a');
        link.href = URL.createObjectURL(respuesta);
        link.download = nombreDoc;
        link.click();
        URL.revokeObjectURL(link.href);
    })
    .catch(error => console.error('Error al obtener productos:', error));
}

function verificarEdicionCita(event, estado){
    if(estado != "Pendiente"){
        event.preventDefault();
        alert("Una vez aceptada o rechazada la cita ya no se puede editar");
    }

}
