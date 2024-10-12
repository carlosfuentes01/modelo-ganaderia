<?php
include '';// aqui va el php de la conexion de la base de datos

if (isset($_POST['submit'])) {
    $nombre = $_POST['nombre'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $cedula = $_POST['cedula'];
    $gmail = $_POST['gmail'];

    $sql = "INSERT INTO users (nombre, contrasena, cedula, gmail) VALUES (:nombre, :contrasena, :cedula, :gmail)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':gmail', $gmail);

    if ($stmt->execute()) {
        echo "Usuario registrado exitosamente.";
    } else {
        echo "Error al registrar el usuario.";
    }
}
?>

<form method="POST" action="create.php">
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <input type="password" name="contrasena" placeholder="Contraseña" required><br>
    <input type="text" name="cedula" placeholder="Cédula" required><br>
    <input type="email" name="gmail" placeholder="Correo Electrónico" required><br>
    <button type="submit" name="submit">Registrar</button>
</form>
