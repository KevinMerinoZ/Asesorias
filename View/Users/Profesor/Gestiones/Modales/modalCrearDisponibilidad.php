<div class="modal fade" id="modalCrearDisponibilidad" tabindex="-1" aria-labelledby="modalCrearDisponibilidadLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header modal-encabezado">
            <h1 class="modal-title fs-5" id="modalCrearDisponibilidadLabel">Registro de una disponibilidad</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body modal-cuerpo">
            <form name="frm-crearDisponibilidad" id="frm-crearDisponibilidad" action="" method="POST">
                <br>
                <div>
                    <label for="periodo">
                        Periodo: <br>
                        <input type="text" name="periodo" id="periodo" placeholder="" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="Lunes">
                        Lunes: <br>
                        <input type="text" name="Lunes" id="Lunes" placeholder="10:00-15:00" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="martes">
                        Martes: <br>
                        <input type="text" name="martes" id="martes" placeholder="10:00-15:00" class="datos" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="miercoles">
                        Miercoles: <br>
                        <input type="text" name="miercoles" id="miercoles" placeholder="10:00-15:00" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="jueves">
                        Jueves: <br>
                        <input type="text" name="jueves" id="jueves" placeholder="10:00-15:00" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="viernes">
                        Viernes: <br>
                        <input type="text" name="viernes" id="viernes" placeholder="10:00-15:00" required>
                    </label>
                </div>

            </form>

        </div>
        <div class="modal-footer modal-pie">
            <button type="submit" class="boton-secundario" form="frm-crearDisponibilidad" name="opc" value="crearDisponibilidad" onclick="return crearDisponibilidad_validarHora('frm-crearDisponibilidad')">Registrar</button>
        </div>
        </div>
    </div>
</div>