<?php
include '../../../conexion/conexion.php'; 
$id_potrero = $_REQUEST['id_potrero']; 

$sql = "SELECT * FROM potrero WHERE id = $id_potrero";
$result = $conexion->query($sql);
$row = $result->fetch_assoc();

?>
<!-- Modal -->
<div class="modal fade" id="ModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title " id="exampleModalLabel">Eliminar potrero</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="Delete" method="POST" action="../../ajax/registro_animales/potrero/ProcesarBorrar.php">
        <input name="id_potrero" type="hidden" value="<?=$id_potrero?>">
        <h2>Seguro que desea eliminar este potrero</h2>
        <p>Nombre: <?=$row['nombre']?></p>
        </form>
      </div>
      <div class="modal-footer bg-danger text-white">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="EnviarBorrar()" class="btn btn-primary">Eliminar potrero</button>
      </div>
    </div>
  </div>
</div>
<script>
function EnviarBorrar() {
    document.getElementById("Delete").submit();
}
</script>