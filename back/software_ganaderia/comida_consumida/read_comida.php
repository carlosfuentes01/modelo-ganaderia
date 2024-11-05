<?php
include '../../conexion/conexion.php';

$sql = "SELECT * FROM comida_consumida";
$result = mysqli_query($conexion, $sql);

echo "<table border='1'>
<tr>
    <th>ID Vaca</th>
    <th>ID Inventario</th>
    <th>Fecha Consumo</th>
    <th>Cantidad Consumida</th>
    <th>Acciones</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
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
?>
