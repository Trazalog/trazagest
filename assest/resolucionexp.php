<?php


include("conexion.php");
$var = new conexion();
$var->conectarse();
$conec = $var->conectarse();

		
	
		if(isset($_GET["idexp"])) //nroexpe 
		{  
			
			$nro=$_GET["idexp"];
			
						
			//Buscar id estado Asignado
			/*$sql = "select id_estado from estados Where descripcion = 'Asignado' Limit 0,1";
			$resu = mysql_query($sql);
			$row = mysql_fetch_array($resu);
			$id_asignado = $row['id_estado'];*/
			
			$sql="select * from expedientes where id_expediente='$nro'"; //and  id_estado != ".$id_ingresado."
			$res=mysql_query($sql)or die(mysql_error());
			$expe=mysql_fetch_assoc($res);
			if(mysql_num_rows($res)>0)
			{									
					$consulta = "Select * From expedientespdf Where idExpediente=".$expe["id_expediente"];
					$ejecuta = mysql_query($consulta) or die(mysql_error());
					
					if(mysql_num_rows($ejecuta) > 0)
						{
							$habilitar = 0;
							
							//mostrar mensaje
							echo "<script>alert(\"el expediente ya tiene cargada resolucion.\");</script>";
						}
					else
						{
							
							
							$habilitar = 1;
							//mostrar mensaje
							echo "<script>alert(\"expediente valido\");</script>";
						}
			}
			else
			{
				$habilitar = 0;		
			}

		}
		
		
		if(isset($_POST["fecha1"])) 
			{
		
						$consulta = "Select Count(*) From expedientespdf Where idExpediente = ".$_POST["idexp"];
						$ejecuta = mysql_query($consulta) or die(mysql_error());
						
						$resu = mysql_fetch_array($ejecuta);
						
						$cantidad = $resu[0] + 1;
						  
						$_FILES["archivo"]["name"] = $_POST["idexp"]."_".$cantidad.".pdf";
						//$fet=invertirFecha($_POST["fecha1"]);
						$fet=$_POST['fecha1'];
						$uploadDir = 'expedientesPDF/';
						$uploadFile = $uploadDir . $_FILES["archivo"]["name"];
						move_uploaded_file($_FILES["archivo"]["tmp_name"], $uploadFile);
						$nro=$_POST['nro'];
						$PDF = "Insert into expedientespdf ( idExpediente, direccionDocumento, observacion, fecha,nro_resolucion ) values ";
						$PDF.= "(".$_POST["idexp"].", '".$_FILES["archivo"]["name"]."', '".$_POST["observaciones"]."', '".$fet."',$nro )";
						
						$query = mysql_query($PDF) or die(mysql_error());
						
						if($query == 1)
							{
								echo "<script>alert(\"Resolucion almacenada.\");</script>";
								//header('Location: principal.php');
								
	                          echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();;</script>";
		                      echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();;</script>";
		                      echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
							}
							else
							{
								echo "<script>alert(\"Se produjo un error al intentar almacenar la resolucion.\");</script>";
							}
						
		}			 
	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <meta charset="UTF-8">

    <title> </title>
	<link rel="stylesheet" href="css/bootstrap.css">
	 <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

   <!-- <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="assest/print.css" type="text/css" media="print">
   
    <link href="calendario_dw/calendario_dw-estilos.css" type="text/css" rel="STYLESHEET" >-->
	<link href="css/bootstrap.min.css/bootstrap/3.3.6" rel="stylesheet">
  <link href="css/estilos.css/bootstrap/3.3.6" rel="stylesheet">
  <link href="bootstrap.css/bootstrap/3.3.6" rel="stylesheet">
  
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <script src="jquery.js"></script>
   


   <!-- <script type="text/javascript" src="Js/ajax.js"></script>
    <script type="text/javascript" src="Js/Botones.js"></script>-->
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="jQuery/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="jQuery/jquery-ui-1.8.10.custom.min.js"></script>
    <script type="text/javascript" src="paginas/generarStock/js/funcion.js"></script>
    <link rel="stylesheet" type="text/css" href="jQuery/jquery.autocomplete.css" /></script>
    <script type="text/javascript" src="jQuery/jquery.js"></script>
    <script type="text/javascript" src="jQuery/jquery.autocomplete.js"></script>

  <!--  <script type="text/javascript" src="calendario_dw/calendario_dw.js"></script>-->
	<script language="javascript" src="reporteExpedientes_js.js" ></script>
    <script type="text/javascript">
	
          function validar()
             {      //alert('entra');
	                 if(document.getElementById('observaciones').value == "" &&
	 	             document.getElementById('archivo').value == "")
		               {
			              alert("Complete los campos de Observaci�n y/o Archivo PDF");
		                  }
		             else
		                 {
			               //grabar
			                  //document.getElementById('oper').value = "g";
			                  document.listado.submit();
		                 }

                }
				
       

		
			/*function traer_datosExp(exp){
				
				jQuery.post('ajax_get_datosexp.php',{exp:exp},function(datos){ 
					//alert(datos);
					var arre = new Array();
					arre = datos.split("**;");
					
					if( arre[4]=='A')
					{
						alert('El expediente ya se encuentra en estado Archivado');
						$('#expediente').val("");
					}
					else{
							$('#iniciador').val(arre[0]);
							$('#fecha').val(arre[1]);
							$('#observa').val(arre[2]);
							$('#idexp').val(arre[3]);
					}
				
				});
			}*/
					
					
		/*function llenartabla(cadena){
	
		var tablasize = $('#tabladatos tbody tr').length;;
		for(var i=0; i < (tablasize-1); i++){ // -1 para no borrar la cabecera
			$('#tabladatos tbody tr:last').remove();
		}
	
		var arre = new Array();
		arre = cadena.split(";");
		//console.log(arre);
		for(var i=0; i < (arre.length-1); i++)
		{ //console.log(arre[i]);
			var arre2 = new Array();
			arre2 = arre[i].split(",");
			
			var tr = "<tr> <td>"+arre2[0]+"</td>  <td>"+arre2[1]+"</td>  <td>"+arre2[2]+"</td> <td>"+arre2[3]+"</td> </tr>";
			
			jQuery('#tabladatos tbody tr:last').after(tr);
		}
		jQuery('#estado').val(arre[0]);
		
	
	}*/

