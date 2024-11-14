<?php
include '../../conexion/conexion.php';
if (isset($_POST['fecha_estimada_de_parto'])) {
    $id=$_POST['id'];
    $fecha_deteccion = $_POST['fecha_deteccion'];
    $fecha_estimada_de_parto = $_POST['fecha_estimada_de_parto'];
    $modo_concepcion = $_POST['modo_concepcion'];
    $descripcion = $_POST['descripcion'];
    $fecha_aproximada_parto = $_POST['fecha_aproximada_parto'];
    if ($_POST['fecha_aproximada_parto'] == "") {

        $fecha_aproximada_parto="NULL";



        $sql = "UPDATE control_embarazo SET
        
        fecha_deteccion='$fecha_deteccion',
        fecha_aproximada_parto='$fecha_aproximada_parto',
        descripcion='$descripcion',
        fecha_estimada_de_parto='$fecha_estimada_de_parto',
        modo_concepcion='$modo_concepcion' WHERE idcontrol_embarazo=$id";
    }else{
        $sql = "UPDATE control_embarazo SET
        
        fecha_deteccion='$fecha_deteccion',
        fecha_aproximada_parto='$fecha_aproximada_parto',
        descripcion='$descripcion',
        fecha_estimada_de_parto='$fecha_estimada_de_parto',
        modo_concepcion='$modo_concepcion' WHERE idcontrol_embarazo=$id"; 
    }



    echo $sql;

    if ($conexion->query($sql) === TRUE) {
        echo "<script>window.alert('Actualización exitosa!');
                window.location.href='../../software_ganaderia/reproduccion/Read.php';
        
        </script>"; 
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}