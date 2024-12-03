<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Profesor") == 0){
        require_once("View\static\layout\header.php");

?>

<section class="body-reportes">
    <div class="container">
    <br>
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 p-0 contenedor-accion">
            <h2> Reportes </h2>
            <div class="contenedor-accion-cuerpo">
                <form name="frmReportes" action="" method="POST" >
                    
                        <label>
                            Numero de alumnos atendidos por mes en un periodo cuatrimestral <br>
                            <button type="submit" name="opc" value="vistaReporteAlumAtenMesCuatrimestre" class="boton-primario">Generar</button>
                        </label>
                    
                        <label>
                            Reporte de Asesorias por Asignaturas por Cuatrimestre <br>
                            <button type="submit" name="opc" value="vistaReporteAAPC" class="boton-primario">Generar</button>
                        </label>

                </form>
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