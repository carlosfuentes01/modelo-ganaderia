<?php
session_start();
include 'conexion.php';

// Verifica que el usuario esté autenticado y tenga un DNI en la sesión
if (!isset($_SESSION['dni'])) {
    echo "Error: Usuario no autenticado.";
    exit;
}

$dni_usuario = $_SESSION['dni'];

// Consulta para obtener las vacas asociadas a la finca y potrero del usuario autenticado
$consulta_vacas = "SELECT vacas.id, vacas.nombre 
                   FROM vacas
                   INNER JOIN potrero ON vacas.potrero_id = potrero.id
                   INNER JOIN finca ON potrero.finca_id = finca.id
                   INNER JOIN usuario ON finca.usuario_dni = usuario.dni
                   WHERE usuario.dni = ?";

$stmt = $conexion->prepare($consulta_vacas);
$stmt->bind_param("s", $dni_usuario);
$stmt->execute();
$resultado_vacas = $stmt->get_result();

// Verificar si hay vacas disponibles para este usuario
$vacas_disponibles = "";
if ($resultado_vacas->num_rows > 0) {
    while ($fila = $resultado_vacas->fetch_assoc()) {
        $vacas_disponibles .= "<option value='{$fila['id']}'>{$fila['nombre']}</option>";
    }
} else {
    echo "No hay vacas asociadas a este usuario.";
    exit;
}

$stmt->close();

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $litros_leche = $_POST['litros_leche'];
    $vacas_id = $_POST['vacas_id'];

    // Insertar la producción lechera
    $sql = "INSERT INTO produccion_lechera (fecha, litros_leche, vacas_id) 
            VALUES ('$fecha', '$litros_leche', '$vacas_id')";
    

    if ($conexion->query($sql) === TRUE) {
        echo "Registro exitoso!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }

}
?>

<form method="POST" action="">
    Fecha: <input type="date" name="fecha" required><br>
    Litros de leche: <input type="text" name="litros_leche" required><br>
    ID de la vaca: 
    <select name="vacas_id" required>
        <option value="">Seleccione una vaca</option>
        <?php echo $vacas_disponibles; ?>
    </select><br>
    <input type="submit" value="Registrar">
</form>
