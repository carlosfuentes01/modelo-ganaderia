<a href="read.php">regresar a lectura de vacas</a>
<?php
include '../../conexion/conexion.php'; //conexion a la base de datos
session_start();
// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}
$sesion=$_SESSION['dni'];
$id = $_REQUEST['id'];

$sql2 = "SELECT * FROM marcacion";
$marcaciones = $conexion->query($sql2);
$sql3 = "SELECT * FROM potrero where finca_id in(select id from finca where usuario_dni = $sesion)";
$potreros = $conexion->query($sql3);



if (isset($_POST['nombre'])) {
    $identificacion = $_POST['identificacion'];
    $nombre = $_POST['nombre'];
    $fecha_de_registro_animal = $_POST['fecha_de_registro_animal'];
    $genero = $_POST['genero'];
    $descartada = $_POST['descartada'];
    $potrero_id = $_POST['potrero'];

    $sql = "UPDATE vacas SET 
                identificacion='$identificacion', 
                nombre='$nombre', 
                fecha_de_registro_animal='$fecha_nacimiento', 
                peso='$peso', 
                estado_salud='$estado_salud',
                genero='$genero',
                id_raza='$id_raza' 
            WHERE id_animal=$id";

    if ($conexion->query($sql) === TRUE) {
        echo "Actualización exitosa!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
} else {
    $sql = "SELECT * FROM vacas WHERE id=$id";
    $result = $conexion->query($sql);
    $row = $result->fetch_assoc();

    $sql4 = "SELECT * FROM potrero where id = $row[potrero_id]";
$query_potrero_escogido = $conexion->query($sql4);
$potrero_escogido=$query_potrero_escogido->fetch_assoc();

$sql5 = "SELECT * FROM marcacion where id =$row[marcacion_id]";
$query_marcacion_escogida = $conexion->query($sql5);
$marcacion_escogida=$query_marcacion_escogida->fetch_assoc();
   
$sql1 = "SELECT * FROM raza
     where id_raza not in(select raza_id_raza from razas_de_la_vaca
    where vacas_id_animal =$row[id]) ";
$razas = $conexion->query($sql1);
 
    $sql6= "SELECT * FROM raza
    where id_raza in(select raza_id_raza from razas_de_la_vaca
    where vacas_id_animal =$row[id]) ";

    $razas_seleccionadas = $conexion->query($sql6); 


?>
    <form method="POST" action="">
        identificacion: <input type="text" name="identificacion" value="<?php echo $row['identificacion']; ?>"><br>
        Nombre: <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"><br>
        fecha de registro animal: <input type="date" name="fecha_de_registro_animal" value="<?php echo $row['fecha_de_registro_animal']; ?>"><br>
        Género: 
        <select name="genero">
            <option value="Toro" <?php if($row['genero'] == 'Hembra') echo 'selected'; ?>>Hembra</option>
            <option value="Vaca" <?php if($row['genero'] == 'Macho') echo 'selected'; ?>>Macho</option>
        </select><br>
        Descartada: 
        <select name="descartada">
            <option value="Toro" <?php if($row['descartada'] == 'Activa') echo 'selected'; ?>>Activa</option>
            <option value="Vaca" <?php if($row['descartada'] == 'Descartada') echo 'selected'; ?>>Descartada</option>
            <option value="Vaca" <?php if($row['descartada'] == 'Vendida') echo 'selected'; ?>>Vendida</option>
        </select><br>
        Raza:
    <?php
    while ($razas_seleccion = $razas_seleccionadas->fetch_assoc()) {
        ?>
        <input checked
        type="checkbox" name="<?php echo $razas_seleccion['id_raza']; ?>" value="<?php echo $razas_seleccion['id_raza']; ?>">
        <label for="raza"> <?php echo $razas_seleccion['nombre']; ?></label><br>
        <?php
    }
    while ($raza_input = $razas->fetch_assoc()) {
        ?>
        <input
        type="checkbox" name="<?php echo $raza_input['id_raza']; ?>" value="<?php echo $raza_input['id_raza']; ?>">
        <label for="raza"> <?php echo $raza_input['nombre']; ?></label><br>
        <?php
    }

    ?>
    Marcacion :
    <select name="marcacion">
        <?php
        while ($marcacion = $marcaciones->fetch_assoc()) {
            ?>
            <option 
            <?php if($marcacion['id'] == $marcacion_escogida['id']) echo 'selected';?>
            value="<?php echo $marcacion['id']; ?>"><?php echo $marcacion['tipo_marcacion']; ?>
            </option>
            <?php
        }

        ?>
    </select> <br>
    potrero:
    <select name="potrero">
        <?php
        while ($potrero = $potreros->fetch_assoc()) {

            ?>
            <option <?php if($potrero['id'] == $potrero_escogido['id']) echo 'selected'; ?> value="<?php echo $potrero['id'];
            ?>"><?php echo $potrero['nombre']; ?></option>
            <?php
        }

        ?>
    </select>
    <br>
        <input type="submit" value="Actualizar">
    </form>
<?php
}
?>
