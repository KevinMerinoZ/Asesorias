<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Alumno") == 0){
        require_once("View/static/layout/header.php");
?>

<section class="body-gestionCitas">
    <div class="container">
        <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 p-0 contenedor-accion">
                <h2>Gestión de Citas</h2>

                <div class="contenedor-accion-cuerpo">
                    <form name="frm-buscarCitaPorAsignatura" action="" method="POST">
                        <label for="nomAsignatura" class="label-body">
                            Busqueda por Asignatura <br>
                            <b>Nombre de la asignatura:</b> <br>
                            <input type="text" name="nomAsignatura" required>
                        </label>
                        <button type="submit" name="opc" value="buscarCitaPorAsignatura" class="boton-primario">Buscar</button>
                    </form>
                    <form name="frm-nomAsignatura" action="" method="POST">
                        <label for="matricula" class="label-body">
                            Busqueda por Asignatura <br>
                            <b>Matricula del profesor:</b> <br>
                            <input type="text" name="matricula" required>
                        </label>
                        <button type="submit" name="opc" value="buscarCitaPorProfesor" class="boton-primario">Buscar</button>
                    </form>
                    <br>
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
                                    <th scope="col">Nota</th>
                                    <th scope="col">ID Alumno</th>
                                    <th scope="col">Accion</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php 
                                if($result != false){
                                    while($rows = mysqli_fetch_array($result)){   
                                ?>
                                <form name="frm-gestionCitas-<?= $rows['idCita'] ?>" id="frm-gestionCitas-<?= $rows['idCita'] ?>" action="" method="POST" onsubmit="return confirmacionAccion()">
                                    <tr>
                                        <td><input type="hidden" name="idCita" value=<?= $rows['idCita'] ?>> <?= $rows['idCita'] ?> </td>
                                        <td><input type="text" name="tema" value="<?= $rows['tema'] ?>" class="form-control"></td>
                                        <td><input type="text" name="detalles" value="<?= $rows['detalles'] ?>" class="form-control"></td>
                                        <td><input type="text" name="fechaEnvio" readonly value="<?= $rows['fechaEnvio'] ?>" class="form-control"></td>
                                        <td><input type="text" name="fechaEstado" readonly value="<?= $rows['fechaEstado'] ?>" class="form-control"></td>
                                        <td><input type="text" name="estado" readonly value="<?= $rows['estado'] ?>" class="form-control"></td>
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
                                        <td>
                                            <div class="columna-acciones">
                                                <button type="button" data-bs-toggle="modal" data-bs-target="#modalVerNota-<?= $rows['Nota_idNota'] ?>" 
                                                    onclick="generarDatosNota('frm-modalVerNota-<?= $rows['Nota_idNota'] ?>')">
                                                    Ver
                                                </button>
                                            </div>
                                            <?php require("View/Users/Alumno/Gestiones/Modales/modalVerNota.php") ?>
                                        </td>
                                        <td><input type="text" name="alumno_matricula" readonly value="<?= $rows['Alumno_matricula'] ?>" class="form-control"></td>
                    
                                        <td>
                                            <div class="columna-acciones">
                                                <button form="frm-gestionCitas-<?= $rows['idCita'] ?>" class="boton-icono" type="submit" name="opc" value="actualizarCita" onclick="verificarEdicionCita(event, '<?= $rows['estado']?>')">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffa500" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                    </svg>
                                                </button> 
                                                
                                                <button form="frm-gestionCitas-<?= $rows['idCita'] ?>" class="boton-icono" type="submit" name="opc" value="eliminarCita" onclick="verificarEdicionCita(event, '<?= $rows['estado']?>')">
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
                    <!-- Button trigger modal -->
                    <button class="boton-primario" data-bs-toggle="modal" data-bs-target="#modalCrearCita"> Crear </button>

                    <!-- Modal -->
                    <?php require_once("View/Users/Alumno/Gestiones/Modales/modalCrearCita.php"); ?>
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
