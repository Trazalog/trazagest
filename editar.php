<?php

include ("conexion.php");
$var=new conexion();
$var->conectarse();



$datos=$_POST['parametros'];

if($datos){
$caja=$datos['descripcion'];
$codigo=$datos['codigo'];
$estanteria=$datos['id_estanteria'];
$fila=$datos['fila'];
$estado=$datos['estado'];
$id=$datos['id_cajas'];


}

$consulta="UPDATE cajas SET codigo='$codigo',
							descrip='$caja',
							fila='$fila',
							id_estanteria=$estanteria,
							estado='C' 
			WHERE id_cajas=$id ";
$result2   = mysql_query($consulta,$var->links);


//if(mysql_query($consulta,$var->links))
if($result2 !='')
	{
				
		
		echo json_encode($result2);
		 
	}
	else
		{
		 
		 // header("Location: nexito.php");
		 echo"$consulta";
		}
		

  
 ?>