<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Directivo") == 0){
        require_once("View\static\layout\header.php");


?>

<section class="body-reporteAsesAtenProfCuatrimestre">
    <div class="container">
    <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 p-0 contenedor-accion">
                <h2> Numero de asesorías atendidas por profesores por cuatrimestre </h2>

                <div class="contenedor-accion-cuerpo">
                    <form name="frm-busquedaAlumno" action="" method="POST">
                        <label for="periodo" class="label-body">
                            <b>Periodo escolar:</b> <br>
                            <select name="periodo" required>
                                <option value="invierno">Invierno</option>
                                <option value="primavera">Primavera</option>
                                <option value="otono">Otoño</option>
                            </select>
                        </label>
                        <br>
                        <label for="ano" class="label-body">
                            <b>Año:</b> <br>
                            <input type="text" name="ano" required>
                        </label>
                        <br>
                        <div>
                            <button type="submit" name="opc" value="reporteAsesAtenProfCuatrimestre" class="boton-primario" >Generar</button>
                        </div>
                    </form>
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
