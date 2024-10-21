<?php 
$host="bj8tsn2ymfxavmfpfcix-mysql.services.clever-cloud.com";
$user="uxz3x1uzsc0h04df";
$psw="ZAARGJZN6U6q16evB0Cj";
$bd="bj8tsn2ymfxavmfpfcix";

$conexion=mysqli_connect($host,$user,$psw,$bd);
if(!$conexion){
	die("Problemas con la conexión".mysql_connect_error());
}

?>