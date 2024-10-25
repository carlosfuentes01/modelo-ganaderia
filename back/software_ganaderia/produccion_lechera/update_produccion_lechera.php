<?php
include 'conect.php';

$id_produccion2 = $_GET['id_produccion']
$id_vaca = $_GET['id'];
$fecha2 = $_GET['fecha'];
$litros_leche2 = $_GET['litros_leche'];

$sesion = $_SESSION['dni'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produccion = $_POST['id_produccion'];
    $fecha = $_POST['fecha'];
    $litros_leche = $_POST['litros_leche'];
    $vacas_id = $_POST['vacas_id'];

    $sql = "update produccion_lechera p join vacas v on p.vacas_id = v.id
join finca f on v.finca_id = f.id join usuario u on f.usuario_dni = u.dni
set fecha = $fecha2, litros_leche = $litros_leche2 where  u.dni = $sesion and p.vacas_id=$id_vaca";

    if ($conexion->query($sql) === TRUE) {
        echo "Actualización exitosa!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
} else {
    $sql = "SELECT * FROM produccion_lechera WHERE id_produccion=$id_produccion2";
    $resultado = $conexion->query($sql);
    $fila = $resultado->fetch_assoc();
?>
    <form method="POST" action="">
        id_produccion: <input type="text" name="id_produccion" value="<?php echo $fila['id_produccion']; ?>" required><br>
        fecha: <input type="date" name="fecha" value="<?php echo $fila['fecha']; ?>" required><br>
        litros_leche: <input type="text" name="litros_leche" value="<?php echo $fila['litros_leche']; ?>" required><br>
        <input type="submit" value="Actualizar">
    </form>
<?php
}
?>
