<a href="read_produccion_lechera.php">Regresar a lectura de producción lechera</a>
<?php
include '../../conexion/conexion.php'; // Conexión a la base de datos
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/login.php");
    exit;
}

$sesion = $_SESSION['dni'];
$id_produccion = $_REQUEST['id_produccion']; // Obtiene el ID del registro de producción lechera a editar

// Consulta para obtener las vacas asociadas a las fincas del usuario
$sqlVacas = "SELECT v.id, v.nombre FROM vacas v
             INNER JOIN potrero p ON v.potrero_id = p.id
             INNER JOIN finca f ON p.finca_id = f.id
             WHERE f.usuario_dni = $sesion";
$vacas = $conexion->query($sqlVacas);

// Consulta para obtener el registro actual de producción lechera
$sql = "SELECT * FROM produccion_lechera WHERE id_produccion = $id_produccion";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();

if (isset($_POST['litros_leche'])) {
    // Captura los valores de los campos del formulario
    $fecha = $_POST['fecha'];
    $litros_leche = $_POST['litros_leche'];
    $vaca_id = $_POST['vacas_id'];
    $id_produccion = $_POST['id_produccion'];

    // Consulta para actualizar el registro en la tabla producción_lechera
    $sqlUpdate = "UPDATE produccion_lechera SET 
                    fecha = '$fecha', 
                    litros_leche = '$litros_leche', 
                    vacas_id = '$vaca_id'
                  WHERE id_produccion = $id_produccion";

    if ($conexion->query($sqlUpdate) === TRUE) {
        echo "Actualización exitosa!";
    } else {
        echo "Error: " . $sqlUpdate . "<br>" . $conexion->error;
    }
} else {
    // Si no se ha enviado el formulario, muestra los datos actuales en el formulario
?>
    <form method="POST" action="">
        <input type="hidden" name="id_produccion" value="<?php echo $id_produccion; ?>">

        Fecha de producción: <input type="date" name="fecha" value="<?php echo $row['fecha']; ?>"><br>
        Cantidad de producción (en litros): <input type="number" step="0.01" name="litros_leche" value="<?php echo $row['litros_leche']; ?>"><br>
        
        Vaca:
        <select name="vacas_id">
            <?php
            while ($vaca = $vacas->fetch_assoc()) {
                ?>
                <option <?php if ($vaca['id'] == $row['vacas_id']) echo 'selected'; ?> value="<?php echo $vaca['id']; ?>">
                    <?php echo $vaca['nombre']; ?>
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
