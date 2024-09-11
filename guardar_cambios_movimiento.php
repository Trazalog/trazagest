<?php
//$fe= invertirFecha($_POST['fechas']);



$fol=$_POST['cant'];
//echo $fol,"folio<br>";
$observa=$_POST['obstext'];
$agent=$_POST['defen'];
$fe= $_POST['fechas'];
$mo= $_POST['mov'];
$usu= $_POST['usu'];

print_r($usu);
print_r($agent);
include ("conexion.php");
$var=new conexion();
$var->conectarse();
if($usu >0 )
{
$consulta= "UPDATE registro_movimiento SET
						 id_usuario='$usu',
						  fecha='$fe',
						  folios='$fol',
						  observaciones='$observa'
		 WHERE id_mov='$mo' ";

mysql_query($consulta,$var->links);
}
else{
$consulta= "UPDATE registro_movimiento SET
						 id_usuario='$agent',
						  fecha='$fe',
						  folios='$fol',
						  observaciones='$observa'
		 WHERE id_mov='$mo' ";

mysql_query($consulta,$var->links);	
}
//************ busco expdiente para volver la pantalla al mismo expdiente
$sql_1="select id_reg from  registro_movimiento  WHERE id_mov='$mo' ";  
$res22=mysql_query($sql_1) or die(mysql_error());
	$movimiento=mysql_fetch_row($res22);

$sql_busca="select e.nro_expediente  from registrodefensor r JOIN expedientes e
    	   on e.id_expediente = r.id_expediente WHERE r.id_reg='".$movimiento[0]."' ";
$res2=mysql_query($sql_busca) or die(mysql_error());
	$expediente=mysql_fetch_row($res2);
	volver($expediente[0]);

//header("Location: historialexpediente.php");
function invertirFecha($valor)
	{
	 $valor = explode("-",$valor);
	 $valor = $valor[2]."-".$valor[1]."-".$valor[0];
	 return $valor;
	}

function volver($exp)
	{
		header("Location:panelexpediente.php?expe=$exp");
	}	

?>

 <script languaje='javascript' type='text/javascript'>window.close();</script>;