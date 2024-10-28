<?php
session_start();
include 'conexion.php';

// Verifica que el usuario esté autenticado y tenga un DNI en la sesión
if (!isset($_SESSION['dni'])) {
    echo "Error: Usuario no autenticado.";
    exit;
}

$dni_usuario = $_SESSION['dni'];

// Consulta para obtener la producción lechera asociada al usuario
$sql = "SELECT produccion_lechera.id_produccion, produccion_lechera.fecha, produccion_lechera.litros_leche, vacas.nombre AS nombre_vaca
             FROM produccion_lechera
             INNER JOIN vacas ON produccion_lechera.vacas_id = vacas.id
             INNER JOIN potrero ON vacas.potrero_id = potrero.id
             INNER JOIN finca ON potrero.finca_id = finca.id
             INNER JOIN usuario ON finca.usuario_dni = usuario.dni
             WHERE usuario.dni = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $dni_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    echo "<table border='1'>";
    echo "<tr><th>Fecha</th><th>Litros de leche</th><th>Nombre de la vaca</th><th>Acciones</th></tr>";
    while ($fila = $resultado->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $fila['fecha'] . "</td>";
        echo "<td>" . $fila['litros_leche'] . "</td>";
        echo "<td>" . $fila['nombre_vaca'] . "</td>";
        echo "<td>";
        
        // Formulario para el botón de actualización
        echo "<form action='update_produccion_lechera.php' method='GET' style='display:inline;'>";
        echo "<input type='hidden' name='id_produccion' value='" . $fila['id_produccion'] . "'>";
        echo "<button type='submit'>Actualizar</button>";
        echo "</form>";

        // Formulario para el botón de eliminación
        echo "<form action='delete_produccion_lechera.php' method='POST' style='display:inline;' onsubmit='return confirm(\"¿Estás seguro de eliminar este registro?\");'>";
        echo "<input type='hidden' name='id_produccion' value='" . $fila['id_produccion'] . "'>";
        echo "<button type='submit'>Eliminar</button>";
        echo "</form>";
        
        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "No se encontraron registros.";
}

$stmt->close();
?>
