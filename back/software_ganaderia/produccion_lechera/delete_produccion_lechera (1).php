<?php
session_start();
include 'conexion.php';

// Verifica que el usuario esté autenticado y tenga un DNI en la sesión
if (!isset($_SESSION['dni'])) {
    echo "Error: Usuario no autenticado.";
    exit;
}

$dni_usuario = $_SESSION['dni'];

// Verifica que el ID se haya recibido por POST
if (isset($_POST['id_produccion'])) {
    $id = $_POST['id_produccion'];

    // Comprueba que el registro pertenezca al usuario autenticado
    $consulta_verificacion = "SELECT produccion_lechera.id_produccion 
                              FROM produccion_lechera
                              INNER JOIN vacas ON produccion_lechera.vacas_id = vacas.id
                              INNER JOIN potrero ON vacas.potrero_id = potrero.id
                              INNER JOIN finca ON potrero.finca_id = finca.id
                              INNER JOIN usuario ON finca.usuario_dni = usuario.dni
                              WHERE produccion_lechera.id_produccion = ? AND usuario.dni = ?";

    $stmt = $conexion->prepare($consulta_verificacion);
    $stmt->bind_param("is", $id, $dni_usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        // Si el registro pertenece al usuario, procedemos a eliminarlo
        $sql = "DELETE FROM produccion_lechera WHERE id_produccion = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Registro eliminado exitosamente!";
            // Redirigir a la página de listado después de la eliminación
            header("Location: read_produccion_lechera.php");
            exit;
        } else {
            echo "Error al eliminar el registro: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: Registro no encontrado o no tienes permiso para eliminarlo.";
    }
} else {
    echo "Error: No se recibió el ID del registro.";
}

?>
