<!-- index.php -->
<?php
include '../../conexion/conexion.php';
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Control de Embarazo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Registros de Embarazo</h2>
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#registroModal">
            Nuevo Registro
        </button>

        <!-- Tabla de registros -->
        <?php
        $sql = "SELECT * FROM control_embarazo";
        $result = $conexion->query($sql);
        if ($result->num_rows > 0) {
            echo "<table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Raza</th>
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
                echo "<tr>
                        <td>".$row["codigo"]."</td>
                        <td>".$row["raza"]."</td>
                        <td>".$row["fecha_deteccion"]."</td>
                        <td>".$row["modo_concepcion"]."</td>
                        <td>".$row["fecha_estimada_de_parto"]."</td>
                        <td>".$row["fecha_aproximada_parto"]."</td>
                        <td>".$row["descripcion"]."</td>
                        <td>
                            <button class='btn btn-sm btn-warning' onclick='editarRegistro(".$row["idcontrol_embarazo"].")'>Editar</button>
                            <button class='btn btn-sm btn-danger' onclick='eliminarRegistro(".$row["idcontrol_embarazo"].")'>Eliminar</button>
                        </td>
                    </tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<p>No hay registros de embarazo.</p>";
        }
        ?>