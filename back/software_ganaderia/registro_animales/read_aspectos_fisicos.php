<a href='create_aspectos_fisicos.php'>Crear Aspecto Físico</a>

<?php
include '../../conexion/conexion.php';
session_start();

if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/login.php");
    exit;
}
$sesion = $_SESSION['dni'];

// Consulta para obtener los aspectos físicos de las vacas en las fincas asociadas al usuario
$sql1 = "
    SELECT af.id AS aspecto_id, af.peso, af.fecha_descripcion, af.condicion_corporal, af.descripcion,
           v.identificacion AS vaca_identificacion, v.nombre AS vaca_nombre,
           c.categoria AS categoria_crecimiento
    FROM aspectos_fisicos af
    INNER JOIN vacas v ON af.id_vaca = v.id
    INNER JOIN crecimiento c ON af.crecimiento_id_crecimiento = c.id_crecimiento
    INNER JOIN potrero p ON v.potrero_id = p.id
    INNER JOIN finca f ON p.finca_id = f.id
    WHERE f.usuario_dni = '$sesion'
";
$aspectos = $conexion->query($sql1);

if ($aspectos->num_rows > 0) {
    ?>
    <table>
        <tr>
            <th>Vaca (Identificación)</th>
            <th>Nombre de la Vaca</th>
            <th>Peso KG</th>
            <th>Fecha de Descripción</th>
            <th>Condición Corporal</th>
            <th>Descripción</th>
            <th>Categoría de Crecimiento</th>
            <th>Acciones</th>
        </tr>
    <?php
    while ($row = $aspectos->fetch_assoc()) {
        ?> 
        <tr>
            <td><?=$row["vaca_identificacion"]?></td>
            <td><?=$row["vaca_nombre"]?></td>
            <td><?=$row["peso"]?></td>
            <td><?=$row["fecha_descripcion"]?></td>
            <td><?=$row["condicion_corporal"]?></td>
            <td><?=$row["descripcion"]?></td>
            <td><?=$row["categoria_crecimiento"]?></td>
            <td>
                <form method='POST' action='update_aspectos_fisicos.php' style='display:inline;'>
                    <input type='hidden' name='aspecto_id' value='<?=$row['aspecto_id']?>'>
                    <input type='submit' value='Editar'>
                </form> 
                <form method='POST' action='delete_aspectos_fisicos.php' style='display:inline;'>
                    <input type='hidden' name='aspecto_id' value='<?=$row['aspecto_id']?>'>
                    <input type='submit' value='Eliminar'>
                </form>
            </td>
        </tr>
        <?php
    }
    ?></table>
    <?php
} else {
    echo "No hay registros de aspectos físicos.";
}
?>
