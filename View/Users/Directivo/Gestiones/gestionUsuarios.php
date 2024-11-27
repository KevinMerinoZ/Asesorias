<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Directivo") == 0){
        require_once("View\static\layout\header.php");

?>

<section class="body-gestionUsuarios">
    <div class="container">
    <br>
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 p-0 contenedor-accion">
            <h2> Gestion de usuarios </h2>
            <div class="contenedor-accion-cuerpo">
                <form name="frmGUsuarios" action="" method="POST" >
                    <button type="submit" name="opc" value="vistaGestionAlumnos" class="boton-primario">Alumno</button>

                    <button type="submit" name="opc" value="vistaGestionProfesores" class="boton-primario">Profesor</button>

                    <button type="submit" name="opc" value="vistaGestionDirectivos" class="boton-primario">Directivo</button>
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
