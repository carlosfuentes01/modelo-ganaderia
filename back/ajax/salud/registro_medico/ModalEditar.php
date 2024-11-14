<?php
include '../../../conexion/conexion.php'; //conexion a la base de datos
session_start();
// Verifica si el usuario está autenticado


$sesion = $_SESSION['dni'];
$id_reporte = $_POST['id_reporte'];
// Obtén los datos actuales de la enfermedad
$sql_reporte = "SELECT * FROM reporte_medico WHERE id_reporte = $id_reporte";
$result_reporte = $conexion->query($sql_reporte);
$row = $result_reporte->fetch_assoc();

// Obtener las enfermedades para el desplegable

// Consultas para llenar las opciones del formulario
$sql_vacas = "
    SELECT v.id, v.nombre, v.identificacion 
    FROM vacas v
    INNER JOIN potrero p ON v.potrero_id = p.id
    INNER JOIN finca f ON p.finca_id = f.id
    WHERE f.usuario_dni = '$sesion'
";
$vacas = $conexion->query($sql_vacas);

$sql_tratamientos = "
    SELECT t.idtratamiento, t.tipo, e.tipo AS enfermedad, e.idenfermedades
    FROM tratamiento t
    INNER JOIN enfermedades e ON t.enfermedades_idenfermedades = e.idenfermedades
";
$tratamientos = $conexion->query($sql_tratamientos);

// Obtener los tratamientos seleccionados en el reporte médico
$sql_tratamientos_seleccionados = "
    SELECT tratamiento_idtratamiento 
    FROM reporte_medico_has_tratamiento 
    WHERE reporte_medico_id_reporte = $id_reporte
";
$result_tratamientos_seleccionados = $conexion->query($sql_tratamientos_seleccionados);
$tratamientos_seleccionados = [];
while ($tratamiento = $result_tratamientos_seleccionados->fetch_assoc()) {
    $tratamientos_seleccionados[] = $tratamiento['tratamiento_idtratamiento'];
}

?>
<div class="modal fade" id="ModalActualizar" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollableg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar registro medico</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="enviar" style="width: 100%;" action="../../ajax/salud/registro_medico/ProcesarEditar.php">
                    
                    
                    <input style="width: 100%;" type="hidden" name="id_reporte" value="<?php echo $id_reporte; ?>">
                    <label for="vaca">Vaca:</label>
                    <select style="width: 100%;" name="vaca" required>
                        <?php
                        while ($vaca = $vacas->fetch_assoc()) {
                            $selected = ($vaca['id'] == $row['id_vaca']) ? 'selected' : '';
                            echo "<option value='{$vaca['id']}' $selected>{$vaca['nombre']} - Identificación: {$vaca['identificacion']}</option>";
                        }
                        ?>
                    </select><br>

                    <label for="fecha_chequeo">Fecha de Chequeo:</label>
                    <input style="width: 100%;" type="date" name="fecha_chequeo" required value="<?php echo $row['fecha_chequeo']; ?>"><br>

                    <label for="fecha_proximo_chequeo">Fecha Próximo Chequeo:</label>
                    <input style="width: 100%;" type="date" name="fecha_proximo_chequeo" value="<?php echo $row['fecha_proximo_chequeo']; ?>"><br>

                    <label for="notas_adicionales">Notas Adicionales:</label>
                    <textarea style="width: 100%;" name="notas_adicionales"><?php echo $row['notas_adicionales']; ?></textarea><br>

                    <label for="tratamientos">Tratamientos:</label><br>
                    <?php
                    while ($tratamiento = $tratamientos->fetch_assoc()) {
                        $checked = in_array($tratamiento['idtratamiento'], $tratamientos_seleccionados) ? 'checked' : '';
                        echo "<input type='checkbox' name='tratamientos[]' value='{$tratamiento['idtratamiento']}' $checked> 
                  Tratamiento: {$tratamiento['tipo']} - Enfermedad: {$tratamiento['enfermedad']}<br>";
                    }
                    ?>


                </form>

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