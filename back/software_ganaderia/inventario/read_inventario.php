<!DOCTYPE html>
<html>

<head>
    <?php
    include '../../conexion/conexion.php';
    session_start();
    // Verifica si el usuario está autenticado
    if (!isset($_SESSION['dni'])) {
        header("Location: login.php");
        exit;
    }

    $sql = "SELECT inventario.id, inventario.nombre, inventario.cantidad, finca.nombre AS nombre_finca
                FROM inventario
                JOIN finca ON inventario.finca_id_finca = finca.id";
    $result = mysqli_query($conexion, $sql);
    ?>
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
    <title>Control de Embarazo</title>
</head>

<body>
    <div id="query" style="display: none;"></div>
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
                    <a href="../inventario/read_inventario.php" class="nav-link active  text-white"><i class="fa-solid fa-layer-group" style="color: #ff0000;"></i> GESTIONAR INVENTARIOS</a>

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
        <?php

        $sql_fincas = "SELECT id, nombre FROM finca";
        $result_fincas = $conexion->query($sql_fincas);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombre = $_POST['nombre'];
            $cantidad = $_POST['cantidad'];
            $finca_id = $_POST['finca_id']; // ID de la finca seleccionado
            if (empty($finca_id)) {
                echo "<script>window.alert('ERROR--No selecciono una finca');
                window.location.href='./read_inventario.php';
        
        </script>";
            }else{
            $sql = "INSERT INTO inventario (nombre, cantidad, finca_id_finca) VALUES ('$nombre', '$cantidad', '$finca_id')";
            if ($conexion->query($sql) === TRUE) {
                echo "<script>window.alert('Inventario agregado exitosamente.');
                window.location.href='./read_inventario.php';
        
        </script>" ;
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
        }
        }
        ?>





        <div class="CentrarBoton">
            <!-- BOTON DE ACTIVACION MODAL -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#ModalRegistrar">
                Registrar inventario
            </button>

            <!-- MODAL REGISTRAR -->
            <div class="modal fade" id="ModalRegistrar" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollableg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Registrar inventario</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form style="width: 100%;" method="POST" id="cre" action="">
                                Nombre del Inventario: <input type="text" name="nombre" required><br>
                                Cantidad: <input type="number" name="cantidad" required><br>
                                Finca:
                                <select name="finca_id" required>
                                    <option value="">Selecciona una finca</option>
                                    <?php
                                    if ($result_fincas->num_rows > 0) {
                                        while ($row = $result_fincas->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['nombre'] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No hay fincas disponibles</option>";
                                    }
                                    ?>
                                </select><br>

                            </form>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" onclick="cr()" class="btn btn-primary">Registrar inventario</button>
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
                        <th><i class="fa-solid fa-seedling" style="color: #00bd52;"></i> <b>Nombre</b></th>
                        <th><i class="fa-solid fa-wheat-awn" style="color: #00bd52;"></i> <b>Cantidad</b></th>
                        <th><i class="fa-solid fa-house-crack" style="color: #00bd52;"></i> <b>Finca</b></th>
                        <th><i class="fa-regular fa-pen-to-square" style="color: #00bd52;"></i> <b>Editar</b></th>
                        <th><i class="fa-solid fa-trash-can" style="color: #00bd52;"></i> <b>Borrar</b></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    while ($row = $result->fetch_assoc()) {

                    ?><tr>
                            <td><?= $row["nombre"] ?></td>
                            <td><?= $row["cantidad"] ?></td>
                            <td><?= $row["nombre_finca"] ?></td>
                            <td>
                                <button class="btn btn-primary" onclick="Editar('<?= $row['id'] ?>')"><i class="fa-regular fa-pen-to-square" style="color: #00bd52;"></i> Editar</button>


                            </td>
                            <td>
                                <button class="btn btn-danger" onclick="Borrar('<?= $row['id'] ?>')"><i class="fa-solid fa-trash-can" style="color: #00bd52;"></i> Eliminar</button>
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
                "id_inventario": id,
                "apellido": "hurtado",
                "telefono": "123456789"
            };
            $.ajax({
                data: parametros,
                url: '../../ajax/inventario/ModalEditar.php',
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
                "id_inventario": id,
                "apellido": "hurtado",
                "telefono": "123456789"
            };
            $.ajax({
                data: parametros,
                url: '../../ajax/inventario/ModalBorrar.php',
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