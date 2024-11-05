<?php
include '../../conexion/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM inventario WHERE id='$id'";
    if ($conexion->query($sql) === TRUE) {
        echo "Inventario eliminado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>
<a href="read_inventario.php">Volver a la lista de inventario</a>
