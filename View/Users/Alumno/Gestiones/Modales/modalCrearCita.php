<div class="modal fade" id="modalCrearCita" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-encabezado">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registro de una Cita</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-cuerpo">
                <form name="frm-crear-cita" id="frm-crear-cita" action="" method="POST">
                    <div>
                        <label for="tema">
                            Tema: <br>
                            <input type="text" name="tema" id="tema" placeholder="Tema" required>
                        </label>
                    </div>
                    <br>
                    <div>
                        <label for="detalles">
                            Detalles: <br>
                            <textarea name="detalles" id="detalles" placeholder="Detalles de la cita" required></textarea>
                        </label>
                    </div>
                    <br>
                    <div>
                        <label for="profesor_matricula">
                            Profesor: <br>
                            <div>
                                <select name="profesor_matricula" id="profesor_matricula">
                                    <option value="">Seleccione un profesor</option>
                                    <?php 
                                    if($profesores != false){
                                    while ($row=mysqli_fetch_array($profesores)){ ?>
                                        <option value="<?= $row['matricula'] ?>"><?= $row['nombre'] ?></option>
                                    <?php }
                                    }else {  ?>
                                        <option value="">No se encontró el profesor</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <button type="button" onclick="seleccionarProfCrearCita(this)">Seleccionar</button>
                            </div>
                            <input type="hidden" name="profesor_matricula" value="">
                            <input type="text" value="" readonly required>

                        </label>
                    </div>
                    <br>
                    <div>
                        <label for="asignatura_idAsignatura">
                            Asignatura: <br>
                            <select name="asignatura_idAsignatura" id="crearCita-asignatura" required>
                                

                            </select>
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer modal-pie">
                <button type="submit" class="boton-secundario" form="frm-crear-cita" name="opc" value="crearCita">Registrar</button>
            </div>
        </div>
    </div>
</div>
