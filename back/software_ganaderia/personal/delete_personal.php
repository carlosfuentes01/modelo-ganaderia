<?php
include ' ';//conexion a la base de datos

$id = $_GET['dni'];

$sql = "DELETE p from personal p
join finca_has_personal fp on p.dni = fp.personal_dni join finca f on fp.finca_id=f.id 
where p.dni = $id and f.usuario_dni=$_SESSION";

if ($conexion->query($sql) === TRUE) {
    echo "Registro eliminado exitosamente";
} else {
    echo "Error: " . $conexion->error;
}
?>
