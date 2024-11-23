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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CowAlly</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0093E9, #80D0C7);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .wrapper {
            text-align: center;
            position: relative;
        }

        .logo {
            position: relative;
            margin-bottom: -50px; /* Ajusta la distancia entre el logo y el contenedor */
            z-index: 2;
        }

        .logo img {
            max-width: 100px;
            border-radius: 50%;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); /* Sombra para destacar el logo */
            background-color: white; /* Fondo blanco para resaltar el logo */
            padding: 10px; /* Espaciado interno alrededor del logo */
        }

        .container {
            background-color: white;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0px 8px 12px rgba(0, 0, 0, 0.2); /* Sombra para un efecto elegante */
            max-width: 400px;
            width: 90%;
            position: relative;
            z-index: 1;
        }

        .container h1 {
            color: #333;
            margin-bottom: 20px;
        }

        .container input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        .container button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .container button:hover {
            background-color: #45A049;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="logo">
            <img src="WhatsApp Image 2024-11-22 at 11.02.24 PM (1).jpeg" alt="Logo">
        </div>
        <div class="container">
            <h1>¡Bienvenido a CowAlly!</h1>
            <form>
                <label for="finca">Ingrese nombre de su finca</label>
                <br>
                <input type="text" id="finca" name="finca" placeholder="Nombre de la finca">
                <br>
                <label for="corral">Ingrese nombre de su primer corral</label>
                <br>
                <input type="text" id="corral" name="corral" placeholder="Nombre del corral">
                <br>
                <button type="submit">Iniciar</button>
            </form>
        </div>
    </div>
</body>
</html>