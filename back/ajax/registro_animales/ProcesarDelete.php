<?php
 include "../../conexion/conexion.php";
 $id=$_POST['VacaId'];
 $sql = "DELETE FROM vacas WHERE id=$id";

if ($conexion->query($sql) === TRUE ) {
    echo "<script>window.alert('Registro eliminado exitosamente')</script>";
} else {
    echo "Error: " . $conexion->error;
}
?>