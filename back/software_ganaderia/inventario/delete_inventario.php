<?php
include '../../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    if (!empty($id) && is_numeric($id)) {
        $sql = "DELETE FROM inventario WHERE id='$id'";

        if ($conexion->query($sql) === TRUE) {
            echo "Inventario eliminado exitosamente.";
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
    } else {
        echo "ID inválido.";
    }
}
?>

<form method="POST" action="">
    ID: <input type="number" name="id" required><br>
    <input type="submit" value="Eliminar Inventario">
</form>
