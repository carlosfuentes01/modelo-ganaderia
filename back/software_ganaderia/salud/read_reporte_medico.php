<a href='create_reporte_medico.php'>Crear Reporte Médico</a>

<?php
include '../../conexion/conexion.php';
session_start();

if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

$sesion = $_SESSION['dni'];

$sql1 = "
    SELECT rm.id_reporte AS reporte_id, rm.fecha_chequeo, rm.fecha_proximo_chequeo, rm.notas_adicionales, 
           v.id AS vaca_id, v.identificacion AS vaca_identificacion, v.nombre AS vaca_nombre,
           rm.control_embarazo_idcontrol_embarazo AS esta_prenada
    FROM reporte_medico rm
    INNER JOIN reporte_medico_vaca rmv ON rm.id_reporte = rmv.reporte_medico_id_reporte
    INNER JOIN vacas v ON rmv.vacas_id_animal = v.id
    INNER JOIN potrero p ON v.potrero_id = p.id
    INNER JOIN finca f ON p.finca_id = f.id
    LEFT JOIN control_embarazo ce ON rm.control_embarazo_idcontrol_embarazo = ce.idcontrol_embarazo
    WHERE f.usuario_dni = '$sesion'
";
$reportes = $conexion->query($sql1);

if ($reportes->num_rows > 0) {
    echo "
    <table border='1'>
        <tr>
            <th>Vaca (Identificación)</th>
            <th>Nombre de la Vaca</th>
            <th>Fecha de Chequeo</th>
            <th>Fecha Próximo Chequeo</th>
            <th>Notas Adicionales</th>
            <th>¿Está Preñada?</th>
            <th>Tratamientos y Enfermedades</th>
            <th>Acciones</th>
        </tr>";
    
    while ($row = $reportes->fetch_assoc()) {
        echo "<tr>
                <td>".$row["vaca_identificacion"]."</td>
                <td>".$row["vaca_nombre"]."</td>
                <td>".$row["fecha_chequeo"]."</td>
                <td>".$row["fecha_proximo_chequeo"]."</td>
                <td>".$row["notas_adicionales"]."</td>
                <td>";
        
        // Mostrar "Sí" si la vaca está preñada, de lo contrario "No"
        if ($row['esta_prenada'] !== null) {
            echo "Sí";
        } else {
            echo "No";
        }

        echo "</td>
              <td>";

        // Consulta para obtener los tratamientos y sus enfermedades asociadas al reporte médico
        $sql2 = "
            SELECT t.tipo AS tratamiento, e.tipo AS enfermedad
            FROM reporte_medico_has_tratamiento rmt
            INNER JOIN tratamiento t ON rmt.tratamiento_idtratamiento = t.idtratamiento
            INNER JOIN enfermedades e ON rmt.tratamiento_enfermedades_idenfermedades = e.idenfermedades
            WHERE rmt.reporte_medico_id_reporte = {$row['reporte_id']}
        ";
        $tratamientos = $conexion->query($sql2);
        
        while ($tratamiento = $tratamientos->fetch_assoc()) {
            echo "Tratamiento: ".$tratamiento['tratamiento']." - Enfermedad: ".$tratamiento['enfermedad']."<br><br>";
        }

        echo "</td>
              <td>
                <form method='POST' action='update_reporte_medico.php' style='display:inline;'>
                    <input type='hidden' name='id' value='".$row['reporte_id']."'>
                    <input type='submit' value='Editar'>
                </form> 
                <form method='POST' action='delete_reporte_medico.php' style='display:inline;'>
                    <input type='hidden' name='id' value='".$row['reporte_id']."'>
                    <input type='submit' value='Eliminar'>
                </form>
              </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No hay reportes médicos registrados.";
}
?>