<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/14.0.0/material-components-web.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://kit.fontawesome.com/3d5e1e5029.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.material.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/14.0.0/material-components-web.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.material.css">
    <link rel="stylesheet" href="../../css/AdministradorVacas.css">
    <link rel="stylesheet" href="../../css/Nav.css">
    <title>Grid Layout</title>

</head>

<body>
    <?php
    include '../../conexion/conexion.php';
    session_start();
    // Verifica si el usuario está autenticado
    if (!isset($_SESSION['dni'])) {
        header("Location: login.php");
        exit;
    }
    $sesion = $_SESSION['dni'];
    #falta la sesion

    $sql1 = "SELECT * from vacas where potrero_id in
 (select id from potrero where finca_id =
 (select id from finca where usuario_dni = $sesion))";


    $raza = "SELECT * FROM raza";
    $razas = $conexion->query($raza);
    $marcacion = "SELECT * FROM marcacion";
    $marcaciones = $conexion->query($marcacion);
    $potrero = "SELECT * FROM potrero where finca_id in(select id from finca where usuario_dni = $sesion)";
    $potreros = $conexion->query($potrero);

    if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['potrero'])) {

        $identificacion = $_POST['identificacion'];
        $nombre = $_POST['nombre'];
        $fecha_de_registro_animal = $_POST['fecha_de_registro_animal'];
        $genero = $_POST['genero'];
        $descartada = $_POST['descartada'];
        $potrero_id = $_POST['potrero'];

        $marca = $_POST['marcacion'];
        $sql = "INSERT INTO vacas (identificacion, nombre, fecha_de_registro_animal,  genero, descartada,potrero_id,marcacion_id   )
            VALUES ( '$identificacion', '$nombre', '$fecha_de_registro_animal',  '$genero', '$descartada',$potrero_id,$marca)";
        $raza_ingresadas = false;
        while ($intro_razas = $razas->fetch_assoc()) {

            if (isset($_POST[$intro_razas["id_raza"]])) {
                # code...
                $raza_ingresadas = true;
            }
        }

        $id_vaca;
        if ($raza_ingresadas) {
            if ($conexion->query($sql) === TRUE) {
               echo"<script>window.alert('¡REGISTRO EXITOSO!')</script>";
                $sql_ver_id = "SELECT id from vacas where identificacion = $identificacion";
                $query_id_vaca = $conexion->query($sql_ver_id);

                while ($ver_id_vaca = $query_id_vaca->fetch_assoc()) {
                    $id_vaca = $ver_id_vaca['id'];
                }
                while ($intro_razas = $razas->fetch_assoc()) {

                    if (isset($_POST[$intro_razas["id_raza"]])) {
                        # code...
                        $sqlinsert = "INSERT INTO razas_de_la_vaca (`raza_id_raza`, `vacas_id_animal`) VALUES ($intro_razas[id_raza],$id_vaca)";
                        $conexion->query($sqlinsert);
                    }
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
        } else {
            echo "no se ha ingresado razas, ingrese al menos una raza";
        }
    }


    #falta potrero

    ?>
    <div id="query" style="display: none;"></div>
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
                    <a href="../registro_animales/read.php" class="nav-link active text-white"><i class="fa-solid fa-clipboard-check" style="color: #ff0000;"></i>  GESTIONAR VACAS</a>

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
                            
                                <a class="nav-link active" aria-current="page" href="#"><i class="fa-solid fa-hat-cowboy-side" style="color: #ff0000;"></i>  VER PERSONAL</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="../produccion_lechera/LecheVaca.php"><i class="fa-solid fa-droplet" style="color: #ff0000;"></i> VER LECHE PRODUCIDA INDIVIDUAL</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#"><i class="fa-solid fa-house-crack" style="color: #ff0026;"></i>  VER POTREROS</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
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
        <div id="LogoCowAlly">
            <div id="logo">
                <img id="cow" src="../imagenes/logo.svg" alt="">
            </div>
            <div id="ContenedorFunciones">
                <!-- REGISTRAR VACAS -->
                <div class="funciones">
                    <div class="ilustraciones">
                        <img class="Ilus" src="../imagenes/corral.svg" alt="">
                    </div>
                   
                    <div class="CentrarBoton">
                        <!-- BOTON DE ACTIVACION MODAL -->
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#ModalRegistrar"><i class="fa-solid fa-plus" style="color: #ff0000;"></i>
                            Registrar vaca
                        </button>

                        <!-- MODAL REGISTRAR -->
                        <div class="modal fade" id="ModalRegistrar" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollableg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-plus"></i>  Registrar Vaca</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <section class="Perfil d-flex">
                                            <img src="../imagenes/vaca.png" class="ImgPerfil" alt="">
                                            <div class="DivPerfil">
                                                <!-- SELECCIONAR RAZA Y NOMBRE -->

                                        </section>
                                        <form method="POST" action="">

                                            Identificación: <input type="text" name="identificacion" required><br>
                                            Nombre: <input type="text" name="nombre"><br>
                                            fecha de registro animal: <input type="date" name="fecha_de_registro_animal" required><br>
                                            Género:
                                            <select name="genero">
                                                <option value="Hembra">Hembra</option>
                                                <option value="Macho">Macho</option>
                                            </select><br>
                                            Descartada:
                                            <select name="descartada">
                                                <option value="Activa">Activa</option>
                                                <option value="Descartada">Descartada</option>
                                                <option value="Vendida">Vendida</option>
                                            </select><br>

                                            Raza:
                                            <?php
                                            while ($raza_input = $razas->fetch_assoc()) {
                                            ?>
                                                <input type="checkbox" name="<?php echo $raza_input['id_raza']; ?>" value=<?php echo $raza_input['id_raza']; ?>>
                                                <label for="raza"> <?php echo $raza_input['nombre']; ?></label><br>
                                            <?php
                                            }

                                            ?>
                                            Marcacion:
                                            <select name="marcacion">
                                                <?php
                                                while ($marcacion = $marcaciones->fetch_assoc()) {
                                                ?>
                                                    <option value=<?php echo $marcacion['id']; ?>><?php echo $marcacion['tipo_marcacion']; ?></option>
                                                <?php
                                                }

                                                ?>
                                            </select> <br>
                                            potrero:
                                            <select name="potrero">
                                                <?php
                                                while ($potrero = $potreros->fetch_assoc()) {
                                                ?>
                                                    <option value=<?php echo $potrero['id']; ?>><?php echo $potrero['nombre']; ?></option>
                                                <?php
                                                }

                                                ?>
                                            </select>
                                            <br>
                                            <input type="submit" value="Registrar">




                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                        <button type="button" class="btn btn-primary">REGISTRAR VACA</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        <?php
        $vacas = $conexion->query($sql1);

        if ($vacas->num_rows > 0) {
        ?>
            <table id="example" class="mdl-data-table" style="width:100%">

                <thead>
                    <tr>
                        <th><i class="fa-solid fa-hat-cowboy" style="color: #00bd52;"></i>  Identificación</th>
                        <th><i class="fa-solid fa-seedling" style="color: #00bd52;"></i>  Nombre</th>
                        <th><i class="fa-regular fa-calendar-days" style="color: #00bd52;"></i>  Fecha de registro animal</th>
                        <th><i class="fa-solid fa-venus-mars" style="color: #00bd52;"></i>  Género</th>
                        <th><i class="fa-solid fa-skull-crossbones" style="color: #00bd52;"></i>  Descartada</th>
                        <th><i class="fa-solid fa-cow" style="color: #00bd52;"></i>  Razas</th>
                        <th><i class="fa-solid fa-house-chimney" style="color: #00bd52;"></i>  Potrero</th>
                        <th><i class="fa-solid fa-check" style="color: #00bd52;"></i>  Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="display: none">
                        <td>Nombre</td>
                        <td>Fecha de registro animal</td>
                        <td>Género</td>
                        <td>Descartada</td>
                        <td>Razas</td>
                        <td>Potrero</td>
                        <td>Acciones</td>
                    </tr>
                    <?php
                    while ($row = $vacas->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?= $row["identificacion"] ?></td>
                            <td><?= $row["nombre"] ?></td>
                            <td><?= $row["fecha_de_registro_animal"] ?></td>
                            <td><?= $row["genero"] ?></td>
                            <td><?= $row["descartada"] ?></td>
                            <td>
                                <?php
                                $sql2 = "SELECT * FROM raza
                    where id_raza in(select raza_id_raza from razas_de_la_vaca
                    where vacas_id_animal =$row[id])";

                                $razas = $conexion->query($sql2);
                                while ($raza = $razas->fetch_assoc()) {
                                    echo $raza['nombre'] . " ";
                                };
                                ?>
                            </td>
                            <td>
                                <?php
                                $sql3 = "SELECT * FROM potrero
                where id = $row[potrero_id]
                ";

                                $potreros = $conexion->query($sql3);
                                while ($potrero = $potreros->fetch_assoc()) {
                                    echo $potrero['nombre'] . " ";
                                };
                                ?>
                            </td>
                            <td><button class="btn btn-primary" onclick="Editar('<?= $row['id'] ?>')"><i class="fa-regular fa-pen-to-square" style="color: #00bd52;"></i>  Editar</button>
                                <button class="btn btn-danger" onclick="Borrar('<?= $row['id'] ?>')"><i class="fa-solid fa-trash" style="color: #00bd52;"></i>  Eliminar</button>
                            </td>

                        </tr>
                    <?php
                    }
                    ?>

                </tbody>
            </table>
        <?php
        }
        ?>


    </div>

    <script>
        function Editar(id) {
            IdEjercicio = id;
            var parametros = {
                "Idvaca": id,
                "apellido": "hurtado",
                "telefono": "123456789"
            };
            $.ajax({
                data: parametros,
                url: '../../ajax/registro_animales/ModalUpdate.php',
                type: 'POST',

                beforeSend: function() {
                    $('#ID_Mostrar_infor').html("Mensjae antes de enviar");

                },
                success: function(response) {
                    // Insertar el modal en el body
                    $('body').append(response);
                    // Mostrar el modal
                    $('#ModalActualizar').modal('show');

                    // Limpiar el modal después de cerrarlo
                    $('#ModalActualizar').on('hidden.bs.modal', function() {
                        $(this).remove(); // Eliminar el modal del DOM
                    });
                }
            });
        }
        function Borrar(id) {
            IdEjercicio = id;
            var parametros = {
                "Idvaca": id,
                "apellido": "hurtado",
                "telefono": "123456789"
            };
            $.ajax({
                data: parametros,
                url: '../../ajax/registro_animales/ModalDelete.php',
                type: 'POST',

                beforeSend: function() {
                    $('#ID_Mostrar_infor').html("Mensjae antes de enviar");

                },
                success: function(response) {
                    // Insertar el modal en el body
                    $('body').append(response);
                    // Mostrar el modal
                    $('#ModalDelete').modal('show');

                    // Limpiar el modal después de cerrarlo
                    $('#ModalDelete').on('hidden.bs.modal', function() {
                        $(this).remove(); // Eliminar el modal del DOM
                    });
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                "language": {
                    "lengthMenu": "Mostrar " + "<select><option>10</option><option>25</option><option>50</option></select> " + " Registros por página",
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function NombreRaza(nombre) {
            document.getElementById("nom").value = nombre;
            document.getElementById("EnviarRaza").submit();
        }

        function BuscarVaca(id) {
            var IdVaca = document.getElementById("idAct").value;
            var parametros = {
                "Identificacion": IdVaca,
                "apellido": "hurtado",
                "telefono": "123456789"
            };
            $.ajax({
                data: parametros,
                url: '../php/ajax/BuscarVaca.php',
                type: 'POST',

                beforeSend: function() {
                    $('#query').html("Mensjae antes de enviar");

                },
                success: function(mensaje_mostrar) {
                    $('#query').html(mensaje_mostrar);

                }
            });

        }
    </script>
</body>

</html>

