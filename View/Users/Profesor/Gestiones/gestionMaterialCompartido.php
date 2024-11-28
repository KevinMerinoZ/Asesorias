<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Profesor") == 0){
        require_once("View\static\layout\header.php");
?>

<section class="body-gestionMaterialCompartido">
    <div class="container">
    <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 p-0 contenedor-accion">
                <h2> Gestion del material compartido al alumno </h2>

                <div class="contenedor-accion-cuerpo">
                    <label> Material compartido para la cita con el ID:</label>
                    <label id="idCita-GestionMaterialCompartido"><?=$idCita?></label>
                    <br>
                    <br>
                    <form name="frm-busquedaMaterialCompartido" action="" method="POST">
                        <label for="id" class="label-body">
                            <b>id:</b> <br>
                            <input type="text" name="id" required>
                        </label>
                        <button type="submit" name="opc" value="consultarUnMaterialCompartido" class="boton-primario" >Buscar</button>
                    </form>
                    <br>
                    <div class="contenedor-tabla">
                        <table class="table tabla">
                            <thead>
                                <tr>
                                    <th scope="col" class="celda-corta"> id </th>
                                    <th scope="col"> Titulo </th>
                                    <th scope="col" class="celda-larga"> Archivo </th>
                                    <th scope="col"> Comentario </th>
                                    <th scope="col"> Tipo de material </th>
                                    <th scope="col"> Acciones </th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php 
                                if($result != false){
                                    while($rows = mysqli_fetch_array($result)){   ?>

                                <form name="frm-gestionMaterialCompartido-<?= $rows['idmaterialCompartido'] ?>" id="frm-gestionMaterialCompartido-<?= $rows['idmaterialCompartido'] ?>" action="" method="POST" enctype="multipart/form-data" onsubmit="return confirmacionAccion()">
                                    <input type="hidden" name="idCita" value=<?=$idCita?>>
                                    <tr>
                                        <td class="celda-corta"> <?= $rows['idmaterialCompartido'] ?> <input type="hidden" name="idmaterialCompartido" value=<?= $rows['idmaterialCompartido'] ?>> </td>
                                        <td> <input type="text" name="titulo" value="<?= $rows['titulo'] ?>" required> </td>
                                        <td class="celda-larga"> 
                                            <input type="hidden" name="dirArchivo" value="<?= $rows['archivo'] ?>" required> 
                                            <button type="button" onclick="descargarArchivo('<?= $rows['archivo'] ?>')">Descargar</button>
                                            <input type="file" name="nuevoArchivo" >
                                        </td>
                                        <td> <input type="text" name="comentario" value="<?= $rows['comentario'] ?>" required> </td>
                                        <td> 
                                            <select name="tipoMaterial">
                                                <?php 
                                                if($tipoMaterial != false){
                                                    mysqli_data_seek($tipoMaterial, 0);
                                                    $categoriaAnt = "";
                                                    while($tMaterial = mysqli_fetch_array($tipoMaterial)){ 
                                                        if($tMaterial['idmaterial'] == $rows['TipoMaterial_idmaterial']){ ?>
                                                        
                                                    <option value=<?= $tMaterial['idmaterial'] ?> selected> <?= $tMaterial['categoria'] ?></option>

                                                <?php
                                                        }else{ ?>

                                                    <option value=<?= $tMaterial['idmaterial'] ?>> <?= $tMaterial['categoria'] ?></option>

                                                        <?php
                                                        }
                                                        
                                                    }
                                                }else{    ?>
                                                    No se encontraron el tipo de material
                                                <?php }   ?>
                                            </select>
                                        </td>
                                        <td> 
                                            <div class="columna-acciones">
                                                <button form="frm-gestionMaterialCompartido-<?= $rows['idmaterialCompartido'] ?>" class="boton-icono" type="submit" name="opc" value="actualizarMaterialCompartido" onclick="validarTamanoArcActualizar('frm-gestionMaterialCompartido-<?= $rows['idmaterialCompartido'] ?>', event)">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffa500" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                                                    </svg>
                                                </button> 
                                                
                                                <button form="frm-gestionMaterialCompartido-<?= $rows['idmaterialCompartido'] ?>" class="boton-icono" type="submit" name="opc" value="eliminarMaterialCompartido">
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
                    <button class="boton-primario" data-bs-toggle="modal" data-bs-target="#modalCrearMaterialCompartido"> Crear </button>

                    <!-- Modal -->
                    <?php require_once("View/Users/Profesor/Gestiones/Modales/modalCrearMaterialCompartido.php"); ?>
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
