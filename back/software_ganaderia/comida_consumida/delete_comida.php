<?php
include '../../conexion/conexion.php';

if (isset($_GET['vacas_id_animal']) && isset($_GET['inventario_id'])) {
    $vacas_id_animal = $_GET['vacas_id_animal'];
    $inventario_id = $_GET['inventario_id'];

    $sql = "DELETE FROM comida_consumida WHERE vacas_id_animal='$vacas_id_animal' AND inventario_id='$inventario_id'";
    if ($conexion->query($sql) === TRUE) {
        echo "Registro eliminado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>
<a href="read_comida.php">Volver a la lista de registros de comida consumida</a>

