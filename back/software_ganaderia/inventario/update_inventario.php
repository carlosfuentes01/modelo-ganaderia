<?php
include '../../conexion/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $cantidad = $_POST['cantidad'];

        if (!empty($id) && is_numeric($id)) {
            $sql = "UPDATE inventario SET nombre='$nombre', cantidad='$cantidad' WHERE id='$id'";

            if ($conexion->query($sql) === TRUE) {
                echo "Inventario actualizado exitosamente.";
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
        } else {
            echo "ID inválido.";
        }
    } else {
        echo "ID no definido.";
    }
}


$sql_inventarios = "SELECT id, nombre, cantidad FROM inventario";
$result_inventarios = $conexion->query($sql_inventarios);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Actualizar Inventario</title>
    <script>
        function cargarDatos() {
            var select = document.getElementById("inventarioSelect");
            var nombreInput = document.getElementById("nombre");
            var cantidadInput = document.getElementById("cantidad");
            
            var selectedOption = select.options[select.selectedIndex];
            var nombre = selectedOption.getAttribute("data-nombre");
            var cantidad = selectedOption.getAttribute("data-cantidad");

            nombreInput.value = nombre;
            cantidadInput.value = cantidad;
        }
    </script>
</head>
<body>

<form method="POST" action="">
    ID del Inventario:
    <select name="id" id="inventarioSelect" onchange="cargarDatos()" required>
        <option value="">Seleccione un inventario</option>
        <?php while ($inventario = $result_inventarios->fetch_assoc()) { ?>
            <option value="<?php echo $inventario['id']; ?>" 
                    data-nombre="<?php echo $inventario['nombre']; ?>" 
                    data-cantidad="<?php echo $inventario['cantidad']; ?>">
                <?php echo $inventario['nombre']; ?>
            </option>
        <?php } ?>
    </select><br>

    Nombre del Inventario: <input type="text" id="nombre" name="nombre" required><br>
    Cantidad: <input type="number" id="cantidad" name="cantidad" required><br>
    <input type="submit" value="Actualizar Inventario">
</form>

</body>
</html>
