<div class="modal fade" id="modalCrearAsignatura" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-encabezado">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de Asignatura</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-cuerpo">
                <form name="frm-crear-asignatura" id="frm-crear-asignatura" action="" method="POST">
                    <br>
                    <div>
                        <label for="nombre">
                            Nombre: <br>
                            <input type="text" name="nombre" id="nombre" placeholder="Nombre de la Asignatura">
                        </label>
                    </div>
                    <br>
                    <div>
                        <label for="siglas">
                            Siglas: <br>
                            <input type="text" name="siglas" id="siglas" placeholder="Siglas de la Asignatura">
                        </label>
                    </div>
                    <br>
                    <div>
                        <label for="descripcion">
                            Descripción: <br>
                            <textarea name="descripcion" id="descripcion" placeholder="Descripción de la Asignatura"></textarea>
                        </label>
                    </div>
                   
                </form>
            </div>
            <div class="modal-footer modal-pie">
                <button type="submit" class="boton-secundario" form="frm-crear-asignatura" name="opc" value="crearAsignatura">Registrar</button>
            </div>
        </div>
    </div>
</div>
