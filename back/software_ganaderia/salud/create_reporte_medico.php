<?php

include '../../conexion/conexion.php';
session_start();

if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}


$hoy = date("Y-n-d");  
$sesion = $_SESSION['dni'];

$sql1 = "
    SELECT v.id, v.nombre,v.identificacion 
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
    $notas_adicionales = $_POST['notas_adicionales'];
    $fecha_proximo_chequeo = $_POST['fecha_proximo_chequeo'];
    if ($_POST['fecha_proximo_chequeo']== "") {

        $fecha_proximo_chequeo="NULL";
        $sql = "INSERT INTO reporte_medico (fecha_chequeo, fecha_proximo_chequeo, notas_adicionales,id_vaca)
        VALUES ('$fecha_chequeo',$fecha_proximo_chequeo, '$notas_adicionales',$vaca_id)";

    }else{
        $sql = "INSERT INTO reporte_medico (fecha_chequeo, fecha_proximo_chequeo, notas_adicionales,id_vaca)
        VALUES ('$fecha_chequeo','$fecha_proximo_chequeo', '$notas_adicionales',$vaca_id)";

    }

    
    
     echo $sql;
    if ($conexion->query($sql) === TRUE) {
        echo "Reporte médico registrado exitosamente!";
        
        $reporte_medico_id = $conexion->insert_id;


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
            echo "<option value='{$vaca['id']}'>{$vaca['nombre']} - Identificación: {$vaca['identificacion']}</option>";
        }
        ?>
    </select><br>

    <label for="fecha_chequeo">Fecha de Chequeo:</label>
    <input type="date" name="fecha_chequeo" required value="<?php echo $hoy; ?>"><br>

    <label for="fecha_proximo_chequeo">Fecha Próximo Chequeo:</label>
    <input type="date" name="fecha_proximo_chequeo" ><br>

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
