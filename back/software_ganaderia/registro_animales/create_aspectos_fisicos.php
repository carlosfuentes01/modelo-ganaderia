<?php
include '../../conexion/conexion.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}
$sesion = $_SESSION['dni'];

// Consulta para obtener las vacas según la finca asociada al usuario
$sql1 = "SELECT * FROM vacas WHERE potrero_id IN (
            SELECT id FROM potrero WHERE finca_id IN (
                SELECT id FROM finca WHERE usuario_dni = $sesion
            )
         )";
$vacas = $conexion->query($sql1);

// Consulta para obtener las opciones de crecimiento
$sql2 = "SELECT * FROM crecimiento";
$crecimientos = $conexion->query($sql2);

if (isset($_POST['id_vaca'])) {
    $peso = $_POST['peso'];
    $fecha_descripcion = $_POST['fecha_descripcion'];
    $condicion_corporal = $_POST['condicion_corporal'];
    $descripcion = $_POST['descripcion'];
    $id_vaca = $_POST['id_vaca'];
    $crecimiento_id_crecimiento = $_POST['crecimiento_id_crecimiento'];

    // Inserción de datos en la tabla aspectos_fisicos
    $sql = "INSERT INTO aspectos_fisicos (peso, fecha_descripcion, condicion_corporal, descripcion, id_vaca, crecimiento_id_crecimiento)
            VALUES ('$peso', '$fecha_descripcion', '$condicion_corporal', '$descripcion', $id_vaca, $crecimiento_id_crecimiento)";

    if ($conexion->query($sql) === TRUE) {
        echo "Registro de aspectos físicos exitoso!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
    Peso KG: <input type="text" name="peso" required><br>
    Fecha de Descripción: <input type="date" name="fecha_descripcion" required><br>
    Condición Corporal: <input type="number" name="condicion_corporal" required><br>
    Descripción: <input type="text" name="descripcion" required><br>
    
    Vaca:
    <select name="id_vaca" required>
        <?php
        while ($vaca = $vacas->fetch_assoc()) {
            
            echo "<option value='{$vaca['id']}'>{$vaca['nombre']} - Identificación: {$vaca['identificacion']}</option>";
            
        }
        ?>
    </select><br>

    Crecimiento:
    <select name="crecimiento_id_crecimiento" required>
        <?php
        while ($crecimiento = $crecimientos->fetch_assoc()) {
            ?>
            <option value=<?php echo $crecimiento['id_crecimiento']; ?>><?php echo $crecimiento['categoria']; ?></option>
            <?php
        }
        ?>
    </select><br>

    <input type="submit" value="Registrar">
</form>

<a href="read_aspectos_fisicos.php">Regresar a la lectura de aspectos físicos</a>
