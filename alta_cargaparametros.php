
<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>TrazaJobs</title>

<link rel="shortcut icon" type="image/x-icon" href="imag/tm.ico" />
<link rel="stylesheet" href="assest/estilos.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/estilo.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<link type="text/css" rel="stylesheet" href="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"/>

<link href="assest/estilo.css" rel="stylesheet"  type="text/css" media="screen, projection"> 


<script type="text/javascript" src="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<script   type="text/javascript" src="assest/Js/Botones.js"></script>

<SCRIPT type="text/javascript" src="assets/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script><link type="text/css" rel="stylesheet" href="assets/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>

<script language="javascript" src="reporteExpedientes_js.js" ></script>
<script type="text/javascript" src="ajax_post.js"></script><!-- metodo ajax -->

<script type="text/javascript" src="jQuery/jQuery.js"></script>
<script type="text/javascript" src="jQuery/jquery-1.6.1.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>

		

		

</script>
<script language="javascript">
 function recha()
 {
	 if(document.getElementById('observaciones').value == "" &&
	 	document.getElementById('archivo').value == "")
		{
			alert("Complete los campos de Observación y/o Archivo PDF");
		}
		else
		{
			//grabar
			document.getElementById('oper').value = "g";
			document.form2.submit();
		}

 }
function busqueda(valor)
	{
	 document.form2.action = "resolucionPDF.php?nroExp="+valor;
	 document.form2.submit();
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
	
	function traer_datos(){
		var lote = jQuery('#lotes').val();
		
		jQuery.post('ajax_get_cparametros.php',{idlote:lote},llenartabla);
	}
	
	$(document).ready(function(){	
		
		$('#addparametro').click(function(event){ 
			event.preventDefault();
			$('[name="agregarparametro"]').css("display",'block');
			$('[name="agregarparametro"]').focus();
		 });

		$('[name="agregarparametro"]').keypress(function(e) {
				
			    if(e.which == 13) {
			       var newn = $('[name="agregarparametro"]').val();
			       if(newn != '')
			       	{	alert(newn);				       		 				       			
			       		  add_parametro(newn);
			       		  $('[name="agregarparametro"]').css("display",'none');
			       		  $('[name="agregarparametro"]').val('');
					  e.preventDefault();
			       	}
			       	else alert('ingrese parametro');
			    }
			});
	
	});
/*function add_parametro(newn){
	var parametros = jQuery('#parametros').val();
		
		//jQuery.post('ajax_add_parametros.php',{idparametros:parametros},llenartabla);
	}*/
	function add_parametro(newn){
		//var parametros = jQuery('#parametros').val();
		
		jQuery.post('ajax_add_parametros.php',{parametro:newn},function(cadena){alert(cadena);
		
		var idnuevo=parseInt(cadena);
		if(idnuevo >0)
		$('#parametros').append("<option value='"+idnuevo+"' selected='selected'>"+newn+"</option>");
		else 
		     alert(cadena);
		} );
	}
	
</script>

<style type="text/css">
<!--
.Estilo1 {font-size: 18px}
-->
</style>

<form  name="ot" action="parametros_php.php" method="post" onSubmit="">

<div id="contenedorcp">
  <table id="tablacargaP"  width="714" class="borde_tabla" style="text-align:center">
    <tr>
      <td colspan="5" align="center" height="10" class="tituloformulario" style="text-align:center"><span class="Estilo4 Estilo1"> Cargar Parametros</span></td>
    </tr>
    <tr>
      <td width="150"  height="26" align="right"><div id="lo">
          <label> <span>Lotes en Curso</span></label>
          <h3></h3>
        <p></p>
        <select name="lotes"  id="lotes"   onchange='traer_datos()' size='10' style='color:E0E0E0 ;background-color:#E0E0E0' >
            <?php
							$consulta2="SELECT * FROM lotes WHERE estado='A'";
							$result2=mysql_query($consulta2,$var->links);
							while($row2=mysql_fetch_array($result2))
								{
									 echo "<option value='".$row2['id_lote']."'>".$row2['lote']."</option>";
								 
								}
							
						?>
          </select>
          <span class="Estilo1">* </span> </div></td>
		  
      <td width="300" height="26" align="center">
	  <div id="datos" style="width: 350px; margin: 0auto;" align="center">
          <table width="100%">
            <?php if( isset($_GET['alta']))
					if( $_GET['alta'] == 1)
					   echo "<tr><td><label style='color:ccc;background-color:#ccc' > guardado </label>  </td></tr>";
			   ?>
            <tr>
              <td height="50" valign="middle"><label for='resul'><span class="Estilo8">Resultado:</span> </label>
                  <input type="text" name="resul"  class="" /></td>
            </tr>
            <tr>
              <td height="50" valign="middle"><label for='fecha'><span class="Estilo8">Fecha:</span></label>
                  <input type="date" name="fecha"  class="select" />
              </td>
            </tr>
            <tr>
              <td height="50" valign="middle"><label for='hora'><span class="Estilo8">Hora:</span> </label>
                  <input name="hora" type="time" class="select" id="hora"  size="10" maxlength="10"  /></td>
            </tr>
            <tr>
              <td height="50" valign="middle"><div style="width: 300px; margin: 0 auto;"align="center" >
                  <input name="submit" type="submit" class="button" value="Guardar" />
              </div></td>
            </tr>
          </table>
		  
        <div  id='tabladatos' align="center">
            <table id='tabladatos' align="center" width="350" height="250">
              <tbody>
                <tr>
                  <th>Lote</th>
                  <th>Resultado</th>
                  <th>Valor</th>
                  <th>Fecha</th>
                </tr>
              </tbody>
            </table >
        </div>
		
      </div>
	  </td>
	  
      <td width="150" height="26" align="left" ><!--<label> con esto lo separo un poco del borde >-->
          <div id="pa">
            <label> Parametros</label>
            <h3></h3>
            <p></p>
            <select name="parametros"  id="parametros" size='10' style='color:E0E0E0 ;background-color:#E0E0E0'>
              <?php
						$consulta2="SELECT * FROM parametros ";
						$result2=mysql_query($consulta2,$var->links);
						while($row2=mysql_fetch_array($result2))
							{
								 echo "<option value='".$row2['id_parametros']."'>".$row2['descripcion']."</option>";
							 
							}
						
					?>
            </select>
            <span class="Estilo1">* </span>
            <button id='addparametro' > <img  src="imag/add.png" width="20" height="20" /> </button>
            <input type="text" name="agregarparametro"  style='display:none '/>
        </div></td>
    </tr>
	


    <div style="width:330px; margin:0 auto;" align="center">
      <table style="display:inline" align="center">
        <tr>
          <td height="40" align="center"><input name="button"  type="button" class="button" onclick="liberarlote()" value="Liberar Lote " />
              <input name="button"  type="button" class="button" onclick="principal()" value="volver" /></td>
        </tr>
      </table>
	  <span class="sub_titulo">*</span> <span class="comentario">datos obligatorios</span>
	  </div>
	  
	  
  </table>
</div>
  
</form>
 
 </body>
</html>

<script>

function principal()
	{
		location.href="./principal.php";
	}
function liberarlote(expe)
    {
		var opciones = "toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,resizable=yes,width=350,height=400" ;

      window.open("liberar_lote.php","nombreventa na", opciones);
    
    }
</script>
	
