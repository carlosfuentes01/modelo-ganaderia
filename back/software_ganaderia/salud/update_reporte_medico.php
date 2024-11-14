<a href="read_reporte_medico.php">Regresar a la lista de reportes médicos</a>
<?php
include '../../conexion/conexion.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

$sesion = $_SESSION['dni'];
$id_reporte = $_REQUEST['id_reporte'];

// Consulta para obtener los datos del reporte médico a actualizar
$sql_reporte = "SELECT * FROM reporte_medico WHERE id_reporte = $id_reporte";
$result_reporte = $conexion->query($sql_reporte);
$row = $result_reporte->fetch_assoc();

if (!$row) {
    echo "Reporte médico no encontrado.";
    exit;
}

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

// Procesamiento de datos del formulario para actualizar el reporte médico
if (isset($_POST['vaca'])) {
    $vaca_id = $_POST['vaca'];
    $fecha_chequeo = $_POST['fecha_chequeo'];
    $fecha_proximo_chequeo = $_POST['fecha_proximo_chequeo'];
    $notas_adicionales = $_POST['notas_adicionales'];
    $id_reporte = $_POST['id_reporte'];

    // Verificar si la fecha de próximo chequeo está vacía
    if ($fecha_proximo_chequeo == "") {
        $fecha_proximo_chequeo_sql = "NULL";
    } else {
        $fecha_proximo_chequeo_sql = "'$fecha_proximo_chequeo'";
    }

    $sql_update = "UPDATE reporte_medico SET 
                    fecha_chequeo='$fecha_chequeo', 
                    fecha_proximo_chequeo=$fecha_proximo_chequeo_sql, 
                    notas_adicionales='$notas_adicionales',
                    id_vaca=$vaca_id 
                   WHERE id_reporte=$id_reporte";

    if ($conexion->query($sql_update) === TRUE) {
        echo "Actualización exitosa!";
        
        // Actualizar tratamientos seleccionados
        $conexion->query("DELETE FROM reporte_medico_has_tratamiento WHERE reporte_medico_id_reporte = $id_reporte");
        
        if (!empty($_POST['tratamientos'])) {
            foreach ($_POST['tratamientos'] as $tratamiento_id) {
                $sql_enfermedad = "SELECT enfermedades_idenfermedades FROM tratamiento WHERE idtratamiento = $tratamiento_id";
                $resultado_enfermedad = $conexion->query($sql_enfermedad);
                $enfermedad = $resultado_enfermedad->fetch_assoc();

                $sql_tratamiento = "
                    INSERT INTO reporte_medico_has_tratamiento 
                    (reporte_medico_id_reporte, tratamiento_idtratamiento, tratamiento_enfermedades_idenfermedades) 
                    VALUES ($id_reporte, $tratamiento_id, {$enfermedad['enfermedades_idenfermedades']})
                ";
                $conexion->query($sql_tratamiento);
            }
        }
    } else {
        echo "Error: " . $sql_update . "<br>" . $conexion->error;
    }
} else {
    // Mostrar el formulario de actualización con datos actuales del reporte médico
?>
    <form method="POST" action="">
        <input type="hidden" name="id_reporte" value="<?php echo $id_reporte; ?>">
        <label for="vaca">Vaca:</label>
        <select name="vaca" required>
            <?php
            while ($vaca = $vacas->fetch_assoc()) {
                $selected = ($vaca['id'] == $row['id_vaca']) ? 'selected' : '';
                echo "<option value='{$vaca['id']}' $selected>{$vaca['nombre']} - Identificación: {$vaca['identificacion']}</option>";
            }
            ?>
        </select><br>

        <label for="fecha_chequeo">Fecha de Chequeo:</label>
        <input type="date" name="fecha_chequeo" required value="<?php echo $row['fecha_chequeo']; ?>"><br>

        <label for="fecha_proximo_chequeo">Fecha Próximo Chequeo:</label>
        <input type="date" name="fecha_proximo_chequeo" value="<?php echo $row['fecha_proximo_chequeo']; ?>"><br>

        <label for="notas_adicionales">Notas Adicionales:</label>
        <textarea name="notas_adicionales"><?php echo $row['notas_adicionales']; ?></textarea><br>

        <label for="tratamientos">Tratamientos:</label><br>
        <?php
        while ($tratamiento = $tratamientos->fetch_assoc()) {
            $checked = in_array($tratamiento['idtratamiento'], $tratamientos_seleccionados) ? 'checked' : '';
            echo "<input type='checkbox' name='tratamientos[]' value='{$tratamiento['idtratamiento']}' $checked> 
                  Tratamiento: {$tratamiento['tipo']} - Enfermedad: {$tratamiento['enfermedad']}<br>";
        }
        ?>
        
        <input type="submit" value="Actualizar Reporte Médico">
    </form>
<?php
}
?>
