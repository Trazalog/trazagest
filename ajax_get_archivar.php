<?php


include("conexion.php");
$var = new conexion();
$var->conectarse();


$idcajas = $_POST['idcajas'];

$consulta2="SELECT * FROM  cajas  JOIN estanteria
	    WHERE cajas.id_cajas=$idcajas
	    AND cajas.id_estanteria= estanteria.id_estanteria
	    ";
   
	    
$result2=mysql_query($consulta2,$var->links);


while( $row2 = mysql_fetch_assoc($result2))
	{
		 echo $row2['descrip'].",".$row2['codigo'].",".$row2['descripcion'].",".$row2['fila'].";";
	 
	}



?>