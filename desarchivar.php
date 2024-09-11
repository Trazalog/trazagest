<?php //session_start();

//var_dump($_SESSION);

include("conexion.php");
$var = new conexion();
$var->conectarse();
$conec = $var->conectarse();




	if(isset($_GET["nroexpe"])) //antes estaba por numero de expediente nroexpe
	{
		$id=$_GET["nroexpe"];
			
				
				
				$sql=" SELECT 
				O.id_expediente,
				O.nro_expediente,
				O.caratula, 
				O.fecha,
				O.id_iniciador,
				C.nombre,
				S.descrip,
				S.fila,
				E.descripcion,
				A.estado
				  
				     FROM expedientes O
					join iniciador C join ccajas A join cajas S join estanteria E on C.dni=O.id_iniciador and A.id_expediente=O.id_expediente and A.id_cajas=S.id_cajas and E.id_estanteria=S.id_estanteria
					Where O.nro_expediente = $id and A.estado='A'"; 
		
				$res=mysql_query($sql)or die($sql);
				$req=mysql_fetch_array($res);
				
				}
				else //fue desarchivado
				{
				 if(isset($_GET["idexp"])) 
				 {
				$id=$_GET["nroexpe"];
				 $sql=" SELECT 
				O.id_expediente,
				O.nro_expediente,
				O.caratula, 
				O.fecha,
				O.id_iniciador,
				C.nombre,
				S.descrip,
				S.fila,
				E.descripcion,
				A.estado
				  
				     FROM expedientes O
					join iniciador C join ccajas A join cajas S join estanteria E on C.dni=O.id_iniciador and A.id_expediente=O.id_expediente and A.id_cajas=S.id_cajas and E.id_estanteria=S.id_estanteria
					Where O.nro_expediente = $id and A.estado='D'"; 
				$result2=mysql_query($sql,$var->links);
	  				while($row2=mysql_fetch_array($result2))
	   					{
				 	
				
				 echo "Expediente se encuentra en estado desarchivado"; // o muestra este cartel osea si un expediente se encuentra
				                                                         //  en estado archivado no trae nada 
				}
				
				}
				
	}
	/*if(mysql_num_rows($req) >0)
		{	
			 if($req[9]=='A')
            {
    		$habilitar = true;
            }
            else
            {
             $habilitar = false;   
            }	 			 
		}else
			{
				echo '<script>alert("Número de Expediente no válido.");</script>';
				$habilitar = false;
			}*/
	
		
					
			
				
				
				
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

  <link href="css/bootstrap.min.css/bootstrap/3.3.6" rel="stylesheet">
  <link href="css/estilos.css/bootstrap/3.3.6" rel="stylesheet">
  <link href="bootstrap.css/bootstrap/3.3.6" rel="stylesheet">
  
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <script src="jquery.js"></script>
  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
  <!--  <link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="assest/print.css" type="text/css" media="print">
   
    <link href="calendario_dw/calendario_dw-estilos.css" type="text/css" rel="STYLESHEET" >-->
   

  

    <script type="text/javascript" src="Js/ajax.js"></script>
   <!-- <script type="text/javascript" src="Js/Botones.js"></script>-->
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="jQuery/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="jQuery/jquery-ui-1.8.10.custom.min.js"></script>
    <script type="text/javascript" src="paginas/generarStock/js/funcion.js"></script>
    <link rel="stylesheet" type="text/css" href="jQuery/jquery.autocomplete.css" /></script>
    <script type="text/javascript" src="jQuery/jquery.js"></script>
    <script type="text/javascript" src="jQuery/jquery.autocomplete.js"></script>

   <!-- <script type="text/javascript" src="calendario_dw/calendario_dw.js"></script>-->
    <SCRIPT TYPE="text/javascript">
		
		
			function traer_datosExp(exp){
				
				jQuery.post('ajax_get_datosdesar.php',{exp:exp},function(datos){ 
					alert(datos);
					var arre = new Array();
					arre = datos.split("**;");
					
					if( arre[7]=='D')
					{
						alert('El expediente ya se encuentra en estado Desarchivado');
						$('#expediente').val("");
					}
					else{
							$('#iniciador').val(arre[0]);
							$('#fecha').val(arre[1]);
							$('#observa').val(arre[2]);
							$('#idexp').val(arre[3]);
							$('#caja').val(arre[4]);
							$('#fila').val(arre[5]);
							$('#estanteria').val(arre[6]);
							
					}
				
				});
			}
					
					
		function llenartabla(cadena){
	
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
		
	
	}

/*function traer_datos(){
		var caja = jQuery('#cajas').val();
		
		jQuery.post('ajax_get_archivar.php',{idcajas:caja},llenartabla);
	}*/
	
	
	$(document).ready(function(){	
	
		$.noConflict();

		$('#expediente').keypress(function(e) {
				//e.preventDefault();
				
			    if(e.which == 13) {
			       var newn = $('#expediente').val();
			       if(newn != '')
			       	{	alert(newn);				       		 				       			
			       		  traer_datosExp(newn);				  
			       	}
			       	else alert('ingrese expediente');
			    }
			});
	

		
		/*$('#expediente').blur(function() {
						    
			       var newn = $('#expediente').val();
			       if(newn != '')
			       	{	alert(newn);				       		 				       			
			       		  traer_datosExp(newn);				  
			       	}
			       	else alert('ingrese expediente');
			});*/
	
	});
        

