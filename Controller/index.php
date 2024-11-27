<?php
require_once("Model/index.php");


class Controlador{
    private $modelo;
    public function __construct(){
        $this->modelo = new Modelo();
    }
    /*************** Abrir vistas ***************/
    function vistaLogin(){
        require_once("View/login.php");
    }

    // Se agregó $_SESSION['vistaActual'] en cada vista
    function vistaInicioDirectivo(){
        $vistaAnt = "vistaInicioDirectivo";
        require_once("View/Users/Directivo/inicioDirectivo.php");
        $_SESSION['vistaActual'] = "vistaInicioDirectivo";
    }

    function vistaInicioAlumno(){
        $vistaAnt = "vistaInicioAlumno";
        require_once("View/Users/Alumno/InicioAlumno.php");
        $_SESSION['vistaActual'] = "vistaInicioAlumno";
    }

    function vistaInicioProfesor(){
        $vistaAnt = "vistaInicioProfesor";
        require_once("View/Users/Profesor/inicioProfesor.php");
        $_SESSION['vistaActual'] = "vistaInicioProfesor";
    }

    function vistaGestionUsuarios(){
        $vistaAnt = "vistaInicioDirectivo";
        require_once("View/Users/Directivo/Gestiones/gestionUsuarios.php");
        $_SESSION['vistaActual'] = "vistaGestionUsuarios";

    }

    function vistaGestionAlumnos($result = null){
        if(($result == null) || ($result == false)){
            $result = $this->modelo->consultarTodosAlumnos();
        }
        $vistaAnt = "vistaGestionUsuarios";
        require_once("View/Users/Directivo/Gestiones/gestionAlumnos.php");
        $_SESSION['vistaActual'] = "vistaGestionAlumnos";
    }

    function vistaGestionProfesores($result = null){
        if(($result == null) || ($result == false)){
            $result = $this->modelo->consultarTodosProfesores();
        }
        $asignaturas= $this->modelo->consultarTodasAsignaturas(); 
        $profesorAsignaturas = $this->modelo->consultarProfesorAsignaturas();
        $vistaAnt = "vistaGestionUsuarios";
        require_once("View/Users/Directivo/Gestiones/gestionProfesores.php");
        $_SESSION['vistaActual'] = "vistaGestionProfesores";
    }

    function vistaGestionDirectivos($result = null){ 
        if(($result == null) || ($result == false)){
            $result = $this->modelo->consultarTodosDirectvos();
        }
        $vistaAnt = "vistaGestionUsuarios";
        require_once("View/Users/Directivo/Gestiones/gestionDirectivos.php");
        $_SESSION['vistaActual'] = "vistaGestionDirectivos";
    }

    function vistaGestionAsignaturas($result = null){
        if($result == null){
            $result = $this->modelo->consultarTodasAsignaturas();
        }
        $vistaAnt = "vistaGestionUsuarios";
        require_once("View/Users/Directivo/Gestiones/gestionAsignaturas.php");
        $_SESSION['vistaActual'] = "vistaGestionAsignaturas";
    }

    function vistaGestionCitas($result = null){
        if($result == null){
            $result = $this->modelo->consultarTodasCitas();
        }
        $profesores= $this->modelo->consultarTodosProfesores();
        $asignaturas= $this->modelo->consultarTodasAsignaturas();
        $vistaAnt = "vistaInicioAlumno";
        require_once("View/Users/Alumno/Gestiones/gestionCitas.php");
        $_SESSION['vistaActual'] = "vistaGestionCitas";
    }

    function vistaGestionMaterialCompartido($result = null){
        $idCita = $_POST['idCita'];
        // $idAlumno = $_POST['idAlumno'];
        if($result == null){
            $result = $this->modelo->consultarTodoMaterial($idCita);
        }
        $tipoMaterial = $this->modelo->consultarTodoTipoMaterial();
        $vistaAnt = "vistaGestionCitasRecibidas";
        require_once("View/Users/Profesor/Gestiones/gestionMaterialCompartido.php");
        $_SESSION['vistaActual'] = "vistaGestionMaterialCompartido";
    }

    function vistaGestionTipoMaterial($result = null){
        if(($result == null) || ($result == false)){
            $result = $this->modelo->consultarTodoTipoMaterial();
        }
        $vistaAnt = "vistaInicioProfesor";
        require_once("View/Users/Profesor/Gestiones/gestionTipoMaterial.php");
        $_SESSION['vistaActual'] = "vistaGestionTipoMaterial";
    }

