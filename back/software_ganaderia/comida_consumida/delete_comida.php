<?php
include '../../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['comida_id'])) {
    $comida_id = $_GET['comida_id'];

    // Ejecutamos la consulta para eliminar usando el ID único
    $sql = "DELETE FROM comida_consumida WHERE id='$comida_id'";

    if ($conexion->query($sql) === TRUE) {
        echo "Registro eliminado exitosamente.";
    } else {
        echo "Error al eliminar el registro: " . $conexion->error;
    }
} else {
    echo "ID de comida no proporcionado.";
}
?>

<a href="read_comida.php">Volver a la lista de registros de comida consumida</a>
