<?php
include 'conect.php';

$sesion = $_SESSION['dni'];

$id_vaca = $_GET['id'];

$sql = "delete p from produccion_lechera p join vacas v on p.vacas_id = v.id
join finca f on v.finca_id = f.id join usuario u on f.usuario_dni = u.dni
where u.dni = $sesion and p.vacas_id=$id_vaca";

if ($conexion->query($sql) === TRUE) {
    echo "Registro eliminado exitosamente";
} else {
    echo "Error: " . $conexion->error;
}
?>
