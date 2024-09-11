<?php


include("conexion.php");
$var = new conexion();
$var->conectarse();


$parametro = $_POST['parametro'];

$consulta="SELECT * FROM parametros WHERE descripcion='$parametro'";	    
$result=mysql_query($consulta,$var->links);

//var_dump($result);

if(mysql_num_rows($result) > 0 )
 echo "ya existe" ;
 else
     {
	$consulta2="INSERT INTO parametros (descripcion) VALUES ('$parametro')";	    
	$result2=mysql_query($consulta2,$var->links);
	if($result2)	
		echo mysql_insert_id();
	else "error al cargar";
     }




?>