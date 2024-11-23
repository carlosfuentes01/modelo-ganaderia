<a href="read.php">regresar a lectura de vacas</a>
<?php
include '../../conexion/conexion.php'; //conexion a la base de datos
session_start();
// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}
$id = $_REQUEST['id'];

$sql = "DELETE FROM vacas WHERE id=$id";

if ($conexion->query($sql) === TRUE ) {
    echo "Registro eliminado exitosamente";
    header("Location: read.php");
    exit();
} else {
    echo "Error: " . $conexion->error;
}
?>
