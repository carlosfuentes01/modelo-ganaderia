<a href='create_enfermedades.php'>Añadir Enfermedad</a>
<?php
include '../../conexion/conexion.php';
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

// Consulta para obtener todas las enfermedades
$sql = "SELECT * FROM enfermedades";
$enfermedades = $conexion->query($sql);

if ($enfermedades->num_rows > 0) {
    ?>
    <table>
        <tr>
            <th>Tipo</th>
            <th>Descripción</th>
            <th>Posibles Causas</th>
            <th>Síntomas</th>
            <th>Transmisible</th>
            <th>Acciones</th>
        </tr>

        <?php
    
    while($row = $enfermedades->fetch_assoc()) {
        // Usar un if para determinar si el valor es "Sí" o "No"
        if ($row["transmisible"] == 1) {
            $transmisible_text = "Sí";
        } else {
            $transmisible_text = "No";
        }
        
        ?><tr>
                <td><?=$row["tipo"]?></td>
                <td><?=$row["descripcion"]?></td>
                <td><?=$row["posible_causa"]?></td>
                <td><?=$row["sintomas"]?></td>
                <td><?=$transmisible_text?></td>
                <td>
                    <form method='POST' action='update_enfermedades.php' style='display:inline;'>
                        <input type='hidden' name='idenfermedades' value='<?=$row['idenfermedades']?>'>
                        <input type='submit' value='Editar'>
                    </form>
                    
                    <form method='POST' action='delete_enfermedades.php' style='display:inline;'>
                        <input type='hidden' name='idenfermedades' value='<?=$row['idenfermedades']?>'>
                        <input type='submit' value='Eliminar'>
                    </form>
                </td>
            </tr>
            <?php
    }
    ?></table>

    <?php
} else {
    echo "No hay registros de enfermedades";
}
?>
