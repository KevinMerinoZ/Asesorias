<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="View/static/css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="View/static/css/normalize.css">
    <link rel="stylesheet" type="text/css" href="View/static/css/styles.css">
    <title>Document</title>
</head>
<body class="body-login">

<div class="contenedor-login">
    <h1>Gestión de Asesorías Académicas</h1>
    <img src="View\static\img\logoUpemor.png" alt="Logo de la Upemor">

    <form name="frmLogin" id="frmLogin" action="" method="POST">
        <div class="contenedor-label">
            <label for="tipoUsuario">
                <b>Usuario:</b> <br>
                <select name="tipoUsuario" id="tipoUsuario" class="datos" required>
                    <option value="Alumno">Alumno</option>
                    <option value="Profesor">Profesor</option>
                    <option value="Directivo">Directivo</option>
                </select>
            </label>
        </div>
        <br>
        <div class="contenedor-label">
            <label for="matricula">
            <b>Matricula: </b><br>
                <input type="text" name="matricula" id="matricula" placeholder="Matricula" class="datos" required>
            </label>
        </div>
        <br>
        <div class="contenedor-label">
            <label for="contrasenia">
            <b>Contraseña: </b><br>
                <input type="password" name="contrasenia" id="contrasenia" placeholder="Contraseña" class="datos" required>
            </label>
        </div>
        <br>
        <input type="hidden" name="opc" value="validarLogin">
        <button type="button" class="submit boton-primario" onclick="validarLogin('frmLogin')">Ingresar</button>
        <?php require_once("View/modalErrorLogin.php"); ?>

        <script src="View/static/js/camposVacios.js"></script>
    </form>
</div>

<script src="View/static/css/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="View/static/js/appFunciones.js"></script>

</body>
</html>