<?php
include ''; // conexion a la base de datos

$sql = "SELECT * FROM animales";
$result = $conexion->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ID</th>
                <th>Identificación</th>
                <th>Nombre</th>
                <th>Fecha de Nacimiento</th>
                <th>Peso</th>
                <th>Estado de Salud</th>
                <th>Género</th>
                <th>Raza</th>
                <th>Acciones</th>
            </tr>";
    
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".$row["id_animal"]."</td>
                <td>".$row["identificacion"]."</td>
                <td>".$row["nombre"]."</td>
                <td>".$row["fecha_nacimiento"]."</td>
                <td>".$row["peso"]."</td>
                <td>".$row["estado_salud"]."</td>
                <td>".$row["genero"]."</td>
                <td>".$row["id_raza"]."</td>
                <td><a href='update.php?id_animal=".$row['id_animal']."'>Editar</a> |
                    <a href='delete.php?id_animal=".$row['id_animal']."'>Eliminar</a></td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros";
}
?>
