<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vacas_id_animal = $_POST['vacas_id_animal'];
    $inventario_id = $_POST['inventario_id'];
    $fecha_consumo = $_POST['fecha_consumo'];
    $cantidad_consumida = $_POST['cantidad_consumida'];

    $sql = "INSERT INTO comida_consumida (vacas_id_animal, inventario_id, fecha_consumo, cantidad_consumida) 
            VALUES ('$vacas_id_animal', '$inventario_id', '$fecha_consumo', '$cantidad_consumida')";

    if ($conexion->query($sql) === TRUE) {
        $_SESSION['mensaje'] = "Registro insertado exitosamente.";
        header("Location: read.php");
        exit;
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>

<h2>Agregar Comida Consumida</h2>
<form method="POST" action="">
    ID Vaca: <input type="number" name="vacas_id_animal" required><br>
    ID Inventario: <input type="number" name="inventario_id" required><br>
    Fecha Consumo: <input type="date" name="fecha_consumo" required><br>
    Cantidad Consumida: <input type="number" step="0.01" name="cantidad_consumida" required><br>
    <input type="submit" value="Agregar">
</form>
