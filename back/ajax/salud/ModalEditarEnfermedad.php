
<?php
include '../../conexion/conexion.php'; //conexion a la base de datos
session_start();
// Verifica si el usuario está autenticado

$idenfermedades = $_POST['idenfermedades']; // Obtiene el id de la enfermedad a actualizar

// Obtén los datos actuales de la enfermedad
$sql = "SELECT * FROM enfermedades WHERE idenfermedades=$idenfermedades";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();



?>
     <div class="modal fade" id="ModalActualizar" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollableg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Actualizar Vaca</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" id="enviar" style="width: 100%;" action="../../ajax/salud/ProcesarEditarPotrero.php">
        <input type="hidden" name="idenfermedades" value="<?php echo $idenfermedades; ?>">

        Tipo: <input style="width: 100%;" type="text" name="tipo" value="<?php echo $row['tipo']; ?>" required><br>
        Descripción: <textarea style="width: 100%;" name="descripcion"><?php echo $row['descripcion']; ?></textarea><br>
        Posible Causa: <input style="width: 100%;" type="text" name="posible_causa" value="<?php echo $row['posible_causa']; ?>"><br>
        Síntomas: <textarea style="width: 100%;" name="sintomas"><?php echo $row['sintomas']; ?></textarea><br>
        Transmisible: 
        <input type="checkbox" name="transmisible" value="1" <?php if ($row['transmisible'] == 1) echo 'checked'; ?>><br>
        
    </form>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" onclick="hola()" class="btn btn-primary">Actualizar enfermedad</button>
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