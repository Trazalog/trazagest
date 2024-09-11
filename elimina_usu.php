<?php
include ("conexion.php");
$var=new conexion();
$var->conectarse();

$idu=$_POST['idu'];

$consulta=" UPDATE usuarios SET estado='AN'
							
					       
					        WHERE id_usuario=$idu ";


if(mysql_query($consulta,$var->links))
	{
		
			
	 	print_r(json_encode(true));
		 
	}else
		{
		 
		 // header("Location: nexito.php");
		 echo"$consulta";
		}
		
//" DELETE FROM usuarios
			//WHERE id_usuario=$idu ";
 
  
 ?>