<?php
$dni=$_POST['dn'];

include ("conexion.php");
$var=new conexion();
$var->conectarse();



$consulta="SELECT Nombre,Dni, Apellido, Direccion, telefono
FROM iniciador
WHERE Dni=$dni";

/*$resul=mysql_query($consulta);
if($resul!="")
	{
	print_r (json_encode($resul));
	}else
		{
		// header("Location: error.php");
		echo $consulta;
		}*/

$res=mysql_query($consulta);

while( $row2 = mysql_fetch_assoc($res))
	{	

		
		$data['Nombre']=$row2['Nombre'];
		$data['Apellido']=$row2['Apellido'];
		$data['Dni']=$row2['Dni'];
		$data['telefono']=$row2['telefono'];
		$data['Direccion']=$row2['Direccion'];
		
		
		
		/* echo $row2 ['id_cajas'].",".$row2['descrip'].",".$row2['codigo'].",".$row2['descripcion'].",".$row2['fila'].";";*/
	 
	}
	
print_r(json_encode($data)) ;

 ?>