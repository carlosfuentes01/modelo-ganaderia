<a href="read_enfermedades.php">Regresar a la lectura de enfermedades</a>
<?php
include '../../conexion/conexion.php'; // Conexión a la base de datos
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

$idenfermedades = $_REQUEST['idenfermedades']; // Obtiene el id de la enfermedad a actualizar

// Obtén los datos actuales de la enfermedad
$sql = "SELECT * FROM enfermedades WHERE idenfermedades=$idenfermedades";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();

if (isset($_POST['tipo'])) { // Si se envió el formulario
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $posible_causa = $_POST['posible_causa'];
    $sintomas = $_POST['sintomas'];
    $idenfermedades = $_POST['idenfermedades'];
    $transmisible = isset($_POST['transmisible']) ? 1 : 0; // Convertir a 1 o 0

    // Actualizar la enfermedad en la base de datos
    $sql = "UPDATE enfermedades SET 
                tipo='$tipo', 
                descripcion='$descripcion', 
                posible_causa='$posible_causa', 
                sintomas='$sintomas', 
                transmisible='$transmisible' 
            WHERE idenfermedades=$idenfermedades";

    if ($conexion->query($sql) === TRUE) {
        echo "Actualización exitosa!";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
} else {
?>

    <!-- Formulario para editar la enfermedad -->
    <form method="POST" action="">
        <input type="hidden" name="idenfermedades" value="<?php echo $idenfermedades; ?>">

        Tipo: <input type="text" name="tipo" value="<?php echo $row['tipo']; ?>" required><br>
        Descripción: <textarea name="descripcion"><?php echo $row['descripcion']; ?></textarea><br>
        Posible Causa: <input type="text" name="posible_causa" value="<?php echo $row['posible_causa']; ?>"><br>
        Síntomas: <textarea name="sintomas"><?php echo $row['sintomas']; ?></textarea><br>
        Transmisible: 
        <input type="checkbox" name="transmisible" value="1" <?php if ($row['transmisible'] == 1) echo 'checked'; ?>><br>
        <input type="submit" value="Actualizar">
    </form>

<?php
}
?>
