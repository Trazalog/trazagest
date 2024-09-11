<?php

$n=$_POST['nom'];
$ap=$_POST['apell'];
$te=$_POST['tel'];
$di=$_POST['dire'];
$dn=$_POST['dni'];

include ("conexion.php");
$var=new conexion();
$var->conectarse();

//$consu="INSERT INTO iniciador() VALUES ();"
$consulta= "UPDATE iniciador SET
							
						  Nombre='$n',
						  Apellido='$ap',
						  telefono='$te',
						  Direccion='$di'
						  
		 WHERE dni=$dn ";
		 
		 
if(mysql_query($consulta,$var->links))

	{   
	print_r(json_encode(true)) ;
		 	
	}
	else
		{ 
		 echo $consulta;
		}


?>
