<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrarse</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index.css">
</head>
<?php
include '../conexion/conexion.php'; // Incluye la conexión a la base de datos

// Crear un usuario (CREATE)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contraseña = $_POST['contraseña'];
    $dni = $_POST['dni'];

    // Inserta los datos en la tabla usuario
    $sql_usuario = "INSERT INTO usuario (dni, usuario, gmail, contraseña) VALUES ('$dni', '$username', '$email', '$contraseña')";

    if ($conexion->query($sql_usuario) === TRUE) {
        echo "Usuario registrado exitosamente!";
    } else {
        echo "Error al registrar el usuario: " . $conexion->error;
    }
}
?>
<body class="d-flex justify-content-center mx-auto p-5">
<form method="POST" action="">
    <div class="d-flex 
     contenedor border rounded-4" id="">
     
        <div class=" border rounded-start-4 texto d-flex flex-column justify-content-center">
            <h1 class="mx-5">¡Bienvenido!</h1>
            <p class="mx-5">Gestiona tu software ganadero de manera eficiente. Inicia sesión con tus datos para
                continuar.</p>
        </div>
        <!-- Input de Nombre -->
        <div class=" border rounded-end-4 registrar d-flex flex-column justify-content-center">
            <h1 class="mx-5" style="color: rgb(44, 156, 255);">Registrate</h1>
            <p class="mx-5"><b>Nombre</b></p>
            <div class="input-group mb-3 inputs mx-5">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="text" class="form-control" name="username" placeholder="Username" aria-describedby="basic-addon1" required>
            </div>
            <p class="mx-5"><b>DNI</b></p>
             <!-- Input de DNI -->
            <div class="input-group mb-3 inputs mx-5">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="Number" name="dni" class="form-control" placeholder="DNI" aria-describedby="basic-addon1" required>
            </div>
            <p class="mx-5"><b>Correo Electrónico</b></p>
            <!-- Input de Correo Electronico -->
            <div class="input-group mb-3 inputs mx-5">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="email" name="email" class="form-control" placeholder="Email" aria-describedby="basic-addon1" required>
            </div>
            <p class="mx-5"><b>Contraseña</b></p>
            <!-- Input de Correo Contraseña -->
            <div class="input-group mb-3 inputs mx-5">
                <span class="input-group-text" id="basic-addon1">*</span>
                <input type="password" name="contraseña" class="form-control" placeholder="Contraseña" aria-describedby="basic-addon1" required>
            </div>

            <input type="submit" class="mx-5 mt-3 btn btn-primary inputs"></button>
            <div class="d-flex justify-content-center mx-5 inputs mt-3">
                <p class="">¿Ya tienes una cuenta? <a href="">Inicia sesion aqui</a></p>
            </div>


        </div>
    </div>
    </form>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</html>