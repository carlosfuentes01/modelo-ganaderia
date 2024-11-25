<a href="read_potrero.php">Regresar a la lectura de potreros</a>
<?php
include '../../conexion/conexion.php'; // Conexión a la base de datos
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}

$sesion = $_SESSION['dni'];
$id_potrero = $_REQUEST['id_potrero']; 

// Consulta para obtener las fincas asociadas al usuario
$sqlFincas = "SELECT id, nombre FROM finca WHERE usuario_dni = $sesion";
$fincas = $conexion->query($sqlFincas);

// Consulta para obtener el registro actual del potrero
$sql = "SELECT * FROM potrero WHERE id = $id_potrero";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();

if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $finca_id = $_POST['finca_id'];
    $id_potrero = $_POST['id_potrero'];

    // Consulta para actualizar el registro en la tabla potrero
    $sqlUpdate = "UPDATE potrero SET 
                    nombre = '$nombre', 
                    finca_id = '$finca_id'
                  WHERE id = $id_potrero";

    if ($conexion->query($sqlUpdate) === TRUE) {
        echo "Actualización exitosa!";
    } else {
        echo "Error: " . $sqlUpdate . "<br>" . $conexion->error;
    }
} else {
    // Si no se ha enviado el formulario, muestra los datos actuales en el formulario
?>
    <form method="POST" action="">
        <input type="hidden" name="id_potrero" value="<?php echo $id_potrero; ?>">

        Nombre del Potrero: <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"><br>
        
        Finca:
        <select name="finca_id">
            <?php
            while ($finca = $fincas->fetch_assoc()) {
                ?>
                <option <?php if ($finca['id'] == $row['finca_id']) echo 'selected'; ?> value="<?php echo $finca['id']; ?>">
                    <?php echo $finca['nombre']; ?>
                </option>
                <?php
            }
            ?>
        </select><br>

        <input type="submit" value="Actualizar">
    </form>
<?php
}
?>
