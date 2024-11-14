<?php
include '../../conexion/conexion.php'; 

$id=$_POST['idembarazo'];
$ident=$conexion->query("SELECT * from control_embarazo WHERE idcontrol_embarazo=$id");
$a=$ident->fetch_object();
$tipo=$a->modo_concepcion;
$descripcion=$a->fecha_deteccion;
?>
<!-- Modal -->
<div class="modal fade" id="ModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title " id="exampleModalLabel">Eliminar registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="Delete" method="POST" action="../../ajax/reproduccion/ProcesarBorrar.php">
        <input name="idembarazo" type="hidden" value="<?=$id?>">
        <h2>Seguro que desea eliminar este registro?</h2>
        <p>Tipo: <?=$tipo?></p>
        <textarea style="width: 100%;" name="" id=""><?=$descripcion?></textarea>
        </form>
      </div>
      <div class="modal-footer bg-danger text-white">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="EnviarBorrar()" class="btn btn-primary">Eliminar registro</button>
      </div>
    </div>
  </div>
</div>
<script>
function EnviarBorrar() {
    document.getElementById("Delete").submit();
}
</script>