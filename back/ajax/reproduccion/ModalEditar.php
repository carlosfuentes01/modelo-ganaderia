<?php
include '../../conexion/conexion.php'; //conexion a la base de datos
session_start();
// Verifica si el usuario está autenticado

$id = $_POST['idembarazo']; // Obtiene el id de la enfermedad a actualizar

// Obtén los datos actuales de la enfermedad
$sql1 = "
    SELECT * FROM modo_concepcion
";
$update_query = "SELECT * from control_embarazo where idcontrol_embarazo = $id";
$update_conexion = $conexion->query($update_query);
$update = $update_conexion->fetch_assoc();
$modo = $conexion->query($sql1);
$hoy = date("Y-n-d");

?>
<div class="modal fade" id="ModalActualizar" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollableg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Actualizar registro</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="enviar" style="width: 100%;" action="../../ajax/reproduccion/ProcesarEditar.php">
                    <label  style="width: 100%;" for="fecha_deteccion">Fecha de deteccion:</label>
                    <input  style="width: 100%;" type="date" name="fecha_deteccion" required value="<?php echo $update['fecha_deteccion']; ?>"><br>
                    modo concepcion:
                    <select  style="width: 100%;" name="modo_concepcion">
                        <?php
                        while ($mod = $modo->fetch_assoc()) {

                            if ($mod['id'] == $update['modo_concepcion']) {
                                echo "<option selected value='{$mod['id']}'>{$mod['nombre_modo']} </option>";
                            } else {
                                echo "<option value='{$mod['id']}'>{$mod['nombre_modo']} </option>";
                            }
                        }
                        ?>
                    </select><br>

                    <input type="hidden" name="id" value="<?=$id?>">
                    <label  style="width: 100%;" for="fecha_estimada_de_parto">Fecha esperada parto:</label>
                    
                    <input  style="width: 100%;" type="date" name="fecha_estimada_de_parto" required value="<?php echo $update['fecha_estimada_de_parto']; ?>"><br>

                    <label for="fecha_aproximada_parto">Fecha del parto:</label>
                    <input  style="width: 100%;" type="date" name="fecha_aproximada_parto" value="<?php echo $update['fecha_aproximada_parto']; ?>"><br>


                    <label>Descripción:</label>
                    <input style="width: 100%;"  type="text" name="descripcion" required value="<?php echo $update['descripcion']; ?>"></input><br>
                  
                </form>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" onclick="hola()" class="btn btn-primary">Actualizar registro</button>
            </div>

        </div>
    </div>
</div>
</div>
</div>

<script>
    function hola(params) {
        document.getElementById("enviar").submit();
    }
</script>