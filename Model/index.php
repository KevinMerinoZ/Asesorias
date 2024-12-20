<?php
    
    require_once("conexion/DB.php");
    require_once("Model/plantilla.php");
    require_once "vendor/autoload.php";
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
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

        /************** Respaldo y Restauración **************/
        public function realizarRespaldo($rutaDestino) {
            try {
                $fechaHora = date("Y-m-d_H-i-s");
                $archivoRespaldo = $rutaDestino . "/respaldo_" . $fechaHora . ".sql";

                $comando = "C:\\xampp\\mysql\\bin\\mysqldump.exe --host=localhost --user='root' --password='' dbasesorias > $archivoRespaldo 2>&1";
                exec($comando, $salida, $resultado);

            if ($resultado === 0) {
                    return "Respaldo creado correctamente: " . $archivoRespaldo;
                } else {
                    $error = implode("\n", $salida);
                    return "Error al realizar el respaldo. Detalles: " . $error;
                }
            } catch (Exception $e) {
                return "Error: " . $e->getMessage();
            }
        }

        public function restaurarRespaldo($rutaArchivoRespaldo) {
            try {
                $rutaMysql = "C:\\xampp\\mysql\\bin\\mysql.exe";

                $comando = "\"{$rutaMysql}\" --host=localhost --user='root' --password='' dbasesorias < \"{$rutaArchivoRespaldo}\" 2>&1";
        
                exec($comando, $salida, $resultado);
        
                if ($resultado === 0) {
                    return "Base de datos restaurada correctamente.";
                } else {
                    $error = implode("\n", $salida);
                    return "Error al restaurar la base de datos. Detalles: " . $error;
                }
            } catch (Exception $e) {
                return "Error: " . $e->getMessage();
            }
        }
        
        /************** Gestion Alumnos **************/
        /**
         * Consultar todos los alumnos activos.
         * 
         * @return mysqli_result Resultado de la consulta con todos los alumnos activos.
         */
        function consultarTodosAlumnos() {
            //consulta a la base de datos
            $sql = "SELECT * FROM Alumno WHERE existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /**
         * Consultar un alumno específico por su matrícula, si está activo.
         * 
         * @param string $matricula Matrícula del alumno a consultar.
         * @return mysqli_result Resultado de la consulta con los datos del alumno.
         */
        function consultarUnAlumno($matricula) {
            //consulta a la base de datos
            $sql = "SELECT * FROM Alumno WHERE matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /**
         * Crear un nuevo registro de alumno en la base de datos.
         * 
         * @param string $matricula Matrícula del alumno.
         * @param string $contrasenia Contraseña del alumno.
         * @param string $nombre Nombre del alumno.
         * @param string $apellidoP Apellido paterno del alumno.
         * @param string $apellidoM Apellido materno del alumno.
         * @param string $genero Género del alumno.
         * @param string $carrera Carrera que cursa el alumno.
         * @param int $grado Grado que cursa el alumno.
         * @param string $grupo Grupo al que pertenece el alumno.
         * @return bool|mysqli_result False si el alumno ya existe o ocurre un error, resultado de la consulta si tiene éxito.
         */
        function crearAlumno($matricula, $contrasenia, $nombre, $apellidoP, $apellidoM, $genero, $carrera, $grado, $grupo) {
            $comprobarAlum = $this->consultarUnAlumno($matricula);
            if (($comprobarAlum == false) || (mysqli_num_rows($comprobarAlum) > 0)) {
                return false;  // El alumno ya existe o hay un error en la consulta
            }

            //Insersion en la base de datos
            $sql = "INSERT INTO Alumno VALUES('$matricula', '$contrasenia', '$nombre', '$apellidoP', '$apellidoM', '$genero', '$carrera', $grado, '$grupo', 1);";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /**
         * Eliminar (desactivar) un alumno mediante su matrícula.
         * 
         * @param string $matricula Matrícula del alumno a eliminar.
         * @return mysqli_result Resultado de la consulta para desactivar al alumno.
         */
        function eliminarAlumno($matricula) {
            //Actualización en la base de datos
            $sql = "UPDATE Alumno SET existencia=0 WHERE matricula='$matricula';";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /**
         * Actualizar los datos de un alumno existente.
         * 
         * @param string $matricula Matrícula del alumno a actualizar.
         * @param string $contrasenia Nueva contraseña del alumno.
         * @param string $nombre Nuevo nombre del alumno.
         * @param string $apellidoP Nuevo apellido paterno del alumno.
         * @param string $apellidoM Nuevo apellido materno del alumno.
         * @param string $genero Nuevo género del alumno.
         * @param string $carrera Nueva carrera del alumno.
         * @param int $grado Nuevo grado del alumno.
         * @param string $grupo Nuevo grupo del alumno.
         * @return mysqli_result Resultado de la consulta para actualizar los datos del alumno.
         */
        function actualizarAlumno($matricula, $contrasenia, $nombre, $apellidoP, $apellidoM, $genero, $carrera, $grado, $grupo) {
            //Actualización en la base de datos
            $sql = "UPDATE Alumno 
                    SET contrasenia='$contrasenia', 
                        nombre='$nombre', 
                        apellidoP='$apellidoP', 
                        apellidoM='$apellidoM', 
                        genero='$genero', 
                        carrera='$carrera', 
                        grado=$grado, 
                        grupo='$grupo' 
                    WHERE matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /************** Gestion Profesores **************/
        /**
         * Consultar todos los profesores activos.
         * 
         * @return mysqli_result Resultado de la consulta con todos los profesores activos.
         */
        function consultarTodosProfesores() {
            $sql = "SELECT * FROM Profesor WHERE existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /**
         * Consultar un profesor específico por su matrícula, si está activo.
         * 
         * @param string $matricula Matrícula del profesor a consultar.
         * @return mysqli_result Resultado de la consulta con los datos del profesor.
         */
        function consultarUnProfesor($matricula) {
            $sql = "SELECT * FROM Profesor WHERE matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /**
         * Crear un nuevo registro de profesor en la base de datos.
         * 
         * @param string $matricula Matrícula del profesor.
         * @param string $contrasenia Contraseña del profesor.
         * @param string $nombre Nombre del profesor.
         * @param string $apellidoP Apellido paterno del profesor.
         * @param string $apellidoM Apellido materno del profesor.
         * @param string $genero Género del profesor.
         * @param string $nivelEducativo Nivel educativo del profesor.
         * @param string $especialidad Especialidad del profesor.
         * @param int $estudiantesAtendidos Número de estudiantes atendidos.
         * @param string $directivo Matrícula del directivo asociado.
         * @param array $asignaturas Lista de asignaturas que el profesor imparte.
         * @return bool|mysqli_result False si falla la validación o la inserción, resultado de la consulta si tiene éxito.
         */
        function crearProfesor($matricula, $contrasenia, $nombre, $apellidoP, $apellidoM, $genero, $nivelEducativo, $especialidad, $estudiantesAtendidos, $directivo, $asignaturas) {
            $comprobarDirec = $this->consultarUnDirectivo($directivo);
            $comprobarProf = $this->consultarUnProfesor($matricula);

            if (($comprobarDirec == false) || (mysqli_num_rows($comprobarDirec) == 0)) {
                return false;
            }
            if (($comprobarProf == false) || (mysqli_num_rows($comprobarProf) > 0)) {
                return false;
            }

            $sql = "INSERT INTO Profesor VALUES('$matricula', '$contrasenia', '$nombre', '$apellidoP', '$apellidoM', '$genero', '$nivelEducativo', '$especialidad', $estudiantesAtendidos, 1, null, '$directivo');";
            $exec = mysqli_query($this->conn, $sql);

            $agregacionProfAsig = $this->agregarProfAsig($matricula, $asignaturas);
            if ($agregacionProfAsig == false) {
                return false;
            }

            return $exec;
        }

        /**
         * Eliminar (desactivar) un profesor mediante su matrícula.
         * 
         * @param string $matricula Matrícula del profesor a eliminar.
         * @return mysqli_result Resultado de la consulta para desactivar al profesor.
         */
        function eliminarProfesor($matricula) {
            $sql = "UPDATE Profesor SET existencia=0 WHERE matricula='$matricula';";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /**
         * Actualizar los datos de un profesor existente.
         * 
         * @param string $matricula Matrícula del profesor a actualizar.
         * @param string $nombre Nuevo nombre del profesor.
         * @param string $apellidoP Nuevo apellido paterno del profesor.
         * @param string $apellidoM Nuevo apellido materno del profesor.
         * @param string $genero Nuevo género del profesor.
         * @param string $nivelEducativo Nuevo nivel educativo del profesor.
         * @param string $especialidad Nueva especialidad del profesor.
         * @param int $estudiantesAtendidos Nuevo número de estudiantes atendidos.
         * @param string $directivo Nueva matrícula del directivo asociado.
         * @return bool|mysqli_result False si falla la validación, resultado de la consulta si tiene éxito.
         */
        function actualizarProfesor($matricula, $nombre, $apellidoP, $apellidoM, $genero, $nivelEducativo, $especialidad, $estudiantesAtendidos, $directivo) {
            $comprobarDirec = $this->consultarUnDirectivo($directivo);
            if (($comprobarDirec == false) || (mysqli_num_rows($comprobarDirec) == 0)) {
                return false;
            }

            $sql = "UPDATE Profesor SET nombre='$nombre', apellidoP='$apellidoP', apellidoM='$apellidoM', genero='$genero', nivelEducativo='$nivelEducativo', especialidad='$especialidad', estudiantesAtendidos=$estudiantesAtendidos, Directivo_matricula='$directivo' WHERE matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }


        /************** Funciones de la tabla profesorAsignatura **************/
        /**
         * Consultar las asignaturas de un profesor específico.
         * 
         * @param string $matricula Matrícula del profesor.
         * @return string|int JSON con las asignaturas del profesor, -1 si ocurre un error, 0 si no tiene asignaturas.
         */
        function consultarAsignaturasProf($matricula) {
            $sql = "SELECT idAsignatura, asignatura.nombre 
                    FROM profesorasignatura, profesor, asignatura 
                    WHERE Profesor_matricula=matricula 
                    AND Asignatura_idAsignatura=idAsignatura 
                    AND matricula='$matricula' 
                    AND asignatura.existencia=1 
                    AND profesor.existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            if ($exec == false) {
                return -1;  // Error en la ejecución de la consulta
            }
            if (mysqli_num_rows($exec) < 1) {
                return 0;  // El profesor no tiene asignaturas asociadas
            }

            $Asignaturas = [];
            while ($fila = mysqli_fetch_assoc($exec)) {
                $Asignaturas[] = $fila;
            }

            return json_encode($Asignaturas);  // Devuelve las asignaturas en formato JSON
        }

        /**
         * Consultar todas las relaciones entre profesores y asignaturas activas.
         * 
         * @return mysqli_result Resultado de la consulta con todas las relaciones activas entre profesores y asignaturas.
         */
        function consultarProfesorAsignaturas() {
            $sql = "SELECT Profesor_matricula, Asignatura_idAsignatura 
                    FROM profesorasignatura, profesor, asignatura 
                    WHERE Profesor_matricula=matricula 
                    AND Asignatura_idAsignatura=idAsignatura 
                    AND asignatura.existencia=1 
                    AND profesor.existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /**
         * Agregar relaciones entre un profesor y un conjunto de asignaturas.
         * 
         * @param string $matricula Matrícula del profesor.
         * @param array $asignaturas Lista de identificadores de asignaturas a asociar.
         * @return bool Resultado de la última operación ejecutada.
         */
        function agregarProfAsig($matricula, $asignaturas) {
            foreach ($asignaturas as $asig) {
                $sqlSelect = "SELECT * FROM profesorasignatura 
                            WHERE Profesor_matricula='$matricula' 
                                AND Asignatura_idAsignatura=$asig;";
                $execSelect = mysqli_query($this->conn, $sqlSelect);

                if (mysqli_num_rows($execSelect) == 0) {
                    // Insertar nueva relación si no existe
                    $sql = "INSERT INTO profesorasignatura VALUES('$matricula', $asig, 1);";
                } else {
                    // Reactivar relación existente
                    $sql = "UPDATE profesorasignatura SET existencia=1 
                            WHERE Profesor_matricula='$matricula' 
                            AND Asignatura_idAsignatura=$asig;";
                }
                $exec = mysqli_query($this->conn, $sql);
            }

            return $exec;
        }

        /**
         * Desactivar todas las relaciones entre un profesor y sus asignaturas.
         * 
         * @param string $matricula Matrícula del profesor.
         * @return mysqli_result Resultado de la consulta para desactivar las relaciones.
         */
        function eliminarProfAsig($matricula) {
            $sql = "UPDATE profesorasignatura SET existencia=0 
                    WHERE Profesor_matricula='$matricula';";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        /**
         * Actualizar las asignaturas de un profesor.
         * 
         * @param string $matricula Matrícula del profesor.
         * @param array $asignaturas Lista de identificadores de asignaturas nuevas.
         * @return int Resultado de la operación: 1 si es exitosa, -1 si falla.
         */
        function actualizarProfAsig($matricula, $asignaturas) {
            $eliminarProfAsig = $this->eliminarProfAsig($matricula);
            if ($eliminarProfAsig == false) {
                return -1;  // Error al desactivar asignaturas previas
            }

            $agregacionProfAsig = $this->agregarProfAsig($matricula, $asignaturas);
            if ($agregacionProfAsig == false) {
                return -1;  // Error al agregar nuevas asignaturas
            }

            return 1;  // Operación exitosa
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

        function crearDirectivo($matricula, $contrasenia, $nombre, $apellidoP, $apellidoM, $genero, $departamento, $noProfesores){
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
        function consultarUnaAsignatura($nombre){
            $sql = "SELECT * FROM Asignatura WHERE nombre='$nombre' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            
            return $exec;
        } 

        function consultarTodasAsignaturas(){
            $sql = "SELECT * FROM asignatura WHERE existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        function crearAsignatura($nombre, $siglas, $descripcion) {
            $comprobarAsig = $this->consultarUnaAsignatura($nombre);
            if(($comprobarAsig == false) || (mysqli_num_rows($comprobarAsig) > 0)){
                return false;
            }
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
         /**
         * Busca citas relacionadas con una asignatura específica para el alumno actual.
         *
         * @param string $nomAsignatura El nombre de la asignatura.
         * @return mysqli_result|false  Resultado de la consulta o false en caso de error.
         */
        function buscarCitaPorAsignatura($nomAsignatura) {
            $alumnoMatricula = $_SESSION['matricula'];
            $sql = "SELECT c.* FROM Cita c, asignatura a 
                    WHERE ProfesorAsignatura_Asignatura_idAsignatura = idAsignatura 
                    AND Alumno_matricula = '$alumnoMatricula' 
                    AND a.nombre = '$nomAsignatura' 
                    AND c.existencia = 1 
                    AND a.existencia = 1;";
            $exec = mysqli_query($this->conn, $sql);
            
            return $exec;
        }

        /**
         * Busca citas asociadas con un profesor específico para el alumno actual.
         *
         * @param string $matricula La matrícula del profesor.
         * @return mysqli_result|false  Resultado de la consulta o false en caso de error.
         */
        function buscarCitaPorProfesor($matricula) {
            $alumnoMatricula = $_SESSION['matricula'];
            $sql = "SELECT * FROM Cita 
                    WHERE ProfesorAsignatura_Profesor_matricula = '$matricula' 
                    AND Alumno_matricula = '$alumnoMatricula' 
                    AND existencia = 1;";
            $exec = mysqli_query($this->conn, $sql);
            
            return $exec;
        }

        /**
         * Consulta todas las citas asociadas con el usuario actual (alumno o profesor).
         *
         * @return mysqli_result|false|null  Resultado de la consulta, null si no hay sesión, o false en caso de error.
         */
        function consultarTodasCitas() {
            if (!isset($_SESSION['matricula'])) {
                return null; 
            }
            $matricula = $_SESSION['matricula'];
            $sql = "SELECT * FROM Cita 
                    WHERE existencia = 1 
                    AND (Alumno_matricula = '$matricula' OR ProfesorAsignatura_Profesor_matricula = '$matricula');";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        /**
         * Crea una nueva cita con los datos proporcionados.
         *
         * @param string $tema                El tema de la cita.
         * @param string $detalles            Detalles de la cita.
         * @param string $fechaEnvio          Fecha en que se envió la solicitud.
         * @param string $estado              Estado inicial de la cita.
         * @param string $profesor_matricula  Matrícula del profesor.
         * @param int    $asignatura_idAsignatura ID de la asignatura.
         * @param string $alumno_matricula    Matrícula del alumno.
         * @return mysqli_result|false        Resultado de la consulta o false en caso de error.
         */
        function crearCita($tema, $detalles, $fechaEnvio, $estado, $profesor_matricula, $asignatura_idAsignatura, $alumno_matricula) {
            $sql = "INSERT INTO Cita (tema, detalles, fechaEnvio, estado, existencia, ProfesorAsignatura_profesor_matricula, ProfesorAsignatura_Asignatura_idAsignatura, Alumno_matricula) 
                    VALUES ('$tema', '$detalles', '$fechaEnvio', '$estado', 1, '$profesor_matricula', $asignatura_idAsignatura, '$alumno_matricula');";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        /**
         * Marca una cita como eliminada de manera lógica.
         *
         * @param int $idCita El ID de la cita.
         * @return mysqli_result|false Resultado de la consulta o false en caso de error.
         */
        function eliminarCita($idCita) {
            $sql = "UPDATE Cita SET existencia = 0 WHERE idCita = $idCita;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        /**
         * Actualiza los datos de una cita existente.
         *
         * @param int    $idCita             El ID de la cita.
         * @param string $tema               El tema de la cita.
         * @param string $detalles           Detalles de la cita.
         * @param string $fechaEnvio         Fecha en que se envió la cita.
         * @param string $fechaEstado        Fecha del último cambio de estado.
         * @param string $estado             Estado actual de la cita.
         * @param string $profesor_matricula Matrícula del profesor.
         * @param int    $asignatura_idAsignatura ID de la asignatura.
         * @param string $alumno_matricula   Matrícula del alumno.
         * @return mysqli_result|false       Resultado de la consulta o false en caso de error.
         */
        function actualizarCita($idCita, $tema, $detalles, $fechaEnvio, $fechaEstado, $estado, $profesor_matricula, $asignatura_idAsignatura, $alumno_matricula) {
            $sql = "UPDATE Cita SET tema = '$tema', detalles = '$detalles', fechaEnvio = '$fechaEnvio', fechaEstado = '$fechaEstado', estado = '$estado', 
                    ProfesorAsignatura_Profesor_matricula = '$profesor_matricula', ProfesorAsignatura_Asignatura_idAsignatura = $asignatura_idAsignatura, 
                    Alumno_matricula = '$alumno_matricula' 
                    WHERE idCita = $idCita AND existencia = 1;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        /**
         * Marca una cita recibida como eliminada de manera lógica.
         *
         * @param int $idCita El ID de la cita.
         * @return mysqli_result|false Resultado de la consulta o false en caso de error.
         */
        function eliminarCitaRecibida($idCita) {
            $sql = "UPDATE Cita SET existencia = 0 WHERE idCita = $idCita;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        /**
         * Actualiza una cita recibida con los datos proporcionados y la fecha actual.
         *
         * @param int    $idCita             El ID de la cita.
         * @param string $tema               El tema de la cita.
         * @param string $detalles           Detalles de la cita.
         * @param string $fechaEnvio         Fecha en que se envió la cita.
         * @param string $estado             Estado actual de la cita.
         * @param string $profesor_matricula Matrícula del profesor.
         * @param int    $asignatura_idAsignatura ID de la asignatura.
         * @param string $alumno_matricula   Matrícula del alumno.
         * @return mysqli_result|false       Resultado de la consulta o false en caso de error.
         */

        function actualizarCitaRecibida($idCita, $tema, $detalles, $fechaEnvio, $fechaEstado, $estado, $profesor_matricula, $asignatura_idAsignatura, $nota_idNota, $alumno_matricula) {
            date_default_timezone_set("America/Mexico_City");
            $fecha = date("Y-m-d");
            if($estado=="Pendiente"){
                $fecha = NULL;
            }

            $sql = "UPDATE Cita SET tema = '$tema', detalles = '$detalles', fechaEnvio = '$fechaEnvio', fechaEstado = '$fecha', estado = '$estado', 
                    ProfesorAsignatura_Profesor_matricula = '$profesor_matricula', ProfesorAsignatura_Asignatura_idAsignatura = $asignatura_idAsignatura, 
                    Alumno_matricula = '$alumno_matricula' 
                    WHERE idCita = $idCita AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        /************** Gestion Material compartido al alumno **************/
         /**
         * Consulta todos los materiales compartidos asociados a una cita específica.
         *
         * @param int $idCita El ID de la cita.
         * @return mysqli_result|false Resultado de la consulta o false en caso de error.
         */
        function consultarTodoMaterial($idCita) {
            $sql = "SELECT * FROM materialcompartido WHERE Cita_idCita = $idCita AND existencia = 1;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        /**
         * Crea un nuevo material compartido y lo asocia a una cita.
         *
         * @param string $titulo      Título del material.
         * @param array  $archivo     Datos del archivo subido ($_FILES).
         * @param string $comentario  Comentario asociado al material.
         * @param int    $tipoMaterial Tipo de material (ID).
         * @param int    $idCita      ID de la cita asociada.
         * @return mysqli_result|false Resultado de la consulta o false en caso de error.
         */
        function crearMaterialCompartido($titulo, $archivo, $comentario, $tipoMaterial, $idCita) {
            $tipoM = $this->consultarUnTipoMaterial($tipoMaterial);
            $categoriaMaterial = mysqli_fetch_assoc($tipoM);

            $destino = $this->procesarArchivo($archivo, $categoriaMaterial['categoria']);
            if($destino === false){
                return 0;
            }
            $sql = "INSERT INTO materialCompartido VALUES (0, '$titulo', '$destino', '$comentario', 1, '$tipoMaterial', '$idCita');";
            $exec = mysqli_query($this->conn, $sql);
            return 1;
        }

        /**
         * Actualiza la información de un material compartido.
         *
         * @param int    $id           ID del material compartido.
         * @param string $titulo       Título del material.
         * @param string $dirArchivo   Ruta actual del archivo.
         * @param array  $nuevoArchivo Nuevo archivo subido ($_FILES), si aplica.
         * @param string $comentario   Comentario asociado al material.
         * @param int    $tipoMaterial Tipo de material (ID).
         * @return mysqli_result|false Resultado de la consulta o false en caso de error.
         */
        function actualizarMaterialCompartido($id, $titulo, $dirArchivo, $nuevoArchivo, $comentario, $tipoMaterial) {
            $matricula = $_SESSION['matricula'];

            $tipoM = $this->consultarUnTipoMaterial($tipoMaterial);
            $resCM = mysqli_fetch_assoc($tipoM);
            $categoriaMaterial = $resCM['categoria'];

            $flag = false;
            if (isset($nuevoArchivo) && $nuevoArchivo != "") {
                // se subió un nuevo archivo
                $dirArchivoAnt = $dirArchivo;
                $dirArchivo = $this->procesarArchivo($nuevoArchivo, $categoriaMaterial);
                if($dirArchivo === false){
                    return false;
                }
                $flag = true;
            }

            $ext = pathinfo($dirArchivo, PATHINFO_EXTENSION);

            $sql = "SELECT * FROM tipomaterial WHERE categoria='$categoriaMaterial' AND Profesor_matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            while($row = mysqli_fetch_assoc($exec)){
                if($row['extension'] === $ext){                
                    $sql = "UPDATE MaterialCompartido SET titulo = '$titulo', archivo = '$dirArchivo', comentario = '$comentario', 
                    TipoMaterial_idmaterial = $tipoMaterial WHERE idmaterialCompartido = '$id' AND existencia = 1;";
                    $exec = mysqli_query($this->conn, $sql);

                    if ($exec == false && $flag) {
                        unlink($dirArchivo);  // Elimina el archivo nuevo si la actualización falla.
                        return $exec;
                    }

                    if (isset($dirArchivoAnt)) {
                        unlink($dirArchivoAnt);  // Elimina el archivo antiguo si se subió uno nuevo.
                    }

                    return $exec;
                }
            }

            return false;

        }

        /**
         * Procesa un archivo subido y lo guarda en el servidor.
         *
         * @param array $archivo Datos del archivo subido ($_FILES).
         * @return string|false Ruta destino donde se guardó el archivo o false en caso de que no coincidiera el tipo de material con la categoría o exeda el tamaño permitido.
         */
        function procesarArchivo($archivo, $categoriaMaterial) {
            $matricula = $_SESSION['matricula'];

            $rutaTemp = $archivo['tmp_name'];
            $nombre = $archivo['name'];
            $tipoArc = $archivo['type'];
            $nuevoNombre = time() . '_' . $nombre;
            $destino = "Model/ArchivosEnviados/" . $nuevoNombre;

            $ext = pathinfo($nombre, PATHINFO_EXTENSION);

            $sql = "SELECT * FROM tipomaterial WHERE categoria='$categoriaMaterial' AND Profesor_matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            while($row = mysqli_fetch_assoc($exec)){
                if(strcasecmp($row['extension'], $ext) == 0){
                    move_uploaded_file($rutaTemp, $destino);
                    return $destino;
                }
            }
            return false;
            
        }

        /**
         * Marca un material compartido como eliminado de manera lógica.
         *
         * @param int    $idMC        ID del material compartido.
         * @param string $direccionArc Ruta del archivo asociado.
         * @return mysqli_result|false Resultado de la consulta o false en caso de error.
         */
        function eliminarMaterialCompartido($idMC, $direccionArc) {
            $sql = "DELETE FROM materialcompartido WHERE idmaterialCompartido = '$idMC';";
            $exec = mysqli_query($this->conn, $sql);

            unlink($direccionArc);

            return $exec;
        }

        /**
         * Permite descargar un archivo desde el servidor.
         *
         * @param string $url Ruta del archivo a descargar.
         * @return int 1 si la descarga fue exitosa, 0 si el archivo no existe.
         */
        function descargarArchivo($url) {
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
                return 0;  // Archivo no encontrado.
            }
        }

         /************** Gestion Disponibilidades **************/
        function consultarTodasDisponibilidades(){
            $matricula = $_SESSION['matricula'];
            $sql = "SELECT idDisponibilidad, periodo, Lunes, martes, miercoles, jueves, viernes FROM profesor, Disponibilidad WHERE Disponibilidad_idDisponibilidad=idDisponibilidad AND matricula='$matricula' AND Disponibilidad.existencia=1 AND profesor.existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

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

        function consultarUnTipoMaterial($idMaterial){
            $matricula=$_SESSION['matricula'];
            $sql = "SELECT * FROM tipomaterial WHERE Profesor_matricula='$matricula' AND idmaterial=$idMaterial AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);
            return $exec;
        }

        function consultarTodoTipoMaterialPorCat($matricula = NULL) {
            if(!isset($matricula)){
                $matricula = $_SESSION['matricula'];
            }
            $sql = "SELECT * FROM tipomaterial WHERE Profesor_matricula='$matricula' AND existencia=1 GROUP BY categoria;";
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
            $sql = "UPDATE tipomaterial SET existencia=0 WHERE idmaterial='$idmaterial';";
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
            $consultaNota = $this->consultarUnaNota($idCita);
            if($consultaNota == 0){
                $sql = "INSERT INTO Nota (titulo, cuerpo, fechaCreacion, horaInicio, horaFin, calificacionP1, calificacionP2, existencia) 
                        VALUES ('$titulo', '$cuerpo', '$fechaCreacion', '$horaInicio', '$horaFin', $calificacionP1, $calificacionP2, 1);";
                $exec = mysqli_query($this->conn, $sql);

                $sql = "UPDATE Cita SET Nota_idNota=(SELECT idNota FROM Nota ORDER BY idNota DESC LIMIT 1) WHERE idCita=$idCita AND existencia=1;";
                $exec = mysqli_query($this->conn, $sql);
                return 1;
            }

            return 0;
        }

        function actualizarNota($idNota, $titulo, $cuerpo, $fechaCreacion, $horaInicio, $horaFin, $calificacionP1, $calificacionP2) {
            $sql = "UPDATE Nota SET titulo='$titulo', cuerpo='$cuerpo', fechaCreacion='$fechaCreacion', horaInicio='$horaInicio', horaFin='$horaFin', calificacionP1='$calificacionP1', calificacionP2='$calificacionP2' WHERE idNota=$idNota";

            $exec = mysqli_query($this->conn, $sql);

            return 2;
        }

        function eliminarNota($idNota, $idCita){
            $matricula = $_SESSION['matricula'];
            $sql = "UPDATE cita SET Nota_idNota=NULL WHERE idCita=$idCita;";
            $exec = mysqli_query($this->conn, $sql);

            $sql = "DELETE FROM Nota WHERE idNota=$idNota;";
            $exec = mysqli_query($this->conn, $sql);

            return 3;
            
        }

        /*************** Reportes ***************/
         /**
         * Genera un reporte en formato PDF que muestra el número de asesorías atendidas por profesores
         * durante un cuatrimestre específico de un año determinado.
         *
         * @param string $periodo  El periodo cuatrimestral del año ('invierno', 'primavera', 'otoño').
         *                         - 'invierno': de enero a abril.
         *                         - 'primavera': de mayo a agosto.
         *                         - 'otoño': de septiembre a diciembre.
         * @param int    $ano      El año para el cual se generará el reporte.
         *
         * @return void            Genera un archivo PDF descargable con el reporte.
         */
        function reporteAsesAtenProfCuatrimestre($periodo, $ano) {
        // Determinar el rango de meses según el periodo cuatrimestral.
        if ($periodo == "invierno") {
            $query = "SELECT p.matricula, p.nombre, apellidoP, apellidoM, COUNT(p.matricula) AS 'noAsesorias' 
                        FROM Cita c, profesor p 
                        WHERE ProfesorAsignatura_Profesor_matricula = matricula 
                        AND estado = 'Aceptada' 
                        AND (MONTH(fechaEstado) BETWEEN 1 AND 4) 
                        AND YEAR(fechaEstado) = $ano 
                        GROUP BY p.matricula;";
        } else if ($periodo == "primavera") {
            $query = "SELECT p.matricula, p.nombre, apellidoP, apellidoM, COUNT(p.matricula) AS 'noAsesorias' 
                        FROM Cita c, profesor p 
                        WHERE ProfesorAsignatura_Profesor_matricula = matricula 
                        AND estado = 'Aceptada' 
                        AND (MONTH(fechaEstado) BETWEEN 5 AND 8) 
                        AND YEAR(fechaEstado) = $ano 
                        GROUP BY p.matricula;";
        } else { // 'otoño'
            $query = "SELECT p.matricula, p.nombre, apellidoP, apellidoM, COUNT(p.matricula) AS 'noAsesorias' 
                        FROM Cita c, profesor p 
                        WHERE ProfesorAsignatura_Profesor_matricula = matricula 
                        AND estado = 'Aceptada' 
                        AND (MONTH(fechaEstado) BETWEEN 9 AND 12) 
                        AND YEAR(fechaEstado) = $ano 
                        GROUP BY p.matricula;";
        }

        // Ejecutar la consulta.
        $resultado = mysqli_query($this->conn, $query);

        // Configuración del PDF.
        $pdf = new PDF('P', 'mm', 'letter');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFillColor(232, 232, 232);
        $pdf->SetFont('Arial', 'B', 12);

        // Encabezado del reporte.
        $pdf->Cell(200, 10, 'Numero de asesorías atendidas por profesores en el periodo ' . $periodo, 1, 1, 'C', true);
        $pdf->Cell(30, 10, 'Matricula', 1, 0, 'C', true);
        $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Apellido Paterno', 1, 0, 'C', true);
        $pdf->Cell(50, 10, 'Apellido Materno', 1, 0, 'C', true);
        $pdf->Cell(30, 10, 'No. Asesorias', 1, 1, 'C', true);

        // Datos del reporte.
        $pdf->SetFont('Arial', '', 12);
        while ($row = mysqli_fetch_array($resultado)) {
            $pdf->Cell(30, 8, $row['matricula'], 1, 0, 'C');
            $pdf->Cell(40, 8, $row['nombre'], 1, 0, 'C');
            $pdf->Cell(50, 8, $row['apellidoP'], 1, 0, 'C');
            $pdf->Cell(50, 8, $row['apellidoM'], 1, 0, 'C');
            $pdf->Cell(30, 8, $row['noAsesorias'], 1, 1, 'C');
        }

        // Generar el archivo PDF y enviarlo como descarga.
        $pdf->Output('D', 'reporteAsesAtenProfCuatrimestre.pdf');
        }

        function reporteSoliAsesAlumMes($mes, $ano){
            $query = "SELECT a.matricula, nombre, apellidoP, apellidoM, COUNT(a.matricula) AS 'noAsesorias' 
                      FROM Cita c, Alumno a 
                      WHERE Alumno_matricula=a.matricula 
                      AND MONTH(fechaEnvio)=$mes 
                      AND YEAR(fechaEnvio)=$ano 
                      GROUP BY a.matricula;"; 
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
            if($periodo == "Enero-Abril"){
                $query = "SELECT MONTHNAME(fechaEstado) AS 'mes', COUNT(MONTHNAME(fechaEstado)) as 'noAsesorias' 
                          FROM Cita 
                          WHERE (MONTH(fechaEstado) BETWEEN 1 and 4) 
                          AND YEAR(fechaEstado)=$ano 
                          AND ProfesorAsignatura_Profesor_matricula='$matricula'
                          AND estado='Aceptada'
                          GROUP BY MONTHNAME(fechaEstado);"; 
                $resultado= mysqli_query($this->conn,$query);
            }else if($periodo == "Mayo-Agosto"){
                $query = "SELECT MONTHNAME(fechaEstado) AS 'mes', COUNT(MONTHNAME(fechaEstado)) as 'noAsesorias' 
                          FROM Cita 
                          WHERE (MONTH(fechaEstado) BETWEEN 5 and 8) 
                          AND YEAR(fechaEstado)=$ano 
                          AND ProfesorAsignatura_Profesor_matricula='$matricula' 
                          AND estado='Aceptada'
                          GROUP BY MONTHNAME(fechaEstado);"; 
                $resultado= mysqli_query($this->conn,$query);
            }else{
                $query = "SELECT MONTHNAME(fechaEstado) AS 'mes', COUNT(MONTHNAME(fechaEstado)) as 'noAsesorias' 
                          FROM Cita 
                          WHERE (MONTH(fechaEstado) BETWEEN 9 and 12) 
                          AND YEAR(fechaEstado)=$ano 
                          AND ProfesorAsignatura_Profesor_matricula='$matricula' 
                          AND estado='Aceptada'
                          GROUP BY MONTHNAME(fechaEstado);"; 
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
                $query = "SELECT a.idAsignatura, a.nombre, a.siglas, a.descripcion, COUNT(c.ProfesorAsignatura_Asignatura_idAsignatura) AS 'noAsesorias' 
                          FROM Cita c, asignatura a 
                          WHERE c.estado = 'Aceptada' 
                          AND MONTH(c.fechaEstado) BETWEEN 9 AND 12
                          AND YEAR(c.fechaEstado) = $ano
                          AND c.ProfesorAsignatura_Profesor_matricula = '$matricula'
                          AND c.ProfesorAsignatura_Asignatura_idAsignatura = a.idAsignatura
                          GROUP BY a.idAsignatura, a.nombre, a.siglas, a.descripcion;";
            } else if ($periodo == "Enero-Abril") {
                $query = "SELECT a.idAsignatura, a.nombre, a.siglas, a.descripcion, COUNT(c.ProfesorAsignatura_Asignatura_idAsignatura) AS 'noAsesorias' 
                          FROM Cita c, asignatura a 
                          WHERE c.estado = 'Aceptada' 
                          AND MONTH(c.fechaEstado) BETWEEN 1 AND 4 
                          AND YEAR(c.fechaEstado) = $ano 
                          AND c.ProfesorAsignatura_Profesor_matricula = '$matricula' 
                          AND c.ProfesorAsignatura_Asignatura_idAsignatura = a.idAsignatura 
                          GROUP BY a.idAsignatura, a.nombre, a.siglas, a.descripcion;";
            } else {
                $query = "SELECT a.idAsignatura, a.nombre, a.siglas, a.descripcion, COUNT(c.ProfesorAsignatura_Asignatura_idAsignatura) AS 'noAsesorias' 
                          FROM Cita c, asignatura a 
                          WHERE c.estado = 'Aceptada' 
                          AND MONTH(c.fechaEstado) BETWEEN 5 AND 8 
                          AND YEAR(c.fechaEstado) = $ano 
                          AND c.ProfesorAsignatura_Profesor_matricula = '$matricula' 
                          AND c.ProfesorAsignatura_Asignatura_idAsignatura = a.idAsignatura 
                          GROUP BY a.idAsignatura, a.nombre, a.siglas, a.descripcion;";
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
        
        public function reporteCCPC($periodo, $ano) {
            $matricula = $_SESSION['matricula'];
            if ($periodo == "Septiembre-Diciembre") {
                $mesInicio = 9;
                $mesFin = 12;
            } elseif ($periodo == "Enero-Abril") {
                $mesInicio = 1;
                $mesFin = 4;
            } else { // Mayo-Agosto
                $mesInicio = 5;
                $mesFin = 8;
            }
            $query = "SELECT 
                          p.matricula AS profesorMatricula,
                          p.nombre AS profesorNombre,
                          p.apellidoP AS profesorApellidoP,
                          p.apellidoM AS profesorApellidoM,
                          COUNT(c.Alumno_matricula) AS noAsesorias
                      FROM 
                          Cita c
                      INNER JOIN 
                          profesor p ON c.ProfesorAsignatura_Profesor_matricula = p.matricula
                      WHERE 
                          MONTH(c.fechaEnvio) BETWEEN $mesInicio AND $mesFin
                          AND YEAR(c.fechaEnvio) = $ano
                          AND c.Alumno_matricula = '$matricula'
                      GROUP BY 
                          p.matricula, p.nombre, p.apellidoP, p.apellidoM";
        
            $resultado = mysqli_query($this->conn, $query);
            if (!$resultado) {
                die("Error en la consulta SQL: " . mysqli_error($this->conn));
            }
            $pdf = new PDF('P', 'mm', 'letter');
            $pdf->AliasNbPages();
            $pdf->AddPage();
            $pdf->SetFillColor(232, 232, 232);
            $pdf->SetFont('Arial', 'B', 12);
        
            $pdf->Cell(200, 10, 'Numero de asesorias enviadas a los profesores en el periodo ' . $periodo, 1, 1, 'C', true);
       
            $pdf->Cell(30, 10, 'Matricula', 1, 0, 'C', true);
            $pdf->Cell(40, 10, 'Nombre', 1, 0, 'C', true);
            $pdf->Cell(50, 10, 'Apellido Paterno', 1, 0, 'C', true);
            $pdf->Cell(50, 10, 'Apellido Materno', 1, 0, 'C', true);
            $pdf->Cell(30, 10, 'No. Asesorias', 1, 1, 'C', true);
        
            $pdf->SetFont('Arial', '', 12);
            while ($row = mysqli_fetch_array($resultado)) {
                $pdf->Cell(30, 8, $row['profesorMatricula'], 1, 0, 'C');
                $pdf->Cell(40, 8, $row['profesorNombre'], 1, 0, 'C');
                $pdf->Cell(50, 8, $row['profesorApellidoP'], 1, 0, 'C');
                $pdf->Cell(50, 8, $row['profesorApellidoM'], 1, 0, 'C');
                $pdf->Cell(30, 8, $row['noAsesorias'], 1, 1, 'C');
            }
            $pdf->Output('D', 'reporteCCPC.pdf');
        }

        /*************** Formato ***************/
        function consultarUnFormato(){
            $matricula = $_SESSION['matricula'];
            $sql = "SELECT * FROM Formato WHERE Profesor_matricula='$matricula' AND existencia=1;";
            $exec = mysqli_query($this->conn, $sql);

            return $exec;
        }

        function crearFormato(){
            
        }
    }

    
    