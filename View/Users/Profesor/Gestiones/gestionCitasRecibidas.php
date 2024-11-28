<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Profesor") == 0){
        require_once("View/static/layout/header.php");
?>

<section class="body-gestionRecibidas">
    <div class="container">
        <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 p-0 contenedor-accion">
                <h2>Gestión de Citas Recibidas</h2>

                <div class="contenedor-accion-cuerpo">
                    <div class="contenedor-tabla">
                        <table class="table tabla">
                            <thead>
                                <tr>
                                    <th scope="col">ID Cita</th>
                                    <th scope="col">Tema</th>
                                    <th scope="col">Detalles</th>
                                    <th scope="col">Fecha de envío</th>
                                    <th scope="col">Fecha de estado</th>
                                    <th scope="col">Estado</th>
                                    <th scope="col">ID Profesor</th>
                                    <th scope="col">Asignatura</th>
                                    <th scope="col">ID Alumno</th>
                                    <th scope="col">Nota</th>
                                    <th scope="col">Material compartido</th>
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php 
                                if($result != false){
                                    while($rows = mysqli_fetch_array($result)){ 
                                        $readonly = $rows['estado'] == 'Aceptada' ? 'readonly' : '';  
                                ?>
                                <form name="frm-gestionCitasRecibidas-<?= $rows['idCita'] ?>" id="frm-gestionCitasRecibidas-<?= $rows['idCita'] ?>" action="" method="POST" onsubmit="return confirmacionAccion()">
                                    <tr>
                                        <td><input type="hidden" name="idCita" readonly value=<?= $rows['idCita'] ?>> <?= $rows['idCita'] ?> </td>
                                        <td><input type="text" name="tema" readonly value="<?= $rows['tema'] ?>" class="form-control"></td>
                                        <td><input type="text" name="detalles" readonly value="<?= $rows['detalles'] ?>" class="form-control"></td>
                                        <td><input type="text" name="fechaEnvio" readonly value="<?= $rows['fechaEnvio'] ?>" class="form-control"></td>
                                        <td><input type="text" id="fechaEstado-<?= $rows['idCita'] ?>" value="<?= $rows['fechaEstado'] ?>" name="fechaEstado" readonly class="form-control"></td>
                                        <td>
                                            <select name="estado" class="form-control" style="width: 130px; height: 40px; appearance: auto;">
                                                <option value="Pendiente"<?= $rows['estado'] == 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                                                <option value="Aceptada" <?= $rows['estado'] == 'Aceptada' ? 'selected' : '' ?>>Aceptado</option>
                                                <option value="Rechazada" <?= $rows['estado'] == 'Rechazada' ? 'selected' : '' ?>>Rechazado</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="profesor_matricula" readonly value="<?= $rows['ProfesorAsignatura_Profesor_matricula'] ?>" class="form-control"></td>
                                        <td>
                                            <?php 
                                                if($asignaturas != false){
                                                    mysqli_data_seek($asignaturas, 0);
                                                    while($asig = mysqli_fetch_array($asignaturas)){  
                                                        if($rows['ProfesorAsignatura_Asignatura_idAsignatura'] == $asig['idAsignatura']){?>

                                            <input type="hidden" name="asignatura_idAsignatura" value="<?= $rows['ProfesorAsignatura_Asignatura_idAsignatura'] ?>">
                                            <input type="text" readonly value="<?= $asig['nombre'] ?>" class="form-control">
                                            
                                            <?php
                                                        }
                                                    }
                                                }
                                            ?>
                                        </td>
                                        <td><input type="text" name="alumno_matricula" readonly value="<?= $rows['Alumno_matricula'] ?>" class="form-control"></td>
                                        <td>
                                            <div class="columna-acciones">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#modalGestionNotas-<?= $rows['idCita'] ?>" onclick="generarDatosNota('frm-crear-nota<?= $rows['idCita'] ?>')">
                                                    Gestionar
                                                </button>
                                                <?php require("View/Users/Profesor/Gestiones/Modales/modalGestionNotas.php") ?>
                                            </div>
                                        </td>
                                        <td> 
                                            <form name="frm-gestionMaterialCompartido-<?= $rows['idCita'] ?>" id="frm-gestionMaterialCompartido-<?= $rows['idCita'] ?>" action="" method="POST">
                                                <input form="frm-gestionMaterialCompartido-<?=$rows['idCita']?>" type="hidden" name="idCita" value="<?= $rows['idCita'] ?>">
                                                <input form="frm-gestionMaterialCompartido-<?=$rows['idCita']?>" type="hidden" name="idAlumno" value="<?= $rows['Alumno_matricula'] ?>">
                                                <button form="frm-gestionMaterialCompartido-<?=$rows['idCita']?>" type="submit" name="opc" value="vistaGestionMaterialCompartido">Gestionar</button>
                                            </form>
                                        </td>
                    
                                        <td>
                                            <div class="columna-acciones">
                                                <button form="frm-gestionCitasRecibidas-<?= $rows['idCita'] ?>" class="boton-icono" type="submit" name="opc" value="actualizarCitaRecibida" onclick="verificarEdicionCita(event, '<?= $rows['estado']?>')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffa500" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                    </svg>
                                                </button> 
                                                
                                                <button form="frm-gestionCitasRecibidas-<?= $rows['idCita'] ?>" class="boton-icono" type="submit" name="opc" value="eliminarCitaRecibida" onclick="verificarEdicionCita(event, '<?= $rows['estado']?>')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ff2d3d" class="bi bi-trash3" viewBox="0 0 16 16">
                                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                                    </svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </form>
                                <?php 
                                    } 
                                }else{    
                                ?>
                                <tr>
                                    <td colspan="5">No se encontraron registros</td>
                                </tr>
                                <?php 
                                }   
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<?php
        require_once("View/static/layout/footer.php");  
    }else{
        header("location: http://localhost/Asesorias");
    }
}else{
    header("location: http://localhost/Asesorias");
}
?>
<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener la fecha actual
        const hoy = new Date();
        const fechaActual = hoy.toISOString().split('T')[0]; // Formato YYYY-MM-DD

        // Seleccionar todos los inputs de fechaEstado
        document.querySelectorAll('[id^="fechaEstado-"]').forEach(input => {
            input.value = fechaActual; // Asignar la fecha actual
        });
    });
</script> -->
