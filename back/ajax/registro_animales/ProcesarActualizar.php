<?php 
include "../../conexion/conexion.php";
$id= $_POST["id"];
$identificacion = $_POST['identificacion'];
$nombre = $_POST['nombre'];
$fecha_de_registro_animal = $_POST['fecha_de_registro_animal'];
$genero = $_POST['genero'];
echo $genero;
$descartada = $_POST['descartada'];
$potrero_id = $_POST['potrero'];

$sql = "UPDATE vacas SET 
            identificacion='$identificacion', 
            nombre='$nombre', 
            fecha_de_registro_animal='$fecha_de_registro_animal', 
            genero='$genero',
            descartada='$descartada',
            potrero_id='$potrero_id' 
        WHERE id=$id";

if ($conexion->query($sql) === TRUE) {
    echo "Actualización exitosa!";
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}