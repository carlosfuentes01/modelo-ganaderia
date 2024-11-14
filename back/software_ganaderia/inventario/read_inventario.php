<?php
include '../../conexion/conexion.php';

$sql = "SELECT inventario.id, inventario.nombre, inventario.cantidad, finca.nombre AS nombre_finca
        FROM inventario
        JOIN finca ON inventario.finca_id_finca = finca.id";
$result = mysqli_query($conexion, $sql);

echo "<table border='1'>
<tr>
    <th>Nombre</th>
    <th>Cantidad</th>
    <th>Finca</th>
    <th>Acciones</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['nombre']}</td>
        <td>{$row['cantidad']}</td>
        <td>{$row['nombre_finca']}</td>
        <td>
            <a href='update_inventario.php?id={$row['id']}'>Editar</a> |
            <a href='delete_inventario.php?id={$row['id']}'>Eliminar</a>
        </td>
    </tr>";
}
echo "</table>";
?>
