<?php 
include '../../conexion/conexion.php';
session_start();
$sesion = $_SESSION['dni'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lectura de Potreros</title>
</head>
<body>
<table id="example" class="mdl-data-table" style="width:100%">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Vacas totales</th>
            <th>Vacas preñadas</th>
            <th>Vacas enfermas</th>
            <th>Alimento Asignado</th>
            <th>Editar</th>
            <th>Borrar</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $sql3 = "SELECT potrero.id, potrero.nombre AS 'nombre_de_potrero', COUNT(vacas.id) AS cantidad 
                 FROM potrero 
                 LEFT JOIN vacas ON vacas.potrero_id = potrero.id 
                 WHERE potrero.finca_id IN (SELECT id FROM finca WHERE usuario_dni = $sesion)
                 GROUP BY potrero.id, potrero.nombre";
        $potreros = $conexion->query($sql3);

        while ($a = $potreros->fetch_assoc()) {
            ?>
            <tr>
                <td><?= $a['nombre_de_potrero'] ?></td>
                <td><?= $a['cantidad'] ?></td>
                
                <?php
                // Variables para almacenar valores obtenidos del procedimiento almacenado
                $nombre = $a['nombre_de_potrero'];
                $sqlpa1 = "SET @embarazadas_potrero = 0;";
                $query_pa1 = $conexion->query($sqlpa1);
                
                $sqlpa2 = "SET @enfermas_potrero = 0;";
                $query_pa2 = $conexion->query($sqlpa2);
                
                $sqlpa3 = "SET @comida_potrero = 0;";
                $query_pa3 = $conexion->query($sqlpa3);
                
                $sqlpa4 = "CALL brftiblxal2dldsiqbzr.tabla_potreros('$nombre', @embarazadas_potrero, @enfermas_potrero, @comida_potrero);";
                $query_pa4 = $conexion->query($sqlpa4);
                
                $sqlpa5 = "SELECT @embarazadas_potrero AS embarazadas, @enfermas_potrero AS enfermas, @comida_potrero AS comida;";
                $tabla = $conexion->query($sqlpa5);
                $resultado = $tabla->fetch_assoc();
                ?>
                
                <td><?= $resultado['embarazadas'] ?></td>
                <td><?= $resultado['enfermas'] ?></td>
                <td><?= $resultado['comida'] ?></td>
                
                <!-- Botones de editar y eliminar que pasan el ID del potrero en lugar del nombre -->
                <td>
                    <form method="POST" action="update_potrero.php" style="display:inline;">
                        <input type="hidden" name="id_potrero" value="<?= $a['id'] ?>">
                        <input type="submit" value="Editar">
                    </form>
                </td>
                <td>
                    <form method="POST" action="delete_potrero.php" style="display:inline;">
                        <input type="hidden" name="id_potrero" value="<?= $a['id'] ?>">
                        <input type="submit" value="Eliminar">
                    </form>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>
</body>
</html>
