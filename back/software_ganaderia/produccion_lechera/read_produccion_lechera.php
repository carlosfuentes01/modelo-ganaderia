<a href='create_produccion_lechera.php'>Registrar producción lechera</a>
<?php
include '../../conexion/conexion.php'; 
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

$sesion = $_SESSION['dni'];

// Consulta para obtener registros de producción lechera relacionados con el usuario
$sql1 = "SELECT produccion_lechera.*, vacas.nombre AS nombre_vaca, potrero.nombre AS nombre_potrero, finca.nombre AS nombre_finca
         FROM produccion_lechera
         INNER JOIN vacas ON produccion_lechera.vacas_id = vacas.id
         INNER JOIN potrero ON vacas.potrero_id = potrero.id
         INNER JOIN finca ON potrero.finca_id = finca.id
         WHERE finca.usuario_dni = $sesion";

$producciones = $conexion->query($sql1);

if ($producciones->num_rows > 0) {
    echo "
    <table border='1'>
        <tr>
            <th>Litros producidos</th>
            <th>Fecha de producción</th>
            <th>Vaca</th>
            <th>Potrero</th>
            <th>Finca</th>
            <th>Acciones</th>
        </tr>";
    
    while ($row = $producciones->fetch_assoc()) {
        echo "<tr>
                <td>".$row["litros_leche"]."</td>
                <td>".$row["fecha"]."</td>
                <td>".$row["nombre_vaca"]."</td>
                <td>".$row["nombre_potrero"]."</td>
                <td>".$row["nombre_finca"]."</td>
                <td>
                    <form method='POST' action='update_produccion_lechera.php'>
                        <input type='hidden' name='id_produccion' required value=".$row['id_produccion'].">
                        <input type='submit' value='Editar'>
                    </form> 
                    <form method='POST' action='delete_produccion_lechera.php'>
                        <input type='hidden' name='id_produccion' required value=".$row['id_produccion'].">
                        <input type='submit' value='Eliminar'>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros de producción lechera";
}
?>
