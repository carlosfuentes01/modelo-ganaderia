<?php 
$host="127.0.0.1";
$user="root";
$psw="ianelperro123";
$bd="brftiblxal2dldsiqbzr";


date_default_timezone_set('America/Bogota');
$conexion=mysqli_connect($host,$user,$psw,$bd);
if(!$conexion){
	
	die("Problemas con la conexión".mysql_connect_error());
}

?>
