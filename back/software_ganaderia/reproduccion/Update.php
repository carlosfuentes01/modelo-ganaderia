<!-- update.php -->
<?php
include '../../conexion/conexion.php';
session_start();

$id = $_REQUEST['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $raza = $_POST['raza'];
    $fecha_descubrimiento = $_POST['fecha_descubrimiento'];
    $modo_concepcion = $_POST['modo_concepcion'];
    $fecha_pronosticada_parto = $_POST['fecha_pronosticada_parto'];
    $fecha_aproximada_parto = $_POST['fecha_aproximada_parto'];
    $descripcion = $_POST['descripcion'];

    $sql = "UPDATE control_embarazo SET 
            codigo='$codigo',
            raza='$raza',
            fecha_deteccion='$fecha_descubrimiento',
            modo_concepcion='$modo_concepcion',
            fecha_estimada_de_parto='$fecha_pronosticada_parto',
            fecha_aproximada_parto='$fecha_aproximada_parto',
            descripcion='$descripcion'
            WHERE idcontrol_embarazo=$id";

    if ($conexion->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}

$sql = "SELECT * FROM control_embarazo WHERE idcontrol_embarazo=$id";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Actualizar Registro de Embarazo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Actualizar Registro de Embarazo</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Código:</label>
                <input type="text" name="codigo" value="<?php echo $row['codigo']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Raza:</label>
                <input type="text" name="raza" value="<?php echo $row['raza']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Fecha de descubrimiento:</label>
                <input type="date" name="fecha_descubrimiento" value="<?php echo $row['fecha_deteccion']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Modo de concepción:</label>
                <input type="text" name="modo_concepcion" value="<?php echo $row['modo_concepcion']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Fecha pronosticada de parto:</label>
                <input type="date" name="fecha_pronosticada_parto" value="<?php echo $row['fecha_estimada_de_parto']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Fecha aproximada de parto:</label>
                <input type="date" name="fecha_aproximada_parto" value="<?php echo $row['fecha_aproximada_parto']; ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Descripción:</label>
                <textarea name="descripcion" class="form-control"><?php echo $row['descripcion']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="index.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