/*function traer_datos(){
		var caja = jQuery('#cajas').val();
		
		jQuery.post('ajax_get_archivar.php',{idcajas:caja},llenartabla);
	}*/
	
	
	$(document).ready(function(){	
	
		//$.noConflict();
      });  

    </script>

    

    </head>

<body class="body">

<div class="container">
<div class="jumbotron">
<div class="row">
<div class="col-sm-12 col-md-12">
<div class="thumbnail">
<div class="caption">
<!--<div class="container  succes" style="height:650px;"> -->
<form name="listado" method="post" id="listado" action="#"class="form-horizontal"  role="form" >

                    <br>
					<div class="form-group">
					<h2 class="text-center">Resolucion de Expediente</h2>
					</div>
					
	
	<fieldset>
	<fieldset>
	<legend> </legend>
    <fieldset>
	</fieldset>
	</fieldset>
	</fieldset>
	
	<div class="row">
    <div class="col-sm-12 col-md-12">
    <div class="thumbnail">
	<div class="caption">  
	<fieldset>
	<fieldset>
	<legend><h5>Datos de Expediente</h5></legend> 
    <fieldset>
	
	<div class="form-group">
    <label class="control-label col-xs-1">Nro</label> 
	<div class="col-xs-1">  

     <?php if(isset($expe)) echo"  ".$expe['nro_expediente'];?>
		
		    <input name="expediente" type="hidden" id="expediente" value='<?php if(isset($expe)) echo"  ".$expe['nro_expediente'];?>' size="20"/>
			<input name="idexp" type="hidden" name="idexp" value='<?php if(isset($expe)) echo" ".$expe['id_expediente'];?>' size="20"/>  
      </div>
	  </div>
	  
	
	
	 <div class="form-group">
    <label class="control-label col-xs-1">Caratula</label> 
	<div class="col-xs-1"> 
	</div>
	</div>
	<div class="form-group">
    <label class="control-label col-xs-1"></label> 
	<div class="col-xs-1"> 
  
		   <textarea name="observa" rows="8" cols="50" width="100%"  maxlegth="100" id="observa"  size="80" style="BORDER-RIGHT: #dfdfdf 2px solid; BORDER-TOP: #dfdfdf 2px solid; BORDER-LEFT: #dfdfdf 2px solid; BORDER-BOTTOM: #dfdfdf 2px solid; color: #006699; background-color:#F5F5F5"><?php if(isset($expe)) echo"  ".$expe['caratula'];?></textarea>
      </div>
	  </div>
  
	<div class="col-xs-6" >
     <h5>Iniciador</h5> 
        <p><?php if(isset($expe)){
										$sqll = "Select Nombre, Apellido from iniciador Where dni=' ".$expe['id_iniciador']."'";
										$resuu = mysql_query($sqll)or(die(mysql_error()));
										$roww = mysql_fetch_array($resuu); 
										echo $roww['Nombre']." ".$roww['Apellido'];
																	}
																	?></p>
		   <input name="iniciador" type="hidden" id="iniciador" value='<?php if(isset($expe)){
										$sqll = "Select Nombre, Apellido from iniciador Where dni=' ".$expe['id_iniciador']."'";
										$resuu = mysql_query($sqll)or(die(mysql_error()));
										$roww = mysql_fetch_array($resuu); 
										echo $roww['Nombre']." ".$roww['Apellido'];
																	}
																	?>' size="20"/>  
      </div>
	  
   <div class="col-xs-8">
        <h5>Fecha Entrada</h5> 
        <?php if(isset($expe)) echo"  ".invertirFecha($expe['fecha_entrada']);?>
		<input  name="fechaen" type="hidden"  class="select"/>
      </div>
	
	 <div class="col-xs-8" >
        <h5>Fecha</h5> 
        <?php if(isset($expe)) echo"  ".invertirFecha($expe['fecha']);?>
		     <input name="fecha"  type="hidden" class="select"/>
      </div>

      <div class="col-xs-8" >
        <h5>Numero Folio </h5> 
        <?php if(isset($expe)) echo"  ".$expe['n_folio'];?>
		     <input  type="hidden" name="folio" id="folio" value='<?php if(isset($expe)) echo"  ".$expe['n_folio'];?>' size="20"/>
      </div>
	
	
	
	</fieldset>
	</fieldset>
	</fieldset>
	</div>
	</div>
	</div>
	</div>
	
	
	<div class="row">
	<div class="col-sm-12 col-md-12">
	<div class="thumbnail">
	<div class="caption"> 
	<fieldset>
	<fieldset>
	<legend> </legend>
    <fieldset>
	</fieldset>
	</fieldset>
	</fieldset> 

	
