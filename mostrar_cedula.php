<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$busca=$_POST['idced'];


 $consulta = "Select 
	                     C.numero_expediente,
	                     C.detalle_cedula,
						 C.expedinete_destino,
						 C.datos,
						 C.id_cedula,
						 C.copias,
						 C.plazo,
						 C.fecha,
						 C.fecha_profesional,
						 C.fecha_notificacion,
						 C.fecha_devolucion,
						 C.oficina,
						 C.fecha_entrada
						
	              from  cedula C  
				  where C.id_cedula =".$busca;


				  $res=mysql_query($consulta);
				   $cedula=mysql_fetch_array($res);
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title class="print2" >Descripcion </title>
</head>
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
     <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <link href="css/bootstrap.min.css/bootstrap/3.3.6" rel="stylesheet">
  <link href="css/estilos.css/bootstrap/3.3.6" rel="stylesheet">
  <link href="bootstrap.css/bootstrap/3.3.6" rel="stylesheet">
  
   
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <script src="jquery.js"></script>
	

<body id="fondo" > 
    <div class="container">
    
    <form name="c" id="cforprint" action=""  class="form-horizontal"   role="form">
					
	<div id="contenedor1">
	
		  
	  	 <?php 
			 
	     if(isset($cedula['detalle_cedula']))
	       echo $cedula['detalle_cedula'];
		
             
		 ?>  
    </div>			
	


</form>


</body>
</html>
