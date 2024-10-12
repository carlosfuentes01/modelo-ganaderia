<?php
include ''; //conexion a la base de datos

$id = $_GET['id_animal'];

$sql = "DELETE FROM animales WHERE id_animal=$id";

if ($conexion->query($sql) === TRUE) {
    echo "Registro eliminado exitosamente";
} else {
    echo "Error: " . $conexion->error;
}
?>
