<?php
session_start();
include '../conexion/conexion.php'; // Conexión a la base de datos

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

// Obtener el DNI del usuario de la sesión
$dni = $_SESSION['dni'];

// Obtener los datos del usuario actual
$sql = "SELECT * FROM usuario WHERE dni = $dni";
$result = $conexion->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
}

// Procesar la actualización de datos
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $contra = $_POST['contra'];

    $sql = "UPDATE usuario SET usuario='$username', gmail='$email', contra='$contra' WHERE dni='$dni'";

    if ($conexion->query($sql) === TRUE) {
        echo "Datos actualizados exitosamente!";
        header("Location: read.php");
        exit;
    } else {
        echo "Error al actualizar los datos: " . $conexion->error;
    }
}
?>

<h2>Editar Datos</h2>
<form method="POST" action="">
    Nombre de Usuario: <input type="text" name="username" value="<?php echo $row['usuario']; ?>" required><br>
    Email: <input type="email" name="email" value="<?php echo $row['gmail']; ?>" required><br>
    Contraseña: <input type="password" name="contra" value="<?php echo $row['contra']; ?>" required><br>
    <input type="submit" value="Actualizar">
</form>
