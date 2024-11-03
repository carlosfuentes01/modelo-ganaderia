<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vacas_id_animal = $_POST['vacas_id_animal'];
    $fecha_consumo = $_POST['fecha_consumo'];
    $cantidad_consumida = $_POST['cantidad_consumida'];
    $inventario_id = $_POST['inventario_id'];
    $usuario_dni = $_SESSION['dni'];


    $sql = "DELETE c FROM comida_consumida c 
            JOIN vacas v ON c.vacas_id_animal = v.id 
            JOIN potrero p ON v.potrero_id = p.id 
            JOIN finca f ON p.finca_id = f.id 
            JOIN usuario u ON f.usuario_dni = u.dni 
            WHERE c.vacas_id_animal = '$vacas_id_animal' 
            AND c.fecha_consumo = '$fecha_consumo' 
            AND c.cantidad_consumida = '$cantidad_consumida' 
            AND c.inventario_id = '$inventario_id' 
            AND u.dni = '$usuario_dni'";

    if ($conexion->query($sql) === TRUE) {
        echo "Consumo de comida eliminado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>


<form method="POST" action="">
    ID de Vaca: <input type="text" name="vacas_id_animal" required><br>

    Fecha de Consumo: <input type="date" name="fecha_consumo" required><br>

    Cantidad Consumida: <input type="number" name="cantidad_consumida" required><br>

    Inventario: 
    <select name="inventario_id" required>
        <?php
  
        $sql_inventarios = "SELECT id, nombre FROM inventario";
        $result_inventarios = $conexion->query($sql_inventarios);

        while ($row_inventario = $result_inventarios->fetch_assoc()) {
            echo "<option value='" . $row_inventario['id'] . "'>" . $row_inventario['nombre'] . "</option>";
        }
        ?>
    </select><br>

    <input type="submit" value="Eliminar Consumo de Comida">
</form>


