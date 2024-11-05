<a href="read_tratamiento.php">Regresar a lectura de tratamientos</a>
<?php
include '../../conexion/conexion.php'; // Conexión a la base de datos
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

// Obtener la lista de enfermedades para el desplegable
$sql_enfermedades = "SELECT * FROM enfermedades";
$enfermedades = $conexion->query($sql_enfermedades);

if (isset($_POST['tipo'])) {
    // Verificar si se ha seleccionado una enfermedad
    if (empty($_POST['enfermedades_idenfermedades'])) {
        echo "Por favor, seleccione una enfermedad asociada.";
    } else {
        // Recoger los datos del formulario
        $tipo = $_POST['tipo'];
        $descripcion = $_POST['descripcion'];
        $horarios_aplicacion = $_POST['horarios_aplicacion'];
        $nombre = $_POST['nombre'];
        $enfermedades_id = $_POST['enfermedades_idenfermedades'];

        // Sentencia SQL para insertar el tratamiento
        $sql_insert = "INSERT INTO tratamiento (tipo, descripcion, horarios_aplicacion, nombre, enfermedades_idenfermedades) 
                       VALUES ('$tipo', '$descripcion', '$horarios_aplicacion', '$nombre', $enfermedades_id)";

        if ($conexion->query($sql_insert) === TRUE) {
            echo "Tratamiento creado exitosamente";
        } else {
            echo "Error al crear el tratamiento: " . $conexion->error;
        }
    }
}
?>

<form method="POST" action="">
    Tipo: <input type="text" name="tipo" required><br>
    Descripción: <textarea name="descripcion" required></textarea><br>
    Horarios de Aplicación: <input type="text" name="horarios_aplicacion" required><br>
    Nombre: <input type="text" name="nombre" required><br>
    Enfermedad Asociada:
    <select name="enfermedades_idenfermedades">
        <option value="">Seleccione una enfermedad</option>
        <?php
        while ($enfermedad = $enfermedades->fetch_assoc()) {
            echo "<option value='" . $enfermedad['idenfermedades'] . "'>" . $enfermedad['tipo'] . "</option>";
        }
        ?>
    </select><br>
    <input type="submit" value="Crear Tratamiento">
</form>
