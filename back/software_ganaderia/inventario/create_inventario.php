<?php
include '../../conexion/conexion.php';

// Obtener las fincas para el combo box
$sql_fincas = "SELECT id, nombre FROM finca";
$result_fincas = $conexion->query($sql_fincas);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $finca_id = $_POST['finca_id']; // ID de la finca seleccionado

    $sql = "INSERT INTO inventario (nombre, cantidad, finca_id_finca) VALUES ('$nombre', '$cantidad', '$finca_id')";
    if ($conexion->query($sql) === TRUE) {
        echo "Inventario agregado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="create_inventario.php">
    Nombre del Inventario: <input type="text" name="nombre" required><br>
    Cantidad: <input type="number" name="cantidad" required><br>
    Finca: 
    <select name="finca_id" required>
        <option value="">Selecciona una finca</option>
        <?php
        if ($result_fincas->num_rows > 0) {
            while($row = $result_fincas->fetch_assoc()) {
                echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
            }
        } else {
            echo "<option value=''>No hay fincas disponibles</option>";
        }
        ?>
    </select><br>
    <input type="submit" value="Agregar Inventario">
</form>
