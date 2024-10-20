<?php
// Conexión a la base de datos
include ' ';

// Verificar la conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener los valores enviados desde el formulario
$personal_dni = $_POST['personal_dni'];
$finca_id = $_POST['finca_id'];

// Comprobar si el personal ya está asignado a la finca
$check_sql = "SELECT * FROM finca_has_personal WHERE finca_id='$finca_id' AND personal_dni='$personal_dni'";
$check_result = mysqli_query($conexion, $check_sql);

if (mysqli_num_rows($check_result) > 0) {
    // Si ya existe la asignación
    echo "Este personal ya está asignado a esta finca.";
} else {
    // Si no existe, proceder con la inserción
    $sql = "INSERT INTO finca_has_personal (finca_id, personal_dni) VALUES ('$finca_id', '$personal_dni')";

    // Ejecutar la consulta y verificar si fue exitosa
    if (mysqli_query($conexion, $sql)) {
        echo "Personal asignado exitosamente a la finca.";
    } else {
        echo "Error: " . mysqli_error($conexion);
    }
}

// Cerrar la conexión
mysqli_close($conexion);
?>
