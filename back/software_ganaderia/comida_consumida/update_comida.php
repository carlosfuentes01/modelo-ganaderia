<?php
include '../../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vacas_id_animal = $_POST['vacas_id_animal'];
    $inventario_id = $_POST['inventario_id'];
    $fecha_consumo = $_POST['fecha_consumo'];
    $cantidad_consumida = $_POST['cantidad_consumida'];

    $sql = "UPDATE comida_consumida SET 
            fecha_consumo='$fecha_consumo', 
            cantidad_consumida='$cantidad_consumida' 
            WHERE vacas_id_animal='$vacas_id_animal' AND inventario_id='$inventario_id'";

    if (mysqli_query($conexion, $sql)) {
        echo "Registro actualizado exitosamente";
    } else {
        echo "Error al actualizar el registro: " . mysqli_error($conexion);
    }
} else {
    $vacas_id_animal = $_GET['vacas_id_animal'] ?? null; 
    $inventario_id = $_GET['inventario_id'] ?? null; 

    if ($vacas_id_animal && $inventario_id) {
        $sql = "SELECT * FROM comida_consumida WHERE vacas_id_animal='$vacas_id_animal' AND inventario_id='$inventario_id'";
        $result = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            echo "Registro no encontrado.";
            exit; 
        }
    } else {
        echo "ID de animal o inventario no proporcionados.";
        exit; 
    }
}
?>


<?php if (isset($row)): ?>
<form method="POST" action="update_comida.php">
    <input type="hidden" name="vacas_id_animal" value="<?php echo htmlspecialchars($row['vacas_id_animal']); ?>">
    <input type="hidden" name="inventario_id" value="<?php echo htmlspecialchars($row['inventario_id']); ?>">
    Fecha de Consumo: <input type="date" name="fecha_consumo" value="<?php echo htmlspecialchars($row['fecha_consumo']); ?>" required>
    Cantidad Consumida: <input type="number" step="0.01" name="cantidad_consumida" value="<?php echo htmlspecialchars($row['cantidad_consumida']); ?>" required>
    <input type="submit" value="Actualizar">
</form>
<?php endif; ?>
