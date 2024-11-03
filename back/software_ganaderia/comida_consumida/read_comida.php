<?php
include 'conexion.php';

$usuario_dni = 1;

$sql = "SELECT v.identificacion AS vaca_identificacion, i.nombre AS inventario_nombre, 
               c.fecha_consumo, c.cantidad_consumida 
        FROM comida_consumida c 
        JOIN vacas v ON c.vacas_id_animal = v.id 
        JOIN inventario i ON c.inventario_id = i.id 
        JOIN potrero p ON v.potrero_id = p.id 
        JOIN finca f ON p.finca_id = f.id 
        JOIN usuario u ON f.usuario_dni = u.dni 
        WHERE u.dni = '$usuario_dni'";

$resultado = $conexion->query($sql);

while ($row = $resultado->fetch_assoc()) {
    echo "Identificación de la Vaca: " . $row['vaca_identificacion'] . " - Nombre del Inventario: " . $row['inventario_nombre'] . 
         " - Fecha de Consumo: " . $row['fecha_consumo'] . " - Cantidad Consumida: " . $row['cantidad_consumida'] . "<br>";
}
?>


