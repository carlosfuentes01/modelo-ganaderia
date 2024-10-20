<?php
include ' '; //Conexion a la base de datos

$id = $_GET['dni'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $tarea = $_POST['tarea'];

    $sql = "UPDATE personal SET 
                dni='$dni',
                nombres='$nombres', 
                apellidos='$apellidos',
                tarea='$tarea' 
            WHERE dni=$id";

    if ($conexion->query($sql) === TRUE) {
        echo "Actualización exitosa!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
} else {
    $sql = "SELECT * FROM personal WHERE dni=$id";
    $resultado = $conexion->query($sql);
    $fila = $resultado->fetch_assoc();
?>
    <form method="POST" action="">
        DNI: <input type="text" name="dni" value="<?php echo $fila['dni']; ?>" required><br>
        Nombres: <input type="text" name="nombres" value="<?php echo $fila['nombres']; ?>" required><br>
        Apellidos: <input type="text" name="apellidos" value="<?php echo $fila['apellidos']; ?>"><br>
        Tarea: <input type="text" name="tarea" value="<?php echo $fila['tarea']; ?>" required><br>
        <input type="submit" value="Actualizar">
    </form>
<?php
}
?>
