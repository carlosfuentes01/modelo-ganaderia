<?php
include '../../conexion/conexion.php'; 

$id = $_POST['aspecto_id'];
$ident=$conexion->query("SELECT * from aspectos_fisicos WHERE id=$id");
$a=$ident->fetch_object();
$tipo=$a->descripcion;
$fecha=$a->fecha_descripcion;
?>
<!-- Modal -->
<div class="modal fade" id="ModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title " id="exampleModalLabel">Eliminar aspecto fisico</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="Delete" method="POST" action="../../ajax/Aspectos_Fisicos/ProcesarBorrar.php">
        <input name="id" type="hidden" value="<?=$id?>">
        <h2>Seguro que desea eliminar este aspecto fisico?</h2>
        <p>Nombre: <?=$tipo?></p>
        <p>Fecha: <?=$fecha?></p>
        </form>
      </div>
      <div class="modal-footer bg-danger text-white">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="EnviarBorrar()" class="btn btn-primary">Eliminar aspecto fisico</button>
      </div>
    </div>
  </div>
</div>
<script>
function EnviarBorrar() {
    document.getElementById("Delete").submit();
}
</script>