<?php
include ' ';//conexion a la base de datos

$id = $_GET['dni'];

$sql = "DELETE FROM personal WHERE dni=$id";

if ($conexion->query($sql) === TRUE) {
    echo "Registro eliminado exitosamente";
} else {
    echo "Error: " . $conexion->error;
}
?>
