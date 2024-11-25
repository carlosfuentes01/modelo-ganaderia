<a href="read_potrero.php">Regresar a lectura de potreros</a>
<?php
include '../../conexion/conexion.php'; 
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}

$id_potrero = $_REQUEST['id_potrero']; 

$sql = "DELETE FROM potrero WHERE id = $id_potrero";

if ($conexion->query($sql) === TRUE) {
    echo "Potrero eliminado exitosamente";
} else {
    echo "Error al eliminar el potrero: " . $conexion->error;
}
?>
