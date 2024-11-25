<?php
include '../../conexion/conexion.php'; // Conexión a la base de datos
session_start();

$fecha = $_POST['fecha'];
    $litros_leche = $_POST['litros_leche'];
    $vaca_id = $_POST['vacas_id'];
    $id_produccion = $_POST['id'];

    $sqlUpdate = "UPDATE produccion_lechera SET 
    fecha = '$fecha', 
    litros_leche = '$litros_leche', 
    vacas_id = '$vaca_id'
  WHERE id_produccion = $id_produccion";

if ($conexion->query($sqlUpdate) === TRUE) {
echo"<script>window.alert('Actualización exitosa!');
                window.location.href='../../software_ganaderia/produccion_lechera/read_produccion_lechera.php';
        
        </script>";
} else {
echo "Error: " . $sqlUpdate . "<br>" . $conexion->error;
}