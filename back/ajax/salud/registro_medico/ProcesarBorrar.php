<?php 
include '../../../conexion/conexion.php'; 
session_start();


$id = $_POST['id_reporte'];

// Primero, elimina las referencias en la tabla reporte_medico_has_tratamiento para evitar errores de clave externa
$sql_delete_tratamientos = "DELETE FROM reporte_medico_has_tratamiento WHERE reporte_medico_id_reporte = $id";
$conexion->query($sql_delete_tratamientos);

// Luego, elimina el registro de `reporte_medico`
$sql = "DELETE FROM reporte_medico WHERE id_reporte = $id";

if ($conexion->query($sql) === TRUE) {
    echo "<script>window.alert('Eliminacion exitosa!');
                window.location.href='../../../software_ganaderia/salud/read_reporte_medico.php';
        
        </script>";
} else {
    echo "Error: " . $conexion->error;
}
?>
