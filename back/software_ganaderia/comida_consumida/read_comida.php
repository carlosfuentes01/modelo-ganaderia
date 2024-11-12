<?php
include '../../conexion/conexion.php';

$sql = "SELECT * FROM comida_consumida";
$result = mysqli_query($conexion, $sql);

?><table>
<tr>
    <th>ID Vaca</th>
    <th>ID Inventario</th>
    <th>Fecha Consumo</th>
    <th>Cantidad Consumida</th>
    <th>Acciones</th>
</tr>

<?php

while ($row = mysqli_fetch_assoc($result)) {
    ?><tr>
        <td><?=$row['vacas_id_animal']?></td>
        <td><?=$row['inventario_id']?></td>
        <td><?=$row['fecha_consumo']?></td>
        <td><?=$row['cantidad_consumida']?></td>
        <td>

        </td>
    </tr>
    <?php
}
?>
</table>