    function vistaGestionCitasRecibidas($result = null){
        if($result == null){
            $result = $this->modelo->consultarTodasCitasRecibidas($_SESSION['matricula']);
        }
        $asignaturas= $this->modelo->consultarTodasAsignaturas();
        $vistaAnt = "vistaInicioProfesor";
        require_once("View/Users/Profesor/Gestiones/gestionCitasRecibidas.php");
        $_SESSION['vistaActual'] = "vistaGestionCitasRecibidas";
    }

    //Nueva Funcion
    function vistaGestionDisponibilidades($result = null){
        if(($result == null) || ($result == false)){
            $result = $this->modelo->consultarTodasDisponibilidades();
        }
        $vistaAnt = "vistaInicioProfesor";
        require_once("View/Users/Profesor/Gestiones/gestionDisponibilidades.php");
        $_SESSION['vistaActual'] = "vistaGestionDisponibilidades";
    }

    //Nueva Funcion
    function vistaReportes(){
        $vistaAnt = "vistaInicio".$_SESSION['tipoUsuario'];
        require_once("View/Users/".$_SESSION['tipoUsuario']."/Reportes/reportes.php");
        $_SESSION['vistaActual'] = "vistaReportes";
    }

    //Nueva Funcion
    function vistaReporteAsesAtenProfCuatrimestre(){
        $vistaAnt = "vistaReportes";
        require_once("View/Users/Directivo/Reportes/reporteAsesAtenProfCuatrimestre.php");
        $_SESSION['vistaActual'] = "vistaReporteAsesAtenProfCuatrimestre";
    }

    //Nueva Funcion
    function vistaReporteSoliAsesAlumMes(){
        $vistaAnt = "vistaReportes";
        require_once("View/Users/Directivo/Reportes/reporteSoliAsesAlumMes.php");
        $_SESSION['vistaActual'] = "vistaReporteSoliAsesAlumMes";
    }

    //Nueva Funcion
    function vistaReporteAlumAtenMesCuatrimestre(){
        $vistaAnt = "vistaReportes";
        require_once("View/Users/Profesor/Reportes/reporteAlumAtenMesCuatrimestre.php");
        $_SESSION['vistaActual'] = "vistaReporteAlumAtenMesCuatrimestre";
    }

    function vistaReporteAAPC($result = null){
        $vistaAnt = "vistaReportes";
        require_once("View/Users/Profesor/Reportes/reporteAAPC.php");
        $_SESSION['vistaActual'] = "vistaReporteAAPC";
    }

    function vistaReporteCCPC($result = null){
        $vistaAnt = "vistaInicioAlumno";
        require_once("View/Users/Alumno/Reportes/reporteCCPC.php");
        $_SESSION['vistaActual'] = "vistaReporteCCPC";
    }

    function validarLogin(){
        $tipoUsuario = $_REQUEST['tipoUsuario'];
        $matricula = $_REQUEST['matricula'];
        $contrasenia = $_REQUEST['contrasenia'];

        if(isset($_POST['modal'])){
            $modal = $_POST['modal'];
            $result = $this->modelo->validarLogin($tipoUsuario, $matricula, $contrasenia);
        }
        
        if(isset($result)){
            if($result == -1 || $result == 0){
                echo json_encode($result);
            }else if($result == 1 && isset($modal)){
                echo json_encode($result);
            }
        }else{
            $this->{"vistaInicio".$tipoUsuario}();
        }
    }

    function logout(){
        $this->modelo->logout();
        header("location:".urlsite);
    }

    /*************** Gestion de Alumnos ***************/
    function consultarUnAlumno(){
        $matricula = $_POST['matricula'];
        $result = $this->modelo->consultarUnAlumno($matricula);
        $this->vistaGestionAlumnos($result);
    }

