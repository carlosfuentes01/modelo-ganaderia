
<?php
include '../../../conexion/conexion.php'; //conexion a la base de datos
session_start();
// Verifica si el usuario está autenticado

$idtratamiento = $_POST['idtratamiento']; // Obtiene el id de la enfermedad a actualizar

// Obtén los datos actuales de la enfermedad
$sql = "SELECT * FROM tratamiento WHERE idtratamiento = $idtratamiento";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();

// Obtener las enfermedades para el desplegable
$sql_enfermedades = "SELECT * FROM enfermedades";
$enfermedades = $conexion->query($sql_enfermedades);


?>
     <div class="modal fade" id="ModalActualizar" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollableg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Actualizar tratamiento</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" id="enviar" style="width: 100%;" action="../../ajax/salud/Tratamiento/ProcesarEditarTratamiento.php">
                                    <input type="hidden" name="idtratamiento" value="<?php echo $idtratamiento; ?>">

Tipo: <input style="width: 100%;"  type="text" name="tipo" value="<?php echo $row['tipo']; ?>" required><br>
Descripción: <textarea style="width: 100%;" name="descripcion" required><?php echo $row['descripcion']; ?></textarea><br>
Horarios de Aplicación: <input style="100%" type="text" name="horarios_aplicacion" value="<?php echo $row['horarios_aplicacion']; ?>" required><br>
Nombre: <input style="width: 100%;" type="text" name="nombre" value="<?php echo $row['nombre']; ?>" required><br>
Enfermedad Asociada:
<select style="width: 100%;" name="enfermedades_idenfermedades">
    <option value="">Seleccione una enfermedad</option>
    <?php
    // Crear opciones del desplegable de enfermedades
    while ($enfermedad = $enfermedades->fetch_assoc()) {
        $selected = ($enfermedad['idenfermedades'] == $row['enfermedades_idenfermedades']) ? 'selected' : '';
        echo "<option value='" . $enfermedad['idenfermedades'] . "' $selected>" . $enfermedad['tipo'] . "</option>";
    }
    ?>
</select><br>



        
    </form>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" onclick="hola()" class="btn btn-primary">Actualizar tratamiento</button>
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