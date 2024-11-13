<?php
include '../../conexion/conexion.php'; 

$id=$_POST['Idvaca'];
$ident=$conexion->query("SELECT identificacion,nombre from vacas where id=$id");
$a=$ident->fetch_object();
$identificacion=$a->identificacion;
$nombre=$a->nombre;
?>
<!-- Modal -->
<div class="modal fade" id="ModalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title " id="exampleModalLabel">Eliminar vaca</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="Delete" method="POST" action="../../ajax/registro_animales/ProcesarDelete.php">
        <input name="VacaId" type="hidden" value="<?=$id?>">
        <h2>Seguro que desea eliminar a esta vaca?</h2>
        <p>Identificacion: <?=$identificacion?></p>
        <p>Nombre: <?=$nombre?></p>
        </form>
      </div>
      <div class="modal-footer bg-danger text-white">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="EnviarBorrar()" class="btn btn-primary">Eliminar vaca</button>
      </div>
    </div>
  </div>
</div>
<script>
function EnviarBorrar() {
    document.getElementById("Delete").submit();
}
</script>