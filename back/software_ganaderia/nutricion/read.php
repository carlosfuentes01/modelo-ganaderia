<?php
session_start();
include 'conexion.php';

if (isset($_SESSION['mensaje'])) {
    echo $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}

$sql = "SELECT * FROM comida_consumida";
$result = $conexion->query($sql);

echo "<h2>Lista de Comida Consumida</h2>";
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID Vaca</th><th>ID Inventario</th><th>Fecha Consumo</th><th>Cantidad Consumida</th><th>Acciones</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['vacas_id_animal']}</td>
                <td>{$row['inventario_id']}</td>
                <td>{$row['fecha_consumo']}</td>
                <td>{$row['cantidad_consumida']}</td>
                <td>
                    <a href='update_comida.php?vacas_id_animal={$row['vacas_id_animal']}&inventario_id={$row['inventario_id']}'>Editar</a> | 
                    <a href='delete_comida.php?vacas_id_animal={$row['vacas_id_animal']}&inventario_id={$row['inventario_id']}'>Eliminar</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros.";
}

$conexion->close();
?>
