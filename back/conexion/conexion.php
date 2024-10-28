<?php 
$host="brftiblxal2dldsiqbzr-mysql.services.clever-cloud.com";
$user="ut75ds3u5guzudxh";
$psw="SOlcWcKeMxJwt6rTEEh";
$bd="brftiblxal2dldsiqbzr";

$conexion=mysqli_connect($host,$user,$psw,$bd);
if(!$conexion){
	die("Problemas con la conexión".mysql_connect_error());
}

?>
