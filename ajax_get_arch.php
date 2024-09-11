<?php


include("conexion.php");
$var = new conexion();
$var->conectarse();

//$idcaja =$_POST['idcajas']; 
$idcaja =$_GET['caja']; 
$consulta2="SELECT * FROM  ccajas 
			JOIN cajas ON ccajas.id_cajas = cajas.id_cajas
			JOIN expedientes ON expedientes.id_expediente = ccajas.id_expediente
	    	WHERE ccajas.id_cajas=$idcaja";
   
	    
$result2=mysql_query($consulta2,$var->links);


/*while( $row2 = mysql_fetch_assoc($result2))
	{
		 echo $row2['nro_expediente'].",,".$row2['caratula'].";;";
		
	 
	}*/
//$row2 = mysql_fetch_assoc($result2);
//$i=0;
//foreach ($row2 as $ro) 
while ( $row2 = mysql_fetch_assoc($result2) )	

{
		
		$data['nro_expediente']=$row2['nro_expediente'];
		$data['caratula']=$row2['caratula'];
		//$i++;
	echo json_encode($data);
	}
	
	//echo json_encode($data);
 
	//return $data;

?>