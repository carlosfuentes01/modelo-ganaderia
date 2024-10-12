<?php
include '';// aqui va el php de la conexion de la base de datos

$sql = "SELECT * FROM users";
$stmt = $conn->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Lista de Usuarios</h2>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Cédula</th>
        <th>Correo</th>
        <th>Acciones</th>
    </tr>
    <?php foreach ($users as $user) { ?>
    <tr>
        <td><?php echo $user['id']; ?></td>
        <td><?php echo $user['nombre']; ?></td>
        <td><?php echo $user['cedula']; ?></td>
        <td><?php echo $user['gmail']; ?></td>
        <td>
            <a href="update.php?id=<?php echo $user['id']; ?>">Editar</a>
            <a href="delete.php?id=<?php echo $user['id']; ?>">Eliminar</a>
        </td>
    </tr>
    <?php } ?>
</table>
