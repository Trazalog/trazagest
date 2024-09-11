<?php

include ("conexion.php");
$var=new conexion();
$var->conectarse();

//$us= $_SESSION["id_usuario"];

$datos=$_POST['parametros'];
$us=$_POST['us'];
if($datos){
$nom=$datos['nombre'];
//$estado=$_POST['estado'];//echo $_POST['fecha_entre']."facha entrega<br>";
$nomus=$datos['nombreusu'];
$contra=$datos['contras'];
$grupo=$datos['id_grupo'];


}

$nuevaE=md5($contra);
$consulta="INSERT INTO usuarios(nombre,nombre_real,contrasena,creado_por,id_grupo, estado)  VALUES ('$nomus','$nom','$nuevaE', '$us', '$grupo', 'AC')";
// $result2   = mysql_query($consulta2,$var->links);

if(mysql_query($consulta,$var->links)){
	print_r(json_encode(true));
}else{
	echo"$consulta";
}
		

  
 ?>