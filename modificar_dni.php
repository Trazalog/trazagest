<?php
include ("conexion.php");
$var=new conexion();
$var->conectarse();

$dn=$_POST['dnn2']; //modificado
$di=$_POST['dn'];
//$pa=$_POST['parametros'];


//$consu="INSERT INTO iniciador() VALUES ();"
$consulta= "UPDATE iniciador SET
							
						 
						  dni='$dn'
						  
		 WHERE dni=$di ";
$re2=mysql_query($consulta,$var->links);
	 

$consulta2="UPDATE expedientes SET
							
						 
						  id_iniciador='$dn'
						  
		 WHERE id_iniciador=$di ";
$re1=mysql_query($consulta2,$var->links);

$consulta3= "SELECT Nombre, Apellido
				From iniciador
				WHERE dni=$dn";
$re3=mysql_query($consulta3,$var->links);
$option = mysql_fetch_row($re3);
//$respueta=mysql_fetch_assoc($re3);


print_r(json_encode($option));
//print_r(1);
/*if(mysql_query($consulta,$var->links))

	{   

		$consulta2="UPDATE expedientes SET
							
						 
						  id_iniciador='$dn'
						  
		 WHERE id_iniciador=$di ";
		 $re1=mysql_query($consulta,$var->links);
		 $respueta=mysql_fetch_assoc($re1);

	print_r(1) ;
		 	
	}
	else
		{ 
		 echo $consulta;
		}*/


?>
