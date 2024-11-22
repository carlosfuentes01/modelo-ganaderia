<?php
include '../../conexion/conexion.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/login.php");
    exit;
}
$sesion = $_SESSION['dni'];

// Obtenemos las fincas asociadas al usuario actual
$sql1 = "SELECT * FROM finca WHERE usuario_dni = $sesion";
$fincas = $conexion->query($sql1);

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $finca_id = $_POST['finca_id'];

    // Inserción en la tabla potrero
    $sql = "INSERT INTO potrero (nombre, finca_id) VALUES ('$nombre', $finca_id)";

    if ($conexion->query($sql) === TRUE) {
        echo "¡Registro de potrero exitoso!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
    Nombre del potrero: <input type="text" name="nombre" required><br>
    
    Finca:
    <select name="finca_id" required>
        <?php
        while ($finca = $fincas->fetch_assoc()) {
            ?>
            <option value=<?php echo $finca['id']; ?>><?php echo $finca['nombre']; ?></option>
            <?php
        }
        ?>
    </select> <br>

    <input type="submit" value="Registrar Potrero">
</form>
<a href="read_potrero.php">Regresar a la lectura de potreros</a>
