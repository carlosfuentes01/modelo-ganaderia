<?php
include '../../conexion/conexion.php';
session_start();

if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

$sesion = $_SESSION['dni'];

$sql1 = "
    SELECT * FROM modo_concepcion
";
$modo = $conexion->query($sql1);

$hoy = date("Y-n-d");
if (isset($_POST['fecha_estimada_de_parto'])) {

    $fecha_deteccion = $_POST['fecha_deteccion'];
    $fecha_estimada_de_parto = $_POST['fecha_estimada_de_parto'];
    $modo_concepcion = $_POST['modo_concepcion'];
    $descripcion = $_POST['descripcion'];
    $fecha_aproximada_parto = $_POST['fecha_aproximada_parto'];
    if ($_POST['fecha_aproximada_parto'] == "") {

        $fecha_aproximada_parto="NULL";



        $sql = "INSERT INTO `control_embarazo`(`fecha_deteccion`, `fecha_aproximada_parto`, `descripcion`, `fecha_estimada_de_parto`, `modo_concepcion`) VALUES ('$fecha_deteccion',$fecha_aproximada_parto,'$descripcion','$fecha_estimada_de_parto',$modo_concepcion)";
    }else{
        $sql = "INSERT INTO `control_embarazo`(`fecha_deteccion`, `fecha_aproximada_parto`, `descripcion`, `fecha_estimada_de_parto`, `modo_concepcion`) VALUES ('$fecha_deteccion','$fecha_aproximada_parto', '$descripcion','$fecha_estimada_de_parto',$modo_concepcion)";
    }



    echo $sql;

    if ($conexion->query($sql) === TRUE) {
        echo "Reporte médico registrado exitosamente!"; 
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>

<form method="POST" action="">
    <label for="fecha_deteccion">Fecha de deteccion:</label>
    <input type="date" name="fecha_deteccion" required value="<?php echo $hoy; ?>"><br>
    modo concepcion:
    <select name="modo_concepcion">
    <?php
        while ($mod = $modo->fetch_assoc()) {
            echo "<option value='{$mod['id']}'>{$mod['nombre_modo']} </option>";
        }
        ?>
    </select><br>


    <label for="fecha_estimada_de_parto">Fecha esperada parto:</label>
    <input type="date" name="fecha_estimada_de_parto" required><br>

    <label for="fecha_aproximada_parto">Fecha del parto:</label>
    <input type="date" name="fecha_aproximada_parto"><br>


    <label>Descripción:</label>
    <input type="text" name="descripcion" required></input><br>
    <input type="submit" value="Registrar control embarazo">
</form>

<a href="Read.php">Regresar a la lista de embarazos</a>