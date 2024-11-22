<!DOCTYPE html>
<?php
include "../../conexion/conexion.php";
session_start();
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/login.php");
    exit;
}
$sesion = $_SESSION['dni'];


?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- INSERCIONES DE AJAX Y JQUERY (ESTA CASADO CON DATATABLES)  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/Nav.css">
    <link rel="stylesheet" href="../../css/leche/LecheVaca.css">

    <title>Raza de vaca</title>

</head>

<body>
    <div id="BarraLateral">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar">
            <span class="fs-4"></span>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">Leche</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">Perfil animal</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">Total leche</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">Produccion mes actual</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">Administrar potreros</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">ver razas</a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                    <strong>mdo</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#">New project...</a></li>
                    <li><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div id="BloqueContenedor">
        <div id="navbar">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">Navbar</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Features</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Pricing</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">Dropdown link</a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <div class="Informacion  mt-3 d-flex">
            <div>
            <form class="d-flex ms-5 Buscar">
                <input class="form-control me-2" type="search" placeholder="ID de vaca" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Buscar</button>
            </form>
            </div>

            <div class="fs-4">
                <p>Raza: Potrero: Estado:</p>
            </div>

        </div>
        <div id="Grafica" class="d-flex flex-column">
            <div id="Contenedor"></div>
            <div id="Botones" class="d-flex">
            <div><button class="btn btn-primary">Registro medico</button></div>
            <div><button class="btn btn-danger">Genealogia</button></div>
        </div>
        </div>
       




    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://fastly.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>
    <script>
        function GraficaTotal() {
            var parametros =
            {
                "nombre": "dostin",
                "apellido": "hurtado",
                "telefono": "123456789"
            };
            $.ajax({
                data: parametros,
                url: '../../php/ajax/GraficaLecheTotal.php',
                type: 'POST',

                beforeSend: function () {
                    $('#Contenedor').html("Mensjae antes de enviar");

                },
                success: function (mensaje_mostrar) {
                    $('#Contenedor').html(mensaje_mostrar);

                }
            });

        }
        window.onload = function () {
            GraficaTotal();
        }
    </script>


</body>

</html>