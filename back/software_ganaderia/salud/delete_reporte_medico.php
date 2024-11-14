<a href="read_reporte_medico.php">Regresar a la lista de reportes médicos</a>
<?php
include '../../conexion/conexion.php'; 
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

$id = $_REQUEST['id_reporte'];

// Primero, elimina las referencias en la tabla reporte_medico_has_tratamiento para evitar errores de clave externa
$sql_delete_tratamientos = "DELETE FROM reporte_medico_has_tratamiento WHERE reporte_medico_id_reporte = $id";
$conexion->query($sql_delete_tratamientos);

// Luego, elimina el registro de `reporte_medico`
$sql = "DELETE FROM reporte_medico WHERE id_reporte = $id";

if ($conexion->query($sql) === TRUE) {
    echo "Reporte médico eliminado exitosamente";
} else {
    echo "Error: " . $conexion->error;
}
?>
