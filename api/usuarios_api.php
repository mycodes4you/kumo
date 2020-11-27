<?php
include 'conexion.php';
foreach($_POST as $k => $v){$$k=$v;} // echo $k.' -> '.$v.' | ';
foreach($_GET as $k => $v){$$k=$v;} // echo $k.' -> '.$v.' | ';
header("Content-type: application/json");

if($accion === "listado"){
	
	// --- Consulta para listado de carreras
	$query_usuarios = "SELECT * FROM usuarios WHERE usuario_activo = 1";
	$consulta_usuarios = $conexion->query($query_usuarios) or die ("Falló listado de usuarios" . $query_usuarios);
	$listado_usuarios = [];
	while($lista_usuarios = $consulta_usuarios->fetch_assoc()){
		
		$usuario_nombre = $lista_usuarios['usuario_apellido1']. ' ' .$lista_usuarios['usuario_apellido2']. ' ' .$lista_usuarios['usuario_nombre1']. ' ' .$lista_usuarios['usuario_nombre2'];

		$arreglo = array('usuario_id' => $lista_usuarios['usuario_id'],
										 'usuario_usuario' => $lista_usuarios['usuario_usuario'],
										 'usuario_nombre' => $usuario_nombre,
										 'usuario_foto' => $lista_usuarios['usuario_foto'],
										 'usuario_nombre1' => $lista_usuarios['usuario_nombre1'],
										 'usuario_nombre2' => $lista_usuarios['usuario_nombre2'],
										 'usuario_apellido1' => $lista_usuarios['usuario_apellido1'],
										 'usuario_apellido2' => $lista_usuarios['usuario_apellido2'],
										 'usuario_activo' => $lista_usuarios['usuario_activo']
				);
		array_push($listado_usuarios, $arreglo); 
	}
	$query_usr = "SELECT usuario_id FROM usuarios";
	$consulta_usr = $conexion->query($query_usr) or die ("Falló num de usuarios " . $query_usr);
	$num_usr = $consulta_usr->num_rows;

	$query_usr_on = "SELECT usuario_id FROM usuarios WHERE usuario_activo = '1'";
	$consulta_usr_on = $conexion->query($query_usr_on) or die ("Falló num de usuarios " . $query_usr_on);
	$num_usr_on = $consulta_usr_on->num_rows;


	$num_usr_off = $num_usr - $num_usr_on;

	$res['num_usr_off'] = $num_usr_off;
	$res['num_usr'] = $num_usr;
	$res['num_usr_on'] = $num_usr_on;
	$res['listado_usuarios'] = $listado_usuarios;


}

