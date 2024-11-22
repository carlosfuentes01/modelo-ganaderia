<a href="read_aspectos_fisicos.php">Regresar a lectura de aspectos físicos</a>
<?php
include '../../conexion/conexion.php'; 
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/login.php");
    exit;
}
$aspecto_id = $_REQUEST['aspecto_id'];

// Ejecuta la consulta de eliminación
$sql = "DELETE FROM aspectos_fisicos WHERE id = $aspecto_id";

if ($conexion->query($sql) === TRUE) {
    echo "Registro de aspectos físicos eliminado exitosamente";
} else {
    echo "Error al eliminar el registro de aspectos físicos: " . $conexion->error;
}
?>
