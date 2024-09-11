<?php
session_start();

include ("conexion.php");
$var=new conexion();
$var->conectarse();

$idus=$_SESSION['id_usuario'];
$vieja=$_POST['pass'];
$nueva=$_POST['nueva'];
//$fech=$_POST['fecha'];
//$repita=$_POST['rep'];
$fe=inviertefecha($_POST['fecha']);


//$vari=md5('admin');
$sql="SELECT * FROM usuarios where id_usuario=$idus ";
$result=mysql_query($sql) or (die(mysql_error()));
		 
		 if ($row = mysql_fetch_array($result))
			{
			 
			 	if(($row["contrasena"] == md5($vieja)))
				     {  
					   $nuevaE=md5($nueva);
					   $cons=" UPDATE usuarios SET contrasena='$nuevaE', 
					                               fecha='$fe'
					                   WHERE id_usuario=$idus ";
									   
						mysql_query($cons,$var->links);	
				
					 	header("Location: alta_usuario.php");
					 }
					 
					 else {
					 
					       //header("Location: principal.php");
					        header("Location: cambiar.php?error=1");
							}
							
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