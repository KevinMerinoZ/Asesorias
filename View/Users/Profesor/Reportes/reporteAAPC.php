<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Profesor") == 0){
        require_once("View/static/layout/header.php");
?>

<section class="body-reporteAAPC">
    <div class="container">
        <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-8 p-0 contenedor-accion">
                <h2>Reporte de Asesorías por Asignatura por Periodo Cuatrimestral</h2>

                <div class="contenedor-accion-cuerpo">
                <form name="frm-busquedaAlumno" action="" method="POST">
                    <div class="d-flex justify-content-between">
                        <label for="periodo" class="label-body" style="flex: 1; margin-right: 10px;">
                            <b>Periodo Cuatrimestral:</b> <br>
                            <select name="periodo" style="width: 300px; height: 25px;"> 
                                <option value="">Seleccione un periodo</option>
                                <option value="Septiembre-Diciembre">Septiembre-Diciembre</option>
                                <option value="Enero-Abril">Enero-Abril</option>
                                <option value="Mayo-Agosto">Mayo-Agosto</option>
                            </select>
                        </label>
                        <label for="ano" class="label-body" style="flex: 1;">
                            <b>Año:</b> <br>
                            <input type="text" name="ano" style="width: 150px; height: 28px;" placeholder="Ingrese el año" maxlength="4"> 
                        </label>
                    </div>
                    <br>
                    <br>
                    <div class="d-flex justify-content-center">
                    <button type="submit" name="opc" value="reporteAAPC" class="boton-primario" >Generar reporte</button>
                    </div>
                </form>
                <br>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
    } else {
        header("location: http://localhost/Asesorias");
    }
} else {
    header("location: http://localhost/Asesorias");
}
require_once("View/static/layout/footer.php");  
?>