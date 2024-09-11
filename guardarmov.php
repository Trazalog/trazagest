<?php


include("conexion.php");
$var = new conexion();
$var->conectarse();

$pa=$_POST['parametros'];
if ($pa >0) {
        	$estaid = $pa['id_estanteria'];
        	$id= $pa['id_caja'];
}

$consulta2="UPDATE  cajas SET id_estanteria = $estaid
   
   WHERE id_cajas=$id
	    
	    ";
   
	    
$result2=mysql_query($consulta2,$var->links);



//return $row2;


	
print_r(json_encode($result2)) ;




?>