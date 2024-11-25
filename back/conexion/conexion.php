<?php 
$host="127.0.0.1";
$user="root";
$bd="brftiblxal2dldsiqbzr";
$pass= "javie234A";
$port=3306;

date_default_timezone_set('America/Bogota');
$conexion=mysqli_connect($host,$user, $pass, $bd,$port);
if(!$conexion){
	
	die("Problemas con la conexión".mysql_connect_error());
}

?>
