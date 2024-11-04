<?php
include '../../conexion/conexion.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

// Obtén el DNI del usuario autenticado
$dni_usuario = $_SESSION['dni'];

// Consulta para obtener las enfermedades relacionadas con el usuario autenticado
$sql = "SELECT e.idenfermedades, e.tipo, e.descripcion, e.posible_causa, e.sintomas, e.transmisible 
        FROM enfermedades e 
        JOIN tratamiento t ON e.idenfermedades = t.enfermedades_idenfermedades
        JOIN reporte_medico_has_tratamiento rm ON t.idtratamiento = rm.tratamiento_idtratamiento
        JOIN reporte_medico r ON rm.reporte_medico_id_reporte = r.id_reporte
        JOIN reporte_medico_vaca rmv ON r.id_reporte = rmv.reporte_medico_id_reporte
        JOIN vacas v ON rmv.vacas_id_animal = v.id
        JOIN potrero p ON v.potrero_id = p.id
        JOIN finca f ON p.finca_id = f.id
        JOIN usuario u ON f.usuario_dni = u.dni
        WHERE u.dni = '$dni_usuario'";

$enfermedades = $conexion->query($sql);

if ($enfermedades->num_rows > 0) {
    echo "
    <table border='1'>
        <tr>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Posibles Causas</th>
            <th>Síntomas</th>
            <th>Transmisible</th>
            <th>Acciones</th>
        </tr>";
    
    while($row = $enfermedades->fetch_assoc()) {
        // Determina si es "Sí" o "No" para transmisible
        $transmisible_text = ($row["transmisible"] == 1) ? "Sí" : "No";
        
        echo "<tr>
                <td>".$row["tipo"]."</td>
                <td>".$row["descripcion"]."</td>
                <td>".$row["posible_causa"]."</td>
                <td>".$row["sintomas"]."</td>
                <td>".$transmisible_text."</td>
                <td>
                    <form method='POST' action='update_enfermedades.php' style='display:inline;'>
                        <input type='hidden' name='idenfermedades' value='".$row['idenfermedades']."'>
                        <input type='submit' value='Editar'>
                    </form>
                    
                    <form method='POST' action='delete_enfermedades.php' style='display:inline;'>
                        <input type='hidden' name='idenfermedades' value='".$row['idenfermedades']."'>
                        <input type='submit' value='Eliminar'>
                    </form>
                </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros de enfermedades";
}
?>
