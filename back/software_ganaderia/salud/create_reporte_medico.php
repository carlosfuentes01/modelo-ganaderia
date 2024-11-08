<?php
include '../../conexion/conexion.php';
session_start();

if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

$sesion = $_SESSION['dni'];

$sql1 = "
    SELECT v.id, v.nombre 
    FROM vacas v
    INNER JOIN potrero p ON v.potrero_id = p.id
    INNER JOIN finca f ON p.finca_id = f.id
    WHERE f.usuario_dni = '$sesion'
";
$vacas = $conexion->query($sql1);

$sql2 = "
    SELECT t.idtratamiento, t.tipo, e.tipo AS enfermedad, e.idenfermedades
    FROM tratamiento t
    INNER JOIN enfermedades e ON t.enfermedades_idenfermedades = e.idenfermedades
";
$tratamientos = $conexion->query($sql2);

if (isset($_POST['vaca'])) {
    $vaca_id = $_POST['vaca'];
    $fecha_chequeo = $_POST['fecha_chequeo'];
    $fecha_proximo_chequeo = $_POST['fecha_proximo_chequeo'];
    $notas_adicionales = $_POST['notas_adicionales'];

    $sql = "INSERT INTO reporte_medico (fecha_chequeo, fecha_proximo_chequeo, notas_adicionales)
            VALUES ('$fecha_chequeo', '$fecha_proximo_chequeo', '$notas_adicionales')";
    
    if ($conexion->query($sql) === TRUE) {
        echo "Reporte médico registrado exitosamente!";
        
        $reporte_medico_id = $conexion->insert_id;

        // Inserta la relación entre reporte_medico y vacas en la tabla reporte_medico_vaca
        $sql_reporte_vaca = "INSERT INTO reporte_medico_vaca (reporte_medico_id_reporte, vacas_id_animal)
                             VALUES ($reporte_medico_id, $vaca_id)";
        $conexion->query($sql_reporte_vaca);

        // Inserta los tratamientos seleccionados en la relación reporte_medico_has_tratamiento
        if (!empty($_POST['tratamientos'])) {
            foreach ($_POST['tratamientos'] as $tratamiento_id) {
                // Consulta para obtener la enfermedad asociada al tratamiento
                $sql_enfermedad = "SELECT enfermedades_idenfermedades FROM tratamiento WHERE idtratamiento = $tratamiento_id";
                $resultado_enfermedad = $conexion->query($sql_enfermedad);
                $enfermedad = $resultado_enfermedad->fetch_assoc();

                // Inserta en reporte_medico_has_tratamiento con la enfermedad correspondiente
                $sql_tratamiento = "INSERT INTO reporte_medico_has_tratamiento 
                                    (reporte_medico_id_reporte, tratamiento_idtratamiento, tratamiento_enfermedades_idenfermedades)
                                    VALUES ($reporte_medico_id, $tratamiento_id, {$enfermedad['enfermedades_idenfermedades']})";
                $conexion->query($sql_tratamiento);
            }
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
    <label for="vaca">Vaca:</label>
    <select name="vaca" required>
        <?php
        while ($vaca = $vacas->fetch_assoc()) {
            echo "<option value='{$vaca['id']}'>{$vaca['nombre']} - ID: {$vaca['id']}</option>";
        }
        ?>
    </select><br>

    <label for="fecha_chequeo">Fecha de Chequeo:</label>
    <input type="date" name="fecha_chequeo" required><br>

    <label for="fecha_proximo_chequeo">Fecha Próximo Chequeo:</label>
    <input type="date" name="fecha_proximo_chequeo" required><br>

    <label for="notas_adicionales">Notas Adicionales:</label>
    <textarea name="notas_adicionales"></textarea><br>

    <label for="tratamientos">Tratamientos:</label><br>
    <?php
    while ($tratamiento = $tratamientos->fetch_assoc()) {
        echo "<input type='checkbox' name='tratamientos[]' value='{$tratamiento['idtratamiento']}'> 
              Tratamiento: {$tratamiento['tipo']} - Enfermedad: {$tratamiento['enfermedad']}<br>";
    }
    ?>
    
    <input type="submit" value="Registrar Reporte Médico">
</form>

<a href="read_reporte_medico.php">Regresar a la lista de reportes médicos</a>
