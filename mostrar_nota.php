<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$busca=$_POST['idnot'];

$consulta = "Select 
	                     N.numero_expediente,
	                     N.detalle_cedula,
						 N.expedinte_destino,
						 N.datos,
						 N.id_nota,
						 N.copias,
						 N.plazo,
						 N.fecha,
						 N.fecha_profesional,
						 N.fecha_notificacion,
						 N.fecha_devolucion,
						 N.oficina,
						 N.fecha_entrada
						
	              from  notas N 
				  where N.id_nota =".$busca;

				  $res=mysql_query($consulta);
				   $nota=mysql_fetch_array($res);
	?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head >
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title class="print2" >RDescripcion <?php echo $busca; ?></title>
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
			 
	     if(isset($nota['detalle_cedula']))
	       echo $nota['detalle_cedula'];
		
             
		 ?>  
 </div>			
	


</form>

</body>
</html>
