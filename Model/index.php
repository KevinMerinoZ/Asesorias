<?php
    
    require_once("conexion/DB.php");
    require_once("Model/plantilla.php");
    class Modelo{
        private $conn;

        public function __construct(){
            $db = new DB();
            $this->conn = $db->getConexion();
        }

        function validarLogin($tipoUsuario, $mtr, $pass){
            $sql = "SELECT * FROM $tipoUsuario WHERE matricula='$mtr' AND contrasenia='$pass' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            $row = mysqli_fetch_assoc($exec);
            
            if($exec == false && isset($row) == false){
                return -1;
            }

            if(mysqli_num_rows($exec) == 0){
                return 0;
            }

            $_SESSION['matricula'] = $row['matricula'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['apellidoP'] = $row['apellidoP'];
            $_SESSION['apellidoM'] = $row['apellidoM'];
            $_SESSION['tipoUsuario'] = $tipoUsuario;
            return 1;

        }
        
        function logout(){
            session_destroy();
        }
        
        
        /************** Gestion Alumnos **************/
        function consultarTodosAlumnos(){
            $sql = "SELECT * FROM Alumno WHERE existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        function consultarUnAlumno($matricula){
            $sql = "SELECT * FROM Alumno WHERE matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        function crearAlumno($matricula, $contrasenia, $nombre, $apellidoP, $apellidoM, $genero, $carrera, $grado, $grupo){
            $comprobarAlum = $this->consultarUnAlumno($matricula);
            if(($comprobarAlum == false) || (mysqli_num_rows($comprobarAlum) > 0)){
                return false;
            }
            $sql = "INSERT INTO Alumno VALUES('$matricula', '$contrasenia', '$nombre', '$apellidoP', '$apellidoM', '$genero', '$carrera', $grado, '$grupo', 1);";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
            
        }

        function eliminarAlumno($matricula){
            $sql = "UPDATE Alumno SET existencia=0 WHERE matricula='$matricula';";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
            
        }

        function actualizarAlumno($matricula, $contrasenia, $nombre, $apellidoP, $apellidoM, $genero, $carrera, $grado, $grupo){
            $sql = "UPDATE Alumno SET contrasenia='$contrasenia', nombre='$nombre', apellidoP='$apellidoP', apellidoM='$apellidoM', genero='$genero', carrera='$carrera', grado=$grado, grupo='$grupo' WHERE matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /************** Gestion Profesores **************/
        function consultarTodosProfesores(){
            $sql = "SELECT * FROM Profesor WHERE existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        function consultarUnProfesor($matricula){
            $sql = "SELECT * FROM Profesor WHERE matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            
            return $exec;
        }

        function crearProfesor($matricula, $contrasenia, $nombre, $apellidoP, $apellidoM, $genero, $nivelEducativo, $especialidad, $estudiantesAtendidos, $directivo, $asignaturas){
            $comprobarDirec = $this->consultarUnDirectivo($directivo);
            $comprobarProf = $this->consultarUnProfesor($matricula);
            if(($comprobarDirec == false) || (mysqli_num_rows($comprobarDirec) == 0)){
                return false;
            }
            if(($comprobarProf == false) || (mysqli_num_rows($comprobarProf) > 0)){
                return false;
            }
            $sql = "INSERT INTO Profesor VALUES('$matricula', '$contrasenia', '$nombre', '$apellidoP', '$apellidoM', '$genero', '$nivelEducativo', '$especialidad', $estudiantesAtendidos, 1, null, '$directivo');";
            $exec = mysqli_query($this->conn, $sql);

            $agregacionProfAsig = $this->agregarProfAsig($matricula, $asignaturas);

            if(($agregacionProfAsig == false)){
                return false;
            }

            return $exec;
            
        }

        function eliminarProfesor($matricula){
            $sql = "UPDATE Profesor SET existencia=0 WHERE matricula='$matricula';";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        function actualizarProfesor($matricula, $nombre, $apellidoP, $apellidoM, $genero, $nivelEducativo, $especialidad, $estudiantesAtendidos, $directivo){
            $comprobarDirec = $this->consultarUnDirectivo($directivo);
            if(($comprobarDirec == false) || (mysqli_num_rows($comprobarDirec) == 0)){
                
                return false;
            }

            $sql = "UPDATE Profesor SET nombre='$nombre', apellidoP='$apellidoP', apellidoM='$apellidoM', genero='$genero', nivelEducativo='$nivelEducativo', especialidad='$especialidad', estudiantesAtendidos=$estudiantesAtendidos, Directivo_matricula='$directivo' WHERE matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /************** Funciones de la tabla profesorAsignatura **************/
        function consultarAsignaturasProf($matricula){
            $sql = "SELECT idAsignatura, asignatura.nombre FROM profesorasignatura, profesor, asignatura WHERE Profesor_matricula=matricula AND Asignatura_idAsignatura=idAsignatura AND matricula='$matricula' AND asignatura.existencia=1 AND profesor.existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            if($exec == false){
                return -1;
            } 
            if(mysqli_num_rows($exec) < 1){
                return 0;
            }
            
            $Asignaturas = [];
            while($fila = mysqli_fetch_assoc($exec)){
                $Asignaturas[] = $fila;
            }

            $jsonAsignaturas = json_encode($Asignaturas);

            return $jsonAsignaturas;
        }

        function consultarProfesorAsignaturas(){
            $sql = "SELECT Profesor_matricula, Asignatura_idAsignatura FROM profesorasignatura, profesor, asignatura WHERE Profesor_matricula=matricula AND Asignatura_idAsignatura=idAsignatura AND asignatura.existencia=1 AND profesor.existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            
            return $exec;
        }

        function agregarProfAsig($matricula, $asignaturas){
            foreach($asignaturas as $asig){
                $sqlSelect = "SELECT * FROM profesorasignatura WHERE Profesor_matricula='$matricula' AND Asignatura_idAsignatura=$asig;";
                $execSelect = mysqli_query($this->conn, $sqlSelect);

                if(mysqli_num_rows($execSelect) == 0){
                    $sql = "INSERT INTO profesorasignatura VALUES('$matricula', $asig, 1);";
                    $exec = mysqli_query($this->conn, $sql);
                }else{
                    $sql = "UPDATE profesorasignatura SET existencia=1 WHERE Profesor_matricula='$matricula' AND Asignatura_idAsignatura=$asig;";
                    $exec = mysqli_query($this->conn, $sql);
                }
                
            }

            return $exec;
        }

        function eliminarProfAsig($matricula){
            $sql = "UPDATE profesorasignatura SET existencia=0 WHERE Profesor_matricula='$matricula';";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        function actualizarProfAsig($matricula, $asignaturas){
            $eliminarProfAsig = $this->eliminarProfAsig($matricula);
            if(($eliminarProfAsig == false)){
                return -1;
            }

            $agregacionProfAsig = $this->agregarProfAsig($matricula, $asignaturas);
            if(($agregacionProfAsig == false)){
                return -1;
            }

            return 1;
        }

        /************** Gestion Directivo **************/
        function consultarUnDirectivo($matricula){
            $sql = "SELECT * FROM Directivo WHERE matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            
            return $exec;
        }

        function consultarTodosDirectvos(){
            $sql = "SELECT * FROM Directivo WHERE existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;   
        }

        function crearDirectivo($matricula, $contrasenia, $nombre, $apellidoP, $apellidoM, $genero, $departamento, $noProfesores, $oficina){
            $comprobarDirec = $this->consultarUnDirectivo($matricula);
            if(($comprobarDirec == false) || (mysqli_num_rows($comprobarDirec) > 0)){
                return false;
            }
            $sql = "INSERT INTO Directivo VALUES('$matricula', '$contrasenia', '$nombre', '$apellidoP', '$apellidoM', '$genero', '$departamento', $noProfesores, 1);";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
            
        }

        function eliminarDirectivo($matricula){
            $sql = "UPDATE Directivo SET existencia=0 WHERE matricula='$matricula';";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
            
        }

        function actualizarDirectivo($matricula, $nombre, $apellidoP, $apellidoM, $genero, $departamento, $noProfesores){
            $sql = "UPDATE Directivo SET nombre='$nombre', apellidoP='$apellidoP', apellidoM='$apellidoM', genero='$genero', departamento='$departamento', noProfesores=$noProfesores WHERE matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /************** Gestion Asignaturas **************/
        function consultarTodasAsignaturas(){
            $sql = "SELECT * FROM asignatura WHERE existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        function crearAsignatura($nombre, $siglas, $descripcion) {
            $sql = "INSERT INTO Asignatura (nombre, siglas, descripcion, existencia) VALUES ('$nombre', '$siglas', '$descripcion', 1);";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        function eliminarAsignatura($idAsignatura){
            $sql = "UPDATE Asignatura SET existencia=0 WHERE idAsignatura='$idAsignatura';";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
            
        }

        function actualizarAsignatura($idAsignatura, $nombre, $siglas, $descripcion) {
            $sql = "UPDATE Asignatura SET nombre='$nombre', siglas='$siglas', descripcion='$descripcion' WHERE idAsignatura='$idAsignatura' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        /************** Gestion Citas **************/
        function buscarCitaPorAsignatura($nomAsignatura){
            $alumnoMatricula = $_SESSION['matricula'];
            $sql = "SELECT c.* FROM Cita c, asignatura a WHERE ProfesorAsignatura_Asignatura_idAsignatura=idAsignatura AND Alumno_matricula='$alumnoMatricula' AND a.nombre='$nomAsignatura' AND c.existencia=1 AND a.existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            
            return $exec;
        }

        function buscarCitaPorProfesor($matricula){
            $alumnoMatricula = $_SESSION['matricula'];
            $sql = "SELECT * FROM Cita WHERE ProfesorAsignatura_Profesor_matricula='$matricula' AND Alumno_matricula='$alumnoMatricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            
            return $exec;
        }

        function consultarTodasCitas() {
            if (!isset($_SESSION['matricula'])) {
                return null; 
            }
            $matricula = $_SESSION['matricula'];
            $sql = "SELECT * FROM Cita WHERE existencia = 1 
                    AND (Alumno_matricula = '$matricula' OR ProfesorAsignatura_Profesor_matricula = '$matricula');";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        function crearCita($tema, $detalles, $fechaEnvio, $estado, $profesor_matricula, $asignatura_idAsignatura, $alumno_matricula) {
            $sql = "INSERT INTO Cita (tema, detalles, fechaEnvio, estado, existencia, ProfesorAsignatura_profesor_matricula, ProfesorAsignatura_Asignatura_idAsignatura, Alumno_matricula) 
                    VALUES ('$tema', '$detalles', '$fechaEnvio', '$estado', 1, '$profesor_matricula', $asignatura_idAsignatura, '$alumno_matricula');";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }
        
        function eliminarCita($idCita) {
            $sql = "UPDATE Cita SET existencia=0 WHERE idCita = $idCita;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        function actualizarCita($idCita, $tema, $detalles, $fechaEnvio, $fechaEstado, $estado, $profesor_matricula, $asignatura_idAsignatura, $nota_idNota, $alumno_matricula) {
            $sql = "UPDATE Cita SET tema = '$tema', detalles = '$detalles', fechaEnvio = '$fechaEnvio', fechaEstado = '$fechaEstado', estado = '$estado', 
                    ProfesorAsignatura_Profesor_matricula = '$profesor_matricula', ProfesorAsignatura_Asignatura_idAsignatura = $asignatura_idAsignatura, 
                    Alumno_matricula = '$alumno_matricula' 
                    WHERE idCita = $idCita AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        function eliminarCitaRecibida($idCita) {
            $sql = "UPDATE Cita SET existencia=0 WHERE idCita = $idCita;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        function actualizarCitaRecibida($idCita, $tema, $detalles, $fechaEnvio, $fechaEstado, $estado, $profesor_matricula, $asignatura_idAsignatura, $nota_idNota, $alumno_matricula) {
            date_default_timezone_set("America/Mexico_City");
            $fecha = date("Y-m-d");
            $sql = "UPDATE Cita SET tema = '$tema', detalles = '$detalles', fechaEnvio = '$fechaEnvio', fechaEstado = '$fecha', estado = '$estado', 
                    ProfesorAsignatura_Profesor_matricula = '$profesor_matricula', ProfesorAsignatura_Asignatura_idAsignatura = $asignatura_idAsignatura, 
                    Alumno_matricula = '$alumno_matricula' 
                    WHERE idCita = $idCita AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

         /************** Gestion Material compartido al alumno **************/
        function consultarTodoMaterial($idCita){
            $sql = "SELECT * FROM materialcompartido WHERE Cita_idCita=$idCita AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        function crearMaterialCompartido($titulo, $archivo, $comentario, $tipoMaterial, $idCita){
            $destino = $this->procesarArchivo($archivo);

            $sql = "INSERT INTO materialCompartido VALUES (0, '$titulo', '$destino', '$comentario', 1, '$tipoMaterial', '$idCita');";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        function actualizarMaterialCompartido($id, $titulo, $dirArchivo, $nuevoArchivo, $comentario, $tipoMaterial){
            $flag = false;
            if(isset($nuevoArchivo) || $nuevoArchivo !=""){
                $dirArchivoAnt = $dirArchivo;
                $dirArchivo = $this->procesarArchivo($nuevoArchivo);
                $flag = true;
            }

            $sql = "UPDATE MaterialCompartido SET titulo='$titulo', archivo='$dirArchivo', comentario='$comentario', TipoMaterial_idmaterial=$tipoMaterial WHERE idmaterialCompartido='$id' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            if($exec == false && $flag){
                unlink($dirArchivo);
                return $exec;
            }

            if(isset($dirArchivoAnt)){
                unlink($dirArchivoAnt);
            }

            return $exec;
        }

        function procesarArchivo($archivo){
            $rutaTemp = $archivo['tmp_name'];
            $nombre = $archivo['name'];
            $tamano = $archivo['size'];
            $tipo = $archivo['type'];

            $nuevoNombre = time().'_'.$nombre;

            $destino = "Model/ArchivosEnviados/".$nuevoNombre;

            move_uploaded_file($rutaTemp, $destino);
            return $destino;
        }

        function eliminarMaterialCompartido($idMC, $direccionArc){
            $sql = "UPDATE materialcompartido SET existencia=0 WHERE idmaterialCompartido='$idMC';";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        function descargarArchivo($url){
            if (file_exists($url)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($url) . '"');
                header('Content-Length: ' . filesize($url));
            
                ob_clean();
                flush();
            
                readfile($url);
            
                return 1;
            } else {
                return 0;
            }
        }

         /************** Gestion Disponibilidades **************/
        function consultarTodasDisponibilidades(){
            $matricula = $_SESSION['matricula'];
            $sql = "SELECT idDisponibilidad, periodo, Lunes, martes, miercoles, jueves, viernes FROM profesor, Disponibilidad WHERE Disponibilidad_idDisponibilidad=idDisponibilidad AND matricula='$matricula' AND Disponibilidad.existencia=1 AND profesor.existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        // function consultarUnaDisponibilidad($id){
        //     $sql = "SELECT * FROM Disponibilidad WHERE idDisponibilidad='$id';";
        //     $exec = mysqli_query($this->conn, $sql);

        //     return $exec;
        // }

        function crearDisponibilidad($periodo, $Lunes, $martes, $miercoles, $jueves, $viernes){
            $matricula = $_SESSION['matricula'];

            $sql = "INSERT INTO Disponibilidad VALUES(0, '$periodo', '$Lunes', '$martes', '$miercoles', '$jueves', '$viernes', 1);";
            $exec = mysqli_query($this->conn, $sql);

            $sql = "UPDATE Profesor SET Disponibilidad_idDisponibilidad=(SELECT idDisponibilidad FROM disponibilidad ORDER BY idDisponibilidad DESC LIMIT 1) WHERE matricula like '$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
            
        }

        function eliminarDisponibilidad($id){
            $matricula = $_SESSION['matricula'];
            $sql = "UPDATE Profesor SET Disponibilidad_idDisponibilidad=NULL WHERE matricula like '$matricula';";
            $exec = mysqli_query($this->conn, $sql);

            $sql = "UPDATE Disponibilidad SET existencia=0 WHERE idDisponibilidad=$id;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
            
        }

        function actualizarDisponibilidad($id, $periodo, $Lunes, $martes, $miercoles, $jueves, $viernes){
            $sql = "UPDATE Disponibilidad SET periodo='$periodo', Lunes='$Lunes', martes='$martes', miercoles='$miercoles', jueves='$jueves', viernes='$viernes' WHERE idDisponibilidad='$id' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /************** Gestion Tipo material **************/
        function consultarTodoTipoMaterial(){
            $matricula=$_SESSION['matricula'];
            $sql = "SELECT * FROM tipomaterial WHERE Profesor_matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        function crearTipoMaterial($extension,$descripcion,$categoria) {
            $matricula=$_SESSION['matricula'];
            $sql = "INSERT INTO tipomaterial (extension,descripcion,categoria,Profesor_matricula) VALUES ('$extension',  '$descripcion','$categoria','$matricula');";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        function eliminarTipoMaterial($idmaterial){
            $sql = "DELETE FROM tipomaterial WHERE idmaterial='$idmaterial';";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
            
        }

        function actualizarTipoMaterial($idmaterial, $extension,$descripcion,$categoria) {
            $sql = "UPDATE tipomaterial SET extension='$extension', descripcion='$descripcion', categoria='$categoria' WHERE idmaterial='$idmaterial';";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        /************** Gestion Notas **************/
        function consultarUnaNota($idCita){
            $sql = "SELECT n.* FROM Cita c, Nota n WHERE Nota_idNota=idNota AND idCita='$idCita' AND c.existencia=1 AND n.existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            
            if($exec == false){
                return -1;
            } 
            if(mysqli_num_rows($exec) < 1){
                return 0;
            }
            
            $nota = [];
            while($fila = mysqli_fetch_row($exec)){
                $nota[] = $fila;
            }

            $jsonNota = json_encode($nota);

            return $jsonNota;
        }

        function crearNota($idCita, $titulo, $cuerpo, $fechaCreacion, $horaInicio, $horaFin, $calificacionP1,$calificacionP2) {
            $sql = "INSERT INTO Nota (titulo, cuerpo, fechaCreacion, horaInicio, horaFin, calificacionP1, calificacionP2, existencia) 
                    VALUES ('$titulo', '$cuerpo', '$fechaCreacion', '$horaInicio', '$horaFin', $calificacionP1, $calificacionP2, 1);";
            $exec = mysqli_query($this->conn, $sql);

            $sql = "UPDATE Cita SET Nota_idNota=(SELECT idNota FROM Nota ORDER BY idNota DESC LIMIT 1) WHERE idCita=$idCita AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            return "1";
        }

        function actualizarNota($idNota, $titulo, $cuerpo, $fechaCreacion, $horaInicio, $horaFin, $calificacionP1, $calificacionP2) {
            $sql = "UPDATE Nota SET titulo='$titulo', cuerpo='$cuerpo', fechaCreacion='$fechaCreacion', horaInicio='$horaInicio', horaFin='$horaFin', calificacionP1='$calificacionP1', calificacionP2='$calificacionP2' WHERE idNota=$idNota";

            $exec = mysqli_query($this->conn, $sql);

            return "1";
        }

        function eliminarNota($idNota, $idCita){
            $matricula = $_SESSION['matricula'];
            $sql = "UPDATE cita SET Nota_idNota=NULL WHERE idCita=$idCita;";
            $exec = mysqli_query($this->conn, $sql);

            $sql = "DELETE FROM Nota WHERE idNota=$idNota;";
            $exec = mysqli_query($this->conn, $sql);

            return 1;
            
        }

        /*************** Reportes ***************/
        function reporteAsesAtenProfCuatrimestre($periodo, $ano){
            if($periodo == "invierno"){
                $query = "SELECT p.matricula, p.nombre, apellidoP, apellidoM, COUNT(p.matricula) AS 'noAsesorias' FROM Cita c, profesor p WHERE ProfesorAsignatura_Profesor_matricula=matricula AND estado='Aceptada' AND (MONTH(fechaEstado) BETWEEN 1 and 4) AND YEAR(fechaEstado)=$ano GROUP BY p.matricula;"; 
                $resultado= mysqli_query($this->conn,$query);
            }else if($periodo == "primavera"){
                $query = "SELECT p.matricula, p.nombre, apellidoP, apellidoM, COUNT(p.matricula) AS 'noAsesorias' FROM Cita c, profesor p WHERE ProfesorAsignatura_Profesor_matricula=matricula AND estado='Aceptada' AND (MONTH(fechaEstado) BETWEEN 5 and 8) AND YEAR(fechaEstado)=$ano GROUP BY p.matricula;"; 
                $resultado= mysqli_query($this->conn,$query);
            }else{
                $query = "SELECT p.matricula, p.nombre, apellidoP, apellidoM, COUNT(p.matricula) AS 'noAsesorias' FROM Cita c, profesor p WHERE ProfesorAsignatura_Profesor_matricula=matricula AND estado='Aceptada' AND (MONTH(fechaEstado) BETWEEN 9 and 12) AND YEAR(fechaEstado)=$ano GROUP BY p.matricula;"; 
                $resultado= mysqli_query($this->conn,$query);
            }
            $pdf = new PDF('P','mm','letter');
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFillColor(232,232,232);
            $pdf->SetFont('Arial','B',12);

            $pdf->Cell(200, 10, 'Numero de asesorías atendidas por profesores en el periodo '.$periodo, 1, 1, 'C', true);
            $pdf->Cell(30, 10, 'Matricula', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
            $pdf->Cell(50, 10, 'Apellido Paterno', 1, 0, 'C', true);
            $pdf->Cell(50, 10, 'Apellido Materno', 1, 0, 'C', true);
            $pdf->Cell(30, 10, 'No. Asesorias', 1, 1, 'C', true);     
		   
            $pdf->SetFont('Arial','',12);
            while($row = mysqli_fetch_array($resultado))
            {
                $pdf->Cell(30, 8, $row['matricula'], 1, 0, 'C');
                $pdf->Cell(40, 8, $row['nombre'], 1, 0, 'C');
                $pdf->Cell(50, 8, $row['apellidoP'], 1, 0, 'C');
                $pdf->Cell(50, 8, $row['apellidoM'], 1, 0, 'C');
                $pdf->Cell(30, 8, $row['noAsesorias'], 1, 1, 'C');				
            }				
            $pdf->Output('D', 'reporteAsesAtenProfCuatrimestre.pdf');
        }

        function reporteSoliAsesAlumMes($mes, $ano){
            $query = "SELECT a.matricula, nombre, apellidoP, apellidoM, COUNT(a.matricula) AS 'noAsesorias' FROM Cita c, Alumno a WHERE Alumno_matricula=a.matricula AND MONTH(fechaEnvio)=$mes AND YEAR(fechaEnvio)=$ano GROUP BY a.matricula;"; 
            $resultado= mysqli_query($this->conn,$query);
            
            $pdf = new PDF('P','mm','letter');
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFillColor(232,232,232);
            $pdf->SetFont('Arial','B',12);

            $pdf->Cell(200, 10, 'Numero de solicitudes para asesorias hechas por los alumnos en el mes '.$mes, 1, 1, 'C', true);
            $pdf->Cell(30, 10, 'Matricula', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
            $pdf->Cell(50, 10, 'Apellido Paterno', 1, 0, 'C', true);
            $pdf->Cell(50, 10, 'Apellido Materno', 1, 0, 'C', true);
            $pdf->Cell(30, 10, 'No. Asesorias', 1, 1, 'C', true);     
		   
            $pdf->SetFont('Arial','',12);
            while($row = mysqli_fetch_array($resultado))
            {
                $pdf->Cell(30, 8, $row['matricula'], 1, 0, 'C');
                $pdf->Cell(40, 8, $row['nombre'], 1, 0, 'C');
                $pdf->Cell(50, 8, $row['apellidoP'], 1, 0, 'C');
                $pdf->Cell(50, 8, $row['apellidoM'], 1, 0, 'C');
                $pdf->Cell(30, 8, $row['noAsesorias'], 1, 1, 'C');				
            }				
            $pdf->Output('D', 'reporteSoliAsesAlumMes.pdf');
        }

        function reporteAlumAtenMesCuatrimestre($periodo, $ano){
            $matricula = $_SESSION['matricula'];
            if($periodo == "invierno"){
                $query = "SELECT MONTHNAME(fechaEstado) AS 'mes', COUNT(MONTHNAME(fechaEstado)) as 'noAsesorias' FROM Cita WHERE (MONTH(fechaEstado) BETWEEN 1 and 4) AND YEAR(fechaEstado)=$ano AND ProfesorAsignatura_Profesor_matricula='$matricula' GROUP BY MONTHNAME(fechaEstado);"; 
                $resultado= mysqli_query($this->conn,$query);
            }else if($periodo == "primavera"){
                $query = "SELECT MONTHNAME(fechaEstado) AS 'mes', COUNT(MONTHNAME(fechaEstado)) as 'noAsesorias' FROM Cita WHERE (MONTH(fechaEstado) BETWEEN 5 and 8) AND YEAR(fechaEstado)=$ano AND ProfesorAsignatura_Profesor_matricula='$matricula' GROUP BY MONTHNAME(fechaEstado);"; 
                $resultado= mysqli_query($this->conn,$query);
            }else{
                $query = "SELECT MONTHNAME(fechaEstado) AS 'mes', COUNT(MONTHNAME(fechaEstado)) as 'noAsesorias' FROM Cita WHERE (MONTH(fechaEstado) BETWEEN 9 and 12) AND YEAR(fechaEstado)=$ano AND ProfesorAsignatura_Profesor_matricula='$matricula' GROUP BY MONTHNAME(fechaEstado);"; 
                $resultado= mysqli_query($this->conn,$query);
            }

            $pdf = new PDF('P','mm','letter');
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFillColor(232,232,232);
            $pdf->SetFont('Arial','B',12);

            $pdf->Cell(150, 10, 'Numero de alumnos atendidos por mes en el periodo '.$periodo, 1, 1, 'C', true);
            $pdf->Cell(100, 10, 'Mes', 1, 0, 'C', true);
            $pdf->Cell(50, 10, 'No. Asesorias', 1, 1, 'C', true);
     
		   
            $pdf->SetFont('Arial','',12);
            while($row = mysqli_fetch_array($resultado))
            {
                $pdf->Cell(100, 8, $row['mes'], 1, 0, 'C');
                $pdf->Cell(50, 8, $row['noAsesorias'], 1, 1, 'C');			
            }				
            $pdf->Output('D', 'reporteAlumAtenMesCuatrimestre.pdf');
        }

        function consultarTodasCitasRecibidas($matricula){
            $sql = "SELECT * FROM cita WHERE ProfesorAsignatura_Profesor_matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        function reporteAAPC($periodo, $ano) {
            $matricula = $_SESSION['matricula'];
            if ($periodo == "Septiembre-Diciembre") {
                $query = "SELECT a.idAsignatura, a.nombre, a.siglas, a.descripcion, COUNT(c.ProfesorAsignatura_Asignatura_idAsignatura) AS 'noAsesorias' FROM Cita c, asignatura a WHERE c.estado = 'Aceptada' AND MONTH(c.fechaEstado) BETWEEN 9 AND 12 AND YEAR(c.fechaEstado) = $ano AND c.ProfesorAsignatura_Profesor_matricula = '$matricula' AND c.ProfesorAsignatura_Asignatura_idAsignatura = a.idAsignatura GROUP BY a.idAsignatura, a.nombre, a.siglas, a.descripcion;";
            } else if ($periodo == "Enero-Abril") {
                $query = "SELECT a.idAsignatura, a.nombre, a.siglas, a.descripcion, COUNT(c.ProfesorAsignatura_Asignatura_idAsignatura) AS 'noAsesorias' FROM Cita c, asignatura a WHERE c.estado = 'Aceptada' AND MONTH(c.fechaEstado) BETWEEN 1 AND 4 AND YEAR(c.fechaEstado) = $ano AND c.ProfesorAsignatura_Profesor_matricula = '$matricula' AND c.ProfesorAsignatura_Asignatura_idAsignatura = a.idAsignatura GROUP BY a.idAsignatura, a.nombre, a.siglas, a.descripcion;";
            } else {
                $query = "SELECT a.idAsignatura, a.nombre, a.siglas, a.descripcion, COUNT(c.ProfesorAsignatura_Asignatura_idAsignatura) AS 'noAsesorias' FROM Cita c, asignatura a WHERE c.estado = 'Aceptada' AND MONTH(c.fechaEstado) BETWEEN 5 AND 8 AND YEAR(c.fechaEstado) = $ano AND c.ProfesorAsignatura_Profesor_matricula = '$matricula' AND c.ProfesorAsignatura_Asignatura_idAsignatura = a.idAsignatura GROUP BY a.idAsignatura, a.nombre, a.siglas, a.descripcion;";
            }
            
            $resultado = mysqli_query($this->conn, $query);
        
            $pdf = new PDF('P', 'mm', 'letter');
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFillColor(232, 232, 232);
            $pdf->SetFont('Arial', 'B', 12);
        
            $pdf->Cell(200, 10, 'Asesorias atendidas por asignaturas en el periodo ' . $periodo, 1, 1, 'C', true);
            $pdf->Cell(30, 10, 'ID Asignatura', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
            $pdf->Cell(30, 10, 'Siglas', 1, 0, 'C', true);
            $pdf->Cell(70, 10, 'Descripcion', 1, 0, 'C', true);
            $pdf->Cell(30, 10, 'No. Asesorias', 1, 1, 'C', true);
        
            $pdf->SetFont('Arial', '', 12);
            while ($row = mysqli_fetch_array($resultado)) {
                $pdf->Cell(30, 8, $row['idAsignatura'], 1, 0, 'C');
                $pdf->Cell(40, 8, substr($row['nombre'], 0, 20), 1, 0, 'C');
                $pdf->Cell(30, 8, $row['siglas'], 1, 0, 'C');
                $pdf->Cell(70, 8, substr($row['descripcion'], 0, 40), 1, 0, 'C');
                $pdf->Cell(30, 8, $row['noAsesorias'], 1, 1, 'C');
            }
        
            $pdf->Output('D', 'reporteAAPC.pdf');
        }        
        
        function reporteCCPC($periodo, $ano){
            $matricula=$_SESSION['matricula'];
            if($periodo == "Septiembre-Diciembre"){
                $query = "SELECT p.matricula, p.nombre, apellidoP, apellidoM, COUNT(Alumno_matricula) AS 'noAsesorias' FROM Cita c, profesor p WHERE ProfesorAsignatura_Profesor_matricula=matricula AND (MONTH(fechaEnvio) BETWEEN 9 and 12) AND YEAR(fechaEnvio)=$ano AND Alumno_matricula='$matricula' GROUP BY Alumno_matricula;"; 
                $resultado= mysqli_query($this->conn,$query);
            }else if($periodo == "Enero-Abril"){
                $query = "SELECT p.matricula, p.nombre, apellidoP, apellidoM, COUNT(Alumno_matricula) AS 'noAsesorias' FROM Cita c, profesor p WHERE ProfesorAsignatura_Profesor_matricula=matricula AND (MONTH(fechaEnvio) BETWEEN 1 and 4) AND YEAR(fechaEnvio)=$ano AND Alumno_matricula='$matricula' GROUP BY Alumno_matricula;"; 
                $resultado= mysqli_query($this->conn,$query);
            }else{
                $query = "SELECT p.matricula, p.nombre, apellidoP, apellidoM, COUNT(Alumno_matricula) AS 'noAsesorias' FROM Cita c, profesor p WHERE ProfesorAsignatura_Profesor_matricula=matricula AND (MONTH(fechaEnvio) BETWEEN 5 and 8) AND YEAR(fechaEnvio)=$ano AND Alumno_matricula='$matricula' GROUP BY Alumno_matricula;"; 
                $resultado= mysqli_query($this->conn,$query);
            }
            $pdf = new PDF('P','mm','letter');
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFillColor(232,232,232);
            $pdf->SetFont('Arial','B',12);

            $pdf->Cell(200, 10, 'Numero de asesorías enviadas a los profesores en el periodo '.$periodo, 1, 1, 'C', true);
            $pdf->Cell(30, 10, 'Matricula', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
            $pdf->Cell(50, 10, 'Apellido Paterno', 1, 0, 'C', true);
            $pdf->Cell(50, 10, 'Apellido Materno', 1, 0, 'C', true);
            $pdf->Cell(30, 10, 'No. Asesorias', 1, 1, 'C', true);     
		   
            $pdf->SetFont('Arial','',12);
            while($row = mysqli_fetch_array($resultado))
            {
                $pdf->Cell(30, 8, $row['matricula'], 1, 0, 'C');
                $pdf->Cell(40, 8, $row['nombre'], 1, 0, 'C');
                $pdf->Cell(50, 8, $row['apellidoP'], 1, 0, 'C');
                $pdf->Cell(50, 8, $row['apellidoM'], 1, 0, 'C');
                $pdf->Cell(30, 8, $row['noAsesorias'], 1, 1, 'C');				
            }				
            $pdf->Output('D', 'reporteCCPC.pdf');
        }
    }

    
    