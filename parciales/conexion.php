<?php

$servidor = 'mycodes4you.com';
$bd = 'admin_kumo';
$usuario_bd = 'kumo_user';
$password_usuario = 'Pv0@zr04';

session_start();
$conn = new mysqli($servidor, $usuario_bd, $password_usuario, $bd);

if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}
else{
	echo 'correcto';
}

?>