<fieldset>		
<fieldset>
<legend><h5>Detalle de Resolucion</h5></legend>    
<fieldset>

 <div class="form-group">
 <label class="control-label col-xs-1">Observacion  </label> 
 <div class="col-xs-1">
 </div>
 </div>
 
 <div class="form-group">
 <label class="control-label col-xs-1"></label> 
 <div class="col-xs-1">
 
 <textarea name="observaciones" id="observaciones"  rows="8" cols="60" placeholder="Cargue una observacion." style="BORDER-RIGHT: #dfdfdf 2px solid; BORDER-TOP: #dfdfdf 2px solid; BORDER-LEFT: #dfdfdf 2px solid; BORDER-BOTTOM: #dfdfdf 2px solid; color: #006699; background-color:#F5F5F5"></textarea>
 </div>
 </div>
 
 <div class="col-xs-6" >
        <h5>Nro </h5> 
        <p></p>
		  <input type="text"  name="nro" class="select" onKeyUp="numerico(copias)" id="nro" size="20"/>
  </div>
  
  <div class="col-xs-6" >
        <h5>Fecha </h5> 
        <p></p>
		  <input type="date" name="fecha1" class="select" />
  </div>

  <div class="col-xs-6" >
        <h5>Archivo PDF</h5> 
        <p></p>
		   <input type="file" size="40" name="archivo" id="archivo" placeholder="Ubicacion archivo PDF" >
  </div>

 

 
<!-- <div class="form-group">
 <label class="control-label col-xs-3">Archivo PDF </label> 
 <div class="col-xs-3">
 <input type="file" size="40" name="archivo" id="archivo" placeholder="Ubicacion archivo PDF" >
 </div>
 </div>-->
 
 </fieldset>
 </fieldset>
 </fieldset>
 </div>
 </div>
 </div>
 </div>
 
    <fieldset>
	<fieldset>
	<legend> </legend>
    <fieldset>
	<center>
    <input type="button" name="princ" id="princ" value="Principal"  onclick=" document.listado.action='principal.php'; document.listado.submit();"class="btn btn-primary" />
    &nbsp;&nbsp;&nbsp;
	<input type="button" name="rechazar" id="rechazar" value="Guardar"  onclick="validar();" class="btn btn-primary"/>
    </center>
	</fieldset>
	</fieldset>
	</fieldset> 
			
    </form>
	
</div> <!--fin container-->
</div>
</div>
</div>
</div>
</div>
</body>
</html>


	
<?php
/*function invertirFecha($date)
    {
        $arre = explode('-',$date);
        
        return $arre[2].'-'.$arre[1].'-'.$arre[0];
    }*/
function invertirfecha($f)	
	{
	
$datos = explode("-",$f);
$fecha[]= $datos[0];
$fecha[] = $datos[1];
$fecha[] = $datos[2];
$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];

return  $total;

}
?>
<script>

function Arriba()
	{
		document.getElementById('cksolu').value = 'S';
		Ocultar();
	}
	
function Medio()
	{
		document.getElementById('cksolu').value = 'U';
		Ocultar();
	}

function Abajo()
	{
		document.getElementById('cksolu').value = 'R';
		Ocultar();
	}
	
function Ocultar()
	{		
		if(document.getElementById('cksolu').value == 'R')
		{
			//habilitar combo
			document.getElementById('tpo_recha').disabled = false;
		}
		else
		{
			//deshabilitar combo
			document.getElementById('tpo_recha').disabled = true;
		}
	}
	
	
function validaAsignacion()
	{	
		
		document.listado.submit();
      
	 
	} 
	
</script>
