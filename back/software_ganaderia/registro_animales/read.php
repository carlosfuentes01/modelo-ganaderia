<a href='create.php'>crear vaca</a>
<?php
include '../../conexion/conexion.php'; 
session_start();
// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}
$sesion=$_SESSION['dni'];
#falta la sesion

$sql1="SELECT * from vacas where potrero_id in
 (select id from potrero where finca_id =
 (select id from finca where usuario_dni = $sesion))";

#potrero
$vacas = $conexion->query($sql1);

if ($vacas->num_rows > 0) {
    echo "
    <table border='1'>
            <tr>
                <th>Identificación</th>
                <th>Nombre</th>
                <th>Fecha de registro animal</th>
                <th>Género</th>
                <th>Descartada</th>
                <th>Razas</th>
                <th>Potrero</th>
                <th>Acciones</th>
            </tr>";
    
    while($row = $vacas->fetch_assoc()) {
        echo "<tr>
                 <td>".$row["identificacion"]."</td>
                <td>".$row["nombre"]."</td>
                <td>".$row["fecha_de_registro_animal"]."</td>
                <td>".$row["genero"]."</td>
                <td>".$row["descartada"]."</td>
                <td>";
                $sql2= "SELECT * FROM raza
                where id_raza in(select raza_id_raza from razas_de_la_vaca
                where vacas_id_animal =$row[id])";
                
                $razas = $conexion->query($sql2); 
               while ($raza =$razas ->fetch_assoc()) {
                    echo $raza['nombre']." ";
                    
                };echo"</td>
                <td>";
                $sql3= "SELECT * FROM potrero
                where id = $row[potrero_id]
                ";
                
                $potreros = $conexion->query($sql3); 
               while ($potrero =$potreros ->fetch_assoc()) {
                    echo $potrero['nombre']." ";
                    
                };echo"</td>
                <td>
                <form method='POST' action='update.php'>
    <input type='hidden' name='id' required value =".$row['id']."><br>
    <input type='submit' value='Editar'>
</form>|
                    <form method='POST' action='delete.php'>
    <input type='hidden' name='id' required value =".$row['id']."><br>
    <input type='submit' value='Eliminar'>
</form>
            </tr>";
    }
    echo "</table>";
} else {
    echo "No hay registros";
}
?>
