<?php
session_start();
include 'conexion.php';

if (isset($_GET['vacas_id_animal']) && isset($_GET['inventario_id'])) {
    $vacas_id_animal = $_GET['vacas_id_animal'];
    $inventario_id = $_GET['inventario_id'];

    $sql = "DELETE FROM comida_consumida WHERE vacas_id_animal='$vacas_id_animal' AND inventario_id='$inventario_id'";

    if ($conexion->query($sql) === TRUE) {
        $_SESSION['mensaje'] = "Registro eliminado exitosamente.";
    } else {
        $_SESSION['mensaje'] = "Error eliminando registro: " . $conexion->error;
    }
}

header("Location: read.php");
exit;
?>
