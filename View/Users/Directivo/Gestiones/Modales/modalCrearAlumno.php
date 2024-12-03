<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header modal-encabezado">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de un alumno</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body modal-cuerpo">
            <form name="frm-crear" id="frm-crear" action="" method="POST">
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
                    <label for="carrera">
                        Carrera: <br>
                        <input type="text" name="carrera" id="carrera" placeholder="ITI" required>
                    </label>
                </div>
                <div>
                    <label for="grado">
                        Grado: <br>
                        <input type="text" name="grado" id="grado" placeholder="1" required>
                    </label>
                </div>
                <div>
                    <label for="grupo">
                        Grado: <br>
                        <input type="text" name="grupo" id="grupo" placeholder="A" required>
                    </label>
                </div>

            </form>

        </div>
        <div class="modal-footer modal-pie">
            <button type="submit" class="boton-secundario" form="frm-crear" name="opc" value="crearAlumno">Registrar</button>
        </div>
        </div>
    </div>
</div>