<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Profesor") == 0){
        require_once("View\static\layout\header.php");
?>

<section class="body-gestionDisponibilidad">
    <div class="container">
    <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 p-0 contenedor-accion">
                <h2> Gestion de disponibilidad </h2>

                <div class="contenedor-accion-cuerpo">
                    <form name="frm-busquedaDisponibilidad" action="" method="POST">
                        <label for="matricula" class="label-body">
                            <b>Matricula:</b> <br>
                            <input type="text" name="matricula" required>
                        </label>
                        <button type="submit" name="opc" value="consultarUnaDisponibilidad" class="boton-primario" >Buscar</button>
                    </form>
                    <br>
                    <div class="contenedor-tabla">
                        <table class="table tabla">
                            <thead>
                                <tr>
                                    <th scope="col" class="celda-corta"> id </th>
                                    <th scope="col"> Periodo </th>
                                    <th scope="col"> Lunes </th>
                                    <th scope="col"> Martes </th>
                                    <th scope="col"> Miercoles </th>
                                    <th scope="col"> Jueves </th>
                                    <th scope="col"> Viernes </th>
                                    <th scope="col"> Gestion </th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php 
                                if($result != false){
                                    while($rows = mysqli_fetch_array($result)){   ?>

                                <form name="frm-gestionDisponibilidad-<?= $rows['idDisponibilidad'] ?>" id="frm-gestionDisponibilidad-<?= $rows['idDisponibilidad'] ?>" action="" method="POST" onsubmit="return confirmacionAccion()">
                                    <tr>
                                        
                                        <td class="celda-corta"> <?= $rows['idDisponibilidad'] ?> <input type="hidden" name="idDisponibilidad" value=<?= $rows['idDisponibilidad'] ?>> </td>
                                        <td> <input type="text" name="periodo" value=<?= $rows['periodo'] ?> required> </td>
                                        <td> <input type="text" name="Lunes" value=<?= $rows['Lunes'] ?> required> </td>
                                        <td> <input type="text" name="martes" value=<?= $rows['martes'] ?> required> </td>
                                        <td> <input type="text" name="miercoles" value=<?= $rows['miercoles'] ?> required> </td>
                                        <td> <input type="text" name="jueves" value=<?= $rows['jueves'] ?> required> </td>
                                        <td> <input type="text" name="viernes" value=<?= $rows['viernes'] ?> required> </td>
                                        <td> 
                                            <div class="columna-acciones">
                                                <button form="frm-gestionDisponibilidad-<?= $rows['idDisponibilidad'] ?>" class="boton-icono" type="submit" name="opc" value="actualizarDisponibilidad">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffa500" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                    </svg>
                                                </button> 
                                                
                                                <button form="frm-gestionDisponibilidad-<?= $rows['idDisponibilidad'] ?>" class="boton-icono" type="submit" name="opc" value="eliminarDisponibilidad">
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
                                }else{    ?>

                                    <td> No se encontraron registros </td>

                                <?php }   ?>
                            </tbody>
                        </table>
                    </div>
                    <br>
                    <!-- Button trigger modal -->
                    <button class="boton-primario" data-bs-toggle="modal" data-bs-target="#modalCrearDisponibilidad"> Crear </button>

                    <!-- Modal -->
                    <?php require_once("View/Users/Profesor/Gestiones/Modales/modalCrearDisponibilidad.php"); ?>
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
