<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$idcaja =$_POST['idcaja']; 
$expn =$_POST['expnu']; //numexp

$consulta2="SELECT * 
			FROM  ccajas 	
			JOIN expedientes ON expedientes.id_expediente = ccajas.id_expediente
	    	WHERE ccajas.id_cajas=$idcaja AND expedientes.nro_expediente=$expn ";
   
	    
$result2=mysql_query($consulta2,$var->links);
$row2 = mysql_fetch_assoc($result2);

print_r($row2);



?>