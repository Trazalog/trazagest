<?php

include ("conexion.php");
$var=new conexion();
$var->conectarse();



$datos=$_POST['parametros'];

if($datos){
$estanteria=$datos['descripcion'];



}

$consulta="INSERT INTO estanteria(descripcion)  VALUES ('$estanteria')";
// $result2   = mysql_query($consulta2,$var->links);



if(mysql_query($consulta,$var->links))
	{
				
		
		 //print_r(json_encode(true));
		 return 0;
	}else
		{
		 
		 // header("Location: nexito.php");
		 echo"$consulta";
		}

 
  
 ?>