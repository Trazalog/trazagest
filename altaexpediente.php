<?php
 include("conexion.php");
	$link= new conexion();
    $link->conectarse();
		
	$dni=$_GET['iniciador'];

     $res=mysql_query("SELECT * FROM iniciador where dni ='".$dni."'")or die(mysql_error());
	 $fila=mysql_fetch_array($res);
	 
	
	 //letra para el expediente
	 $let=substr($fila['Apellido'],0,1);
	 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>trazagest</title>
	    <!-- <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">-->
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script   type="text/javascript" src="abm_iniciador_js.js"></script>
	<script   type="text/javascript" src="validacionesDeEntrada.js"></script>
</head>
 


<body class="body" onLoad="<?php echo isset($_GET["habilitar"]) ? "habilitarBoton()":"";?>" >

<link rel="stylesheet" type="text/css" media="all" />

<div class="container">
 <div class="jumbotron">
 	<div class="row">
 		<div class="col-sm-12 col-md-12">
 			<div class="thumbnail">
 				<div class="caption">

					<form name="formexp" id="formexp" method="Post" action="abm_expediente_libreria.php" onSubmit="return guardaExpediente(formexp);">
							<input type="hidden" name="ope" value="Ie"/>
							<input type="hidden" name="iniciador" value="<?php echo $dni;?>">
							
							  <!--DWLayoutTable-->
							<fieldset>
				  			<fieldset>
							<legend><h5>Nuevo Expediente</h5></legend>
							
									<table width="100%" align="left">
									    
									    <tr>
									        <td>Numero de Expediente:
									        
				    							
									          <input type="text" name="tnroexp" onKeyUp="numerico(tnroexp)" value="<?php echo isset($_GET["nroExp"]) ? $_GET["nroExp"]:"" ; ?>" title="Número que identificara a el expediente" />
										  	  <input type="button"  name="AS" onClick="ValidarNumero(tnroexp.value)"  class="btn btn-primary" value="Buscar">
	    								  		<input type="button" name="es" onClick="Otro(<?php echo $dni;?>)"  class="btn btn-primary" value="Nuevo" >
										    </td>
									    	<td> Iniciador:
										      <input type="text"  value="<?php echo obtenerDato($fila['dni'],'iniciador', 'dni', 'Nombre~Apellido') ;?>"/>   
										      
										      <input type="hidden" name="tnroini" size="20"  maxlength="10" value="<?php echo($fila['dni']);?>" readonly="readonly" title="Identificador del iniciador del expediente" />
										    </td>
									    </tr>
									</table>

								<legend></legend>

								<table width="100%" align="left">

								<?php
								if(isset($_GET["habilitar"]))
									{
								?>
								 <tr>
								    <td>Nro Folio:
								      <input type="text" name="nrofolio"  onKeyUp="numerico(nrofolio)"/></td>
								    <td>Fecha:    
								    	<input type="date" name="tfecha"  value='<?php echo date("Y-m-d"); ?>' class="select"/>
									</td>
								    <td>Fecha Entrada:&nbsp;
								      <input type="date" name="tfechain"  value='<?php echo date("Y-m-d"); ?>' class="select"/>	
									 </td>
								  </tr>

								  </table>
								  <legend></legend>
								  <TABLE>


								  <tr>
								    <td>
								    	<div class="form-group">
    										<label class="control-label col-xs-1">Datos:</label> 
											<div class="col-xs-1">
											<textarea name="cart_exp" rows="6" cols="90" width="100%"  maxlegth="100" size="80"  style="BORDER-RIGHT: #dfdfdf 2px solid; BORDER-TOP: #dfdfdf 2px solid; BORDER-LEFT: #dfdfdf 2px solid; BORDER-BOTTOM: #dfdfdf 2px solid; color: #006699; background-color:#F5F5F5" title="Describir el contenido del expediente">
											</textarea> 
										</td>
								    </tr>
								  <tr>
								      <td>
								      	<div class="form-group">
    										<label class="control-label col-xs-1">Extracto:</label> 
											<div class="col-xs-6">
								        		<textarea name="testract" rows="6" cols="90" width="100%"  maxlegth="100" size="80"  style="BORDER-RIGHT: #dfdfdf 2px solid; BORDER-TOP: #dfdfdf 2px solid; BORDER-LEFT: #dfdfdf 2px solid; BORDER-BOTTOM: #dfdfdf 2px solid; color: #006699; background-color:#F5F5F5" title="Informacin adicional"></textarea>
								        	</div>
								        </div>		  
								      </td>
								    </tr>


								  <input type="hidden" name="dtll_exp" value="-" /> 
								  	<tr>
								        <td> 
									        <div class="form-group">
	    										<label class="control-label col-xs-1">Letra</label> 
												  <div class="col-xs-1">
												      <?php echo"<input type=\"text\" name=\"lt_exp\"  size=\"1\" value=\"  ".$let." \"  readonly=\"readonly\" /> ";	?>
												  </div>
											
	    										<label class="control-label col-xs-1">Tipo</label> 
												  <div class="col-xs-2">
											            <select onChange="recargarS2(this.value)"  name="tpo_exp" title="Tipo de expediente" >
											              <?php $cons = "SELECT *FROM  tipo_expedientes ";
															$result = mysql_query($cons) or die("falla la consulta");
															
															while($option = mysql_fetch_row($result))
															{
															 echo" <option value=\" ". $option[0]."\" >".$option[1 ]." </option>"; 
															} 
															?>
														 </select>
													</div>
											
										
											
	    										<label class="control-label col-xs-1">Amparo </label> 
												  	<div class="col-xs-1">			  
								            
								            			<select id="s2" name="s2" title="Expediente Amparo"></select>	
								            		</div>
								            			
												<label class="control-label col-xs-1">estado</label> 
												  	<div class="col-xs-1">	   
									        			<input name="std_exp"  value="Ingresado" readonly="true" title="Estado en que se guardara el expediente">
									        		</div>
									        </div>			
										</td>
								  	</tr>
								  	<tr>
										<td>
											<div class="form-group">
	    										<label class="control-label col-xs-1">Datos:</label> 
												<div class="col-xs-2">

											     	 <textarea name="dt_exp" rows="6" cols="90" width="100%"  maxlegth="100" size="80"  style="BORDER-RIGHT: #dfdfdf 2px solid; BORDER-TOP: #dfdfdf 2px solid; BORDER-LEFT: #dfdfdf 2px solid; BORDER-BOTTOM: #dfdfdf 2px solid; color: #006699; background-color:#F5F5F5"  title="Informacin adicional"></textarea>
											     </div>	 
										    </div>
										 </td>
								  	</tr>
								  	<tr>
									    <td>
									    	<div class="form-group">
	    										<label class="control-label col-xs-1">observacion:</label> 
												<div class="col-xs-2">  
												  <textarea  name="obs_exp" rows="6" cols="90" width="100%"  maxlegth="100" size="80"  style="BORDER-RIGHT: #dfdfdf 2px solid; BORDER-TOP: #dfdfdf 2px solid; BORDER-LEFT: #dfdfdf 2px solid; BORDER-BOTTOM: #dfdfdf 2px solid; color: #006699; background-color:#F5F5F5"  title="Informacin adicional">
												  	</textarea>
												</div>
											</div>	  
										</td>
								 	</tr>
								  	<tr >
								<?php
									}
								?>
									    <td height="32" colspan="3" align="center" valign="middle" class="fondo3"  >                                                              
									      	<input type="button" name="salir" value="<<Principal"  onclick="formexp.action='principal.php';formexp.submit();" class="btn btn-primary"/>
									    	<input type="submit" name="nuevoexp" disabled="disabled"  value="Guardar"  class="btn btn-primary" id="uno" />
									    </td>  

								    </tr>
								</table>
						</form>
				</div>
			</div>
		</div>
		</div>
	</div>
