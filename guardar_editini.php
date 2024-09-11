<?php




include ("conexion.php");
$var=new conexion();
$var->conectarse();

$exp=$_POST['tnnnn'];


$dniini=$_POST['idIniciador'];
$nom=$_POST['tnom'];
$ap=$_POST['tape'];
$dom=$_POST['tdom'];
$tel=$_POST['ttelef'];

$consulta1= "UPDATE iniciador SET nombre='".$nom."',apellido='".$ap."',direccion='".$dom."',telefono='".$tel."' WHERE dni='".$dniini."'";
mysql_query($consulta1,$var->links);

volver($exp);

//echo"$consulta1";

 function inviertefecha($f)
{
$datos = explode("-",$f);
$fecha[]= $datos[0];
$fecha[] = $datos[1];
$fecha[] = $datos[2];
$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];
return  $total;

}

function volver($exp)
	{
		header("Location:editaexpediente.php?nroexpe=$exp");
	}	
	
 
 ?>