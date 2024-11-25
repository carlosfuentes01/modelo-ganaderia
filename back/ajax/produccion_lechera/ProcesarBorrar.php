<?php
include '../../conexion/conexion.php'; // Conexión a la base de datos
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}

// Obtiene el ID del registro de producción lechera a eliminar
$id = $_POST['id'];

// Consulta para eliminar el registro en la tabla de producción lechera
$sql = "DELETE FROM produccion_lechera WHERE id_produccion=$id";

if ($conexion->query($sql) === TRUE) {
    echo "<script>window.alert('Elminacion exitosa!');
                window.location.href='../../software_ganaderia/produccion_lechera/read_produccion_lechera.php';
        
        </script>";
} else {
    echo "Error: " . $conexion->error;
}