<a href="read_enfermedades.php">Regresar a la lectura de enfermedades</a>
<?php
include '../../conexion/conexion.php'; // Conexión a la base de datos
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}


$id = $_REQUEST['idenfermedades']; // Obtiene el id de la enfermedad a eliminar

$sql = "DELETE FROM enfermedades WHERE idenfermedades=$id"; // Consulta para eliminar la enfermedad

if ($conexion->query($sql) === TRUE) {
    echo "Enfermedad eliminada exitosamente";
} else {
    echo "Error: " . $conexion->error;
}
?>
