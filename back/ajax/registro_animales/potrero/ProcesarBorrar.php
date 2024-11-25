
<?php
include '../../../conexion/conexion.php'; 
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

$id_potrero = $_REQUEST['id_potrero']; 

$sql = "DELETE FROM potrero WHERE id = $id_potrero";

if ($conexion->query($sql) === TRUE) {
    echo "<script>window.alert('Potrero eliminado!');
                window.location.href='../../../software_ganaderia/registro_animales/read_potrero.php';
        
        </script>";
} else {
    echo "Error al eliminar el potrero: " . $conexion->error;
}
?>
