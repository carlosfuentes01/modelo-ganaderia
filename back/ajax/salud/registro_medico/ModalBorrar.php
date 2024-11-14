<?php
include '../../../conexion/conexion.php'; 

$id=$_POST['id_reporte'];
$ident=$conexion->query("SELECT * from reporte_medico WHERE id_reporte=$id");
$a=$ident->fetch_object();
$tipo=$a->fecha_chequeo;
$descripcion=$a->notas_adicionales;
?>
<!-- Modal -->
<div class="modal fade" id="ModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title " id="exampleModalLabel">Eliminar reporte</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="Delete" method="POST" action="../../ajax/salud/registro_medico/ProcesarBorrar.php">
        <input name="id_reporte" type="hidden" value="<?=$id?>">
        <h2>Seguro que desea eliminar este reporte?</h2>
        <p>Fecha de chequeo: <?=$tipo?></p>
        <textarea style="width: 100%;" name="" id=""><?=$descripcion?></textarea>
        </form>
      </div>
      <div class="modal-footer bg-danger text-white">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="EnviarBorrar()" class="btn btn-primary">Eliminar reporte</button>
      </div>
    </div>
  </div>
</div>
<script>
function EnviarBorrar() {
    document.getElementById("Delete").submit();
}
</script>