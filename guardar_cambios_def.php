<?php

include ("conexion.php");
$var=new conexion();
$var->conectarse();


$fol=$_POST['nrofolio'];
$fech=$_POST['fechas'];
$reg=$_POST['mov'];
$usu=$_POST['usu'];

//int intval ( mixed $usu [, int $base = 10 ] )

$consulta= "UPDATE registrodefensor SET
						  id_defen='".$usu."',
						  fecha='$fech',
						  folios='$fol'
						  
						  				  
		 WHERE id_reg=".$_POST['mov'];

mysql_query($consulta,$var->links);



$sql_busca="SELECT expedientes.nro_expediente, expedientes.id_expediente FROM expedientes   JOIN  registrodefensor  ON expedientes.id_expediente = registrodefensor.id_expediente WHERE registrodefensor.id_reg= $reg";
$res2=mysql_query($sql_busca) or die(mysql_error());
	$expediente=mysql_fetch_row($res2);
	volver($expediente[0]);

function invertirFecha($valor)
	{
	 $valor = explode("-",$valor);
	 $valor = $valor[2]."-".$valor[1]."-".$valor[0];
	 return $valor;
	}
	
	function volver($exp)
	{   
		

		echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();;</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();;</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
		header("Location:panelexpediente.php?expe=$exp");
		
	}

?>

