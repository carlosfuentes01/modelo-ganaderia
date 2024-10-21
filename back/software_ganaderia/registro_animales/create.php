
<?php
include '../../conexion/conexion.php';
session_start();
// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}
$sesion = $_SESSION['dni'];

$sql1 = "SELECT * FROM raza";
$razas = $conexion->query($sql1);
$sql2 = "SELECT * FROM marcacion";
$marcaciones = $conexion->query($sql2);
$sql3 = "SELECT * FROM potrero where finca_id in(select id from finca where usuario_dni = $sesion)";
$potreros = $conexion->query($sql3);

if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['potrero'])) {

    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $fecha_de_registro_animal = $_POST['fecha_de_registro_animal'];
    $genero = $_POST['genero'];
    $descartada = $_POST['descartada'];
    $potrero_id = $_POST['potrero'];

    $marca = $_POST['marcacion'];
    $sql = "INSERT INTO vacas (identificacion, nombre, fecha_de_registro_animal,  genero, descartada,potrero_id,marcacion_id   )
            VALUES ( '$identificacion', '$nombre', '$fecha_de_registro_animal',  '$genero', '$descartada',$potrero_id,$marca)";
$raza_ingresadas=false;
while ($intro_razas = $razas->fetch_assoc()) {

    if (isset($_POST[$intro_razas["id_raza"]])) {
        # code...
        $raza_ingresadas=true;
    }
}

    $id_vaca;
    if ($raza_ingresadas) {
        if ($conexion->query($sql) === TRUE) {
            echo "Registro exitoso!";
            $sql_ver_id = "SELECT id from vacas where identificacion = $identificacion";
            $query_id_vaca = $conexion->query($sql_ver_id);
    
            while ($ver_id_vaca = $query_id_vaca->fetch_assoc()) {
                $id_vaca = $ver_id_vaca['id'];
    
    
            }
            while ($intro_razas = $razas->fetch_assoc()) {
    
                if (isset($_POST[$intro_razas["id_raza"]])) {
                    # code...
                    $sqlinsert = "INSERT INTO razas_de_la_vaca (`raza_id_raza`, `vacas_id_animal`) VALUES ($intro_razas[id_raza],$id_vaca)";
                    $conexion->query($sqlinsert);
                }
            }
        } else {
            echo "Error: " . $sql . "<br>" . $conexion->error;
        }
    }else{
        echo "no se ha ingresado razas, ingrese al menos una raza";
    }
    

}


#falta potrero
?>

<form method="POST" action="">

    Identificación: <input type="text" name="identificacion" required><br>
    Nombre: <input type="text" name="nombre"><br>
    fecha de registro animal: <input type="date" name="fecha_de_registro_animal" required><br>
    Género:
    <select name="genero">
        <option value="Hembra">Hembra</option>
        <option value="Macho">Macho</option>
    </select><br>
    Descartada:
    <select name="descartada">
        <option value="Activa">Activa</option>
        <option value="Descartada">Descartada</option>
        <option value="Vendida">Vendida</option>
    </select><br>

    Raza:
    <?php
    while ($raza_input = $razas->fetch_assoc()) {
        ?>
        <input type="checkbox" name="<?php echo $raza_input['id_raza']; ?>" value=<?php echo $raza_input['id_raza']; ?>>
        <label for="raza"> <?php echo $raza_input['nombre']; ?></label><br>
        <?php
    }

    ?>
    Marcacion:
    <select name="marcacion">
        <?php
        while ($marcacion = $marcaciones->fetch_assoc()) {
            ?>
            <option value=<?php echo $marcacion['id']; ?>><?php echo $marcacion['tipo_marcacion']; ?></option>
            <?php
        }

        ?>
    </select> <br>
    potrero:
    <select name="potrero">
        <?php
        while ($potrero = $potreros->fetch_assoc()) {
            ?>
            <option value=<?php echo $potrero['id']; ?>><?php echo $potrero['nombre']; ?></option>
            <?php
        }

        ?>
    </select>
    <br>
    <input type="submit" value="Registrar">




</form>
<a href="read.php">regresar a lectura de vacas</a>