<?php

include ("conexion.php");
$var=new conexion();
$var->conectarse();



$datos=$_POST['parametros'];

if($datos){
$caja=$datos['descripcion'];
//$estado=$_POST['estado'];//echo $_POST['fecha_entre']."facha entrega<br>";
$codigo=$datos['codigo'];
$estanteria=$datos['id_estanteria'];
$fila=$datos['fila'];
$estado=$datos['estado'];


}

$consulta="INSERT INTO cajas(codigo,descrip,id_estanteria,fila,estado)  VALUES ('$codigo','$caja','$estanteria', '$fila', 'C')";
// $result2   = mysql_query($consulta2,$var->links);



if(mysql_query($consulta,$var->links))
	{
				
		
		 print_r(json_encode(true));
		 
	}else
		{
		 
		 // header("Location: nexito.php");
		 echo"$consulta";
		}
		
/*		
 function inviertefecha($f)
{
$datos = explode("-",$f);
$fecha[]= $datos[0];
$fecha[] = $datos[1];
$fecha[] = $datos[2];
$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];

return  $total;

}

function calcular_mes($f)
{
$datos = explode("-",$f);
$fecha[]= $datos[0];
$fecha[] = $datos[1];
$fecha[] = $datos[2];
$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];

return  $fecha[1];

}

function calcular_nio($f)
{
$datos = explode("-",$f);
$fecha[]= $datos[0];
$fecha[] = $datos[1];
$fecha[] = $datos[2];
$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];

return  $fecha[0];

} */
 
  
 ?>