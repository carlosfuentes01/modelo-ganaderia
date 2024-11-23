<?php

include '../conexion/conexion.php'; // Conexión a la base de datos
session_start();
// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_finca = $_POST['finca'];
    $nombre_potrero = $_POST['potrero'];
    $dni = $_SESSION['dni']; // DNI del usuario autenticado, guardado en la sesión

    // Inserta los datos de la finca
    $sql_finca = "INSERT INTO finca (usuario_dni, nombre) VALUES ('$dni', '$nombre_finca')";

    if ($conexion->query($sql_finca) === TRUE) {
        // Obtener el ID de la finca recién creada
        $finca_id = $conexion->insert_id;

        // Inserta los datos del potrero, relacionado con la finca recién creada
        $sql_potrero = "INSERT INTO potrero (finca_id, nombre) VALUES ('$finca_id', '$nombre_potrero')";

        if ($conexion->query($sql_potrero) === TRUE) {
            header("Location: ../software_ganaderia/registro_animales/read.php"); // Redirige a la página de usuario
           
            
        } else {
            echo "Error al crear el potrero: " . $conexion->error;
        }
    } else {
        echo "Error al crear la finca: " . $conexion->error;
    }
}
?>

<!-- Formulario para crear una finca y un potrero -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Primerizo Cowally</title>
</head>
<body >
<form method="POST" action="">
            <h1 >Crear Finca y Potrero</h1>
            <p>Finca</p>
                <input type="text" name="finca"  placeholder="nombre de finca"  required>
            <p>Potrero</p> 
                <input type="text" name="potrero"  placeholder="nombre de potrero" required>
            <button type="submit">Crear</button>
    </form>
</body>

</html>