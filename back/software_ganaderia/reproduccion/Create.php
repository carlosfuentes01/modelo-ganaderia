<!-- Modal de Registro -->
<div class="modal fade" id="registroModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">REGISTRO DE EMBARAZO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="embarazoForm" method="POST" action="create.php">
                            <div class="mb-3">
                                <label>CODIGO:</label>
                                <input type="text" name="codigo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>RAZA:</label>
                                <input type="text" name="raza" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>FECHA DE DESCUBRIMIENTO:</label>
                                <input type="date" name="fecha_descubrimiento" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>MODO CONCEPCION:</label>
                                <input type="text" name="modo_concepcion" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>FECHA PRONOSTICADA PARTO:</label>
                                <input type="date" name="fecha_pronosticada_parto" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>FECHA APROXIMADA PARTO:</label>
                                <input type="date" name="fecha_aproximada_parto" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label>DESCRIPCION:</label>
                                <textarea name="descripcion" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">REGISTRAR</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editarRegistro(id) {
            window.location.href = 'update.php?id=' + id;
        }

        function eliminarRegistro(id) {
            if(confirm('¿Está seguro de eliminar este registro?')) {
                window.location.href = 'delete.php?id=' + id;
            }
        }
    </script>
</body>
</html>

<!-- create.php -->
<?php
include '../../conexion/conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $raza = $_POST['raza'];
    $fecha_descubrimiento = $_POST['fecha_descubrimiento'];
    $modo_concepcion = $_POST['modo_concepcion'];
    $fecha_pronosticada_parto = $_POST['fecha_pronosticada_parto'];
    $fecha_aproximada_parto = $_POST['fecha_aproximada_parto'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO control_embarazo (codigo, raza, fecha_deteccion, modo_concepcion, fecha_estimada_de_parto, fecha_aproximada_parto, descripcion) 
            VALUES ('$codigo', '$raza', '$fecha_descubrimiento', '$modo_concepcion', '$fecha_pronosticada_parto', '$fecha_aproximada_parto', '$descripcion')";

    if ($conexion->query($sql) === TRUE) {
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
}
?>
