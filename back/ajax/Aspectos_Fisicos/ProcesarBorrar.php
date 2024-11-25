<?php
include '../../conexion/conexion.php'; 
session_start();


$aspecto_id = $_REQUEST['id'];

// Ejecuta la consulta de eliminación
$sql = "DELETE FROM aspectos_fisicos WHERE id = $aspecto_id";

if ($conexion->query($sql) === TRUE) {
    echo "<script>window.alert('Eliminacion exitosa!');
                window.location.href='../../software_ganaderia/registro_animales/read_aspectos_fisicos.php';
        
        </script>";
} else {
    echo "Error al eliminar el registro de aspectos físicos: " . $conexion->error;
}
?>