</script>
</head>

<body >
    <div class="container">
    <div class="jumbotron">
    <div class="row">
    <div class="col-sm-12 col-md-12">
    <div class="thumbnail">
	<div class="caption">	
    <form name="listado" method="post" id="listado" action="alta_desarchivar.php" class="form-horizontal" role="form">
					<br>
					<div class="form-group">
     				<h3 class="text-center"> Desarchivar Expediente
					</h3>
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
	<legend ><h5>Datos del Expediente</h5>
    </legend>
	<fieldset>
	<table width="100%" align="center">
    <tbody>
	<tr>
	<td>
    <div class="form-group">
    <label class="control-label col-xs-2"> Nro</label> 
	<div class="col-xs-9">
    <input name="expediente" type="text" id="expediente" value='<?php if(isset($req)) echo"  ".$req[1];?>' size="20"/> 
	<input name="idexp" type="hidden" id="idexp" value='<?php if(isset($req)) echo"  ".$req[0];?>' size="20"/> 
    </div>
	</div>
	</td>
			   
	<td>
	<div class="form-group">
	<label class="control-label col-xs-3"> Caratula </label>
	<div class="col-xs-9">
	<textarea name="observa" cols="60" rows="4" c id="observa" value='<?php if(isset($req)) echo"  ".$req[2];?>' style="BORDER-RIGHT: #dfdfdf 2px solid; BORDER-TOP: #dfdfdf 2px solid; BORDER-LEFT: 
                    #dfdfdf 2px solid; BORDER-BOTTOM: #dfdfdf 2px solid; color: #006699; background-color:#F5F5F5"><?php if(isset($req)) echo $req['caratula'];?></textarea>
	</div>
	</div>
	</td>
	</tr>
			  
	<tr>
	<td>
	<div class="form-group">
	<label class="control-label col-xs-2">Caja </label>
	<div class="col-xs-9">
	<input type="text" name="caja" id="caja" value='<?php if(isset($req)) echo"  ".$req[6];?>' size="20"/>
    </div>
	</div>
	</td>
				
	<td>
	<div class="form-group">
	<label class="control-label col-xs-3">Iniciador </label> 
	<div class="col-xs-9">                 
    <input name="iniciador" type="text" id="iniciador" value='<?php if(isset($req)) echo"  ".$req[5];?>' size="20"/> 
    </div>
	</div>
	</td>
			   
	<td>
	<div class="form-group">
	<label class="control-label col-xs-3"> Fecha </label> 
	<div class="col-xs-9">                 
	<input type="text" name="fecha" id="fecha" value='<?php if(isset($req)) echo"  ".$req[3];?>' class="campofecha" readonly="readonly" onclick="AbrirCalendario()">
     </div>
	 </div>
	 </td>
	 </tr>
				
	 <tr>
	 <td>
	 <div class="form-group">
	 <label class="control-label col-xs-2">Fila </label>
	 <div class="col-xs-9">	
	 <input type="text" name="fila" id="fila" value='<?php if(isset($req)) echo"  ".$req[7];?>' size="20"/>
     </div>
	 </div>
	 </td>
				 
	 <td>
	 <div class="form-group">
	 <label class="control-label col-xs-3">Estanteria </label>
	 <div class="col-xs-9"> 
	 <input type="text" name="estanteria" id="estaneria" value='<?php if(isset($req)) echo"  ".$req[8];?>' size="20"/>
     </div>
	 </div>
	 </td>
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
    
	<div class="row">
    <div class="col-sm-12 col-md-12">
    <div class="thumbnail">
	<div class="caption"> 
	<fieldset>
    <fieldset>
	<legend> </legend>
    <fieldset>
	
    <div class="form-group">
    <label class="control-label col-xs-1">Fecha </label>
	<div class="col-xs-9"> 
	<input type="date" name="fecha1" class="select" />
    </div>
	</div>

   </fieldset>
   </fieldset>
   </fieldset>
   </div>
   </div>
   </div>
   </div>
   
    <fieldset>
	<fieldset>
	<legend></legend>
    <fieldset>   
    <center>
                <input type="button" value="Desarchivar" class="btn btn-primary" onclick="validaAsignacion()" >
                &nbsp;&nbsp;&nbsp;
				<input type="button" value="Principal"class="btn btn-primary"  onclick="principal()">
    </center>
	</fieldset>
	</fieldset>
	</fieldset>
    </form>
	
</div>
</div>
</div>
</div>
</div>
</div> <!--fin container-->
</body>
</html>
	
<script>

function principal()
	{
		location.href="./principal.php";
	}

	
function validaAsignacion()
	{
	/*if(document.altaped.fecha1.value ==0)
	 	{
			alert("no seleccino  Fecha");
			document.altaped.fecha1.focus();
			return false;
		 
		}
	if(document.altaped.txtHora.value ==0)
	 	{
			alert("no seleccino  Hora");
			
			return false;
		 
		}	*/	
		
		document.listado.submit();
      
	 
	} 
	
</script>