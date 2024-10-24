<?php
include ' '; //Conexion a la base de datos

$id = $_GET['dni'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $tarea = $_POST['tarea'];

    $sql = "UPDATE personal p join finca_has_personal fp on p.dni = fp.personal_dni join finca f on fp.finca_id=f.id 
    set dni= '$dni',
    nombres='$nombres',
    apellidos ='$apellidos',
    tarea='$tarea'
    WHERE p.dni = $id and f.usuario_dni=$_SESSION";

    if ($conexion->query($sql) === TRUE) {
        echo "Actualización exitosa!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
} else {
    $fila = $resultado->fetch_assoc();
    $sql = "select p.* from personal p join finca_has_personal fp 
    on p.dni = fp.personal_dni join finca f on fp.finca_id=f.id 
    where f.usuario_dni = $_SESSION";
    $resultado = $conexion->query($sql);
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
