<div class="modal fade" id="modalTipoMaterial" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header modal-encabezado">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Registro del tipo de material</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body modal-cuerpo">
            <form name="frm-crear" id="frm-crear" action="" method="POST">
                <br>
                <div>
                    <label for="extension">
                        Extensión: <br>
                        <input type="text" name="extension" id="extension" placeholder="Extension" required>
                    </label>
                </div>
                <div>
                    <label for="descripcion">
                        Descripción: <br>
                        <input type="text" name="descripcion" id="descripcion" placeholder="Descripcion" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="categoria">
                        Categoría: <br>
                        <input type="text" name="categoria" id="categoria" placeholder="categoria" required>
                    </label>
                </div>
            </form>

        </div>
        <div class="modal-footer modal-pie">
            <button type="submit" class="boton-secundario" form="frm-crear" name="opc" value="crearTipoMaterial">Registrar</button>
        </div>
        </div>
    </div>
</div>