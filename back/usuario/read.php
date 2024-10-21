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

// Obtener los datos del usuario autenticado
$sql = "SELECT * FROM usuario WHERE dni = '$dni'";
$result = $conexion->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
} else {
    echo "Usuario no encontrado.";
    exit;
}
?>

<h2>Bienvenido, <?php echo $_SESSION['username']; ?></h2>
<p><strong>DNI:</strong> <?php echo $row['dni']; ?></p>
<p><strong>Email:</strong> <?php echo $row['gmail']; ?></p>
<p><strong>Contraseña:</strong> <?php echo $row['contra']; ?></p>

<a href="update.php">Editar mis datos</a>
<a href="logout.php">Cerrar Sesión</a>
