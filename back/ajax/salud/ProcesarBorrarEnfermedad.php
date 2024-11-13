<?php
include '../../conexion/conexion.php';

$id = $_POST['idenfermedades']; // Obtiene el id de la enfermedad a eliminar

$sql = "DELETE FROM enfermedades WHERE idenfermedades=$id"; // Consulta para eliminar la enfermedad

if ($conexion->query($sql) === TRUE) {
    echo "<script>window.alert('Eliminación exitosa!');
                window.location.href='../../software_ganaderia/salud/read_enfermedades.php';
        
        </script>";
} else {
    echo "Error: " . $conexion->error;
}
?>