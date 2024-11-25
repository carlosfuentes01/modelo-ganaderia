<?php
include '../../conexion/conexion.php';


    $id = $_POST['id'];

    $sql = "DELETE FROM inventario WHERE id='$id'";
    if ($conexion->query($sql) === TRUE) {
        echo "<script>window.alert('Eliminacion exitosa!');
                window.location.href='../../software_ganaderia/inventario/read_inventario.php';
        
        </script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conexion->error;
    }
?>