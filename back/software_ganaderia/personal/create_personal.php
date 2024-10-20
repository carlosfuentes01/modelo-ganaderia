<?php
include ' '; //conexion a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $tarea = $_POST['tarea'];


    $sql = "INSERT INTO personal (dni, nombres, apellidos, tarea)
            VALUES ('$dni', '$nombres', '$apellidos', '$tarea')";

    if ($conexion->query($sql) === TRUE) {
        echo "Registro exitoso!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
    DNI: <input type="text" name="dni" required><br>
    Nombres: <input type="text" name="nombres" required><br>
    Apellidos: <input type="text" name="apellidos"><br>
    Tarea: <input type="text" name="tarea"><br>
    <input type="submit" value="Registrar">
</form>
