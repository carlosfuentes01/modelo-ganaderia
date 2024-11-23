<a href="read_tratamiento.php">Regresar a lectura de tratamientos</a>
<?php
include '../../conexion/conexion.php'; // Conexión a la base de datos
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}


// Obtener el ID del tratamiento a actualizar
$idtratamiento = $_REQUEST['idtratamiento'];

// Consultar los detalles del tratamiento actual
$sql = "SELECT * FROM tratamiento WHERE idtratamiento = $idtratamiento";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();

// Obtener las enfermedades para el desplegable
$sql_enfermedades = "SELECT * FROM enfermedades";
$enfermedades = $conexion->query($sql_enfermedades);

if (isset($_POST['tipo'])) {
    // Datos enviados para actualizar
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $horarios_aplicacion = $_POST['horarios_aplicacion'];
    $nombre = $_POST['nombre'];
    $idtratamiento = $_POST['idtratamiento'];
    $enfermedades_id = $_POST['enfermedades_idenfermedades'] ?? 'NULL';

    // Sentencia SQL para actualizar el tratamiento
    $sql_update = "UPDATE tratamiento SET 
                    tipo = '$tipo', 
                    descripcion = '$descripcion', 
                    horarios_aplicacion = '$horarios_aplicacion', 
                    nombre = '$nombre', 
                    enfermedades_idenfermedades = $enfermedades_id 
                   WHERE idtratamiento = $idtratamiento";

    if ($conexion->query($sql_update) === TRUE) {
        echo "Tratamiento actualizado exitosamente";
    } else {
        echo "Error al actualizar el tratamiento: " . $conexion->error;
    }
} else {
    // Mostrar el formulario con los datos actuales del tratamiento
?>

<form method="POST" action="">
    <input type="hidden" name="idtratamiento" value="<?php echo $idtratamiento; ?>">

    Tipo: <input type="text" name="tipo" value="<?php echo $row['tipo']; ?>" required><br>
    Descripción: <textarea name="descripcion" required><?php echo $row['descripcion']; ?></textarea><br>
    Horarios de Aplicación: <input type="text" name="horarios_aplicacion" value="<?php echo $row['horarios_aplicacion']; ?>" required><br>
    Nombre: <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required><br>
    Enfermedad Asociada:
    <select name="enfermedades_idenfermedades">
        <option value="">Seleccione una enfermedad</option>
        <?php
        // Crear opciones del desplegable de enfermedades
        while ($enfermedad = $enfermedades->fetch_assoc()) {
            $selected = ($enfermedad['idenfermedades'] == $row['enfermedades_idenfermedades']) ? 'selected' : '';
            echo "<option value='" . $enfermedad['idenfermedades'] . "' $selected>" . $enfermedad['tipo'] . "</option>";
        }
        ?>
    </select><br>
    <input type="submit" value="Actualizar">
</form>

<?php
}
?>
