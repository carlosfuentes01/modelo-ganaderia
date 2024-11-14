<!-- index.php -->
<?php
include '../../conexion/conexion.php';
session_start();
// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: login.php");
    exit;
}

// Consulta para obtener todas las enfermedades
$sql = "SELECT * FROM control_embarazo";
$result = $conexion->query($sql);
?>
<!DOCTYPE html>
<html>

<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/14.0.0/material-components-web.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.material.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/material-components-web/14.0.0/material-components-web.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.material.css">
    <link rel="stylesheet" href="../../css/AdministradorVacas.css">
    <link rel="stylesheet" href="../../css/Nav.css">
    <title>Control de Embarazo</title>
</head>

<body>
    <div id="query" style="display: none;"></div>
    <div id="BarraLateral">
        <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark sidebar">
            <span class="fs-4">Sidebar</span>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="#" class="nav-link active" aria-current="page">Home</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">Dashboard</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">Orders</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">Products</a>
                </li>
                <li>
                    <a href="#" class="nav-link text-white">Customers</a>
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
                                    data-bs-toggle="dropdown" aria-expanded="false">Seleccionar Raza</a>

                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <form id="EnviarRaza" action="./leche/RazaIndividual.php" method="post">
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



        <!-- REGISTRAR VACAS -->
        <?php
       $sql1 = "SELECT * FROM modo_concepcion";
       $modo = $conexion->query($sql1);
       
       // Fecha actual
       $hoy = date("Y-n-d");
       
       if (isset($_POST['fecha_estimada_de_parto'])) {
       
           $fecha_deteccion = $_POST['fecha_deteccion'];
           $fecha_estimada_de_parto = $_POST['fecha_estimada_de_parto'];
           $modo_concepcion = $_POST['modo_concepcion'];
           $descripcion = $_POST['descripcion'];
           $fecha_aproximada_parto = $_POST['fecha_aproximada_parto'];
       
           // Si la fecha de parto aproximada está vacía, asignar NULL
           if ($fecha_aproximada_parto == "") {
               $fecha_aproximada_parto = "NULL";
           } else {
               $fecha_aproximada_parto = "'$fecha_aproximada_parto'";
           }
       
           // SQL para insertar los datos en la base de datos
           $sql = "INSERT INTO `control_embarazo`(`fecha_deteccion`, `fecha_aproximada_parto`, `descripcion`, `fecha_estimada_de_parto`, `modo_concepcion`) 
                   VALUES ('$fecha_deteccion', $fecha_aproximada_parto, '$descripcion', '$fecha_estimada_de_parto', $modo_concepcion)";
       
           // Ejecución de la consulta
           if ($conexion->query($sql) === TRUE) {
               // Si la inserción es exitosa, se ejecuta la alerta y la redirección
               echo "<script>
                       alert('Registro exitoso!');
                       window.location.href='./Read.php';
                     </script>";
           } else {
               // Si hay un error, se muestra un mensaje
               echo "Error: " . $sql . "<br>" . $conexion->error;
           }
       }
       ?>

        <h2>Registros de Embarazo</h2>
        <a href="creacion_control_embarazo.php">Crear Registro de reproduccion</a>
        <div class="CentrarBoton">
            <!-- BOTON DE ACTIVACION MODAL -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#ModalRegistrar">
                Registrar Embarazo
            </button>

            <!-- MODAL REGISTRAR -->
            <div class="modal fade" id="ModalRegistrar" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollableg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Registrar enfermedad</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form style="width: 100%;" method="POST" id="cre" action="">
                                <label for="fecha_deteccion">Fecha de deteccion:</label>
                                <input style="width: 100%;" type="date" name="fecha_deteccion" required value="<?php echo $hoy; ?>" max="<?php echo $hoy; ?>"><br>
                                modo concepcion:
                                <select style="width: 100%;" name="modo_concepcion">
                                    <?php
                                    while ($mod = $modo->fetch_assoc()) {
                                        echo "<option value='{$mod['id']}'>{$mod['nombre_modo']} </option>";
                                    }
                                    ?>
                                </select><br>


                                <label for="fecha_estimada_de_parto">Fecha esperada parto:</label>
                                <input style="width: 100%;" type="date" name="fecha_estimada_de_parto" required><br>

                                <label for="fecha_aproximada_parto">Fecha del parto:</label>
                                <input style="width: 100%;" type="date" name="fecha_aproximada_parto"><br>


                                <label>Descripción:</label>
                                <input style="width: 100%;" type="text" name="descripcion" required></input><br>
                               

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" onclick="cr()" class="btn btn-primary">Registrar enfermedad</button>
                        </div>
                        <script>
                            function cr() {
                                document.getElementById("cre").submit();
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>


        <?php
        if ($result->num_rows > 0) {
        ?>
            <table id="example" class="mdl-data-table" style="width:100%">
                <thead>
                    <tr>
                        <th><b>Fecha de descubrimiento</b></th>
                        <th><b>Modo de concepción</b></th>
                        <th><b>Fecha pronosticada de parto</b></th>
                        <th><b>Fecha aproximada de parto</b></th>
                        <th><b>Descripción</b></th>
                        <th><b>Editar</b></th>
                        <th><b>Borrar</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($row = $result->fetch_assoc()) {
                        $modo = "SELECT * from modo_concepcion where id = $row[modo_concepcion] ";
                        $concepcion = $conexion->query($modo);
                        $nombre_modo_concepcion = $concepcion->fetch_assoc();

                    ?><tr>
                            <td><?= $row["fecha_deteccion"] ?></td>
                            <td><?= $nombre_modo_concepcion["nombre_modo"] ?></td>
                            <td><?= $row["fecha_estimada_de_parto"] ?></td>
                            <td><?= $row["fecha_aproximada_parto"] ?></td>
                            <td><?= $row["descripcion"] ?></td>
                            <td>
                                <button class="btn btn-primary" onclick="Editar('<?= $row['idcontrol_embarazo'] ?>')">Editar</button>


                            </td>
                            <td>
                                <button class="btn btn-danger" onclick="Borrar('<?= $row['idcontrol_embarazo'] ?>')">Eliminar</button>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>

        <?php
        } else {
            echo "No hay registros de embarazo.";
        }
        ?>





    </div>

    <script>
        function Editar(id) {
            IdEjercicio = id;
            var parametros = {
                "idembarazo": id,
                "apellido": "hurtado",
                "telefono": "123456789"
            };
            $.ajax({
                data: parametros,
                url: '../../ajax/reproduccion/ModalEditar.php',
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
                "idembarazo": id,
                "apellido": "hurtado",
                "telefono": "123456789"
            };
            $.ajax({
                data: parametros,
                url: '../../ajax/reproduccion/ModalBorrar.php',
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
                scrollX: true, // Habilita el desplazamiento horizontal
                scrollCollapse: true, // Hace que la tabla colapse si tiene menos filas que el tamaño especificado
                responsive: true,
                columnDefs: [{
                    targets: '_all', // Aplica a todas las columnas
                    createdCell: function(td, cellData, rowData, row, col) {
                        // Aplicamos una clase CSS para permitir el ajuste de texto
                        $(td).addClass('text-wrap');
                    }
                }],
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