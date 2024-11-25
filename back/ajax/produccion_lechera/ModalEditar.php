
<?php
include '../../conexion/conexion.php'; //conexion a la base de datos
session_start();
// Verifica si el usuario está autenticado

$sesion=$_SESSION['dni'];
$id=$_POST["id_produccion"];

$sqlVacas = "SELECT v.id, v.nombre FROM vacas v
             INNER JOIN potrero p ON v.potrero_id = p.id
             INNER JOIN finca f ON p.finca_id = f.id
             WHERE f.usuario_dni = $sesion";
$vacas = $conexion->query($sqlVacas);

// Consulta para obtener el registro actual de producción lechera
$sql = "SELECT * FROM produccion_lechera WHERE id_produccion = $id";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();


?>
     <div class="modal fade" id="ModalActualizar" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollableg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Actualizar leche</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                    <form method="POST" id="enviar" action="../../ajax/produccion_lechera/ProcesarEditar.php">
                                        <section class="Perfil d-flex">
                                            <img src="../imagenes/vaca.png" class="ImgPerfil" alt="">
                                            <div class="DivPerfil">
                                          
                                            </div>
                                        </section>
                                        <input type="hidden" name="id" value="<?=$id?>">
                                      
        Fecha de producción: <input type="date" name="fecha" value="<?php echo $row['fecha']; ?>"><br>
        Cantidad de producción (en litros): <input type="number" step="0.01" name="litros_leche" value="<?php echo $row['litros_leche']; ?>"><br>
        
        Vaca:
        <select name="vacas_id">
            <?php
            while ($vaca = $vacas->fetch_assoc()) {
                ?>
                <option <?php if ($vaca['id'] == $row['vacas_id']) echo 'selected'; ?> value="<?php echo $vaca['id']; ?>">
                    <?php echo $vaca['nombre']; ?>
                </option>
                <?php
            }
            ?>
        </select><br>
    </form>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" onclick="hola()" class="btn btn-primary">ACTUALIZAR LECHE</button>
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