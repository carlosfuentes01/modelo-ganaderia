<?php
include '../../conexion/conexion.php';

$sql = "SELECT * FROM inventario";
$result = mysqli_query($conexion, $sql);

?> <table >
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Cantidad</th>
    <th>Acciones</th>
</tr>
<?php
while ($row = mysqli_fetch_assoc($result)) {
    ?><tr>
        <td><?=$row['id']?></td>
        <td><?=$row['nombre']?></td>
        <td><?=$row['cantidad']?></td>
        <td>

        </td>
    </tr>
    <?php
}
?>
</table>

