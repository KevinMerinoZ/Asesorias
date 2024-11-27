<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Profesor") == 0){
        require_once("View\static\layout\header.php");


?>

<section class="body-reporteAsesAtenProfCuatrimestre">
    <div class="container">
    <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 p-0 contenedor-accion">
                <h2> Numero de alumnos atendidos por mes en un periodo cuatrimestral </h2>

                <div class="contenedor-accion-cuerpo">
                    <form name="frm-busquedaAlumno" action="" method="POST">
                        <label for="periodo" class="label-body">
                            <b>Periodo escolar:</b> <br>
                            <select name="periodo">
                                <option value="invierno">Invierno</option>
                                <option value="primavera">Primavera</option>
                                <option value="otono">Otoño</option>
                            </select>
                        </label>
                        <br>
                        <label for="ano" class="label-body">
                            <b>Año:</b> <br>
                            <input type="text" name="ano">
                        </label>
                        <br>
                        <div>
                            <button type="submit" name="opc" value="reporteAlumAtenMesCuatrimestre" class="boton-primario" >Generar</button>
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
