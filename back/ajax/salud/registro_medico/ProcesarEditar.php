<?php
include '../../../conexion/conexion.php';
session_start();
$sesion = $_SESSION['dni'];
$id_reporte = $_POST['id_reporte'];
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
        echo "<script>window.alert('Actualizacion exitosa!');
                window.location.href='../../../software_ganaderia/salud/read_reporte_medico.php';
        
        </script>";
        
        // Actualizar tratamientos seleccionados
        $conexion->query("DELETE FROM reporte_medico_has_tratamiento WHERE reporte_medico_id_reporte = $id_reporte");
        
        // Aseguramos que el campo esté definido y sea un array
        if (isset($_POST['tratamientos']) && is_array($_POST['tratamientos'])) {
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
}