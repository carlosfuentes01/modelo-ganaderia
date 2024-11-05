<?php
include '../../conexion/conexion.php';


$inventario_query = "SELECT id, nombre FROM inventario";
$inventario_result = mysqli_query($conexion, $inventario_query);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identificacion = $_POST['identificacion'];
    $inventario_id = $_POST['inventario_id'];
    $fecha_consumo = $_POST['fecha_consumo'];
    $cantidad_consumida = $_POST['cantidad_consumida'];


    $vaca_query = "SELECT id FROM vacas WHERE identificacion='$identificacion'";
    $vaca_result = mysqli_query($conexion, $vaca_query);

    if (mysqli_num_rows($vaca_result) > 0) {
        $vaca_row = mysqli_fetch_assoc($vaca_result);
        $vacas_id_animal = $vaca_row['id'];

        $insert_query = "INSERT INTO comida_consumida (vacas_id_animal, inventario_id, fecha_consumo, cantidad_consumida) 
                         VALUES ('$vacas_id_animal', '$inventario_id', '$fecha_consumo', '$cantidad_consumida')";

        if (mysqli_query($conexion, $insert_query)) {
            echo "Registro de comida consumida agregado exitosamente.";
        } else {
            echo "Error: " . mysqli_error($conexion);
        }
    } else {
        echo "Vaca no encontrada con la identificación ingresada.";
    }
}
?>


<form method="POST" action="create_comida.php">
    Identificación de la Vaca: <input type="text" name="identificacion" required><br>

    <label for="inventario_id">Inventario:</label>
    <select name="inventario_id" required>
        <?php while ($inventario = mysqli_fetch_assoc($inventario_result)) { ?>
            <option value="<?php echo $inventario['id']; ?>"><?php echo $inventario['nombre']; ?></option>
        <?php } ?>
    </select><br>

    Fecha de Consumo: <input type="date" name="fecha_consumo" required><br>
    Cantidad Consumida: <input type="number" step="0.01" name="cantidad_consumida" required><br>
    <input type="submit" value="Registrar Comida Consumida">
</form>
