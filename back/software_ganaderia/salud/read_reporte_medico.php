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

    if (!isset($_SESSION['dni'])) {
        header("Location: ../../usuario/iniciar_sesion.php");
        exit;
    }
    
    $sesion = $_SESSION['dni'];

    $sql1 = "
    SELECT rm.id_reporte AS reporte_id, rm.fecha_chequeo, rm.fecha_proximo_chequeo, rm.notas_adicionales, 
        v.identificacion AS vaca_identificacion, v.nombre AS vaca_nombre,
           rm.control_embarazo_idcontrol_embarazo AS esta_prenada
    FROM reporte_medico rm
    INNER JOIN vacas v ON rm.id_vaca = v.id
    INNER JOIN potrero p ON v.potrero_id = p.id
    INNER JOIN finca f ON p.finca_id = f.id
    LEFT JOIN control_embarazo ce ON rm.control_embarazo_idcontrol_embarazo = ce.idcontrol_embarazo
    WHERE f.usuario_dni = '$sesion'
";
    $reportes = $conexion->query($sql1);

    $hoy = date("Y-n-d");


    $sql4 = "
        SELECT v.id, v.nombre,v.identificacion 
        FROM vacas v
        INNER JOIN potrero p ON v.potrero_id = p.id
        INNER JOIN finca f ON p.finca_id = f.id
        WHERE f.usuario_dni = '$sesion'
    ";
    $vacas = $conexion->query($sql4);

    $sql5 = "
        SELECT t.idtratamiento, t.tipo, e.tipo AS enfermedad, e.idenfermedades
        FROM tratamiento t
        INNER JOIN enfermedades e ON t.enfermedades_idenfermedades = e.idenfermedades
    ";
    $tratamientos = $conexion->query($sql5);

    ?>



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

        <?php
        if (isset($_POST['vaca'])) {

            $vaca_id = $_POST['vaca'];
            $fecha_chequeo = $_POST['fecha_chequeo'];
            $notas_adicionales = $_POST['notas_adicionales'];
            $fecha_proximo_chequeo = $_POST['fecha_proximo_chequeo'];
            if ($_POST['fecha_proximo_chequeo'] == "") {

                $fecha_proximo_chequeo = "NULL";
                $sql = "INSERT INTO reporte_medico (fecha_chequeo, fecha_proximo_chequeo, notas_adicionales,id_vaca)
        VALUES ('$fecha_chequeo',$fecha_proximo_chequeo, '$notas_adicionales',$vaca_id)";
            } else {
                $sql = "INSERT INTO reporte_medico (fecha_chequeo, fecha_proximo_chequeo, notas_adicionales,id_vaca)
        VALUES ('$fecha_chequeo','$fecha_proximo_chequeo', '$notas_adicionales',$vaca_id)";
            }




            if ($conexion->query($sql) === TRUE) {
                echo "<script>window.alert('Creacion exitosa!');
                window.location.href='./read_reporte_medico.php';
        
        </script>";

                $reporte_medico_id = $conexion->insert_id;


                // Inserta los tratamientos seleccionados en la relación reporte_medico_has_tratamiento
                if (!empty($_POST['tratamientos'])) {
                    foreach ($_POST['tratamientos'] as $tratamiento_id) {
                        // Consulta para obtener la enfermedad asociada al tratamiento
                        $sql_enfermedad = "SELECT enfermedades_idenfermedades FROM tratamiento WHERE idtratamiento = $tratamiento_id";
                        $resultado_enfermedad = $conexion->query($sql_enfermedad);
                        $enfermedad = $resultado_enfermedad->fetch_assoc();

                        // Inserta en reporte_medico_has_tratamiento con la enfermedad correspondiente
                        $sql_tratamiento = "INSERT INTO reporte_medico_has_tratamiento 
                                    (reporte_medico_id_reporte, tratamiento_idtratamiento, tratamiento_enfermedades_idenfermedades)
                                    VALUES ($reporte_medico_id, $tratamiento_id, {$enfermedad['enfermedades_idenfermedades']})";
                        $conexion->query($sql_tratamiento);
                    }
                }
            } else {
                echo "Error: " . $sql . "<br>" . $conexion->error;
            }
        }
        ?>



        <div class="CentrarBoton">
            <?php
            $sql_enfermedades = "SELECT * FROM enfermedades";
            $enfermedades = $conexion->query($sql_enfermedades);

            if (isset($_POST['tipo'])) {
                // Verificar si se ha seleccionado una enfermedad
                if (empty($_POST['enfermedades_idenfermedades'])) {
                    echo "Por favor, seleccione una enfermedad asociada.";
                } else {
                    // Recoger los datos del formulario
                    $tipo = $_POST['tipo'];
                    $descripcion = $_POST['descripcion'];
                    $horarios_aplicacion = $_POST['horarios_aplicacion'];
                    $nombre = $_POST['nombre'];
                    $enfermedades_id = $_POST['enfermedades_idenfermedades'];

                    // Sentencia SQL para insertar el tratamiento
                    $sql_insert = "INSERT INTO tratamiento (tipo, descripcion, horarios_aplicacion, nombre, enfermedades_idenfermedades) 
                       VALUES ('$tipo', '$descripcion', '$horarios_aplicacion', '$nombre', $enfermedades_id)";

                    if ($conexion->query($sql_insert) === TRUE) {
                        echo  "<script>window.alert('Creacion exitosa!');
                window.location.href='./read_tratamiento.php';
        
        </script>";
                    } else {
                        echo "Error al crear el tratamiento: " . $conexion->error;
                    }
                }
            }
            ?>
            <!-- BOTON DE ACTIVACION MODAL -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#ModalRegistrar">
                Registrar reporte medico
            </button>
            </div>
            <!-- MODAL REGISTRAR -->
            <div class="modal fade" id="ModalRegistrar" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollableg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Registrar reporte medico</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <form method="POST" id="cre" action="">
                                <label for="vaca">Vaca:</label>
                                <select name="vaca" required>
                                    <?php
                                    while ($vaca = $vacas->fetch_assoc()) {
                                        echo "<option value='{$vaca['id']}'>{$vaca['nombre']} - Identificación: {$vaca['identificacion']}</option>";
                                    }
                                    ?>
                                </select><br>

                                <label for="fecha_chequeo">Fecha de Chequeo:</label>
                                <input type="date" name="fecha_chequeo" required value="<?php echo $hoy; ?>"><br>

                                <label for="fecha_proximo_chequeo">Fecha Próximo Chequeo:</label>
                                <input type="date" name="fecha_proximo_chequeo"><br>

                                <label for="notas_adicionales">Notas Adicionales:</label>
                                <textarea name="notas_adicionales"></textarea><br>

                                <label for="tratamientos">Tratamientos:</label><br>
                                <?php
                                while ($tratamiento = $tratamientos->fetch_assoc()) {
                                    echo "<input type='checkbox' name='tratamientos[]' value='{$tratamiento['idtratamiento']}'> 
              Tratamiento: {$tratamiento['tipo']} - Enfermedad: {$tratamiento['enfermedad']}<br>";
                                }
                                ?>



                            </form>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" onclick="cr()" class="btn btn-primary">Registrar reporte</button>
                        </div>
                        <script>function cr(){
                            document.getElementById("cre").submit();
                        }
                            </script>
                    </div>
                    </div>
                    </div>




                        <?php
                        $vacas = $conexion->query($sql1);


                        ?>

                        

                        <table id="example" class="mdl-data-table" style="width:100%">

                            <thead>
                                <tr>
                                    <th>Vaca (Identificación)</th>
                                    <th>Nombre de la Vaca</th>
                                    <th>Fecha de Chequeo</th>
                                    <th>Fecha Próximo Chequeo</th>
                                    <th>Notas Adicionales</th>
                                    <th>¿Está Preñada?</th>
                                    <th>Tratamientos y Enfermedades</th>
                                    <th>Editar</th>
                                    <th>Borrar</th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php
                                while ($row = $reportes->fetch_assoc()) {
                                ?>
                                    <tr>

                                        <td><?= $row["vaca_identificacion"] ?></td>
                                        <td><?= $row["vaca_nombre"] ?></td>
                                        <td><?= $row["fecha_chequeo"] ?></td>
                                        <td><?= $row["fecha_proximo_chequeo"] ?></td>
                                        <td><?= $row["notas_adicionales"] ?></td>
                                        <td>
                                            <?php
                                            // Mostrar "Sí" si la vaca está preñada, de lo contrario "No"
                                            if ($row['esta_prenada'] !== null) {
                                                echo "Sí";
                                            } else {
                                                echo "No";
                                            }
                                            ?>
                                        </td>
                                        <td>

                                            <?php
                                            // Consulta para obtener los tratamientos y sus enfermedades asociadas al reporte médico
                                            $sql2 = "
            SELECT t.tipo AS tratamiento, e.tipo AS enfermedad
            FROM reporte_medico_has_tratamiento rmt
            INNER JOIN tratamiento t ON rmt.tratamiento_idtratamiento = t.idtratamiento
            INNER JOIN enfermedades e ON rmt.tratamiento_enfermedades_idenfermedades = e.idenfermedades
            WHERE rmt.reporte_medico_id_reporte = {$row['reporte_id']}
        ";
                                            $tratamientos = $conexion->query($sql2);

                                            while ($tratamiento = $tratamientos->fetch_assoc()) {
                                                echo "Tratamiento: " . $tratamiento['tratamiento'] . " - Enfermedad: " . $tratamiento['enfermedad'] . "<br><br>";
                                            }

                                            ?>
                                        </td>
                                        <td>

                                            <button class="btn btn-primary" onclick="Editar('<?= $row['reporte_id'] ?>')">Editar</button>

                                        </td>
                                        <td>
                                            <button class="btn btn-danger" onclick="Borrar('<?= $row['reporte_id'] ?>')">Eliminar</button>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>

                            </tbody>
                        </table>



                        </v>

                        <script>
                            function Editar(id) {
                                IdEjercicio = id;
                                var parametros = {
                                    "id_reporte": id,
                                    "apellido": "hurtado",
                                    "telefono": "123456789"
                                };
                                $.ajax({
                                    data: parametros,
                                    url: '../../ajax/salud/registro_medico/ModalEditar.php',
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
                                    "id_reporte": id,
                                    "apellido": "hurtado",
                                    "telefono": "123456789"
                                };
                                $.ajax({
                                    data: parametros,
                                    url: '../../ajax/salud/registro_medico/ModalBorrar.php',
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