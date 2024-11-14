<?php
include '../../conexion/conexion.php';

$sql = "SELECT comida_consumida.id AS comida_id, comida_consumida.vacas_id_animal, comida_consumida.inventario_id, comida_consumida.fecha_consumo, comida_consumida.cantidad_consumida,
               vacas.identificacion AS identificacion_vaca, inventario.nombre AS nombre_inventario
        FROM comida_consumida
        JOIN vacas ON comida_consumida.vacas_id_animal = vacas.id
        JOIN inventario ON comida_consumida.inventario_id = inventario.id";

$result = mysqli_query($conexion, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1'>
    <tr>
        <th>Identificación de la Vaca</th>
        <th>Nombre del Inventario</th>
        <th>Fecha Consumo</th>
        <th>Cantidad Consumida</th>
        <th>Acciones</th>
    </tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
            <td>" . $row['identificacion_vaca'] . "</td>
            <td>" . $row['nombre_inventario'] . "</td>
            <td>" . $row['fecha_consumo'] . "</td>
            <td>" . $row['cantidad_consumida'] . "</td>
            <td>
                <a href='update_comida.php?comida_id=" . $row['comida_id'] . "'>Editar</a> |
                <a href='delete_comida.php?comida_id=" . $row['comida_id'] . "'>Eliminar</a>
            </td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros disponibles.";
}

mysqli_close($conexion);
?>

