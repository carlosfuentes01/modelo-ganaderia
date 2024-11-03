<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $usuario_dni = 1;

    $sql = "UPDATE inventario i 
            JOIN comida_consumida c ON i.id = c.inventario_id 
            JOIN vacas v ON c.vacas_id_animal = v.id 
            JOIN potrero p ON v.potrero_id = p.id 
            JOIN finca f ON p.finca_id = f.id 
            JOIN usuario u ON f.usuario_dni = u.dni 
            SET i.nombre = '$nombre', i.cantidad = '$cantidad' 
            WHERE u.dni = '$usuario_dni'";

    if ($conexion->query($sql) === TRUE) {
        echo "Inventario actualizado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
    Nombre: <input type="text" name="nombre" required><br>
    Cantidad: <input type="number" name="cantidad" required><br>
    <input type="submit" value="Actualizar Inventario">
</form>

