<?php
include 'conect.php';

$sesion = $_SESSION['dni'];

$sql = "select p.id_produccion, p.fecha, p.litros_leche, p.vacas_id from produccion_lechera p join vacas v on p.vacas_id = v.id
join finca f on v.finca_id = f.id join usuario u on f.usuario_dni = u.dni
where u.dni=$sesion ";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID_Produccion</th>
                <th>Fecha</th>
                <th>Litros leche</th>
                <th>id_vaca</th>
                <th>Acciones</th>
            </tr>";
    
    while($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>".$fila["id_produccion"]."</td>
                <td>".$fila["fecha"]."</td>
                <td>".$fila["litros_leche"]."</td>
                <td>".$fila["vacas_id"]."</td>
                <td><a href='update_produccion_lechera.php?id_produccion=".$fila['id_produccion']."'>Editar</a> |
                    <a href='delete_produccion_lechera.php?id_produccion=".$fila['id_produccion']."'>Eliminar</a></td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros";
}
?>