</div>

</body>
</html>



<script>
function recargarS2(val,val1){
 
   //esperando la carga...
   $('#s2').html('<option value="">Cargando...aguarde</option>');
   //realizo la call via jquery ajax
   $.ajax({
		url: './procesar.php',
		data: 'id='+val+'&id1='+formexp.tnroini.value,
		success: function(resp){
		 $('#s2').html(resp)
		 }
	});
}



function guardaExpediente(formulario)
	{
	  
	  if(!tamano(formulario.tnroini,2)==true)
	  	{alert("Tiene que existir un iniciador.");location.href="index.php";return false;}
	  if(!tamano(formulario.tnroexp, 1)==true)
	  {mensaje("longitud_invalida","Nmero de expediente");return false;}
	  if(!tamano(formulario.nrofolio, 1)==true)
	  {mensaje("longitud_invalida","Nmero de folio");return false;}
	  /*if(!tamao(formulario.tfecha, 1)==true)
	  {mensaje("longitud_invalida","Fecha");return false;}
	  if(!tamao(formulario.tfechain, 1)==true)
	  {mensaje("longitud_invalida","Fecha entrada");return false;}*/
	  if(!tamano(formulario.cart_exp, 1)==true)
	  {mensaje("longitud_invalida","Contenido");return false;}
	  if(!tamano(formulario.testract, 1)==true)
	  {mensaje("longitud_invalida","Extracto");return false;}
	  //if(!tamaño(formulario.dtll_exp, 1)==true)
	  //{mensaje("longitud_invalida","Detalle");return false;}
	  //if(!tamao(formulario.tpo_exp, 1)==true)
	  //{mensaje("longitud_invalida","Tipo de Expediente");return false;}
	  if(!tamano(formulario.std_exp, 1)==true)
	  {mensaje("longitud_invalida","Estado");return false;}
	  // if(!tamaño(formulario.obs_exp, 1)==true)
	  //{mensaje("longitud_invalida","Observaciones");return false;}
	  //if(!tamaño(formulario.dt_exp, 1)==true)
	  //{mensaje("longitud_invalida","Datos");return false;}
	  //formulario.action="abm_expediente_libreria.php";
	   
	   formulario.tnroexp.disabled = false;
	  
	   formulario.ope.value ="Ie";
	  return true;
	}

function ValidarNumero(valor)

	{
	
	 document.formexp.action = "ValidarNumeroExpediente.php?nroExp="+valor+"&iniciador="+document.formexp.iniciador.value;
  	 
	 document.formexp.submit();
	
	 
	}
	
	function activar()
	{
  		document.formexp.nuevoexp.disabled = false;
	}
	function habilitarBoton()
	{
	 
	 document.formexp.tnroexp.disabled = true;
	 document.formexp.nuevoexp.disabled = false;
	 
	}
function Otro(valor)
	{
	 document.formexp.tnroexp.disabled = false;
	 document.formexp.action = "altaexpediente.php?iniciador="+valor;
	 document.formexp.submit();
	}
</script>
<?php
function obtenerDato($id,$tabla,$campo,$campoRetorno)
		{
		 if($id !="")
			{
			 $consulta="Select * From ".$tabla." Where ".$campo."='".$id."'";
			 
			 
			 
			  
			 $resu = mysql_query($consulta);
			 $row = mysql_fetch_array($resu);
			 
			 $arre = explode('~',$campoRetorno);
			 return $row[$arre[0]].' '.$row[$arre[1]];
			 }
		 else
		 	{
			 return "-";
			}
		}
?>