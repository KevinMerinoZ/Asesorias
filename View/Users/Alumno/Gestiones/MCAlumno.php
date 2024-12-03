<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Alumno") == 0){
        require_once("View\static\layout\header.php");
?>

<section class="body-MCAlumno">
    <div class="container">
    <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 p-0 contenedor-accion">
                <h2> Ver material compartido </h2>

                <div class="contenedor-accion-cuerpo">
                    <label> Material compartido para la cita con el ID:</label>
                    <label id="idCita-MCAlumno"><?=$idCita?></label>
                    <br>
                    <br>
                    <form name="frm-busquedaMCAlumno" action="" method="POST">
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
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                <?php 
                                if($result != false){
                                    while($rows = mysqli_fetch_assoc($result)){   ?>

                                <form name="frm-MCAlumno-<?= $rows['idmaterialCompartido'] ?>" id="frm-MCAlumno-<?= $rows['idmaterialCompartido'] ?>" action="" method="POST" enctype="multipart/form-data" onsubmit="return confirmacionAccion()">
                                    <input type="hidden" name="idCita" value=<?=$idCita?>>
                                    <tr>
                                        <td class="celda-corta"> <?= $rows['idmaterialCompartido'] ?> <input type="hidden" name="idmaterialCompartido" value=<?= $rows['idmaterialCompartido'] ?>> </td>
                                        <td> <input type="text" name="titulo" value="<?= $rows['titulo'] ?>" required> </td>
                                        <td class="celda-larga"> 
                                            <button type="button" onclick="descargarArchivo('<?= $rows['archivo'] ?>')">Descargar</button>
                                        </td>
                                        <td> <input type="text" name="comentario" value="<?= $rows['comentario'] ?>" required> </td>
                                        <td> 
                                            <select name="tipoMaterial" required>
                                                <?php 
                                                if($tipoMaterial != false){
                                                    mysqli_data_seek($tipoMaterial, 0);
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
                                                    <option value="">No se encontraron el tipo de material</option>
                                                <?php }   ?>
                                            </select>
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
