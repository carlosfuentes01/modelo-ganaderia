<?php
include '../../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comida_id = $_POST['comida_id'];
    $vaca_identificacion = $_POST['vaca_identificacion'];
    $inventario_id = $_POST['inventario_id'];
    $fecha_consumo = $_POST['fecha_consumo'];
    $cantidad_consumida = $_POST['cantidad_consumida'];

    // Obtener el ID de la vaca basado en la identificación ingresada
    $vaca_query = "SELECT id FROM vacas WHERE identificacion='$vaca_identificacion'";
    $vaca_result = mysqli_query($conexion, $vaca_query);
    $vaca_row = mysqli_fetch_assoc($vaca_result);

    if ($vaca_row) {
        $vacas_id_animal = $vaca_row['id'];

        // Actualiza el registro de comida consumida con el nuevo ID de la vaca
        $sql = "UPDATE comida_consumida SET 
                vacas_id_animal='$vacas_id_animal', 
                inventario_id='$inventario_id', 
                fecha_consumo='$fecha_consumo', 
                cantidad_consumida='$cantidad_consumida' 
                WHERE id='$comida_id'";

        if (mysqli_query($conexion, $sql)) {
            echo "Registro actualizado exitosamente";
        } else {
            echo "Error al actualizar el registro: " . mysqli_error($conexion);
        }
    } else {
        echo "Identificación de vaca no válida.";
    }

} else {
    $comida_id = $_GET['comida_id'] ?? null;

    if ($comida_id) {
        // Obtener el registro actual
        $sql = "SELECT comida_consumida.*, vacas.identificacion AS identificacion_vaca, inventario.nombre AS nombre_inventario
                FROM comida_consumida
                JOIN vacas ON comida_consumida.vacas_id_animal = vacas.id
                JOIN inventario ON comida_consumida.inventario_id = inventario.id
                WHERE comida_consumida.id = '$comida_id'";

        $result = mysqli_query($conexion, $sql);
        
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "Registro no encontrado.";
            exit;
        }

        // Consulta para obtener la lista de inventarios
        $inventarios = mysqli_query($conexion, "SELECT id, nombre FROM inventario");
    } else {
        echo "ID de comida no proporcionado.";
        exit;
    }
}
?>

<?php if (isset($row)): ?>
<form method="POST" action="update_comida.php">
    <input type="hidden" name="comida_id" value="<?php echo $row['id']; ?>">

    <label for="vaca_identificacion">Identificación de la Vaca:</label>
    <input type="text" name="vaca_identificacion" value="<?php echo $row['identificacion_vaca']; ?>" required><br>

    <label for="inventario_id">Nombre del Inventario:</label>
    <select name="inventario_id" required>
        <?php while ($inventario = mysqli_fetch_assoc($inventarios)) : ?>
            <option value="<?php echo $inventario['id']; ?>" <?php echo ($inventario['id'] == $row['inventario_id']) ? 'selected' : ''; ?>>
                <?php echo $inventario['nombre']; ?>
            </option>
        <?php endwhile; ?>
    </select><br>

    <label for="fecha_consumo">Fecha de Consumo:</label>
    <input type="date" name="fecha_consumo" value="<?php echo $row['fecha_consumo']; ?>" required><br>

    <label for="cantidad_consumida">Cantidad Consumida:</label>
    <input type="number" step="0.01" name="cantidad_consumida" value="<?php echo $row['cantidad_consumida']; ?>" required><br>

    <input type="submit" value="Actualizar">
</form>
<?php endif; ?>
