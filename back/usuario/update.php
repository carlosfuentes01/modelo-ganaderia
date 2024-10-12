<?php
include '';// aqui va el php de la conexion de la base de datos

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST['submit'])) {
    $nombre = $_POST['nombre'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $cedula = $_POST['cedula'];
    $gmail = $_POST['gmail'];

    $sql = "UPDATE users SET nombre = :nombre, contrasena = :contrasena, cedula = :cedula, gmail = :gmail WHERE id = :id";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':nombre', $nombre);
    $stmt->bindParam(':contrasena', $contrasena);
    $stmt->bindParam(':cedula', $cedula);
    $stmt->bindParam(':gmail', $gmail);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Usuario actualizado exitosamente.";
    } else {
        echo "Error al actualizar el usuario.";
    }
}
?>

<form method="POST" action="update.php?id=<?php echo $user['id']; ?>">
    <input type="text" name="nombre" value="<?php echo $user['nombre']; ?>" required><br>
    <input type="password" name="contrasena" placeholder="Nueva Contraseña" required><br>
    <input type="text" name="cedula" value="<?php echo $user['cedula']; ?>" required><br>
    <input type="email" name="gmail" value="<?php echo $user['gmail']; ?>" required><br>
    <button type="submit" name="submit">Actualizar</button>
</form>
