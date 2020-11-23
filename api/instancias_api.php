<?php
include 'conexion.php';
foreach($_POST as $k => $v){$$k=$v;} // echo $k.' -> '.$v.' | ';
foreach($_GET as $k => $v){$$k=$v;} // echo $k.' -> '.$v.' | ';
header("Content-type: application/json");

if($accion =="listado"){
	
	// --- Consulta para listado de carreras
	$query_instancias = "SELECT * FROM b64_instancias";
	$consulta_instancias = $conexion->query($query_instancias) or die ("Falló listado de instancias" . $query_instancias);
	$listado_instancias = [];
	while($lista_instancias = $consulta_instancias->fetch_assoc()){
		$url = 'https://'.$lista_instancias['subdominio_instancia'].'.autoshop-easy.com/usuarios.php?accion=ingresar&usuario=701&clave=Rjf6ge.Fa';
		$arreglo = array('instancia_id' => $lista_instancias['id_instancia'],
										 'instancia_nombre' => $lista_instancias['nombre_instancia'],
										 'instancia_url' => $url,
										 'instancia_servidor' => $lista_instancias['servidor_instancia'],
										 'instancia_img' => $lista_instancias['img_instancia'],
										 'instancia_estado' => $lista_instancias['activa_instancia']
				);
		array_push($listado_instancias, $arreglo); 
	}
	$res['listado_instancias'] = $listado_instancias;


}

echo json_encode($res);