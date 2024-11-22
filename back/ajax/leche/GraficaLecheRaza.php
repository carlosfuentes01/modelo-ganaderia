
<?php 
include "../../conexion/conexion.php";
session_start();
if (!isset($_SESSION['dni'])) {
  header("Location: ../../usuario/login.php");
  exit;
}
$sesion = $_SESSION['dni'];
$id_Raza = $_POST["raza"];
$hoy = date("t");
echo "$id_Raza.'hola'";
echo "<script>
console.log('<?=$id_Raza?>'+'Hola');
</script>";
$queryleche="SELECT day(fecha),sum(litros_leche) FROM	produccion_lechera
where Month(fecha) = Month(curdate()) and year(fecha)=year(curdate()) and produccion_lechera.vacas_id in (select vacas.id from vacas where 
vacas.id in(select vacas_id_animal from razas_de_la_vaca where raza_id_raza = $id_Raza) and vacas.potrero_id in
 (select id from potrero where finca_id =
 (select id from finca where usuario_dni = $sesion)))
GROUP BY day(fecha)  ";
$leche_mensual=$conexion->query($queryleche);
$total=array();
while ($leche = $leche_mensual->fetch_assoc()) {
    $k[$leche["day(fecha)"]]= $leche["sum(litros_leche)"];
    
    
    
}

for ($i=1; $i < $hoy+1; $i++) { 
  

if (!(isset($k[$i]))) {
    array_push($total,0);
}else{
    array_push($total,$k[$i]);
}
    if (($i==1)||( $i==$hoy)) {
      
    }else{
        
    }
}
?>
<?php
$valor="";
 foreach ($total as $var ) {
 $valor=$valor.$var.",";
}
$rest = substr($valor, 0, -1); 
?>

<h1>Hola</h1>
<script>
    var dom = document.getElementById('Grafica');
var myChart = echarts.init(dom, null, {
  renderer: 'canvas',
  useDirtyRect: false
});
var app = {};

var option;

option = {
    title: {
        text: "Leche producida por mes ",
        left: "center"
    },
  xAxis: {
    type: 'category',
    data: [<?php
    for ($i=1; $i < $hoy+1; $i++) { 
      # code...
      echo$i;
        if (( $i==$hoy)) {
          
        }else{
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
 echo $rest ;
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