    function crearAlumno(){
        $matricula = $_POST['matricula'];
        $contrasenia = $_POST['contrasenia'];
        $nombre = $_POST['nombre'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoM = $_POST['apellidoM']; 
        $genero = $_POST['genero'];
        $carrera = $_POST['carrera'];
        $grado = $_POST['grado'];
        $grupo = $_POST['grupo'];
        $result = $this->modelo->crearAlumno($matricula, $contrasenia, $nombre, $apellidoP, $apellidoM, $genero, $carrera, $grado, $grupo);

        $this->vistaGestionAlumnos();
    }

    function eliminarAlumno(){
        $matricula = $_POST['matricula'];
        $result = $this->modelo->eliminarAlumno($matricula);

        $this->vistaGestionAlumnos();
    }

    function actualizarAlumno(){
        $matricula = $_POST['matricula'];
        $contrasenia = $_POST['contrasenia'];
        $nombre = $_POST['nombre'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoM = $_POST['apellidoM']; 
        $genero = $_POST['genero'];
        $carrera = $_POST['carrera'];
        $grado = $_POST['grado'];
        $grupo = $_POST['grupo'];
        $result = $this->modelo->actualizarAlumno($matricula, $contrasenia, $nombre, $apellidoP, $apellidoM, $genero, $carrera, $grado, $grupo);

        $this->vistaGestionAlumnos();
    }

    /*************** Gestion de Profesores ***************/
    function consultarUnProfesor(){
        $matricula = $_POST['matricula'];
        $result = $this->modelo->consultarUnProfesor($matricula);
        
        $this->vistaGestionProfesores($result);
    }

    function crearProfesor(){
        $matricula = $_POST['matricula'];
        $contrasenia = $_POST['contrasenia'];
        $nombre = $_POST['nombre'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoM = $_POST['apellidoM']; 
        $genero = $_POST['genero'];
        $nivelEducativo = $_POST['nivelEducativo'];
        $especialidad = $_POST['especialidad'];
        $estudiantesAtendidos = $_POST['estudiantesAtendidos'];
        $directivo = $_POST['directivo'];
        $asignaturas = $_POST['asignaturas'];

        $result = $this->modelo->crearProfesor($matricula, $contrasenia, $nombre, $apellidoP, $apellidoM, $genero, $nivelEducativo, $especialidad, $estudiantesAtendidos, $directivo, $asignaturas);

        $this->vistaGestionProfesores();
    }

    function eliminarProfesor(){
        $matricula = $_POST['matricula'];
        $result = $this->modelo->eliminarProfesor($matricula);

        $this->vistaGestionProfesores();
    }

    // Duda para la progesora:
    // Si un profesor y sus asignaturas existen en varias cita y se quiere cambiar 
    // las asignaturas del profesor, ¿QUe le permita al usuario cambiar las asignaturas?

    function actualizarProfesor(){ //De momento no se pueden actualizar las asignaturas de los profesores si estos están en alguna cita
        $matricula = $_POST['matricula'];
        $nombre = $_POST['nombre'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoM = $_POST['apellidoM']; 
        $genero = $_POST['genero'];
        $nivelEducativo = $_POST['nivelEducativo'];
        $especialidad = $_POST['especialidad'];
        $estudiantesAtendidos = $_POST['estudiantesAtendidos'];
        $directivo = $_POST['directivo'];

        $result = $this->modelo->actualizarProfesor($matricula, $nombre, $apellidoP, $apellidoM, $genero, $nivelEducativo, $especialidad, $estudiantesAtendidos, $directivo);

        if($result == false){
            sleep(3);
        }
        $this->vistaGestionProfesores();
    }

    /************** Funciones de la tabla profesorAsignatura **************/
    function consultarAsignaturasProf(){
        $matricula = $_POST["matricula"];

        $jsonAsignaturas = $this->modelo->consultarAsignaturasProf($matricula);
        echo $jsonAsignaturas; 
    }

    function actualizarProfAsig(){
        $matricula = $_POST["matricula"];
        $asignaturas = $_POST["asignaturas"];

        $jsonAsignaturas = $this->modelo->actualizarProfAsig($matricula, $asignaturas);
        echo $jsonAsignaturas; 
    }

    /************** Gestion Directivos **************/
    function consultarUnDirectivo(){
        $matricula = $_POST['matricula'];
        $result = $this->modelo->consultarUnDirectivo($matricula);
        $this->vistaGestionDirectivos($result);
    }

    function crearDirectivo(){
        $matricula = $_POST['matricula'];
        $contrasenia = $_POST['contrasenia'];
        $nombre = $_POST['nombre'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoM = $_POST['apellidoM']; 
        $genero = $_POST['genero'];
        $departamento = $_POST['departamento'];
        $noProfesores = $_POST['noProfesores'];
        $oficina = $_POST['oficina'];
        $result = $this->modelo->crearDirectivo($matricula, $contrasenia, $nombre, $apellidoP, $apellidoM, $genero, $departamento, $noProfesores, $oficina);

        // echo json_encode("Entró al controlador");
        $this->vistaGestionDirectivos();
    }

    function eliminarDirectivo(){
        $matricula = $_POST['matricula'];
        $result = $this->modelo->eliminarDirectivo($matricula);

        $this->vistaGestionDirectivos();
    }

    function actualizarDirectivo(){
        $matricula = $_POST['matricula'];
        $nombre = $_POST['nombre'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoM = $_POST['apellidoM']; 
        $genero = $_POST['genero'];
        $departamento = $_POST['departamento'];
        $noProfesores = $_POST['noProfesores'];
        $oficina = $_POST['oficina'];
        $result = $this->modelo->actualizarDirectivo($matricula, $nombre, $apellidoP, $apellidoM, $genero, $departamento, $noProfesores, $oficina);

        $this->vistaGestionDirectivos();
    }

    /*************** Gestion de Asignaturas ***************/
    function crearAsignatura(){
        $nombre = $_POST['nombre'];
        $siglas = $_POST['siglas'];
        $descripcion = $_POST['descripcion'];

        $result = $this->modelo->crearAsignatura($nombre, $siglas,  $descripcion);

        $this->vistaGestionAsignaturas();
    }

    function eliminarAsignatura(){
        $idAsignatura = $_POST['idAsignatura'];
        $result = $this->modelo->eliminarAsignatura($idAsignatura);
    
       $this->vistaGestionAsignaturas();
    }

    function actualizarAsignatura(){
        $idAsignatura = $_POST['idAsignatura'];
        $nombre = $_POST['nombre'];
        $siglas = $_POST['siglas'];
        $descripcion = $_POST['descripcion'];

        $result = $this->modelo->actualizarAsignatura($idAsignatura, $nombre, $siglas,  $descripcion);

        $this->vistaGestionAsignaturas();
    }

    /*************** Gestion de Citas ***************/
    function buscarCitaPorAsignatura(){
        $nomAsignatura = $_POST['nomAsignatura'];
        $result = $this->modelo->buscarCitaPorAsignatura($nomAsignatura);
        
        $this->vistaGestionCitas($result);
    }

    function buscarCitaPorProfesor(){
        $matricula = $_POST['matricula'];
        $result = $this->modelo->buscarCitaPorProfesor($matricula);
        
        $this->vistaGestionCitas($result);
    }

    function crearCita(){
        $tema = $_POST['tema'];
        $detalles = $_POST['detalles'];
        date_default_timezone_set("America/Mexico_City");
        $fechaEnvio = date("Y-m-d");
        $profesor_matricula = $_POST['profesor_matricula'];
        $asignatura_idAsignatura = $_POST['asignatura_idAsignatura'];
        $alumno_matricula = $_SESSION['matricula'];
        $estado = 'Pendiente';
    
        $result = $this->modelo->crearCita($tema, $detalles, $fechaEnvio, $estado, $profesor_matricula, $asignatura_idAsignatura, $alumno_matricula);
    
        $this->vistaGestionCitas();
    }
    
    
    function eliminarCita(){
        $idCita = $_POST['idCita'];
        $result = $this->modelo->eliminarCita($idCita);
    
        $this->vistaGestionCitas();
    }
    
    function actualizarCita(){
        $idCita = $_POST['idCita'];
        $tema = $_POST['tema'];
        $detalles = $_POST['detalles'];
        $fechaEnvio = $_POST['fechaEnvio'];
        $fechaEstado = $_POST['fechaEstado'];
        $estado = $_POST['estado'];
        $profesor_matricula = $_POST['profesor_matricula'];
        $asignatura_idAsignatura = $_POST['asignatura_idAsignatura'];
        $nota_idNota=0;
        if(isset($_POST['nota_idNota'])){
            $nota_idNota = $_POST['nota_idNota'];
        }
        $alumno_matricula = $_SESSION['matricula'];
    
        $result = $this->modelo->actualizarCita($idCita, $tema, $detalles, $fechaEnvio, $fechaEstado, $estado, $profesor_matricula, $asignatura_idAsignatura, $nota_idNota, $alumno_matricula);
    
        $this->vistaGestionCitas();

    }

    function actualizarCitaRecibida(){
        $idCita = $_POST['idCita'];
        $tema = $_POST['tema'];
        $detalles = $_POST['detalles'];
        $fechaEnvio = $_POST['fechaEnvio'];
        $fechaEstado = $_POST['fechaEstado'];
        $estado = $_POST['estado'];
        $profesor_matricula = $_POST['profesor_matricula'];
        $asignatura_idAsignatura = $_POST['asignatura_idAsignatura'];
        $nota_idNota=0;
        if(isset($_POST['nota_idNota'])){
            $nota_idNota = $_POST['nota_idNota'];
        }
        $alumno_matricula = $_POST['alumno_matricula'];
    
        $result = $this->modelo->actualizarCitaRecibida($idCita, $tema, $detalles, $fechaEnvio, $fechaEstado, $estado, $profesor_matricula, $asignatura_idAsignatura, $nota_idNota, $alumno_matricula);
    
        $this->vistaGestionCitasRecibidas();

    }

    function eliminarCitaRecibida(){
        $idCita = $_POST['idCita'];
        $result = $this->modelo->eliminarCita($idCita);
    
        $this->vistaGestionCitas();
    }

    /*************** Gestion del Tipo de Material ***************/
    function crearTipoMaterial(){
        $extension = $_POST['extension'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];

        $result = $this->modelo->crearTipoMaterial($extension,$descripcion,$categoria);

        $this->vistaGestionTipoMaterial();
    }

    function eliminarTipoMaterial(){
        $idmaterial = $_POST['idmaterial'];
        $result = $this->modelo->eliminarTipoMaterial($idmaterial);
    
       $this->vistaGestionTipoMaterial();
    }

    function actualizarTipoMaterial(){
        $idmaterial = $_POST['idmaterial'];
        $extension = $_POST['extension'];
        $descripcion = $_POST['descripcion'];
        $categoria = $_POST['categoria'];

        $result = $this->modelo->actualizarTipoMaterial($idmaterial, $extension,$descripcion,$categoria);

        $this->vistaGestionTipoMaterial();
    }

    /*************** Gestion de Disponibilidades ***************/
    // function consultarUnaDisponibilidad(){
    //     $id = $_POST['idDisponibilidad'];
    //     $result = $this->modelo->consultarUnaDisponibilidad($id);
    //     $this->vistaGestionDisponibilidades($result);
    // }

    function crearDisponibilidad(){
        $periodo = $_POST['periodo'];
        $Lunes = $_POST['Lunes'];
        $martes = $_POST['martes'];
        $miercoles = $_POST['miercoles']; 
        $jueves = $_POST['jueves'];
        $viernes = $_POST['viernes'];
        $result = $this->modelo->crearDisponibilidad($periodo, $Lunes, $martes, $miercoles, $jueves, $viernes);

        $this->vistaGestionDisponibilidades();
    }

    function eliminarDisponibilidad(){
        $id = $_POST['idDisponibilidad'];
        $result = $this->modelo->eliminarDisponibilidad($id);

        $this->vistaGestionDisponibilidades();
    }

    function actualizarDisponibilidad(){
        $id = $_POST['idDisponibilidad'];
        $periodo = $_POST['periodo'];
        $Lunes = $_POST['Lunes'];
        $martes = $_POST['martes'];
        $miercoles = $_POST['miercoles']; 
        $jueves = $_POST['jueves'];
        $viernes = $_POST['viernes'];
        $result = $this->modelo->actualizarDisponibilidad($id, $periodo, $Lunes, $martes, $miercoles, $jueves, $viernes);

        $this->vistaGestionDisponibilidades();
    }

    /*************** Gestion de material compartido ***************/
    function crearMaterialCompartido(){
        $titulo = $_POST['titulo'];
        $archivo = $_FILES['archivo'];
        $comentario = $_POST['comentario'];
        $tipoMaterial = $_POST['tipoMaterial'];
        $idCita = $_POST['idCita'];

        $result = $this->modelo->crearMaterialCompartido($titulo, $archivo, $comentario, $tipoMaterial, $idCita);

        $this->vistaGestionMaterialCompartido();
    }

    function eliminarMaterialCompartido(){
        $idMC = $_POST['idmaterialCompartido'];
        $direccionArc = $_POST['dirArchivo'];
        $result = $this->modelo->eliminarMaterialCompartido($idMC, $direccionArc);

        $this->vistaGestionMaterialCompartido();
    }

    function descargarArchivo(){
        $url = $_POST['url'];

        $result = $this->modelo->descargarArchivo($url);
        
    }

    function actualizarMaterialCompartido(){
        $id = $_POST['idmaterialCompartido'];
        $titulo = $_POST['titulo'];
        $dirArchivo = $_POST['dirArchivo'];
        $nuevoArchivo = NULL;
        if(isset($_FILES['nuevoArchivo']) && $_FILES['nuevoArchivo']['error'] == 0){
            $nuevoArchivo = $_FILES['nuevoArchivo'];
        }
        $comentario = $_POST['comentario'];
        $tipoMaterial = $_POST['tipoMaterial'];
        // $idCita = $_POST['idCita'];
        
        $result = $this->modelo->actualizarMaterialCompartido($id, $titulo, $dirArchivo, $nuevoArchivo, $comentario, $tipoMaterial);

        $this->vistaGestionMaterialCompartido();
    }

    /*************** Gestion de Notas ***************/
    function crearNota(){
        $idCita = $_POST['idCita']; 
       $titulo = $_POST['titulo'];
       $cuerpo = $_POST['cuerpo'];
       date_default_timezone_set("America/Mexico_City");
       $fechaCreacion = date("Y-m-d");
       $horaInicio = $_POST['horaInicio'];
       $horaFin = NULL;
       if(isset($_POST['horaFin']) && $_POST['horaFin'] !== ''){
           $horaFin = $_POST['horaFin'];
       }
       $calificacionP1 = $_POST['calificacionP1'];
       $calificacionP2 = 'NULL';
       if(isset($_POST['calificacionP2']) && $_POST['calificacionP2'] !== ''){
           $calificacionP2 = $_POST['calificacionP2'];
       }

       $result = $this->modelo->crearNota($idCita, $titulo,$cuerpo,$fechaCreacion,$horaInicio,$horaFin,$calificacionP1,$calificacionP2);
       echo $result;
    }

    function actualizarNota(){
        $idNota = $_POST['idNota']; 
        $titulo = $_POST['titulo'];
        $cuerpo = $_POST['cuerpo'];
        date_default_timezone_set("America/Mexico_City");
        $fechaCreacion = date("Y-m-d");
        $horaInicio = $_POST['horaInicio'];
        $horaFin = NULL;
        if(isset($_POST['horaFin']) && $_POST['horaFin'] !== ''){
            $horaFin = $_POST['horaFin'];
        }
        $calificacionP1 = $_POST['calificacionP1'];
        $calificacionP2 = 'NULL';
        if(isset($_POST['calificacionP2']) && $_POST['calificacionP2'] !== ''){
            $calificacionP2 = $_POST['calificacionP2'];
        }

        $result = $this->modelo->crearNota($idNota, $titulo,$cuerpo,$fechaCreacion,$horaInicio,$horaFin,$calificacionP1,$calificacionP2);
        echo $result;
    }

    function eliminarNota(){
        $idCita = $_POST['idCita'];
        $idNota = $_POST['idNota']; 
        $result = $this->modelo->eliminarNota($idNota, $idCita);
        echo $result;
    }

    function consultarUnaNota(){
        $idCita = $_POST['idCita'];
        
        $result = $this->modelo->consultarUnaNota($idCita);
        echo $result;
    }

    /*************** Reportes ***************/
    function reporteAsesAtenProfCuatrimestre(){
        $periodo = $_POST['periodo'];
        $ano = $_POST['ano'];

        $this->modelo->reporteAsesAtenProfCuatrimestre($periodo, $ano);

        $this->vistaReporteAsesAtenProfCuatrimestre();
    }

    function reporteSoliAsesAlumMes(){
        $mes = $_POST['mes'];
        $ano = $_POST['ano'];

        $this->modelo->reporteSoliAsesAlumMes($mes, $ano);

        $this->vistaReporteSoliAsesAlumMes();
    }

    function reporteAlumAtenMesCuatrimestre(){
        $periodo = $_POST['periodo'];
        $ano = $_POST['ano'];

        $this->modelo->reporteAlumAtenMesCuatrimestre($periodo, $ano);

        $this->vistaReporteAlumAtenMesCuatrimestre();
    }

    function reporteAAPC(){
        $periodo = $_POST['periodo'];
        $ano = $_POST['ano'];
        $this->modelo->reporteAAPC($periodo, $ano);
        $this->vistaReporteAAPC();
    }

    function reporteCCPC(){
        $periodo = $_POST['periodo'];
        $ano = $_POST['ano'];
        $this->modelo->reporteCCPC($periodo, $ano);
        $this->vistaReporteCCPC();
    }

}
