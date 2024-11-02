<?php
include '../../conexion/conexion.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}
$sesion = $_SESSION['dni'];

// Obtener las fincas asignadas al usuario logueado
$sql1 = "SELECT * FROM finca WHERE usuario_dni = $sesion";
$fincas = $conexion->query($sql1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $trabajo_principal = $_POST['trabajo_principal'];
    $finca_id = $_POST['finca'];

    // Verificar si el DNI ya existe en la tabla `personal`
    $checkDni = "SELECT dni FROM personal WHERE dni = '$dni'";
    $result = $conexion->query($checkDni);

    if ($result->num_rows > 0) {
        // Si el DNI ya existe, mostrar un mensaje
        echo "Error: El DNI ingresado ya está registrado.";
    } else {
        // Insertar datos en la tabla `personal`
        $sql = "INSERT INTO personal (dni, nombres, apellidos, trabajo_principal)
                VALUES ('$dni', '$nombres', '$apellidos', '$trabajo_principal')";

        if ($conexion->query($sql) === TRUE) {
            echo "Registro exitoso en personal!";
            
            // Asociar el personal a una finca en la tabla `finca_has_personal`
            $sql_finca_personal = "INSERT INTO finca_has_personal (finca_id, personal_dni) VALUES ($finca_id, '$dni')";
            if ($conexion->query($sql_finca_personal) === TRUE) {
                echo "Personal asociado a la finca exitosamente!";
            } else {
                echo "Error al asociar a la finca: " . $conexion->error;
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
    }
}
?>

<form method="POST" action="">
    DNI: <input type="text" name="dni" required><br>
    Nombres: <input type="text" name="nombres" required><br>
    Apellidos: <input type="text" name="apellidos" required><br>
    Trabajo Principal: <input type="text" name="trabajo_principal"><br>

    Finca:
    <select name="finca" required>
        <?php
        while ($finca = $fincas->fetch_assoc()) {
            ?>
            <option value="<?php echo $finca['id']; ?>"><?php echo $finca['nombre']; ?></option>
            <?php
        }
        ?>
    </select> <br>

    <input type="submit" value="Registrar">
</form>

<a href="read_personal.php">Regresar a lectura de personal</a>
