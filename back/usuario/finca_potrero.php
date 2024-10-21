<?php

include '../conexion/conexion.php'; // Conexión a la base de datos
session_start();
// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_finca = $_POST['nombre_finca'];
    $nombre_potrero = $_POST['nombre_potrero'];
    $dni = $_SESSION['dni']; // DNI del usuario autenticado, guardado en la sesión

    // Inserta los datos de la finca
    $sql_finca = "INSERT INTO finca (usuario_dni, nombre) VALUES ('$dni', '$nombre_finca')";

    if ($conexion->query($sql_finca) === TRUE) {
        // Obtener el ID de la finca recién creada
        $finca_id = $conexion->insert_id;

        // Inserta los datos del potrero, relacionado con la finca recién creada
        $sql_potrero = "INSERT INTO potrero (finca_id, nombre) VALUES ('$finca_id', '$nombre_potrero')";

        if ($conexion->query($sql_potrero) === TRUE) {
            echo "Finca y potrero creados exitosamente! 
            ";
        } else {
            echo "Error al crear el potrero: " . $conexion->error;
        }
    } else {
        echo "Error al crear la finca: " . $conexion->error;
    }
}
?>

<!-- Formulario para crear una finca y un potrero -->
<h2>Crear Finca y Potrero</h2>
<form method="POST" action="">
    Nombre de la Finca: <input type="text" name="nombre_finca" required><br>
    Nombre del Potrero: <input type="text" name="nombre_potrero" required><br>
    <input type="submit" value="Crear Finca y Potrero">
</form>
