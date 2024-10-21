<?php
include '../conexion/conexion.php'; // Incluye la conexión a la base de datos

// Crear un usuario (CREATE)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recoge los datos del formulario
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contra = $_POST['contra'];
    $dni = $_POST['dni'];

    // Inserta los datos en la tabla usuario
    $sql_usuario = "INSERT INTO usuario (dni, usuario, gmail, contra) VALUES ('$dni', '$username', '$email', '$contra')";

    if ($conexion->query($sql_usuario) === TRUE) {
        echo "Usuario registrado exitosamente!";
    } else {
        echo "Error al registrar el usuario: " . $conexion->error;
    }
}
?>

<!-- Formulario para registrar usuarios -->
<h2>Registrar Usuario</h2>
<form method="POST" action="">
    DNI: <input type="number" name="dni" required><br>
    Nombre de Usuario: <input type="text" name="username" required><br>
    Email: <input type="email" name="email" required><br>
    Contraseña: <input type="password" name="contra" required><br>
    <input type="submit" value="Registrar">
</form>
<a href="login.php">ir a login</a>