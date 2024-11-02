<a href='create_personal.php'>Registrar Personal</a>
<?php
include '../../conexion/conexion.php'; 
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}
$sesion = $_SESSION['dni'];

// Obtener personal asignado a las fincas del usuario autenticado
$sql1 = "SELECT * FROM personal 
         WHERE dni IN (SELECT personal_dni FROM finca_has_personal 
                       WHERE finca_id IN (SELECT id FROM finca WHERE usuario_dni = $sesion))";
$personal = $conexion->query($sql1);

if ($personal->num_rows > 0) {
    echo "
    <table border='1'>
        <tr>
            <th>DNI</th>
            <th>Nombres</th>
            <th>Apellidos</th>
            <th>Trabajo Principal</th>
            <th>Finca Asignada</th>
            <th>Acciones</th>
        </tr>";
    
    // Iterar a través de los resultados de personal
    while($row = $personal->fetch_assoc()) {
        echo "<tr>
                <td>".$row["dni"]."</td>
                <td>".$row["nombres"]."</td>
                <td>".$row["apellidos"]."</td>
                <td>".$row["trabajo_principal"]."</td>
                <td>";
        
        // Obtener el nombre de la finca asociada
        $sql2 = "SELECT nombre FROM finca 
                 WHERE id IN (SELECT finca_id FROM finca_has_personal WHERE personal_dni = '".$row["dni"]."')";
        $finca_result = $conexion->query($sql2);
        
        // Mostrar el nombre de la finca o "Sin asignar" si no tiene finca
        if ($finca_result->num_rows > 0) {
            while ($finca = $finca_result->fetch_assoc()) {
                echo $finca['nombre'] . " ";
            }
        } else {
            echo "Sin asignar";
        }
        
        echo "</td>
              <td>
                <form method='POST' action='update_personal.php'>
                    <input type='hidden' name='dni' value='".$row['dni']."'>
                    <input type='submit' value='Editar'>
                </form> 
                <form method='POST' action='delete_personal.php'>
                    <input type='hidden' name='dni' value='".$row['dni']."'>
                    <input type='submit' value='Eliminar'>
                </form>
              </td>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros de personal asignado a sus fincas.";
}
?>
