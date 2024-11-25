<?php 
include '../../../conexion/conexion.php'; //conexion a la base de datos
session_start();
if (isset($_POST['nombre'])) {
    $nombre = $_POST['nombre'];
    $finca_id = $_POST['finca_id'];
    $id_potrero = $_POST['id_potrero'];

    // Consulta para actualizar el registro en la tabla potrero
    $sqlUpdate = "UPDATE potrero SET 
                    nombre = '$nombre', 
                    finca_id = '$finca_id'
                  WHERE id = $id_potrero";

    if ($conexion->query($sqlUpdate) === TRUE) {
        echo "<script>window.alert('Actualización exitosa!');
                window.location.href='../../../software_ganaderia/registro_animales/read_potrero.php';
        
        </script>";
    } else {
        echo "Error: " . $sqlUpdate . "<br>" . $conexion->error;
    }
}
?>