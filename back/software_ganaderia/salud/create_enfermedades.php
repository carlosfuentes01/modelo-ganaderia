<?php
include '../../conexion/conexion.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $posible_causa = $_POST['posible_causa'];
    $sintomas = $_POST['sintomas'];
    $transmisible = isset($_POST['transmisible']) ? 1 : 0;

    // Inserción en la tabla enfermedades
    $sql = "INSERT INTO enfermedades (tipo, descripcion, posible_causa, sintomas, transmisible)
            VALUES ('$tipo', '$descripcion', '$posible_causa', '$sintomas', $transmisible)";

    if ($conexion->query($sql) === TRUE) {
        echo "Registro de enfermedad exitoso!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
    Tipo: <input type="text" name="tipo" required><br>
    Descripción: <textarea name="descripcion" required></textarea><br>
    Posibles Causas: <input type="text" name="posible_causa" required><br>
    Síntomas: <input type="text" name="sintomas" required><br>
    Transmisible:
    <input type="checkbox" name="transmisible" value="1"><br>
    <input type="submit" value="Registrar">
</form>
<a href="read_enfermedades.php">Regresar a la lista de enfermedades</a>
