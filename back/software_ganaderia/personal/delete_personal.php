<a href="read_personal.php">Regresar a lectura de personal</a>
<?php
include '../../conexion/conexion.php'; // Conexión a la base de datos
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

// Obtener el DNI del personal a eliminar
$dni = $_REQUEST['dni'];

// Primero, elimina las referencias en `finca_has_personal`
$sql_delete_finca_personal = "DELETE FROM finca_has_personal WHERE personal_dni='$dni'";
if ($conexion->query($sql_delete_finca_personal) === TRUE) {
    
    // Luego, elimina el registro en `personal`
    $sql_delete_personal = "DELETE FROM personal WHERE dni='$dni'";
    if ($conexion->query($sql_delete_personal) === TRUE) {
        echo "Registro de personal eliminado exitosamente";
    } else {
        echo "Error al eliminar el registro de personal: " . $conexion->error;
    }
    
} else {
    echo "Error al eliminar la relación en finca_has_personal: " . $conexion->error;
}
?>
