<!-- delete.php -->
<?php
include '../../conexion/conexion.php';
session_start();

$id = $_REQUEST['idembarazo'];

$sql = "DELETE FROM control_embarazo WHERE idcontrol_embarazo=$id";

if ($conexion->query($sql) === TRUE) {
    echo "<script>window.alert('Eliminación exitosa!');
                window.location.href='../../software_ganaderia/reproduccion/Read.php';
        
        </script>";
} else {
    echo "Error: " . $conexion->error;
}
?>