<?php 
        if(isset($_SESSION['nombre'])){
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->
    <link rel="stylesheet" type="text/css" href="View/static/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="View/static/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="View/static/css/styles.css">
    <title>Document</title>
</head>
<body>
    
    <header>
        <div class="row linea_dec"></div>
    <form action="" method="POST" class="row">
        <div class="col-md-3 p-4 sesion">
            <div class="contenedor-iconos-sesion">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                </svg>

                <button type="submit" name="opc" value="logout" class="boton-icono">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-box-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M6 12.5a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-9a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v2a.5.5 0 0 1-1 0v-2A1.5 1.5 0 0 1 6.5 2h8A1.5 1.5 0 0 1 16 3.5v9a1.5 1.5 0 0 1-1.5 1.5h-8A1.5 1.5 0 0 1 5 12.5v-2a.5.5 0 0 1 1 0z"/>
                    <path fill-rule="evenodd" d="M.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L1.707 7.5H10.5a.5.5 0 0 1 0 1H1.707l2.147 2.146a.5.5 0 0 1-.708.708z"/>
                    </svg>
                    logout
                </button>
            </div>
            
            <div>
                <p> <b><?php echo $_SESSION['tipoUsuario']; ?>(a)</b> <br> 
                <?php echo $_SESSION['nombre']." ".$_SESSION['apellidoP']." ". $_SESSION['apellidoM']; ?></p>
            </div>
        </div>

        <div class="col-md-9 sistema">
            <h1>Sistema web para la gestión de asesorías académicas</h1>
            <div class="contenedor-iconos-nav">
                <button type="submit" name="opc" value=<?= $vistaAnt?> class="boton-icono">
                    <svg width="25" height="25" fill="#ffa500" class="bi bi-arrow-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8"/>
                    </svg>
                </button>

                <button type="submit" name="opc" value="vistaInicioDirectivo" class="boton-icono">
                    <svg width="25" height="25" fill="#ffa500" viewBox="0 0 16 16">
                    <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
                    </svg>
                </button>
            </div>
        </div>

    </form>
    </header>
    <?php
        }else{
            header("location:".urlsite);
        }
    ?>
