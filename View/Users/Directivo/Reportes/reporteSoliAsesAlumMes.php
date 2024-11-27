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
                <h2> Numero de solicitudes para asesorias hechas por los alumnos por mes </h2>

                <div class="contenedor-accion-cuerpo">
                    <form name="frm-busquedaAlumno" action="" method="POST">
                        <label for="periodo" class="label-body">
                            <b>Mes:</b> <br>
                            <select name="mes" id="mes">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>

                        </label>
                        <br>
                        <label for="ano" class="label-body">
                            <b>Año:</b> <br>
                            <input type="text" name="ano">
                        </label>
                        <br>
                        <div>
                            <button type="submit" name="opc" value="reporteSoliAsesAlumMes" class="boton-primario" >Generar</button>
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
