<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
</head>
<?php
session_start();
include '../conexion/conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $contra = $_POST['contra'];

    $sql = "SELECT * FROM usuario WHERE dni = '$dni' AND contra = '$contra'";
    $result = $conexion->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Guarda el DNI del usuario en la sesión
        $_SESSION['dni'] = $row['dni'];
        $_SESSION['username'] = $row['usuario'];
        echo "Inicio de sesión exitoso!";
        header("Location: ver_usuario.php"); // Redirige a la página de usuario
        exit;
    } else {
        echo "DNI o contraseña incorrectos.";
    }
}
?>
<body class="d-flex justify-content-center mx-auto p-5">
<form method="POST" action="">
    <div class="d-flex 
     contenedor border rounded-4" id="">
     
        <div class=" border rounded-start-4 texto d-flex flex-column justify-content-center">
            <h1 class="mx-5">Bienvenido de nuevo</h1>
            <p class="mx-5">Accede a tu cuenta y gestiona tu software ganadero. Si no tienes una cuenta, ¡regístrate ahora!</p>
        </div>
        <!-- Input de Nombre -->
        <div class=" border rounded-end-4 registrar d-flex flex-column justify-content-center">
            <h1 class="mx-5" style="color: rgb(44, 156, 255);">Inicar sesión</h1>
           
            <p class="mx-5"><b>DNI</b></p>
             <!-- Input de DNI -->
            <div class="input-group mb-3 inputs mx-5">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="Number" name="dni" class="form-control" placeholder="DNI" aria-describedby="basic-addon1" required>
            </div>
        
            <p class="mx-5"><b>Contraseña</b></p>
            <div class="input-group mb-3 inputs mx-5">
                <span class="input-group-text" id="basic-addon1">*</span>
                <input type="password" name="contra" class="form-control" placeholder="Contraseña" aria-describedby="basic-addon1" required>
            </div>

            <button type="submit" class="mx-5 mt-3 btn btn-primary inputs">Iniciar sesión</button>
            <div class="d-flex justify-content-center mx-5 inputs mt-3">
                <p class=""><a href="">¿Olvidaste tu contraseña?</a><br>¿No tienes una cuenta? <a href="registro.php">Registrate aqui</a></p>
                
                
            </div>


        </div>
    </div>
    </form>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</html>