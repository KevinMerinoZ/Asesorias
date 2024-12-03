<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Directivo") == 0){
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
                            Numero de asesorías atendidas por profesores por cuatrimestre <br>
                            <button type="submit" name="opc" value="vistaReporteAsesAtenProfCuatrimestre" class="boton-primario">Generar</button>
                        </label>
                    
                        <label>
                            Numero de solicitudes para asesorias hechas por los alumnos por mes <br>
                            <button type="submit" name="opc" value="vistaReporteSoliAsesAlumMes" class="boton-primario">Generar</button>
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