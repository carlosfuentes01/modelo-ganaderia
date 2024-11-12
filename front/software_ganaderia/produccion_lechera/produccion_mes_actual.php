<?php
include '../../conexion/conexion.php'; 
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

$sesion = $_SESSION['dni'];

// Consulta para obtener registros de producción lechera relacionados con el usuario
$sql1 = "SELECT SUM(produccion_lechera.litros_leche) as 'Producción de Leche(L)',raza.nombre as 'nombre de raza'
         FROM produccion_lechera
         RIGHT JOIN vacas
         ON produccion_lechera.vacas_id = vacas.id
         RIGHT JOIN razas_de_la_vaca 
         ON razas_de_la_vaca.vacas_id_animal = vacas.id
         RIGHT JOIN raza 
         ON raza.id_raza = razas_de_la_vaca.raza_id_raza
         where potrero_id in
 (select id from potrero where finca_id =
 (select id from finca where usuario_dni = $sesion))
 and Month(produccion_lechera.fecha)=Month(curdate())
 GROUP BY raza.nombre";

$producciones = $conexion->query($sql1);

if ($producciones->num_rows > 0) {
    echo "
    <table border='1'>
        <tr>
            <th>Raza</th>
            <th>Producción de Leche(L)</th>

        </tr>";
    
    while ($row = $producciones->fetch_assoc()) {
        echo "<tr>
                <td>".$row["Producción de Leche(L)"]."</td>
                <td>".$row["nombre de raza"]."</td>
                
              </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros de producción lechera de este mes";
}
?>
