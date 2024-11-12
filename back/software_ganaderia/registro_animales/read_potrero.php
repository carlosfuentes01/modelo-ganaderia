<?php include '../../conexion/conexion.php';
    session_start();
    $sesion = $_SESSION['dni'];
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                <tr style='display: none'>
                    <td>Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>320800</td>
                    <td>320800</td>
                    <td>320800</td>
                    <td>320800</td>
                </tr>
                <tr>
                    <?php
                    $sql3 = "SELECT count(*) as cantidad ,potrero.nombre as 'nombre de potrero' FROM potrero join vacas on vacas.potrero_id = potrero.id where finca_id in(select id from finca where usuario_dni = $sesion)";
                    $potreros = $conexion->query($sql3);

                    while ($a = $potreros->fetch_assoc()) {
                       ?><tr>

                        <td><?= $a['nombre de potrero'] ?></td>
                        <td><?= $a['cantidad'] ?></td>
                        <?php
                        $nombre = $a['nombre de potrero'];
                        $sqlpa1 = "set @embarazadas_potrero = 0";
                        $query_pa1=$conexion->query($sqlpa1);
                        $sqlpa2="set @enfermas_potrero = 0;";
                        $query_pa2=$conexion->query($sqlpa2);
                        $sqlpa3="set @comida_potrero = 0;";
                        $query_pa3=$conexion->query($sqlpa3);
                        $sqlpa4="call brftiblxal2dldsiqbzr.tabla_potreros('$nombre'  , @embarazadas_potrero, @enfermas_potrero, @comida_potrero);";
                        $query_pa4=$conexion->query($sqlpa4);
                        $sqlpa5 = "select @embarazadas_potrero as embarazadas, @enfermas_potrero as enfermas, @comida_potrero as comida;";
                        $tabla = $conexion->query($sqlpa5);
                        $resultado = $tabla->fetch_assoc();

                        ?>
                        <td><?= $resultado['embarazadas'] ?> </td>
                         <td><?=$resultado['enfermas'] ?></td>
                         <td><?=$resultado['comida'] ?></td>
                         <td> eliminar</td>
                         <td> editar </td>
                        </tr>
                        <?php
                    }



                    ?>
                </tr>
            </tbody>
        </table>
</body>
</html>