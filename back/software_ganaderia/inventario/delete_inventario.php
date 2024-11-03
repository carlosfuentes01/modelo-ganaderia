<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $usuario_dni = 1;

    $sql = "DELETE i FROM inventario i 
            JOIN comida_consumida c ON i.id = c.inventario_id 
            JOIN vacas v ON c.vacas_id_animal = v.id 
            JOIN potrero p ON v.potrero_id = p.id 
            JOIN finca f ON p.finca_id = f.id 
            JOIN usuario u ON f.usuario_dni = u.dni 
            WHERE u.dni = '$usuario_dni'";

    if ($conexion->query($sql) === TRUE) {
        echo "Inventario eliminado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
Nombre: <input type="text" name="nombre" required><br>
    <input type="submit" value="Eliminar Inventario">
</form>
