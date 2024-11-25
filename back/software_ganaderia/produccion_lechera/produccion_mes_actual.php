<?php
include '../../conexion/conexion.php'; 
session_start();

// Verifica si el usuario está autenticado
if (!isset($_SESSION['dni'])) {
    header("Location: ../../usuario/iniciar_sesion.php");
    exit;
}

$sesion = $_SESSION['dni'];