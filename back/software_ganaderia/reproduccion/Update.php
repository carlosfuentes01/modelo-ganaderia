<!-- update.php -->

<a href="Read.php">ir a </a>
<?php
include '../../conexion/conexion.php';
session_start();

$id = $_POST['idcontrol_embarazo'];
$sql1 = "
    SELECT * FROM modo_concepcion
";
$update_query="SELECT * from control_embarazo where idcontrol_embarazo = $id";
$update_conexion=$conexion->query($update_query);
$update=$update_conexion->fetch_assoc();
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
    <input type="date" name="fecha_deteccion" required value="<?php echo $update['fecha_deteccion']; ?>"><br>
    modo concepcion:
    <select name="modo_concepcion">
    <?php
        while ($mod = $modo->fetch_assoc()) {
           
            if ($mod['id'] == $update['modo_concepcion']) {
                echo "<option selected value='{$mod['id']}'>{$mod['nombre_modo']} </option>";
            }else {
                echo "<option value='{$mod['id']}'>{$mod['nombre_modo']} </option>"; 
            }
            
        }
        ?>
    </select><br>


    <label for="fecha_estimada_de_parto">Fecha esperada parto:</label>
    <input type="date" name="fecha_estimada_de_parto" required value="<?php echo $update['fecha_estimada_de_parto']; ?>"><br>

    <label for="fecha_aproximada_parto">Fecha del parto:</label>
    <input type="date" name="fecha_aproximada_parto" value="<?php echo $update['fecha_aproximada_parto']; ?>"><br>


    <label>Descripción:</label>
    <input type="text" name="descripcion" required value="<?php echo $update['descripcion']; ?>"></input><br>
    <input type="submit" value="Registrar control embarazo">
</form>
