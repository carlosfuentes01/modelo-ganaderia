<a href='create_tratamiento.php'>Crear tratamiento</a>
<?php
include '../../conexion/conexion.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

// Consulta principal para obtener todos los tratamientos, incluyendo las enfermedades asociadas
$sql_tratamientos = "SELECT tratamiento.*, enfermedades.tipo AS tipo_enfermedad 
                     FROM tratamiento
                     LEFT JOIN enfermedades ON tratamiento.enfermedades_idenfermedades = enfermedades.idenfermedades";
$tratamientos = $conexion->query($sql_tratamientos);

if ($tratamientos->num_rows > 0) {
    ?>
    <table>
            <tr>
                <th>ID Tratamiento</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Horarios de Aplicación</th>
                <th>Nombre</th>
                <th>Enfermedad Asociada</th>
                <th>Acciones</th>
            </tr>

            <?php

    while ($row = $tratamientos->fetch_assoc()) {
        ?><tr>
                <td><?= $row["idtratamiento"] ?></td>
                <td><?=$row["tipo"] ?></td>
                <td><?=$row["descripcion"] ?></td>
                <td><?=$row["horarios_aplicacion"] ?></td>
                <td><?=$row["nombre"] ?></td>
                <td><?=($row["tipo_enfermedad"] ? $row["tipo_enfermedad"] : "No asociada") ?></td>
                <td>
                    <form method='POST' action='update_tratamiento.php' style='display:inline;'>
                        <input type='hidden' name='idtratamiento' value='<?= $row['idtratamiento'] ?>'>
                        <input type='submit' value='Editar'>
                    </form> |
                    <form method='POST' action='delete_tratamiento.php' style='display:inline;'>
                        <input type='hidden' name='idtratamiento' value='<?= $row['idtratamiento']?>'>
                        <input type='submit' value='Eliminar'>
                    </form>
                </td>
              </tr>

              <?php
    }
    ?></table>
    <?php
} else {
    echo "No hay registros de tratamientos.";
}
?>
