<?php
include 'conect.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produccion = $_POST['id_produccion'];
    $fecha = $_POST['fecha'];
    $litros_leche = $_POST['litros_leche'];
    $vacas_id = $_POST['vacas_id'];

    $sql = "INSERT INTO produccion_lechera (id_produccion, fecha,litros_leche,vacas_id)
            VALUES ('$id_produccion', '$fecha', '$litros_leche', '$vacas_id')";

    if ($conexion->query($sql) === TRUE) {
        echo "Registro exitoso!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
    ID: <input type="text" name="id_produccion" required><br>
    Fecha: <input type="date" name="fecha" required><br>
    litros leche: <input type="text" name="litros_leche" required><br>
    id vaca: <input type="text" name="vacas_id" required><br>


    <input type="submit" value="Registrar">
</form>
