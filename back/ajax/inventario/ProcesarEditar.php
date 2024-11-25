<?php
    include '../../conexion/conexion.php';
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $finca_id = $_POST['finca_id'];
    if (empty($finca_id)) {
        echo "<script>window.alert('No selecciono una finca :C');
        window.location.href='../../software_ganaderia/inventario/read_inventario.php';

</script>";
    }else{
    // Actualizar inventario con el nuevo nombre, cantidad y finca
    $sql = "UPDATE inventario SET nombre='$nombre', cantidad='$cantidad', finca_id_finca='$finca_id' WHERE id='$id'";
    if (mysqli_query($conexion, $sql)) {
        echo "<script>window.alert('Actualización exitosa!');
                window.location.href='../../software_ganaderia/inventario/read_inventario.php';
        
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conexion);
    }
}
