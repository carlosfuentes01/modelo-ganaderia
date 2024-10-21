<?php
session_start();
include '../conexion/conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $contra = $_POST['contra'];

    // Busca al usuario con el correo electrónico y la contraseña
    $sql = "SELECT * FROM usuario WHERE dni = $dni AND contra = '$contra'";
    $result = $conexion->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Guarda el DNI del usuario en la sesión
        $_SESSION['dni'] = $row['dni'];
        $_SESSION['username'] = $row['usuario'];
        echo "Inicio de sesión exitoso!";
        $sql1 = "SELECT * FROM finca WHERE usuario_dni = $dni";
        $fincas = $conexion->query($sql);
        if ( $fincas->num_rows == 1) {
            header("Location: ../software_ganaderia/registro_animales/read.php");
        }else{
            header("Location: finca_potrero.php");
        }
         // Redirige a la página de usuario
        exit;
    } else {
        echo "Correo o contraseña incorrectos.";
    }
}
?>

<!-- Formulario de inicio de sesión -->
<h2>Iniciar Sesión</h2>
<form method="POST" action="">
    dni: <input type="text" name="dni" required><br>
    Contraseña: <input type="password" name="contra" required><br>
    <input type="submit" value="Iniciar Sesión">
</form>
