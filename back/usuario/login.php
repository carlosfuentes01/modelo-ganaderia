<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesion</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/index.css">
</head>



<?php
session_start();
include '../conexion/conexion.php'; // Conexión a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST['dni'];
    $contra = $_POST['contra'];

    // Busca al usuario con el correo electrónico y la contraseña
    $sql = "SELECT * FROM usuario WHERE dni = $dni AND contra = '$contra'";
    $result = $conexion->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Guarda el DNI del usuario en la sesión
        $_SESSION['dni'] = $row['dni'];
        $_SESSION['username'] = $row['usuario'];
        echo "Inicio de sesión exitoso!";
        $sql1 = "SELECT * FROM finca WHERE usuario_dni = $dni";
        $fincas = $conexion->query($sql);
        if ( $fincas->num_rows == 1) {
            header("Location: ../software_ganaderia/registro_animales/read.php");
        }else{
            header("Location: finca_potrero.php");
        }
         // Redirige a la página de usuario
        exit;
    } else {
        ?>
        
	<div class="alert alert-danger" role="alert" >
  dni y/o contraseña incorrecta
</div>
<?php

    }
}
?>
<body class="d-flex justify-content-center mx-auto p-5"></body>
<form method="POST" action="">
    <div class="d-flex 
     contenedor border rounded-4" id="">
     
        <div class=" border rounded-start-4 texto d-flex flex-column justify-content-center">
            <h1 class="mx-5">¡Bienvenido!</h1>
            <p class="mx-5">Gestiona tu software ganadero de manera eficiente. Inicia sesión con tus datos para
                continuar.</p>
        </div>
        <!-- Input de Nombre -->
        <div class=" border rounded-end-4 registrar d-flex flex-column justify-content-center">
       

<form id="lo" method="POST" action="">
            <p class="mx-5"><b>DNI</b></p>
             <!-- Input de DNI -->
            <div class="input-group mb-3 inputs mx-5">
                <span class="input-group-text" id="basic-addon1">@</span>
                <input type="Number" name="dni" class="form-control" placeholder="DNI" aria-describedby="basic-addon1" required>
            </div>
           
            <p class="mx-5"><b>Contraseña</b></p>
            <!-- Input de Correo Contraseña -->
            <div class="input-group mb-3 inputs mx-5">
                <span class="input-group-text" id="basic-addon1">*</span>
                <input type="password" name="contra" class="form-control" placeholder="Contraseña" aria-describedby="basic-addon1" required>
            </div>

            <input type="submit" value="Iniciar Sesión" onclick="send()" type="submit" class="mx-5 mt-3 btn btn-primary inputs"></button>
            <div class="d-flex justify-content-center mx-5 inputs mt-3">
                <p class="">¿No tienes cuenta? <a href="./registro.php">registrate aqui</a></p>
            </div>
            </form>
<script>function send(){
    document.getElementById("lo").submit();
}
</script>

        </div>
    </div>
    </form>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

</html>




