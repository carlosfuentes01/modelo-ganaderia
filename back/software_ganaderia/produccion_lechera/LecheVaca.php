<!DOCTYPE html>
<?php
include "../../conexion/conexion.php";
session_start();
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}
$sesion = $_SESSION['dni'];

date("n");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3d5e1e5029.js" crossorigin="anonymous"></script>

    <!-- INSERCIONES DE AJAX Y JQUERY (ESTA CASADO CON DATATABLES)  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="../../css/Nav.css">
    <link rel="stylesheet" href="../../css/leche/LecheVaca.css">

    <title>Raza de vaca</title>

</head>

<body>
<div id="BarraLateral">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar">
            <span class="fs-4">CowAlly</span>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="../produccion_lechera/read_produccion_lechera.php" class="nav-link text-white" aria-current="page"><i class="fa-solid fa-clipboard-check" style="color: #ff0000;"></i>  GESTIONAR LECHE</a>
                </li>
                <li>
                    <a href="../registro_animales/read_aspectos_fisicos.php" class="nav-link text-white"><i class="fa-solid fa-cow" style="color: #ff0000;"></i>  GESTIONAR ASPECTOS FISICOS</a>
                </li>
                <li>
                    <a href="../produccion_lechera/LecheTotal.php" class="nav-link text-white"><i class="fa-solid fa-square-poll-vertical" style="color: #ff0000;"></i> TOTAL DE LECHE</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white"><i class="fa-solid fa-chart-simple"style="color: #ff0000;"></i>  PRODUCCION DE LECHE MES ACTUAL</a>
                </li>
                <li>
                    <a href="../registro_animales/read_potrero.php" class="nav-link text-white"><i class="fa-solid fa-house-flag "style="color: #ff0000;"></i>  ADMINISTRAR POTREROS</a>
                </li>
                <li>
                    <a href="../registro_animales/read.php" class="nav-link text-white"><i class="fa-solid fa-clipboard-check" style="color: #ff0000;"></i>  GESTIONAR VACAS</a>

                </li>
                <li>
                    <a href="../salud/read_reporte_medico.php" class="nav-link  text-white"><i class="fa-solid fa-clipboard-check" style="color: #ff0000;"></i>  GESTIONAR REPORTES MEDICOS</a>

                </li>
                <li>
                    <a href="../salud/read_tratamiento.php" class="nav-link text-white"><i class="fa-solid fa-kit-medical" style="color: #ff0000;"></i>  GESTIONAR TRATAMIENTO</a>

                </li>
                <li>
                    <a href="../salud/read_enfermedades.php" class="nav-link  text-white"><i class="fa-solid fa-code-merge" style="color: #ff0000;"></i>  GESTIONAR ENFERMEDAD</a>
                  
                </li>
                <li>
                    <a href="../reproduccion/Read.php" class="nav-link   text-white"><i class="fa-solid fa-code-fork" style="color: #ff0000;"></i>  GESTIONAR EMBARAZOS</a>
                   
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
                            
                                <a class="nav-link " aria-current="page" href="#"><i class="fa-solid fa-hat-cowboy-side" style="color: #ff0000;"></i>  VER PERSONAL</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../produccion_lechera/LecheVaca.php"><i class="fa-solid fa-droplet" style="color: #ff0000;"></i> VER LECHE PRODUCIDA INDIVIDUAL</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa-solid fa-house-crack" style="color: #ff0026;"></i>  VER POTREROS</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link active bg-success rounded-3 dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false"><i class="fa-solid fa-cow" style="color: #ff0000;"></i>  Seleccionar Raza</a>

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

        <div class="Informacion  mt-3 d-flex">
            <div>
                <form class="d-flex ms-5 Buscar">
                    <input class="form-control me-2" type="search" placeholder="ID de vaca" aria-label="Search"
                        name="identificacion">
                    <button class="btn btn-outline-success" type="submit">Buscar</button>
                </form>
            </div>

            <div class="fs-4">
                
                <p><?php
                 if (!(isset($_REQUEST['identificacion'])) || $_REQUEST['identificacion'] == "" || $_REQUEST['identificacion'] === null) {
                    echo ''; #confirma de que se ha enviado algo
                } else {
                    $query_confirmacion = "SELECT identificacion from vacas where vacas.identificacion = '$_REQUEST[identificacion]' and vacas.potrero_id in
 (select id from potrero where finca_id =
 (select id from finca where usuario_dni = $sesion))";
                    $conexion_confirmacion = $conexion->query($query_confirmacion);
                    $confirmar = $conexion_confirmacion->fetch_assoc();
                    if ($confirmar["identificacion"]==$_REQUEST["identificacion"]) {
                        #como ya se confirmo que le pertenecia al usuario, ya no se tiene que hacer esa misma confirmacion despues
                        # confirma de que existe una vaca con esa identificacion
                        $sql1="SELECT nombre from potrero where potrero.id =(select potrero_id from vacas where identificacion = '$_REQUEST[identificacion]')";
                        $conexion_potrero=$conexion->query($sql1);
                        $potrero=$conexion_potrero->fetch_assoc();
                        $sql2="SELECT * FROM raza
                    where id_raza in(select raza_id_raza from razas_de_la_vaca
                    where vacas_id_animal =(select vacas.id from vacas where identificacion = '$_REQUEST[identificacion]'))";
                    $conexion_raza=$conexion->query($sql2);
                    $raza=$conexion_raza->fetch_assoc();
                        echo " Raza: ".$raza['nombre'];
                        echo " Potrero: ".$potrero['nombre'];
                    }
                } ?>
                    <?= $meses[date('n')-1]?>
                </p>
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
        function NombreRaza(nombre) {
                                document.getElementById("nom").value = nombre;
                                document.getElementById("EnviarRaza").submit();
                            }
        function GraficaTotal() {
            var parametros =
                {
                    "identificacion_vaca": "<?php
                    if (!(isset($_REQUEST['identificacion'])) || $_REQUEST['identificacion'] == "" || $_REQUEST['identificacion'] === null) {
                        echo 'nada';
                    } else {

                        echo $_REQUEST['identificacion'];
                    } ?>",
        "apellido": "hurtado",
            "telefono": "123456789"
            };
        $.ajax({
            data: parametros,
            url: '../../ajax/leche/GraficaLecheIndividual.php',
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