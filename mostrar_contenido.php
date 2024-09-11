<?php

include ("conexion.php");
$var=new conexion();
$var->conectarse();


//$caja=$_GET['cajas'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <meta charset="UTF-8">
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />-->

<title></title>
   <link rel="stylesheet" href="css/bootstrap.css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

<!--<link rel="shortcut icon" type="image/x-icon" href="imag/tm.ico" />
<link rel="stylesheet" href="assest/estilos.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/estilo.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<link type="text/css" rel="stylesheet" href="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"/>-->

<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
 <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
 <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <script type="text/javascript" src="js/bootstrap.min.js"></script>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <!-- Bootstrap -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/estilos.css" rel="stylesheet">
  <link href="bootstrap.css" rel="stylesheet">
  <script src="jquery.js"></script>
<script src="bootstrap-modal.js"></script>


  
 
 
 


<!--<script type="text/javascript" src="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<script   type="text/javascript" src="assest/Js/Botones.js"></script>

<SCRIPT type="text/javascript" src="assets/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script><link type="text/css" rel="stylesheet" href="assets/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>

<script language="javascript" src="reporteExpedientes_js.js" ></script>
<script type="text/javascript" src="ajax_post.js"></script><!-- metodo ajax -->

<!--<script type="text/javascript" src="jQuery/jQuery.js"></script>
<script type="text/javascript" src="jQuery/jquery-1.6.1.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>-->

		

		

</script>


<script language="javascript">

	function llenartabla2(cadena){ console.log(cadena);
	
	
		var arre = new Array();
		arre = cadena.split(";;");
		
		console.log(arre.length);
		
		jQuery('#tabladatos2 tbody tr').remove();
		
		for(var i=0; i < (arre.length-1); i++)
		{  
			var arre2 = new Array();
			arre2 = arre[i].split(",,");
			console.log('entra');
			
			var tr = "<tr> <td>"+arre2[0]+"</td>  <td>"+arre2[1]+"</td> </tr>";
			
			$('#tabladatos2').append(tr);
		}
		
	
	}
	
	function traer_datos2(){ //alert('cambia');
	        
			function getUrlVars() 
        {
            var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(m,key,value) {
            vars[key] = value;
            });
            return vars;
        }
    //esta funcion es fija,. no se toca ni modifica nada
    
    
    var modulo = getUrlVars()["idcaja"];  //acá obtengo la variable que anvie por get por ejemplo http//localhost/sistema/archivo.php?modulo=Ventas
    
   // alert(modulo); //muestra: 'Ventas' para ver si recie correctamente
	
		<!--var caja= jQuery('#cajas').val();-->
		
		jQuery.post('ajax_get_arch.php',{idcajas:modulo},llenartabla2);
	}
	</script>
	</head>
 <body onload='traer_datos2()'>
    <div class="container">
    <div class="jumbotron">
    <div class="row">
    <div class="col-sm-12 col-md-12">
    <div class="thumbnail">
	<div class="caption">	
	<form name="listado2" method="post" id="listado2" action=""  >
	 	<div class="form-group">
		<h3 class="text-center">Contenido de Caja </h3>
		</div>
		
	<div class="row">
    <div class="col-sm-12 col-md-12">
    <div class="thumbnail">
	<div class="caption">  	
	<fieldset>
	<fieldset>
	<legend></legend>
    <fieldset>
	<table align="center" id='tabladatos2' name='tabladatos2' class="table table-active">
			<tbody>
			 <tr class="active">
				  <!-- <td> Expediente: </td> <td> Caratula: </td>-->
				 <th> Expediente:</th>
                  <th> Caratula:</th>
                  
				 </tr> 
			</tbody>
	</table>
	</fieldset>
	</fieldset>
	</fieldset>
	</div>
	</div>
	</div>
	</div>

  </form>
    </div>
	</div>
	</div>
	</div>
	</div>
	</div>
	
  </body>
    
 </html>
 