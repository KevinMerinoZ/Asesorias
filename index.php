<?php
session_start();
require_once("config.php");
require_once("Controller/index.php");
// session_destroy();
if(!(isset($controlador))){
    $controlador = new Controlador();
    
}

// --------------- Cambiado --------------
if(isset($_SESSION['tipoUsuario'])){
    
    if(isset($_POST['opc'])){  
        $opc = $_POST['opc'];
        if(method_exists("Controlador",$opc)){
            $controlador->{$opc}();
            $opc = null;
        }else if(isset($_SESSION['vistaActual'])){
            $controlador->{$_SESSION['vistaActual']}();
            $opc = null;
        }else{
            $controlador->{"vistaInicio".$_SESSION['tipoUsuario']}();
        }
    }else if(isset($_SESSION['vistaActual'])){
        $controlador->{$_SESSION['vistaActual']}();
        $opc = null;
    }else{
        $controlador->{"vistaInicio".$_SESSION['tipoUsuario']}();
    }

}else{
    if(isset($_POST['opc'])){  
        $opc = $_POST['opc'];
        if(strcmp($opc, "validarLogin") == 0){
            $controlador->validarLogin();
            $opc = null;
        }else{
            $controlador->vistaLogin();
            $opc = null;
        }
    }else{
        $controlador->vistaLogin();
    }
}
