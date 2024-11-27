<div class="modal fade" id="modalGestionNotas-<?= $rows['idCita'] ?>"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header modal-encabezado">
            <h1 class="modal-title fs-5" id="exampleModalLabel">Gestión de Nota</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body modal-cuerpo">
            <form name="Hola" method="POST" action="index.php" ><p>hola</p> </form>  
            <form name="frm-crear-nota<?= $rows['idCita'] ?>" id="frm-crear-nota<?= $rows['idCita'] ?>" action="" method="POST">
                <input type="hidden" name="idCita" value="<?= $rows['idCita'] ?>">
                <input type="hidden" name="idNota" value="<?= $rows['Nota_idNota'] ?>">
                <div>
                    <label for="titulo">
                        Titulo: <br>
                        <input type="text" form="frm-crear-nota<?= $rows['idCita'] ?>" name="titulo" id="titulo" placeholder="Titulo" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="cuerpo">
                        Cuerpo: <br>
                        <input type="text" form="frm-crear-nota<?= $rows['idCita'] ?>" name="cuerpo" id="cuerpo" placeholder="Cuerpo" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="fechaCreacion">
                        Fecha de Creación: <br>
                        <input type="text" form="frm-crear-nota<?= $rows['idCita'] ?>" name="fechaCreacion" id="fechaCreacion-modalGestionNotas-<?= $rows['idCita'] ?>" placeholder="Fecha de Creación" readonly required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="horaInicio">
                        Hora de inicio: <br>
                        <input type="text" form="frm-crear-nota<?= $rows['idCita'] ?>" name="horaInicio" id="horaInicio" placeholder="Hora de Inicio" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="horaFin">
                        Hora de finalización: <br>
                        <input type="text" form="frm-crear-nota<?= $rows['idCita'] ?>" name="horaFin" id="horaFin" placeholder="Hora de finzalizacion" >
                    </label>
                </div>
                <br>
                <div>
                    <label for="calificacionP1">
                        Calificación del Parcial 1: <br>
                        <input type="text" form="frm-crear-nota<?= $rows['idCita'] ?>" name="calificacionP1" id="calificacionP1" placeholder="calificacionP1" required>
                    </label>
                </div>
                <br>
                <div>
                    <label for="calificacionP2">
                        Calificación del Parcial 2: <br>
                        <input type="text" form="frm-crear-nota<?= $rows['idCita'] ?>" name="calificacionP2" id="calificacionP2" placeholder="calificacionP2" >
                    </label>
                </div>
            </form>

        </div>
        <div class="modal-footer modal-pie">

            <button 
                type="button" 
                class="boton-secundario" 
                onclick="enviarNotas('frm-crear-nota<?= $rows['idCita'] ?>', 'crearNota')">
                Registrar
            </button>
            <button type="button" class="boton-secundario" onclick="enviarNotas('frm-crear-nota<?= $rows['idCita'] ?>', 'actualizarNota')">Actualizar</button>
            <button type="button" class="boton-secundario" onclick="enviarNotas('frm-crear-nota<?= $rows['idCita'] ?>', 'eliminarNota')">Eliminar</button>

        </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modalGestionNotas = document.getElementById("modalGestionNotas-<?= $rows['idCita'] ?>");
        const fechaCreacionInput = document.getElementById("fechaCreacion-modalGestionNotas-<?= $rows['idCita'] ?>");

        modalGestionNotas.addEventListener("show.bs.modal", function () {
            const hoy = new Date();
            const fechaActual = hoy.toISOString().split('T')[0]; 
            fechaCreacionInput.value = fechaActual; 
        });
    });
</script>
