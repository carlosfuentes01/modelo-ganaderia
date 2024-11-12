<?php
session_start();
include 'conexion.php';

if (isset($_SESSION['mensaje'])) {
    echo $_SESSION['mensaje'];
    unset($_SESSION['mensaje']);
}

$sql = "SELECT * FROM comida_consumida";
$result = $conexion->query($sql);

?>
<h2>Lista de Comida Consumida</h2>

<?php
if ($result->num_rows > 0) {
     ?>
     <table ><tr><th>ID Vaca</th><th>ID Inventario</th><th>Fecha Consumo</th><th>Cantidad Consumida</th><th>Acciones</th></tr>

     <?php
    while ($row = $result->fetch_assoc()) {
        ?>
                <td><?=$row['vacas_id_animal']?></td>
                <td><?=$row['inventario_id']?></td>
                <td><?=$row['fecha_consumo']?></td>
                <td><?=$row['cantidad_consumida']?></td>
                <td>
                    
                </td>
              </tr>

              <?php
    }
    ?>
    </table>
    <?php
} else {
    echo "No hay registros.";
}

$conexion->close();
?>
