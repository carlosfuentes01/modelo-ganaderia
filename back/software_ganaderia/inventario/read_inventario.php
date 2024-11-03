<?php
include 'conexion.php';

$usuario_dni = 1; 
$sql = "SELECT i.id AS id_inventario, i.nombre, i.cantidad 
        FROM inventario i 
        JOIN comida_consumida c ON i.id = c.inventario_id 
        JOIN vacas v ON c.vacas_id_animal = v.id 
        JOIN potrero p ON v.potrero_id = p.id 
        JOIN finca f ON p.finca_id = f.id 
        JOIN usuario u ON f.usuario_dni = u.dni 
        WHERE u.dni = '$usuario_dni'";

$resultado = $conexion->query($sql);

if ($resultado->num_rows > 0) {
    while ($row = $resultado->fetch_assoc()) {
        echo "ID: " . $row['id_inventario'] . " - Nombre: " . $row['nombre'] . " - Cantidad: " . $row['cantidad'] . "<br>";
    }
} else {
    echo "No hay inventario registrado.";
}
?>

