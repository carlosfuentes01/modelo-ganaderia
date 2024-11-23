<?php
include "../../conexion/conexion.php";

session_start();
$sesion = $_SESSION["dni"];
$identificacion_vaca = $_REQUEST["identificacion_vaca"];
$hoy = date("t");
$colocar_vaca_individual = false;
if (isset($_REQUEST["identificacion_vaca"])) {
  #se confirma primero si se consulto por una vaca especifico, en caso contrario, muestra el total de las vacas


  $query_confirmacion = "SELECT identificacion from vacas where vacas.identificacion = '$identificacion_vaca' and vacas.potrero_id in
 (select id from potrero where finca_id =
 (select id from finca where usuario_dni = $sesion))";
  $conexion_confirmacion = $conexion->query($query_confirmacion);
  $confirmar = $conexion_confirmacion->fetch_assoc();
  #ahora con una identificacion planteada, se confirma si existe, del caso contrario, que se muestren las vacas totales

  if ($confirmar["identificacion"] == $identificacion_vaca) {
    $colocar_vaca_individual = True;
    $queryleche = "SELECT day(fecha),sum(litros_leche) FROM	produccion_lechera
where Month(fecha) = MOnth(curdate()) and year(fecha)=year(curdate()) and produccion_lechera.vacas_id in
 (select vacas.id from vacas where vacas.identificacion='$identificacion_vaca' and vacas.potrero_id in
 (select id from potrero where finca_id =
 (select id from finca where usuario_dni = $sesion)))
GROUP BY day(fecha)  ";
  } else {
    $queryleche = "SELECT day(fecha),sum(litros_leche) FROM	produccion_lechera
  where Month(fecha) = MOnth(curdate()) and year(fecha)=year(curdate()) and produccion_lechera.vacas_id in
   (select vacas.id from vacas where vacas.potrero_id in
   (select id from potrero where finca_id =
   (select id from finca where usuario_dni = $sesion)))
  GROUP BY day(fecha)  ";
  }
} else {
  $queryleche = "SELECT day(fecha),sum(litros_leche) FROM	produccion_lechera
  where Month(fecha) = MOnth(curdate()) and year(fecha)=year(curdate()) and produccion_lechera.vacas_id in
   (select vacas.id from vacas where vacas.potrero_id in
   (select id from potrero where finca_id =
   (select id from finca where usuario_dni = $sesion)))
  GROUP BY day(fecha)  ";
}


$leche_mensual = $conexion->query($queryleche);
$total = array();
while ($leche = $leche_mensual->fetch_assoc()) {
  $k[$leche["day(fecha)"]] = $leche["sum(litros_leche)"];

}

for ($i = 1; $i < $hoy + 1; $i++) {


  if (!(isset($k[$i]))) {
    array_push($total, 0);
  } else {
    array_push($total, $k[$i]);
  }
  if (($i == 1) || ($i == $hoy)) {

  } else {

  }
}

?>

<?php
$valor = "";
foreach ($total as $var) {
  $valor = $valor . $var . ",";
}
$rest = substr($valor, 0, -1);
?>
<script>
  var dom = document.getElementById('Contenedor');
  var myChart = echarts.init(dom, null, {
    renderer: 'canvas',
    useDirtyRect: false
  });
  var app = {};

  var option;

  option = {
    title: {
      text: "Leche producida por <?php if ($colocar_vaca_individual) {
        #se hace la misma confirmacion aca al momento de dar el nombre
        echo $identificacion_vaca;
      } else {
        echo "todas las vacas";
      }
      ?>",
      left: "center"
    },
    xAxis: {
      type: 'category',
      data: [<?php
      for ($i = 1; $i < $hoy + 1; $i++) {
        # code...
        echo $i;
        if (($i == $hoy)) {

        } else {
          echo ",";
        }

      }
      ?>]
    },
    yAxis: {
      type: 'value'
    },
    series: [
      {
        data: [<?php
        echo $rest;
        ?>],
        type: 'bar',
        showBackground: true,
        backgroundStyle: {
          color: 'rgba(180, 180, 180, 0.2)'
        }
      }
    ]
  };

  if (option && typeof option === 'object') {
    myChart.setOption(option);
  }

  window.addEventListener('resize', myChart.resize);
</script>