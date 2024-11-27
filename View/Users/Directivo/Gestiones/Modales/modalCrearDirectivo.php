<div class="modal fade" id="modalCrearDirectivo" tabindex="-1" aria-labelledby="modalCrearDirectivoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header modal-encabezado">
            <h1 class="modal-title fs-5" id="modalCrearDirectivoLabel">Registro de un directivo</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body modal-cuerpo">
            <form name="frm-crearDirectivo" id="frm-crearDirectivo" action="" method="POST">
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
                    <label for="departamento">
                        Departamento: <br>
                        <input type="text" name="departamento" id="departamento" placeholder="" required>
                    </label>
                </div>
                <div>
                    <label for="noProfesores">
                        Numero de profesores: <br>
                        <input type="text" name="noProfesores" id="noProfesores" placeholder="" required>
                    </label>
                </div>
                <div>
                    <label for="oficina">
                        Oficina: <br>
                        <input type="text" name="oficina" id="oficina" placeholder="" required>
                    </label>
                </div>

            </form>

        </div>
        <div class="modal-footer modal-pie">
            <button type="submit" class="boton-secundario" form="frm-crearDirectivo" name="opc" value="crearDirectivo">Registrar</button>
        </div>
        </div>
    </div>
</div>