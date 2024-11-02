<a href="read_personal.php">Regresar a lectura de personal</a>
<?php
include '../../conexion/conexion.php'; // Conexión a la base de datos
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

$sesion = $_SESSION['dni']; // DNI del usuario autenticado
$id_personal = $_REQUEST['dni']; // Captura el DNI del personal a actualizar

// Consulta para obtener las fincas asociadas al usuario
$sqlFincas = "SELECT id, nombre FROM finca WHERE usuario_dni = $sesion";
$fincas = $conexion->query($sqlFincas);

// Consulta para obtener los datos actuales del personal
$sql = "SELECT * FROM personal WHERE dni = $id_personal";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();

if (isset($_POST['nombres'])) {
    // Captura los valores del formulario
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $trabajo_principal = $_POST['trabajo_principal'];
    $id_personal = $_POST['dni'];
    $finca_id = $_POST['finca']; // Finca seleccionada en el formulario

    // Consulta para actualizar los datos del personal
    $sqlUpdate = "UPDATE personal SET 
                    nombres='$nombres', 
                    apellidos='$apellidos', 
                    trabajo_principal='$trabajo_principal' 
                WHERE dni = $id_personal";

    if ($conexion->query($sqlUpdate) === TRUE) {
        echo "Actualización exitosa!";
        
        // Actualizar la relación con la finca en la tabla intermedia
        $sqlUpdateFinca = "UPDATE finca_has_personal SET finca_id='$finca_id' WHERE personal_dni = $id_personal";
        $conexion->query($sqlUpdateFinca);
    } else {
        echo "Error: " . $sqlUpdate . "<br>" . $conexion->error;
    }
} else {
    ?>
    <!-- Formulario de actualización -->
    <form method="POST" action="">
        <input type="hidden" name="dni" value="<?php echo $id_personal; ?>">
        Nombres: <input type="text" name="nombres" value="<?php echo $row['nombres']; ?>"><br>
        Apellidos: <input type="text" name="apellidos" value="<?php echo $row['apellidos']; ?>"><br>
        Trabajo Principal: <input type="text" name="trabajo_principal" value="<?php echo $row['trabajo_principal']; ?>"><br>
        
        Finca:
        <select name="finca">
            <?php
            while ($finca = $fincas->fetch_assoc()) {
                // Verificar si esta finca ya está asignada en la tabla intermedia
                $fincaAsignada = $conexion->query("SELECT finca_id FROM finca_has_personal WHERE personal_dni = $id_personal")->fetch_assoc();
                ?>
                <option value="<?php echo $finca['id']; ?>" <?php if ($finca['id'] == $fincaAsignada['finca_id']) echo 'selected'; ?>>
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
