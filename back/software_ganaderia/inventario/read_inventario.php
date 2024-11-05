<?php
include '../../conexion/conexion.php';

$sql = "SELECT * FROM inventario";
$result = mysqli_query($conexion, $sql);

echo "<table border='1'>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Cantidad</th>
    <th>Acciones</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
        <td>{$row['id']}</td>
        <td>{$row['nombre']}</td>
        <td>{$row['cantidad']}</td>
        <td>
            <a href='update_inventario.php?id={$row['id']}'>Editar</a> |
            <a href='delete_inventario.php?id={$row['id']}'>Eliminar</a>
        </td>
    </tr>";
}
echo "</table>";
?>