elseif ($accion == 'actualizar') {

		$passMd5 = md5($usuario_psswrd);
		$result = $conexion->query("UPDATE usuarios SET usuario_nombre1 = '$usuario_nombre1', usuario_nombre2 = '$usuario_nombre2', usuario_apellido1 = '$usuario_apellido1', usuario_apellido2 = '$usuario_apellido2', usuario_usuario = '$usuario_usuario', usuario_psswrd = '$passMd5', usuario_activo = '$usuario_activo' WHERE usuario_id ='$usuario_id'");
		//$desc_bit = 'Se edito alumno: ' . $alumno_matricula . ' con el alumno_email: ' . $alumno_email . ' y el telefono: ' . $alumno_telefono;
		//$bitacora = $conn->query("INSERT INTO bitacora (desc_bit) VALUES('$desc_bit')");

		if ($result) {
			$res['message'] = 'Exito! se actualizo el Usuario ' .$usuario_id;
			//$res['message2'] = $desc_bit;
		} else {
			$res['error']   = true;
			$res['message'] = 'Error al actualizar Usuario!.';
		}
}
/*elseif ($accion == 'agregar') {

	if (!isset($usuario_foto_add)){
		$nombre_archivo =$_FILES['usuario_foto_add']['name'];
    $tipo_archivo = $_FILES['usuario_foto_add']['type'];
    $tamano_archivo = $_FILES['usuario_foto_add']['size'];
    $archivo= $_FILES['usuario_foto_add']['tmp_name'];


 	} else{
 		$nombre_archivo="";
  }

  if ($nombre_archivo!=""){
	  if (!((strpos($tipo_archivo, "jpeg") || strpos($tipo_archivo, "jpg")))) {
	  	if ($tamano_archivo  < 30000000) {
	  		$res['error']   = true;
				$mensaje = 'El tamaño de los archivos no es correcto. Se permiten archivos de 3 Mb máximo.';
				$res['message'] = $mensaje;
	  	}
	  	$res['error']   = true;
	  	$res1 = explode(".", $nombre_archivo);
      $extension1 = $res1[count($res1)-1];
			$mensaje = 'El tipo de archivo ' . $extension1 . ' no esta permitido. Se permiten archivos .jpg, .jpeg';
			$res['message'] = $mensaje;
	  }
	  else{

	  	$directorio = '/dist/img/';
	  	$tipo = $_FILES['usuario_foto_add']['name'];
			$ext = explode('.',$tipo);
			$extension = array_pop($ext);
			$fecha = new DateTime();
			$archivo = $directorio.$fecha->getTimestamp().'.'.$extension;
			$evento_fecha_creado = date("Y-m-d H:i:s");
			
            if (move_uploaded_file($_FILES['usuario_foto_add']['tmp_name'], $archivo)) {
               $passMd5 = md5($usuario_psswrd_add);
              $sqlFoto = $conexion->query("INSERT INTO usuarios (usuario_nombre1, usuario_nombre2, usuario_apellido1, usuario_foto, usuario_apellido2, usuario_usuario, usuario_psswrd) VALUES('$usuario_nombre1_add', '$usuario_nombre2_add', '$usuario_apellido1_add', '$archivo', $usuario_apellido2_add, $usuario_usuario_add, $passMd5)");

              //$sqlFoto = $conexion->query("UPDATE eventos SET usuario_foto_add = '$archivo' WHERE alumno_id = '$alumno_id'");
							if ($sqlFoto) {
								$mensaje = 'Se agrego correctamente el Usuario: '.$usuario_usuario.'.';
								$res['message'] = $mensaje;
								//$res['message2'] = $desc_bit;
							} else {
								$res['error']   = true;
								$mensaje = 'Error agregar el usuario: ' . $usuario_usuario;
								$res['message'] = $mensaje;
							}
                unlink($dirtemp); //Borrar el fichero temporal
            }
            else
            {
              $res['error']   = true;
							$mensaje = 'Ocurrió algún error al subir el fichero. No pudo guardarse. Nombre:'.$usuario_usuario_add.' - Archivo: '.$archivo.'';
							$res['message'] = $mensaje;
            }			
    }
	}      
}*/

elseif ($accion == 'agregar') {
	$foto = 'dist/img/usuario.png';
	$activo = '1';
	$passMd5 = md5($usuario_psswrd_add);
	$sql_add_usr = $conexion->query("INSERT INTO usuarios (usuario_nombre1, usuario_nombre2, usuario_apellido1, usuario_apellido2, usuario_usuario, usuario_psswrd, usuario_activo, usuario_foto) VALUES('$usuario_nombre1_add', '$usuario_nombre2_add', '$usuario_apellido1_add', '$usuario_apellido2_add', '$usuario_usuario_add', '$passMd5', '$activo', '$foto')");

	if ($sql_add_usr) {
		$mensaje = 'Se agrego correctamente el Usuario: '.$usuario_usuario_add;
		$res['message'] = $mensaje;
	} 
	else {
		$res['error']   = true;
		$mensaje = 'Error agregar el usuario: ' . $usuario_usuario_add.' ==> ' .$sql_add_usr;
		$res['message'] = $mensaje;
	}
}

else{
	echo 'error 404';
}


echo json_encode($res);