<div class="modal fade" id="modalCrearMaterialCompartido" tabindex="-1" aria-labelledby="modalCrearMaterialCompartidoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header modal-encabezado">
            <h1 class="modal-title fs-5" id="modalCrearMaterialCompartidoLabel">Registro de un material a compartir</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body modal-cuerpo">
            <form name="frm-crearMaterialCompartido" id="frm-crearMaterialCompartido" action="" method="POST" enctype="multipart/form-data" >
                <br>
                <div>
                    <label for="idCita">
                        ID de la cita: <br>
                        <input type="text" name="idCita" id="idCita" value="<?=$idCita?>" readonly>
                    </label>
                </div>
                <br>
                <div>
                    <label for="titulo">
                        Titulo: <br>
                        <input type="text" name="titulo" id="titulo" placeholder="" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="archivo">
                        Archivo: <br>
                        <input type="file" name="archivo" id="archivo" value="Agregar" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="comentario">
                        Comentario: <br>
                        <input type="text" name="comentario" id="comentario" placeholder="" class="datos" required>
                    </label>
                </div>                
                <br>
                <div>
                    <label for="tipoMaterial">
                        Tipo de material: <br>
                        <input type="text" name="tipoMaterial" id="tipoMaterial" placeholder="" class="datos" required>
                    </label>
                </div>

            </form>

        </div>
        <div class="modal-footer modal-pie">
            <button type="submit" class="boton-secundario" form="frm-crearMaterialCompartido" name="opc" value="crearMaterialCompartido">Registrar</button>
        </div>
        </div>
    </div>
</div>