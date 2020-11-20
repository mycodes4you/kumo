<?php
foreach($_POST as $k => $v){$$k=$v;} // echo $k.' -> '.$v.' | ';
foreach($_GET as $k => $v){$$k=$v;} // echo $k.' -> '.$v.' | ';
session_start(); // --- Validar sesión ---

include ('api/conexion.php');

// ---- Se establece la zona horarira y el lenguaje
date_default_timezone_set("America/Mexico_City");
setlocale(LC_ALL , 'es_ES.UTF-8');

// ---- Hora actual
$hora_actual = strftime("%A, %e $de %B $de %Y %R");

// ---- Saludo de acuerdo a la hora del día
$today = getdate();
$hora=$today["hours"];
if ($hora<12) {
	$saludo = '<i class="fas fa-sun fa-lg" style="color: #ffef00; text-shadow: 0 0 5px #000;"></i> Buenos días bienvenid@ a KUMO';
}elseif($hora<19){
	$saludo = '<i class="fas fa-cloud-sun fa-lg" style="color: #faff50; text-shadow: 0 0 5px #000;"></i> Buenas tardes bienvenid@ a KUMO';
}else{ 
	$saludo = '<i class="fas fa-moon fa-lg" style="color: blue; text-shadow: 0 0 5px #000;"></i> Buenas Noches bienvenid@ a KUMO'; 
}



// --- URL para axios
$url_axios = "https://localhost/control/";
//$url_axios = "https://atom-rm.com/control/";


if(!isset($_SESSION['usr'])){
	header("location:login.php?accion=entrar"); // --- redirigir a login si no hay sesión ---
}

if($accion == 'dashboard'){
	
	$titulo_pagina = 'Dashboard';
	// ---- Marcar la sección en el menú ---
	$menu_dashboard = 'active';
	// --- BACKEND ----
	include('front/dashboard.php');
	unset($_SESSION['mensajes']);
	
}

if($accion == 'cuenta'){
	
	$titulo_pagina = 'Cuenta';
	// ---- Marcar la sección en el menú ---
	$menu_dashboard = 'active';
	// --- BACKEND ----
	include('front/cuenta.php');
	unset($_SESSION['mensajes']);
	
}

?>
