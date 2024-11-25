<?php 
include '../../conexion/conexion.php';

$peso = $_POST['peso'];
$fecha_descripcion = $_POST['fecha_descripcion'];
$condicion_corporal = $_POST['condicion_corporal'];
$descripcion = $_POST['descripcion'];
$vaca_id = $_POST['vaca'];
$crecimiento_id = $_POST['crecimiento'];
$aspecto_id = $_POST['id'];

$sql_update = "UPDATE aspectos_fisicos SET 
                peso = '$peso', 
                fecha_descripcion = '$fecha_descripcion', 
                condicion_corporal = '$condicion_corporal', 
                descripcion = '$descripcion',
                id_vaca = $vaca_id,
                crecimiento_id_crecimiento = $crecimiento_id
               WHERE id = $aspecto_id";

if ($conexion->query($sql_update) === TRUE) {
    echo "<script>window.alert('Actualización exitosa!');
                window.location.href='../../software_ganaderia/registro_animales/read_aspectos_fisicos.php';
        
        </script>";
} else {
    echo "Error: " . $sql_update . "<br>" . $conexion->error;
}