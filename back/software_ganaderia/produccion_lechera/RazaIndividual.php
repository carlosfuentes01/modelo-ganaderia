<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    include "../../conexion/conexion.php";
    $NombreRaza = $_POST["raza"];
    session_start();
    if (!isset($_SESSION['dni'])) {
        header("Location: ../../usuario/iniciar_sesion.php");
        exit;
    }
$sesion = $_SESSION['dni'];
$imagen=$conexion->query(query: "SELECT imagen from raza where id_raza=$NombreRaza");
$img=$imagen->fetch_object();
$blob=$img->imagen;
$base64=base64_encode($blob);
$img64="data:image/jpeg;base64,$base64";
    $vacas = $conexion->query(
        "SELECT razas_de_la_vaca.raza_id_raza,vacas.identificacion,vacas.nombre,vacas.genero 
    from razas_de_la_vaca
    join vacas 
    on razas_de_la_vaca.vacas_id_animal=vacas.id where razas_de_la_vaca.raza_id_raza=$NombreRaza AND vacas.potrero_id in
 (select id from potrero where finca_id =
 (select id from finca where usuario_dni = $sesion))" 
    );
$query_de_pa1="set @embarazadas_raza = 0;";
$query_de_pa2="set @enfermas_raza = 0;";
$query_de_pa3="set @sana_raza = 0;";
$query_de_pa4="call brftiblxal2dldsiqbzr.datos_raza($NombreRaza, $sesion, @embarazadas_raza, @enfermas_raza, @sana_raza);";
$query_de_pa5="select @embarazadas_raza as emb, @enfermas_raza as enf, @sana_raza as sana;";
$PA1=$conexion->query($query_de_pa1);
$PA2=$conexion->query($query_de_pa2);
$PA3=$conexion->query($query_de_pa3);
$PA4=$conexion->query($query_de_pa4);
$PA5=$conexion->query($query_de_pa5);
$datos =$PA5->fetch_assoc();
    $ContarRazas = $conexion->query(
        "SELECT COUNT(*) AS total 
from razas_de_la_vaca
join vacas 
on razas_de_la_vaca.vacas_id_animal=vacas.id where razas_de_la_vaca.raza_id_raza=$NombreRaza AND vacas.potrero_id in
 (select id from potrero where finca_id =
 (select id from finca where usuario_dni = $sesion))"
    );
    $LecheMensual=$conexion->query("SELECT 
    monthname(pl.fecha) AS mes,               -- Extrae el mes de la fecha
    SUM(pl.litros_leche) AS total_leche   -- Suma los litros de leche producidos en ese mes
FROM 
    produccion_lechera pl
JOIN 
    razas_de_la_vaca rv
ON 
    rv.vacas_id_animal = pl.vacas_id
WHERE 
    YEAR(pl.fecha) = YEAR(CURDATE())    -- Filtra solo el año actual
    AND rv.raza_id_raza = $NombreRaza         -- Filtra por la raza con ID 3
GROUP BY 
    monthname(pl.fecha)                     -- Agrupa por mes
ORDER BY 
    mes ASC; ");
    
    
    $LecheMensualArray = [];
    while ($a = $LecheMensual->fetch_object()) {
        $LecheMensualArray[] = $a; // Añade cada fila de resultado como un objeto
    }

    $Total = $ContarRazas->fetch_object();
    ?>
      <script>

    </script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- INSERCIONES DE AJAX Y JQUERY (ESTA CASADO CON DATATABLES)  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <!-- INSERCION DE DATATABLES Y SU ESTILOS -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/14.0.0/material-components-web.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://kit.fontawesome.com/3d5e1e5029.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.material.js"></script>
    <link rel="stylesheet" href="../../css/Nav.css">
    <link rel="stylesheet" href="../../css/leche/LecheRazaIndividual.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/14.0.0/material-components-web.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.material.css">
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
        <div class="InformacionRaza d-flex ">
            <div class="fs-4 ms-4 d-flex flex-column justify-content-center">
                <p>Total de vacas: <?=$Total->total ?></p>

                <p>Enfermas:<?=$datos["enf"];?></p>

                <p>Sanas:<?=$datos["sana"];?></p>

                <p>Embarazadas: <?=$datos["emb"];?></p>

            </div>
            <div id="Grafica" class="">
            </div>
        </div>

        <table id="example2" class="mdl-data-table" style="width:100%">
            <thead>
                <tr>
                    <th>1</th>
                    <th>2</th>
                    <th>3</th>
                    <th>4</th>
                    <th>5</th>
                </tr>
            </thead>
            <tbody>
                <?php

                $totalItems = $Total->total;
                $itemsPerRow = 5;
                $i = 0;
                while ($a = $vacas->fetch_object()) {
                    if ($i % $itemsPerRow == 0) { // Si es un múltiplo de 5, abrimos una nueva fila <tr>
                        echo '<tr>';
                    }
                ?>
                    <td>
                        <div class="card Vacas">
                            <img src="<?=$img64?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <p>ID: <?= $a->identificacion ?></p>
                                <p><?= $a->nombre ?></p>
                            </div>
                        </div>
                    </td>
                <?php
                    $i++;
                    // Si hemos alcanzado el límite de celdas por fila o es el último elemento, cerramos la fila
                    if ($i % $itemsPerRow == 0 || $i == $totalItems) {
                        echo '</tr>';
                    }
                }
                ?>
            </tbody>


        </table>



    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#example2').DataTable({
                "language": {
                    "lengthMenu": "Mostrar " + "<select><option>1</option><option>3</option><option>10</option><option>15</option></select> " + " Registros por página",
                    "zeroRecords": "Nada encontrado - disculpa",
                    "info": "Mostrando la página _PAGE_ de _PAGES_",
                    "infoEmpty": "(Filtrado de _MAX_ registros totales)",
                    "search": "Buscar:",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                }
            });
        });
    </script>
  
    <script src="https://fastly.jsdelivr.net/npm/echarts@5.5.1/dist/echarts.min.js"></script>
    <script>
  var Mensual = <?php echo json_encode($LecheMensualArray); ?>;
var Mes = [];
var Litros = [];

if (Mensual.length > 0) {
    // Recorremos los datos y los agregamos a los arrays Mes y Litros
    for (let i = 0; i < Mensual.length; i++) {
        // Accedemos a las propiedades de cada objeto
        Mes.push(Mensual[i].mes);
        Litros.push(Mensual[i].total_leche);

        // Mostramos los valores en consola para verificar
        console.log(Mes[i]);    // Muestra el mes
        console.log(Litros[i]); // Muestra los litros de leche
    }
} else {
    console.log("No hay datos disponibles.");
}
function NombreRaza(nombre) {
            document.getElementById("nom").value = nombre;
            document.getElementById("EnviarRaza").submit();
        }
        function saludame() {
            var parametros = {
                "raza": "<?= $_POST['raza']?>",
                "apellido": "hurtado",
                "telefono": "123456789"
            };
            $.ajax({
                data: parametros,
                url: '../../ajax/leche/GraficaLecheRaza.php',
                type: 'POST',

                beforeSend: function() {
                    $('#Grafica').html("Mensjae antes de enviar");

                },
                success: function(mensaje_mostrar) {
                    $('#Grafica').html(mensaje_mostrar);

                }
            });
           
        }
        window.onload = function() {
            saludame();
 
        }
      
 
        
    </script>
    

</body>

</html>