<div class="modal fade" id="modalVerNota-<?= $rows['Nota_idNota'] ?>"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header modal-encabezado">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Nota</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body modal-cuerpo">
        <form name="Hola" method="POST" action="index.php" ><p>hola</p> </form>  
            <form name="frm-modalVerNota-<?= $rows['Nota_idNota'] ?>" id="frm-modalVerNota-<?= $rows['Nota_idNota'] ?>" action="" method="POST">
                <input type="hidden" name="idCita" value="<?= $rows['idCita'] ?>">
                <input type="hidden" name="idNota" value="<?= $rows['Nota_idNota'] ?>">
                <div>
                    <label for="titulo">
                        Titulo: <br>
                        <input type="text" form="frm-modalVerNota-<?= $rows['Nota_idNota'] ?>" name="titulo" id="titulo" placeholder="Titulo" readonly>
                    </label>
                </div>
                <br>
                <div>
                    <label for="cuerpo">
                        Cuerpo: <br>
                        <input type="text" form="frm-modalVerNota-<?= $rows['Nota_idNota'] ?>" name="cuerpo" id="cuerpo" placeholder="Cuerpo" readonly>
                    </label>
                </div>
                <br>
                <div>
                    <label for="fechaCreacion">
                        Fecha de Creación: <br>
                        <input type="text" form="frm-modalVerNota-<?= $rows['Nota_idNota'] ?>" name="fechaCreacion" id="fechaCreacion-modalGestionNotas-<?= $rows['idCita'] ?>" placeholder="Fecha de Creación" readonly>
                    </label>
                </div>
                <br>
                <div>
                    <label for="horaInicio">
                        Hora de inicio: <br>
                        <input type="text" form="frm-modalVerNota-<?= $rows['Nota_idNota'] ?>" name="horaInicio" id="horaInicio" placeholder="Hora de Inicio" readonly>
                    </label>
                </div>
                <br>
                <div>
                    <label for="horaFin">
                        Hora de finalización: <br>
                        <input type="text" form="frm-modalVerNota-<?= $rows['Nota_idNota'] ?>" name="horaFin" id="horaFin" placeholder="Hora de finzalizacion" readonly>
                    </label>
                </div>
                <br>
                <div>
                    <label for="calificacionP1">
                        Calificación del Parcial 1: <br>
                        <input type="text" form="frm-modalVerNota-<?= $rows['Nota_idNota'] ?>" name="calificacionP1" id="calificacionP1" placeholder="calificacionP1" readonly>
                    </label>
                </div>
                <br>
                <div>
                    <label for="calificacionP2">
                        Calificación del Parcial 2: <br>
                        <input type="text" form="frm-modalVerNota-<?= $rows['Nota_idNota'] ?>" name="calificacionP2" id="calificacionP2" placeholder="calificacionP2" readonly>
                    </label>
                </div>
            </form>
    </div>
</div>