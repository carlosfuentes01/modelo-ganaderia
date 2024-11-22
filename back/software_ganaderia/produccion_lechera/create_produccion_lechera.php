<?php
include '../../conexion/conexion.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/login.php");
    exit;
}

$sesion = $_SESSION['dni'];

// Consulta para obtener las vacas asociadas a la finca del usuario
$sql_vacas = "SELECT id, nombre FROM vacas WHERE potrero_id IN (SELECT id FROM potrero WHERE finca_id IN (SELECT id FROM finca WHERE usuario_dni = $sesion))";
$vacas = $conexion->query($sql_vacas);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vaca_id'])) {
    $litros = $_POST['litros'];
    $fecha = $_POST['fecha'];
    $vaca_id = $_POST['vaca_id'];

    // Inserción de los datos en la tabla de producción lechera
    $sql = "INSERT INTO produccion_lechera (litros_leche, fecha, vacas_id) VALUES ('$litros', '$fecha', '$vaca_id')";

    if ($conexion->query($sql) === TRUE) {
        echo "Registro de producción lechera exitoso!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
    Litros producidos: <input type="number" name="litros" step="0.01" required><br>
    Fecha de producción: <input type="date" name="fecha" required><br>
    
    Vaca:
    <select name="vaca_id">
        <?php
        while ($vaca = $vacas->fetch_assoc()) {
            ?>
            <option value="<?php echo $vaca['id']; ?>"><?php echo $vaca['nombre']; ?></option>
            <?php
        }
        ?>
    </select><br>

    <input type="submit" value="Registrar">
</form>
<a href="read_produccion_lechera.php">Regresar a lectura de producción</a>
