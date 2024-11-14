<?php
include '../../conexion/conexion.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Obtener el inventario junto con el nombre de la finca
    $sql = "SELECT inventario.id, inventario.nombre, inventario.cantidad, inventario.finca_id_finca, finca.nombre AS nombre_finca 
            FROM inventario
            JOIN finca ON inventario.finca_id_finca = finca.id
            WHERE inventario.id='$id'";
    $result = mysqli_query($conexion, $sql);

    // Obtener todas las fincas para el combo box
    $sql_fincas = "SELECT id, nombre FROM finca";
    $result_fincas = mysqli_query($conexion, $sql_fincas);

    if ($row = mysqli_fetch_assoc($result)) {
        echo '<form method="POST" action="update_inventario.php">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo 'Nombre del Inventario: <input type="text" name="nombre" value="' . htmlspecialchars($row['nombre']) . '" required><br>';
        echo 'Cantidad: <input type="number" name="cantidad" value="' . $row['cantidad'] . '" required><br>';

        // Combo box para seleccionar la finca
        echo 'Finca: <select name="finca_id" required>';
        echo '<option value="">Selecciona una finca</option>';
        while ($finca = mysqli_fetch_assoc($result_fincas)) {
            $selected = $finca['id'] == $row['finca_id_finca'] ? 'selected' : '';
            echo "<option value='" . $finca['id'] . "' $selected>" . $finca['nombre'] . "</option>";
        }
        echo '</select><br>';

        echo '<input type="submit" value="Actualizar Inventario">';
        echo '</form>';
    } else {
        echo "No se encontró el inventario con ID $id.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $finca_id = $_POST['finca_id'];

    // Actualizar inventario con el nuevo nombre, cantidad y finca
    $sql = "UPDATE inventario SET nombre='$nombre', cantidad='$cantidad', finca_id_finca='$finca_id' WHERE id='$id'";
    if (mysqli_query($conexion, $sql)) {
        echo "Inventario actualizado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }
} else {
    echo "ID del inventario no especificado.";
}
?>

