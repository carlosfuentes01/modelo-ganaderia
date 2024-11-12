<!-- index.php -->
<?php
include '../../conexion/conexion.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Control de Embarazo</title>
</head>
<body>
    <div>
        <h2>Registros de Embarazo</h2>
        <a href="creacion_control_embarazo.php">Crear Registro de reproduccion</a>

        <!-- Tabla de registros -->
        <?php
        $sql = "SELECT * FROM control_embarazo";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Fecha de descubrimiento</th>
                            <th>Modo de concepción</th>
                            <th>Fecha pronosticada de parto</th>
                            <th>Fecha aproximada de parto</th>
                            <th>Descripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>";
            while($row = $result->fetch_assoc()) {
                $modo="SELECT * from modo_concepcion where id = $row[modo_concepcion] ";
                $concepcion=$conexion->query($modo);
                $nombre_modo_concepcion=$concepcion->fetch_assoc();
                echo "<tr>
                        <td>".$row["fecha_deteccion"]."</td>
                        <td>".$nombre_modo_concepcion["nombre_modo"]."</td>
                        <td>".$row["fecha_estimada_de_parto"]."</td>
                        <td>".$row["fecha_aproximada_parto"]."</td>
                        <td>".$row["descripcion"]."</td>
                        <td>
                    <form method='POST' action='Update.php' style='display:inline;'>
                        <input type='hidden' name='idcontrol_embarazo' value='" . $row['idcontrol_embarazo'] . "'>
                        <input type='submit' value='Editar'>
                    </form> |
                    <form method='POST' action='Delete.php' style='display:inline;'>
                        <input type='hidden' name='idcontrol_embarazo' value='" . $row['idcontrol_embarazo'] . "'>
                        <input type='submit' value='Eliminar'>
                    </form>
                </td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No hay registros de embarazo.</p>";
        }
        ?>