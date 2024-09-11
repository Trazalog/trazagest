<?php


include("conexion.php");
$var = new conexion();
$var->conectarse();

$exp=$_POST['exp'];
$consulta= " SELECT 
				O.id_expediente,
				O.nro_expediente,
				O.caratula, 
				O.fecha,
				 O.id_iniciador,
				   C.nombre
				    FROM expedientes O
					join iniciador C  on C.dni=O.id_iniciador
					Where O.nro_expediente = $exp"; 
					
					
					
					$result2=mysql_query($consulta,$var->links);

//$Arre = Array();
if(mysql_num_rows($result2) > 0){
while( $row2 = mysql_fetch_array($result2)) // se ejecuta una vez
	{
		 echo $row2[5]."**;".$row2[3]."**;".$row2[2]."**;".$row2[0];
	 
	}
} else echo 'nada';	

					?>
					






