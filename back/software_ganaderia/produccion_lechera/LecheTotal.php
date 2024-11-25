<!DOCTYPE html>
<html lang="en">
<?php
include "../../conexion/conexion.php";
session_start();
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}
$sesion = $_SESSION['dni'];
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- INSERCIONES DE AJAX Y JQUERY (ESTA CASADO CON DATATABLES)  -->
    <script src="https://kit.fontawesome.com/3d5e1e5029.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/Nav.css">
    <link rel="stylesheet" href="../../css/leche/LecheRazaTotal.css">

    <title>Raza de vaca</title>

</head>

<body>
<div id="BarraLateral">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar">
            <span class="fs-4">CowAlly</span>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="../produccion_lechera/read_produccion_lechera.php" class="nav-link text-white" aria-current="page"><i class="fa-solid fa-clipboard-check" style="color: #ff0000;"></i> GESTIONAR LECHE</a>
                </li>
                <li>
                    <a href="../registro_animales/read_aspectos_fisicos.php" class="nav-link text-white"><i class="fa-solid fa-cow" style="color: #ff0000;"></i>  GESTIONAR ASPECTOS FISICOS</a>
                </li>
                <li>
                    <a href="../produccion_lechera/LecheTotal.php" class="nav-link text-white"><i class="fa-solid fa-square-poll-vertical" style="color: #ff0000;"></i> TOTAL DE LECHE</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white"><i class="fa-solid fa-chart-simple" style="color: #ff0000;"></i> PRODUCCION DE LECHE MES ACTUAL</a>
                </li>
                <li>
                    <a href="../registro_animales/read_potrero.php" class="nav-link text-white"><i class="fa-solid fa-house-flag "style="color: #ff0000;"></i>  ADMINISTRAR POTREROS</a>
                </li>
                <li>
                    <a href="../registro_animales/read.php" class="nav-link text-white"><i class="fa-solid fa-clipboard-check" style="color: #ff0000;"></i> GESTIONAR VACAS</a>

                </li>
                <li>
                    <a href="../salud/read_reporte_medico.php" class="nav-link  text-white"><i class="fa-solid fa-clipboard-check" style="color: #ff0000;"></i> GESTIONAR REPORTES MEDICOS</a>

                </li>
                <li>
                    <a href="../salud/read_tratamiento.php" class="nav-link text-white"><i class="fa-solid fa-kit-medical" style="color: #ff0000;"></i> GESTIONAR TRATAMIENTO</a>

                </li>
                <li>
                    <a href="../salud/read_enfermedades.php" class="nav-link  text-white"><i class="fa-solid fa-code-merge" style="color: #ff0000;"></i> GESTIONAR ENFERMEDAD</a>

                </li>
                <li>
                    <a href="../reproduccion/Read.php" class="nav-link text-white"><i class="fa-solid fa-code-fork" style="color: #ff0000;"></i> GESTIONAR EMBARAZOS</a>

                </li>
                <li>
                    <a href="../inventario/read_inventario.php" class="nav-link  text-white"><i class="fa-solid fa-layer-group" style="color: #ff0000;"></i> GESTIONAR INVENTARIOS</a>

                </li>
                
            </ul>
            <hr>

        </div>
    </div>
    <div id="BloqueContenedor">
    <div id="navbar">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white">
                <div class="container-fluid">
                    <a class="navbar-brand" href="#">CowAlly</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item">

                                <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-hat-cowboy-side" style="color: #ff0000;"></i> VER PERSONAL</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../produccion_lechera/LecheVaca.php"><i class="fa-solid fa-droplet" style="color: #ff0000;"></i> VER LECHE PRODUCIDA INDIVIDUAL</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa-solid fa-house-crack" style="color: #ff0026;"></i> VER POTREROS</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-cow" style="color: #ff0000;"></i> Seleccionar Raza</a>

                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <form id="EnviarRaza" action="../produccion_lechera/RazaIndividual.php" method="post">
                                        <?php
                                        $Razas = $conexion->query("SELECT * FROM raza");
                                        while ($data = $Razas->fetch_object()) {
                                        ?>
                                            <li><a class="dropdown-item" onclick="NombreRaza('<?= $data->id_raza ?>')"
                                                    href="#"><?= $data->nombre ?></a></li>
                                        <?php
                                        }
                                        ?>
                                        <input id="nom" type="hidden" name="raza">
                                    </form>



                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>

        <div id="Grafica" class="mt-5">
            <div id="Contenedor"></div>
            <div>

                <h4>Leche producida por razas en el mes actual</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Raza</th>
                            <th scope="col">Leche (kg)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>

                        </tr>

                    </tbody>
                </table>
            </div>
        </div>





    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://fastly.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>
    <script>
        function NombreRaza(nombre) {
            document.getElementById("nom").value = nombre;
            document.getElementById("EnviarRaza").submit();
        }
        function GraficaTotal() {
            var parametros =
            {
                "nombre": "dostin",
                "apellido": "hurtado",
                "telefono": "123456789"
            };
            $.ajax({
                data: parametros,
                url: '../../ajax/leche/GraficaLecheTotal.php',
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