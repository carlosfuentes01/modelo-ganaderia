<?php
session_start();
include 'conexion.php';

// Verifica que el usuario esté autenticado y tenga un DNI en la sesión
if (!isset($_SESSION['dni'])) {
    echo "Error: Usuario no autenticado.";
    exit;
}

$id_produccion = $_GET['id_produccion'];
$dni_usuario = $_SESSION['dni'];

// Obtener el registro actual de producción lechera
$consulta = "SELECT * FROM produccion_lechera WHERE id_produccion = ?";
$stmt = $conexion->prepare($consulta);
$stmt->bind_param("i", $id_produccion);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
} else {
    echo "Registro no encontrado.";
    exit;
}

$stmt->close();

// Obtener la lista de vacas disponibles para el usuario
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

$vacas_disponibles = "";
while ($vaca = $resultado_vacas->fetch_assoc()) {
    $selected = ($vaca['id'] == $fila['vacas_id']) ? "selected" : "";
    $vacas_disponibles .= "<option value='{$vaca['id']}' $selected>{$vaca['nombre']}</option>";
}

$stmt->close();

// Procesar el formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fecha = $_POST['fecha'];
    $litros_leche = $_POST['litros_leche'];
    $vacas_id = $_POST['vacas_id']; // ID de la vaca seleccionada

    // Validar que los datos no estén vacíos
    if (!empty($fecha) && !empty($litros_leche) && !empty($vacas_id)) {
        // Actualizar el registro
        $sql = "UPDATE produccion_lechera SET fecha = ?, litros_leche = ?, vacas_id = ? WHERE id_produccion = ?";
        $stmt = $conexion->prepare($sql);
        
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $conexion->error;
            exit;
        }

        $stmt->bind_param("sdii", $fecha, $litros_leche, $vacas_id, $id_produccion);

        if ($stmt->execute()) {
            echo "Registro actualizado exitosamente!";
            // Redirigir a la página de lista después de la actualización
            header("Location: read_produccion_lechera.php"); 
            exit;
        } else {
            echo "Error al actualizar el registro: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Por favor, complete todos los campos.";
    }
}
?>

<form method="POST">
    Fecha: <input type="date" name="fecha" value="<?php echo $fila['fecha']; ?>" required><br>
    Litros de leche: <input type="text" name="litros_leche" value="<?php echo $fila['litros_leche']; ?>" required><br>
    Vaca: 
    <select name="vacas_id" required>
        <?php echo $vacas_disponibles; ?>
    </select><br>
    <input type="submit" value="Actualizar">
</form>
