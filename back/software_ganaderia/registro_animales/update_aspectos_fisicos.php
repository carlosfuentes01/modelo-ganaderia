<a href="read_aspectos_fisicos.php">Regresar a la lista de aspectos físicos</a>

<?php
include '../../conexion/conexion.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}

$sesion = $_SESSION['dni'];
$aspecto_id = $_REQUEST['aspecto_id'];

// Consulta para obtener los datos del aspecto físico a actualizar
$sql_aspecto = "SELECT * FROM aspectos_fisicos WHERE id = $aspecto_id";
$result_aspecto = $conexion->query($sql_aspecto);
$row = $result_aspecto->fetch_assoc();

if (!$row) {
    echo "Aspecto físico no encontrado.";
    exit;
}

// Consulta para llenar las opciones de vacas
$sql_vacas = "
    SELECT v.id, v.nombre, v.identificacion 
    FROM vacas v
    INNER JOIN potrero p ON v.potrero_id = p.id
    INNER JOIN finca f ON p.finca_id = f.id
    WHERE f.usuario_dni = '$sesion'
";
$vacas = $conexion->query($sql_vacas);

// Consulta para llenar las opciones de crecimiento
$sql_crecimientos = "SELECT id_crecimiento, categoria FROM crecimiento";
$crecimientos = $conexion->query($sql_crecimientos);

// Procesamiento de datos del formulario para actualizar el aspecto físico
if (isset($_POST['peso'])) {
    $peso = $_POST['peso'];
    $fecha_descripcion = $_POST['fecha_descripcion'];
    $condicion_corporal = $_POST['condicion_corporal'];
    $descripcion = $_POST['descripcion'];
    $vaca_id = $_POST['vaca'];
    $crecimiento_id = $_POST['crecimiento'];
    $aspecto_id = $_POST['aspecto_id'];

    $sql_update = "UPDATE aspectos_fisicos SET 
                    peso = '$peso', 
                    fecha_descripcion = '$fecha_descripcion', 
                    condicion_corporal = '$condicion_corporal', 
                    descripcion = '$descripcion',
                    id_vaca = $vaca_id,
                    crecimiento_id_crecimiento = $crecimiento_id
                   WHERE id = $aspecto_id";

    if ($conexion->query($sql_update) === TRUE) {
        echo "Actualización exitosa!";
    } else {
        echo "Error: " . $sql_update . "<br>" . $conexion->error;
    }
} else {
    // Mostrar el formulario de actualización con los datos actuales del aspecto físico
?>
    <form method="POST" action="">
        <input type="hidden" name="aspecto_id" value="<?php echo $aspecto_id; ?>">
        <label for="vaca">Vaca:</label>
        <select name="vaca" required>
            <?php
            while ($vaca = $vacas->fetch_assoc()) {
                $selected = ($vaca['id'] == $row['id_vaca']) ? 'selected' : '';
                echo "<option value='{$vaca['id']}' $selected>{$vaca['nombre']} - Identificación: {$vaca['identificacion']}</option>";
            }
            ?>
        </select><br>

        <label for="peso">Peso:</label>
        <input type="number" name="peso" required value="<?php echo $row['peso']; ?>"><br>

        <label for="fecha_descripcion">Fecha de Descripción:</label>
        <input type="date" name="fecha_descripcion" required value="<?php echo $row['fecha_descripcion']; ?>"><br>

        <label for="condicion_corporal">Condición Corporal:</label>
        <input type="number" name="condicion_corporal" value="<?php echo $row['condicion_corporal']; ?>"><br>

        <label for="descripcion">Descripción:</label>
        <textarea name="descripcion"><?php echo $row['descripcion']; ?></textarea><br>

        <label for="crecimiento">Crecimiento:</label>
        <select name="crecimiento" required>
            <?php
            while ($crecimiento = $crecimientos->fetch_assoc()) {
                $selected = ($crecimiento['id_crecimiento'] == $row['crecimiento_id_crecimiento']) ? 'selected' : '';
                echo "<option value='{$crecimiento['id_crecimiento']}' $selected>{$crecimiento['categoria']}</option>";
            }
            ?>
        </select><br>

        <input type="submit" value="Actualizar Aspecto Físico">
    </form>
<?php
}
?>
