
<?php
include '../../conexion/conexion.php'; //conexion a la base de datos
session_start();
// Verifica si el usuario está autenticado

$sesion=$_SESSION['dni'];
$id=$_POST["aspecto_id"];

// Consulta para obtener los datos del aspecto físico a actualizar
$sql_aspecto = "SELECT * FROM aspectos_fisicos WHERE id = $id";
$result_aspecto = $conexion->query($sql_aspecto);
$row = $result_aspecto->fetch_assoc();

// Consulta para llenar las opciones de vacas
$sql_vacas = "
    SELECT v.id, v.nombre, v.identificacion 
    FROM vacas v
    INNER JOIN potrero p ON v.potrero_id = p.id
    INNER JOIN finca f ON p.finca_id = f.id
    WHERE f.usuario_dni = '$sesion'
";
$vacas = $conexion->query($sql_vacas);

// Consulta para llenar las opciones de crecimiento
$sql_crecimientos = "SELECT id_crecimiento, categoria FROM crecimiento";
$crecimientos = $conexion->query($sql_crecimientos);



?>
     <div class="modal fade" id="ModalActualizar" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollableg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Actualizar aspecto fisico</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" id="enviar" action="../../ajax/Aspectos_Fisicos/ProcesarEditar.php">
                                    <label for="vaca">Vaca:</label>
        <select style="width: 100%;" name="vaca" required>
            <?php
            while ($vaca = $vacas->fetch_assoc()) {
                $selected = ($vaca['id'] == $row['id_vaca']) ? 'selected' : '';
                echo "<option value='{$vaca['id']}' $selected>{$vaca['nombre']} - Identificación: {$vaca['identificacion']}</option>";
            }
            ?>
        </select><br>

        <label for="peso">Peso:</label>
        <input style="width: 100%;" type="number" name="peso" required value="<?php echo $row['peso']; ?>"><br>

        <label for="fecha_descripcion">Fecha de Descripción:</label>
        <input style="width: 100%;" type="date" name="fecha_descripcion" required value="<?php echo $row['fecha_descripcion']; ?>"><br>

        <label for="condicion_corporal">Condición Corporal:</label>
        <input style="width: 100%;" type="number" name="condicion_corporal" value="<?php echo $row['condicion_corporal']; ?>"><br>

        <label for="descripcion">Descripción:</label>
        <textarea style="width: 100%;" name="descripcion"><?php echo $row['descripcion']; ?></textarea><br>

        <label for="crecimiento">Crecimiento:</label>
        <select style="width: 100%;" name="crecimiento" required>
            <?php
            while ($crecimiento = $crecimientos->fetch_assoc()) {
                $selected = ($crecimiento['id_crecimiento'] == $row['crecimiento_id_crecimiento']) ? 'selected' : '';
                echo "<option value='{$crecimiento['id_crecimiento']}' $selected>{$crecimiento['categoria']}</option>";
            }
            ?>
        </select><br>
                                        <input type="hidden" name="id" value="<?=$id?>">
                                      
      
    </form>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" onclick="hola()" class="btn btn-primary">ACTUALIZAR aspecto fisico</button>
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