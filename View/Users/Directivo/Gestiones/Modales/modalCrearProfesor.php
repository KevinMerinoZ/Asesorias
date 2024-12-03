<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header modal-encabezado">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de un alumno</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body modal-cuerpo">
            <form name="frm-crearProfAsig" id="frm-crearProfAsig" action="" method="POST">
                <br>
                <div>
                    <label for="matricula">
                        Matricula: <br>
                        <input type="text" name="matricula" id="matricula" placeholder="Matricula" required>
                    </label>
                </div>
                <div>
                    <label for="contrasenia">
                        Contraseña: <br>
                        <input type="text" name="contrasenia" id="contrasenia" placeholder="Contraseña" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="nombre">
                        Nombre: <br>
                        <input type="text" name="nombre" id="nombre" placeholder="Nombre" class="datos" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="apellidoP">
                        Apellido Paterno: <br>
                        <input type="text" name="apellidoP" id="apellidoP" placeholder="Apellido Paterno" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="apellidoM">
                        Apellido Materno: <br>
                        <input type="text" name="apellidoM" id="apellidoM" placeholder="Apellido Materno" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="genero">
                        Genero: <br>
                        <select name="genero" id="genero" required>
                            <option value="Femenino">Femenino</option>
                            <option value="Masculino">Masculino</option>
                        </select>
                    </label>
                </div>
                <br>
                <div>
                    <label for="asignatura">
                        Asignatura: <br>
                        <div class="d-flex justify-content-center">
                        <select id="slcCrearProfAsig">
                            <option value="">Seleccione una asignatura</option>
                            <?php 
                                if($asignaturas != false){
                                while ($row=mysqli_fetch_array($asignaturas)){ 
                            ?>
                                <option value="<?= $row['idAsignatura'] ?>"><?= $row['nombre'] ?></option>
                            <?php 
                                    }
                                }
                            ?>
                        </select>
                        <button type="button" id="agregarAsig" class="boton-secundario" onclick="agregarAsignatura('tblCrearProfAsig', 'slcCrearProfAsig', 'frm-crearProfAsig')">Agregar</button>
                        </div>
                        <br>
                        <table id="tblCrearProfAsig" class="tabla">
                            <thead>
                                <tr>
                                    <th>Asignaturas</th>
                                    <th>Eliminar</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </label>
                </div>
                <br>
                <div>
                    <label for="nivelEducativo">
                        Nivel Educativo: <br>
                        <select name="nivelEducativo" id="nivelEducativo" required>
                            <option value="">Seleccione nivel educativo</option>
                            <option value="Tecnico Superior Universitario">Técnico Superior Universitario</option>
                            <option value="Licenciatura">Licenciatura</option>
                            <option value="Especialidad">Especialidad</option>
                            <option value="Maestria">Maestría</option>
                            <option value="Doctorado">Doctorado</option>
                        </select>
                    </label>
                </div>
                <div>
                    <label for="especialidad">
                        Especialidad: <br>
                        <input type="text" name="especialidad" id="especialidad" placeholder="" required>
                    </label>
                </div>
                <div>
                    <label for="estudiantesAtendidos">
                        Estudiantes Atendidos: <br>
                        <input type="text" name="estudiantesAtendidos" id="estudiantesAtendidos" placeholder="" required>
                    </label>
                </div>
                <div>
                    <label for="directivo">
                        Directivo: <br>
                        <input type="text" name="directivo" id="directivo" placeholder="A" required>
                    </label>
                </div>

            </form>

        </div>
        <div class="modal-footer modal-pie">
            <button type="submit" class="boton-secundario" form="frm-crearProfAsig" name="opc" value="crearProfesor" onclick="tablaProfAsigVacia('tblCrearProfAsig', event)">Registrar</button>
        </div>
        </div>
    </div>
</div>

