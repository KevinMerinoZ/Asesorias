<?php
if(isset($_SESSION['tipoUsuario'])){
    if(strcmp($_SESSION['tipoUsuario'], "Directivo") == 0){
        require_once("View\static\layout\header.php");
?>

<section class="body-inicioDirectivo">
    <form name="frmAccion" action="" method="POST" class="container">
        <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 p-0 contenedor-accion">
                <h2>Usuarios</h2>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam quidem tenetur similique, corporis iste obcaecati veritatis molestiae aspernatur dignissimos voluptatum praesentium eaque repellat eligendi repudiandae reprehenderit natus minima numquam adipisci?</p>
                <button type="submit" name="opc" value="vistaGestionUsuarios" class="boton-primario">Gestionar</button>
            </div>
        </div>
        <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 p-0 contenedor-accion">
                <h2>Material Compartido</h2>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam quidem tenetur similique, corporis iste obcaecati veritatis molestiae aspernatur dignissimos voluptatum praesentium eaque repellat eligendi repudiandae reprehenderit natus minima numquam adipisci?</p>
                <button type="submit" name="opc" value="vistaGestionMaterialCompartido" class="boton-primario">Gestionar</button>
            </div>
        </div>
        <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 p-0 contenedor-accion">
                <h2>Asignaturas</h2>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam quidem tenetur similique, corporis iste obcaecati veritatis molestiae aspernatur dignissimos voluptatum praesentium eaque repellat eligendi repudiandae reprehenderit natus minima numquam adipisci?</p>
                <button type="submit" name="opc" value="vistaGestionAsignaturas" class="boton-primario">Gestionar</button>
            </div>
        </div>
        <br>
        <div class="row d-flex justify-content-center">
            <div class="col-md-6 p-0 contenedor-accion">
                <h2>Reportes</h2>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Nam quidem tenetur similique, corporis iste obcaecati veritatis molestiae aspernatur dignissimos voluptatum praesentium eaque repellat eligendi repudiandae reprehenderit natus minima numquam adipisci?</p>
                <button type="submit" name="opc" value="vistaReportes" class="boton-primario">Ver</button>
            </div>
        </div>
        
    </form>
</section>

<?php
        require_once("View/static/layout/footer.php");
    }else{
        header("location: Asesorias");
    }
}else{
    header("location: Asesorias");
}
