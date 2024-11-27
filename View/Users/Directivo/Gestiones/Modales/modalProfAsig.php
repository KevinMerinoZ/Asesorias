
<div class="modal fade" id="modalProfAsig-<?= $rows['matricula'] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalProfAsig-<?= $rows['matricula'] ?>Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header modal-encabezado">
                <h1 class="modal-title fs-5" id="modalProfAsig-<?= $rows['matricula'] ?>Label">Asignaturas del profesor</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body modal-cuerpo">

                <label id="profAsigMatricula-<?= $rows['matricula'] ?>"><?= $rows['matricula'] ?></label>
                
                    <br>
                    <div>
                    
                        <label for="asignatura">
                            Asignatura: <br>
                            <div class="d-flex justify-content-center">
                            <select id="slcActualizarProfAsig-<?= $rows['matricula'] ?>">
                                <option value="">Seleccione una asignatura</option>
                                <?php 
                                    mysqli_data_seek($asignaturas, 0);
                                    if($asignaturas != false){
                                        while ($row=mysqli_fetch_array($asignaturas)){ 
                                ?>
                                    <option value="<?= $row['idAsignatura'] ?>"><?= $row['nombre'] ?></option>
                                <?php 
                                        }
                                    }
                                ?>
                            </select>

                            <button type="button" class="boton-secundario" onclick="agregarAsignatura('tblActualizarProfAsig-<?= $rows['matricula'] ?>', 'slcActualizarProfAsig-<?= $rows['matricula'] ?>')">Agregar</button>
                            </div>
                            <br>
                            <table id="tblActualizarProfAsig-<?= $rows['matricula'] ?>" class="table tabla">
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
            </div>
            
            <div class="modal-footer modal-pie">
                <button type="button" class="boton-secundario" name="opc" value="crearProfesor" onclick="actualizarProfAsig('profAsigMatricula-<?= $rows['matricula'] ?>', 'tblActualizarProfAsig-<?= $rows['matricula'] ?>', event)">Actualizar</button>
            </div>
        </div>
    </div>
</div>

