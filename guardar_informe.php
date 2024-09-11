<?php
$fe=$_POST['fecha'];
$ex=$_POST['extracto'];
$idmov=$_POST['mov']; //id_mov 
$rid=$_POST['id'];

include ("conexion.php");
$var=new conexion();
$var->conectarse();



$consulta= "UPDATE respuesta_agente SET id_mov='$idmov',
                               extracto='$ex',
							   fecha='$fe'
 
							   WHERE id=$rid" ;
if(mysql_query($consulta))
	{
	//header("Location: exito.php");
	//header("Location:panelexpediente.php?expe=$expe");
	
	    echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();;</script>";
		 echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();;</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
		 
	
	}else
		{
		// header("Location: error.php");
		echo $consulta;
		}
 
 

 
 ?>
 