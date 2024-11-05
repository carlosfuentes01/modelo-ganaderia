<?php
include '../../conexion/conexion.php';


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    

    $sql = "SELECT * FROM inventario WHERE id='$id'";
    $result = mysqli_query($conexion, $sql);


    if ($row = mysqli_fetch_assoc($result)) {
    
        echo '<form method="POST" action="update_inventario.php">';
        echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
        echo 'Nombre del Inventario: <input type="text" name="nombre" value="' . htmlspecialchars($row['nombre']) . '" required><br>';
        echo 'Cantidad: <input type="number" name="cantidad" value="' . $row['cantidad'] . '" required><br>';
        echo '<input type="submit" value="Actualizar Inventario">';
        echo '</form>';
    } else {
        echo "No se encontró el inventario con ID $id.";
    }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];

    $sql = "UPDATE inventario SET nombre='$nombre', cantidad='$cantidad' WHERE id='$id'";
    if (mysqli_query($conexion, $sql)) {
        echo "Inventario actualizado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }
} else {
    echo "ID del inventario no especificado.";
}
?>
