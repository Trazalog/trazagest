<?php
session_start();

include ("conexion.php");
$var=new conexion();
$var->conectarse();

$idus=$_POST['ide'];
$usu=$_POST['nomusu'];
$nueva=$_POST['contra'];
//$fech=$_POST['fecha'];
//$fe=inviertefecha($_POST['fecha']);

$nuevaE=md5($nueva);
$cons=" UPDATE usuarios SET nombre_real='$usu',
							contrasena='$nuevaE' 
					       
					        WHERE id_usuario=$idus ";
									   
// mysql_query($cons,$var->links);	
// return true;
				
if(mysql_query($cons,$var->links))

{   
//header("Location: exito.php"); esta bien /probando 
/*echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";*/
return 1;
	 	
}
else
	{ 
	 echo $consulta;
	// header("Location: error.php");
	}				 	
			

 function inviertefecha($f)
{
$datos = explode("-",$f);
$fecha[]= $datos[0];
$fecha[] = $datos[1];
$fecha[] = $datos[2];
$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];

return  $total;

}

?>