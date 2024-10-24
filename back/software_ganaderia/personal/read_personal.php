<?php
include ' ';//conexion a la base de datos

$sql = "select p.* from personal p join finca_has_personal fp 
on p.dni = fp.personal_dni join finca f on fp.finca_id=f.id 
where f.usuario_dni = $_SESSION";
$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>DNI</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Tarea</th>
                <th>Acciones</th>
            </tr>";
    
    while($fila = $resultado->fetch_assoc()) {
        echo "<tr>
                <td>".$fila["dni"]."</td>
                <td>".$fila["nombres"]."</td>
                <td>".$fila["apellidos"]."</td>
                <td>".$fila["tarea"]."</td>
                <td><a href='update_personal.php?dni=".$fila['dni']."'>Editar</a> |
                    <a href='delete_personal.php?dni=".$fila['dni']."'>Eliminar</a></td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros";
}
?>
