<?php
include ("conexion.php");
$var=new conexion();
$var->conectarse();

$caja=$_POST['idcaja'];

$consulta=" DELETE FROM cajas
			WHERE id_cajas=$caja ";



if(mysql_query($consulta,$var->links))
	{
		
			
	 	print_r(json_encode(true));
		 
	}else
		{
		 
		 // header("Location: nexito.php");
		 echo"$consulta";
		}
		

 
  
 ?>