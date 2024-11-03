<?php
include 'conexion.php';


$vacas_result = $conexion->query("SELECT id, identificacion FROM vacas");


$inventarios_result = $conexion->query("SELECT id, nombre FROM inventario");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vacas_id_animal = $_POST['vacas_id_animal'];
    $inventario_id = $_POST['inventario_id'];
    $fecha_consumo = $_POST['fecha_consumo'];
    $cantidad_consumida = $_POST['cantidad_consumida'];
    $usuario_dni = 1; 

    $sql = "UPDATE comida_consumida c
            JOIN vacas v ON c.vacas_id_animal = v.id
            JOIN potrero p ON v.potrero_id = p.id
            JOIN finca f ON p.finca_id = f.id
            JOIN usuario u ON f.usuario_dni = u.dni
            SET c.inventario_id = '$inventario_id', 
                c.fecha_consumo = '$fecha_consumo', 
                c.cantidad_consumida = '$cantidad_consumida'
            WHERE c.vacas_id_animal = '$vacas_id_animal' 
              AND u.dni = '$usuario_dni'";

    if ($conexion->query($sql) === TRUE) {
        echo "Consumo de comida actualizado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>


<form method="POST" action="">
    Identificación de la Vaca: 
    <select name="vacas_id_animal" required>
        <?php while ($vaca = $vacas_result->fetch_assoc()) { ?>
            <option value="<?php echo $vaca['id']; ?>">
                <?php echo $vaca['identificacion']; ?>
            </option>
        <?php } ?>
    </select>
    <br>
    
    Nombre del Inventario: 
    <select name="inventario_id" required>
        <?php while ($inventario = $inventarios_result->fetch_assoc()) { ?>
            <option value="<?php echo $inventario['id']; ?>">
                <?php echo $inventario['nombre']; ?>
            </option>
        <?php } ?>
    </select>
    <br>
    
    Fecha de Consumo: <input type="date" name="fecha_consumo" required><br>
    Cantidad Consumida: <input type="number" step="0.01" name="cantidad_consumida" required><br>
    <input type="submit" value="Actualizar Consumo de Comida">
</form>
