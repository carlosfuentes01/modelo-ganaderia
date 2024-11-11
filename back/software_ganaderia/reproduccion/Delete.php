<!-- delete.php -->
<?php
include '../../conexion/conexion.php';
session_start();

$id = $_REQUEST['idcontrol_embarazo'];

$sql = "DELETE FROM control_embarazo WHERE idcontrol_embarazo=$id";

if ($conexion->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $conexion->error;
}
?>