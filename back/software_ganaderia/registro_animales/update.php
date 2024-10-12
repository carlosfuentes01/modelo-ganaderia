<?php
include ''; //conexion a la base de datos

$id = $_GET['id_animal'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_animal = $_POST['id_animal'];
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $peso = $_POST['peso'];
    $estado_salud = $_POST['estado_salud'];
    $genero = $_POST['genero'];
    $id_raza = $_POST['id_raza'];

    $sql = "UPDATE animales SET 
                id_animal='$id_animal',
                identificacion='$identificacion', 
                nombre='$nombre', 
                fecha_nacimiento='$fecha_nacimiento', 
                peso='$peso', 
                estado_salud='$estado_salud',
                genero='$genero',
                id_raza='$id_raza' 
            WHERE id_animal=$id";

    if ($conexion->query($sql) === TRUE) {
        echo "Actualización exitosa!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
} else {
    $sql = "SELECT * FROM animales WHERE id_animal=$id";
    $result = $conexion->query($sql);
    $row = $result->fetch_assoc();
?>
    <form method="POST" action="">
        ID Animal: <input type="text" name="id_animal" value="<?php echo $row['id_animal']; ?>" required><br>
        Identificación: <input type="text" name="identificacion" value="<?php echo $row['identificacion']; ?>" required><br>
        Nombre: <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"><br>
        Fecha de Nacimiento: <input type="date" name="fecha_nacimiento" value="<?php echo $row['fecha_nacimiento']; ?>"><br>
        Peso: <input type="number" step="0.01" name="peso" value="<?php echo $row['peso']; ?>"><br>
        Estado de Salud: <input type="text" name="estado_salud" value="<?php echo $row['estado_salud']; ?>"><br>
        Género: 
        <select name="genero">
            <option value="Toro" <?php if($row['genero'] == 'Toro') echo 'selected'; ?>>Toro</option>
            <option value="Vaca" <?php if($row['genero'] == 'Vaca') echo 'selected'; ?>>Vaca</option>
        </select><br>
        Raza: <input type="number" name="id_raza" value="<?php echo $row['id_raza']; ?>"><br>
        <input type="submit" value="Actualizar">
    </form>
<?php
}
?>
