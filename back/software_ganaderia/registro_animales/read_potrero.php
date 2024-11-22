<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- INSERCIONES DE AJAX Y JQUERY (ESTA CASADO CON DATATABLES)  -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="../../css/Nav.css">
    <link rel="stylesheet" href="../../css/perfil/PerfilVaca.css">
    <!-- INSERCION DE DATATABLES Y SU ESTILOS -->
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/14.0.0/material-components-web.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.material.js"></script>
    <link rel="stylesheet" href="../../css/Nav.css">
    <link rel="stylesheet" href="../../css/leche/LecheRazaIndividual.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/14.0.0/material-components-web.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.material.css">
    <title>Raza de vaca</title>

</head>

<body>
    <?php 
    include '../../conexion/conexion.php';
    session_start();
    if (!isset($_SESSION['dni'])) {
        header("Location: ../../usuario/login.php");
        exit;
    }
    $sesion = $_SESSION['dni'];
    ?>
    <div id="BarraLateral">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar">
            <span class="fs-4">Sidebar</span>
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
                    <a href="read_potrero.php" class="nav-link text-white">Administrar potreros</a>
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

        <button class="btn btn-success">Crear Potrero</button>
        <table id="example" class="mdl-data-table" style="width:100%">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Vacas totales</th>
                    <th>Vacas preñadas</th>
                    <th>Vacas enfermas</th>
                    <th>Alimento Asignado</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                </tr>
            </thead>

            <tbody>
                <tr style='display: none'>
                    <td>Nixon</td>
                    <td>System Architect</td>
                    <td>Edinburgh</td>
                    <td>320800</td>
                    <td>320800</td>
                    <td>320800</td>
                    <td>320800</td>
                </tr>
                <tr>
                    <?php
                    $sql3 = "SELECT count(*) as cantidad ,potrero.nombre as 'nombre de potrero' FROM potrero join vacas on vacas.potrero_id = potrero.id where finca_id in(select id from finca where usuario_dni = $sesion)";
                    $potreros = $conexion->query($sql3);

                    while ($a = $potreros->fetch_assoc()) {
                        ?>
                        <tr>

                        <td><?= $a['nombre de potrero'] ?></td>
                        <td><?= $a['cantidad'] ?></td>
                        <?php
                        $nombre = $a['nombre de potrero'];
                        $sqlpa1 = "set @embarazadas_potrero = 0";
                        $query_pa1=$conexion->query($sqlpa1);
                        $sqlpa2="set @enfermas_potrero = 0;";
                        $query_pa2=$conexion->query($sqlpa2);
                        $sqlpa3="set @comida_potrero = 0;";
                        $query_pa3=$conexion->query($sqlpa3);
                        $sqlpa4="call brftiblxal2dldsiqbzr.tabla_potreros('$nombre'  , @embarazadas_potrero, @enfermas_potrero, @comida_potrero);";
                        $query_pa4=$conexion->query($sqlpa4);
                        $sqlpa5 = "select @embarazadas_potrero as embarazadas, @enfermas_potrero as enfermas, @comida_potrero as comida;";
                        $tabla = $conexion->query($sqlpa5);
                        $resultado = $tabla->fetch_assoc();
                        ?>
                        <td><?=$resultado['embarazadas']?></td>
                         <td><?= $resultado['enfermas'] ?></td>
                         <td><?= $resultado['comida'] ?> </td>
                         <td> eliminar</td>
                         <td> editar </td>
                        </tr>

                        <?php
                    }



                    ?>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        function BuscarPotrero(id) {
            IdPtrero = id;
            var parametros = {
                "IdPotrero": id,
                "apellido": "hurtado",
                "telefono": "123456789"
            };
            $.ajax({
                data: parametros,
                url: '../php/ajax/BuscarVaca.php',
                type: 'POST',

                beforeSend: function () {
                    $('#ID_Mostrar_infor').html("Mensjae antes de enviar");

                },
                success: function (response) {
                    // Insertar el modal en el body
                    $('body').append(response);
                    // Mostrar el modal
                    $('#ModalActualizar').modal('show');

                    // Limpiar el modal después de cerrarlo
                    $('#ModalActualizar').on('hidden.bs.modal', function () {
                        $(this).remove(); // Eliminar el modal del DOM
                    });
                }
            });
        }
        function BorrarPotrero(id) {
            IdPtrero = id;
            var parametros = {
                "IdPotrero": id,
                "apellido": "hurtado",
                "telefono": "123456789"
            };
            $.ajax({
                data: parametros,
                url: '../php/ajax/BorrarPotrero.php',
                type: 'POST',

                beforeSend: function () {
                    $('#ID_Mostrar_infor').html("Mensjae antes de enviar");

                },
                success: function (response) {
                    // Insertar el modal en el body
                    $('body').append(response);
                    // Mostrar el modal
                    $('#ModalActualizar').modal('show');

                    // Limpiar el modal después de cerrarlo
                    $('#ModalActualizar').on('hidden.bs.modal', function () {
                        $(this).remove(); // Eliminar el modal del DOM
                    });
                }
            });
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#example').DataTable({
                "language": {
                    "lengthMenu": "Mostrar " + "<select><option>3</option><option>10</option><option>15</option></select> " + " Registros por página",
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

</body>

</html>