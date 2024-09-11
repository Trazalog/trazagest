<?php


include("conexion.php");
$var = new conexion();
$var->conectarse();
$ca=$_POST['id_cajas'];



$consulta2="SELECT cajas.id_cajas, cajas.codigo, cajas.descrip, cajas.fila, cajas.id_estanteria, estanteria.descripcion FROM  cajas  JOIN estanteria ON  cajas.id_estanteria= estanteria.id_estanteria
WHERE cajas.id_cajas=$ca
	    
	    ";
   
	    
$result2=mysql_query($consulta2,$var->links);

//$row2 = mysql_fetch_assoc($result2);

//return $row2;

while( $row2 = mysql_fetch_assoc($result2))
	{	

		
		$data['id_cajas']=$row2['id_cajas'];
		$data['codigo']=$row2['codigo'];
		$data['descrip']=$row2['descrip'];
		$data['fila']=$row2['fila'];
		$data['id_estanteria']=$row2['id_estanteria'];
		$data['descripcion']=$row2['descripcion'];

		
		
		/* echo $row2 ['id_cajas'].",".$row2['descrip'].",".$row2['codigo'].",".$row2['descripcion'].",".$row2['fila'].";";*/
	 
	}
	
print_r(json_encode($data)) ;




?>