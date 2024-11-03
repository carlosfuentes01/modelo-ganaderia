<?php
include 'conexion.php'; // No Se Pude Agregar masde una comida al dia la vaca ya q esta se guarda por la fecha 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $identificacion_vaca = $_POST['identificacion_vaca']; 
    $inventario_id = $_POST['inventario_id'];
    $fecha_consumo = $_POST['fecha_consumo'];
    $cantidad_consumida = $_POST['cantidad_consumida'];


    $sql_vaca = "SELECT id FROM vacas WHERE identificacion = '$identificacion_vaca'";
    $resultado_vaca = $conexion->query($sql_vaca);

    if ($resultado_vaca->num_rows > 0) {
        $fila_vaca = $resultado_vaca->fetch_assoc();
        $vacas_id_animal = $fila_vaca['id']; 


        $sql = "INSERT INTO comida_consumida (vacas_id_animal, inventario_id, fecha_consumo, cantidad_consumida) 
                VALUES ('$vacas_id_animal', '$inventario_id', '$fecha_consumo', '$cantidad_consumida')";

        if ($conexion->query($sql) === TRUE) {
            echo "Comida consumida agregada exitosamente.";
        } else {
            echo "Error al insertar: " . $conexion->error;
        }
    } else {
        echo "No se encontró una vaca con la identificación proporcionada.";
    }
}
?>

<form method="POST" action="">
    Identificación de la Vaca: <input type="text" name="identificacion_vaca" required><br>
    Inventario: 
    <select name="inventario_id" required>
        <?php
        $sql_inventario = "SELECT id, nombre FROM inventario";
        $result_inventario = $conexion->query($sql_inventario);

        while ($row = $result_inventario->fetch_assoc()) {
            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
        }
        ?>
    </select><br>
    Fecha de Consumo: <input type="date" name="fecha_consumo" required><br>
    Cantidad Consumida: <input type="number" name="cantidad_consumida" required><br>
    <input type="submit" value="Agregar Consumo de Comida">
</form>
