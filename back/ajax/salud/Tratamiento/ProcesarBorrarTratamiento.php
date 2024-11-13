<?php
include "../../../conexion/conexion.php"; 
$id = $_POST['idtratamiento'];

// Sentencia SQL para eliminar el tratamiento
$sql = "DELETE FROM tratamiento WHERE idtratamiento = $id";

if ($conexion->query($sql) === TRUE) {
    echo "<script>window.alert('Eliminación exitosa!');
                window.location.href='../../../software_ganaderia/salud/read_tratamiento.php';
        
        </script>";
} else {
    echo "Error al eliminar el tratamiento: " . $conexion->error;
}
?>
