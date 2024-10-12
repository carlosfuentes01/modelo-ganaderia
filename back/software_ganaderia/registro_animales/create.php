<?php
include 'conect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_animal = $_POST['id_animal'];
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $peso = $_POST['peso'];
    $estado_salud = $_POST['estado_salud'];
    $genero = $_POST['genero'];
    $id_raza = $_POST['id_raza'];

    $sql = "INSERT INTO animales (id_animal, identificacion, nombre, fecha_nacimiento, peso, estado_salud, genero, id_raza)
            VALUES ('$id_animal', '$identificacion', '$nombre', '$fecha_nacimiento', '$peso', '$estado_salud', '$genero', '$id_raza')";

    if ($conexion->query($sql) === TRUE) {
        echo "Registro exitoso!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
    ID Animal: <input type="text" name="id_animal" required><br>
    Identificación: <input type="text" name="identificacion" required><br>
    Nombre: <input type="text" name="nombre"><br>
    Fecha de Nacimiento: <input type="date" name="fecha_nacimiento"><br>
    Peso: <input type="number" step="0.01" name="peso"><br>
    Estado de Salud: <input type="text" name="estado_salud"><br>
    Género: 
    <select name="genero">
        <option value="Toro">Toro</option>
        <option value="Vaca">Vaca</option>
    </select><br>
    Raza: <input type="number" name="id_raza"><br>
    <input type="submit" value="Registrar">
</form>
