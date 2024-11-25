<?php
include '../../../conexion/conexion.php'; //conexion a la base de datos
session_start();
// Verifica si el usuario está autenticado
$sesion = $_SESSION['dni'];
$id_potrero = $_REQUEST['id_potrero']; 

// Consulta para obtener las fincas asociadas al usuario
$sqlFincas = "SELECT id, nombre FROM finca WHERE usuario_dni = $sesion";
$fincas = $conexion->query($sqlFincas);

// Consulta para obtener el registro actual del potrero
$sql = "SELECT * FROM potrero WHERE id = $id_potrero";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();


?>
<div class="modal fade" id="ModalActualizar" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollableg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form method="POST" id="enviar" action="../../ajax/registro_animales/potrero/ProcesarEditar.php">
        <input type="hidden" name="id_potrero"  value="<?php echo $id_potrero; ?>">

        Nombre del Potrero: <input type="text" name="nombre" style="width: 100%;" value="<?php echo $row['nombre']; ?>"><br>
        
        Finca:
        <select name="finca_id" style="width: 100%;">
            <?php
            while ($finca = $fincas->fetch_assoc()) {
                ?>
                <option <?php if ($finca['id'] == $row['finca_id']) echo 'selected'; ?> value="<?php echo $finca['id']; ?>">
                    <?php echo $finca['nombre']; ?>
                </option>
                <?php
            }
            ?>
        </select><br>

    </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" onclick="hola()" class="btn btn-primary">Actualizar potrero</button>
            </div>

        </div>
    </div>
</div>
</div>
</div>

<script>
    function hola(params) {
        document.getElementById("enviar").submit();
    }
</script>