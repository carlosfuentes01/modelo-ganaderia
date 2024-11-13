<?php
include '../../../conexion/conexion.php'; // Conexión a la base de datos
session_start();

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
        echo "<script>window.alert('Actualización exitosa!');
        window.location.href='../../../software_ganaderia/salud/read_tratamiento.php';

</script>";
    } else {
        echo "Error al actualizar el tratamiento: " . $conexion->error;
    }
}