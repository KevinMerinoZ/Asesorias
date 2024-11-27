<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Alumno") == 0){
        require_once("View\static\layout\header.php");

?>

<section class="body-inicioAlumno">
    <form name="frmAccion" action="" method="POST" class="container">
        <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 p-0 contenedor-accion">
                <h2>Citas</h2>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam quidem tenetur similique, corporis iste obcaecati veritatis molestiae aspernatur dignissimos voluptatum praesentium eaque repellat eligendi repudiandae reprehenderit natus minima numquam adipisci?</p>
                <button type="submit" name="opc" value="vistaGestionCitas" class="boton-primario">Gestionar</button>
            </div>
        </div>
        <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 p-0 contenedor-accion">
                <h2>Reporte</h2>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam quidem tenetur similique, corporis iste obcaecati veritatis molestiae aspernatur dignissimos voluptatum praesentium eaque repellat eligendi repudiandae reprehenderit natus minima numquam adipisci?</p>
                <button type="submit" name="opc" value="vistaReporteCCPC" class="boton-primario">Ver</button>
            </div>
        </div>
 
    </form>
</section>

<?php
        require_once("View/static/layout/footer.php");
    }else{
        header("location: http://localhost/Asesorias");
    }
}else{
    header("location: http://localhost/Asesorias");
}


