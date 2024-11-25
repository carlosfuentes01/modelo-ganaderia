<?php
include '../../conexion/conexion.php'; //conexion a la base de datos
session_start();
// Verifica si el usuario está autenticado

$id = $_POST['id_inventario']; // Obtiene el id de la enfermedad a actualizar

$sql = "SELECT inventario.id, inventario.nombre, inventario.cantidad, inventario.finca_id_finca, finca.nombre AS nombre_finca 
            FROM inventario
            JOIN finca ON inventario.finca_id_finca = finca.id
            WHERE inventario.id='$id'";
    $result = mysqli_query($conexion, $sql);

    // Obtener todas las fincas para el combo box
    $sql_fincas = "SELECT id, nombre FROM finca";
    $result_fincas = mysqli_query($conexion, $sql_fincas);

?>
<div class="modal fade" id="ModalActualizar" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollableg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar inventario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
            if ($row = mysqli_fetch_assoc($result)) {
                ?>
                <form method="POST" id="enviar" style="width: 100%;" action="../../ajax/inventario/ProcesarEditar.php">
                    <label  style="width: 100%;" for="fecha_deteccion">Nombre del inventario</label>
                    <input  style="width: 100%;" type="text" name="nombre" required value="<?php echo $row['nombre']; ?>"><br>
                    <label  style="width: 100%;">Cantidad</label>
                    <input  style="width: 100%;" type="number" name="cantidad" required value="<?php echo $row['cantidad']; ?>"><br>
                    <label  style="width: 100%;">Finca:</label>
                    <select  style="width: 100%;" name="finca_id" required>
                    <option value="">Selecciona una finca</option>
                        <?php
                        while ($finca = mysqli_fetch_assoc($result_fincas)) {
                            
                            $selected = $finca['id'] == $row['finca_id_finca'] ? 'selected' : '';
                            
                            echo "<option value='" . $finca['id'] . "' $selected>" . $finca['nombre'] . "</option>";
                            if ($mod['id'] == $update['modo_concepcion']) {
                                echo "<option selected value='{$mod['id']}'>{$mod['nombre_modo']} </option>";
                            } else {
                                echo "<option value='{$mod['id']}'>{$mod['nombre_modo']} </option>";
                            }
                        }
                        ?>
                    </select><br>

                    <input type="hidden" name="id" value="<?=$row['id']?>">
                </form>
                <?php
            }
            ?>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" onclick="hola()" class="btn btn-primary">Actualizar registro</button>
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