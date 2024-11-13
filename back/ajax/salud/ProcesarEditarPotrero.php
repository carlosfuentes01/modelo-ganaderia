<?php
include '../../conexion/conexion.php'; // Conexión a la base de datos
session_start();


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
        echo "<script>window.alert('Actualización exitosa!');
                window.location.href='../../software_ganaderia/salud/read_enfermedades.php';
        
        </script>";
        // header("location: ../../software_ganaderia/salud/read_enfermedades.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}

