<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vacas_id_animal = $_POST['vacas_id_animal'];
    $inventario_id = $_POST['inventario_id'];
    $fecha_consumo = $_POST['fecha_consumo'];
    $cantidad_consumida = $_POST['cantidad_consumida'];

    $sql = "UPDATE comida_consumida 
            SET fecha_consumo='$fecha_consumo', cantidad_consumida='$cantidad_consumida' 
            WHERE vacas_id_animal='$vacas_id_animal' AND inventario_id='$inventario_id'";

    if ($conexion->query($sql) === TRUE) {
        $_SESSION['mensaje'] = "Registro actualizado exitosamente.";
        header("Location: read.php");
        exit;
    } else {
        echo "Error: " . $conexion->error;
    }
}

if (isset($_GET['vacas_id_animal']) && isset($_GET['inventario_id'])) {
    $vacas_id_animal = $_GET['vacas_id_animal'];
    $inventario_id = $_GET['inventario_id'];

    $sql = "SELECT * FROM comida_consumida WHERE vacas_id_animal='$vacas_id_animal' AND inventario_id='$inventario_id'";
    $result = $conexion->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
    }
}
?>

<h2>Actualizar Comida Consumida</h2>
<form method="POST" action="">
    <input type="hidden" name="vacas_id_animal" value="<?php echo $row['vacas_id_animal']; ?>">
    <input type="hidden" name="inventario_id" value="<?php echo $row['inventario_id']; ?>">
    Fecha Consumo: <input type="date" name="fecha_consumo" value="<?php echo $row['fecha_consumo']; ?>" required><br>
    Cantidad Consumida: <input type="number" step="0.01" name="cantidad_consumida" value="<?php echo $row['cantidad_consumida']; ?>" required><br>
    <input type="submit" value="Actualizar">
</form>
