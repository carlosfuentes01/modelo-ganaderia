<a href="read_tratamiento.php">Regresar a lectura de tratamientos</a>
<?php
include '../../conexion/conexion.php'; // Conexión a la base de datos
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}



// Obtener el ID del tratamiento a eliminar
$id = $_REQUEST['idtratamiento'];

// Sentencia SQL para eliminar el tratamiento
$sql = "DELETE FROM tratamiento WHERE idtratamiento = $id";

if ($conexion->query($sql) === TRUE) {
    echo "Tratamiento eliminado exitosamente";
} else {
    echo "Error al eliminar el tratamiento: " . $conexion->error;
}
?>
