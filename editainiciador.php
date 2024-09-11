<?php
      include("conexion.php");
	  $link= new conexion();
      $link->conectarse();
	  
	  $dni=$_GET['dni'];
	  
	  $nroExp=$_GET['nro'];
	  
		 //buscamos si un iniciador con ese dni esta en la db 
		 $consulta = "Select * from iniciador where dni='".$dni."'";
		 $resu = mysql_query($consulta);
		 $row=mysql_fetch_array($resu);

		 echo"$resu[0]";
		 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Iniciador</title>
<script   type="text/javascript" src="abm_iniciador_js.js"></script>
<script   type="text/javascript" src="validacionesDeEntrada.js"></script>
</head>
<link rel="stylesheet" href="estilo.css" type="text/css"  media="screen"/>
<body class="body" onload="cambiarNombreBoton(<?php echo $sePuedeGuardar == false ? 1:0;?>)">
  <form name="finici" id="finici" action="guardar_editini.php"  method="post" > <!--onsubmit="return agregaIniciador()" >-->
  <div align="center">
  			<input type="hidden" name="siSePuedeGuardar" value="<?php echo $sePuedeGuardar;?>">
			<input type="hidden" name="idIniciador" value="<?php echo $row['dni'] ?>">
            <input type="hidden" name="tnnnn" value="<?php echo $nroExp;?>">
			<table width="50%" >
			   <tr>
				<td colspan="2" align="center" class="tituloformulario" ><b>Iniciador <?php echo $nroExp;?> </b></td>
			  </tr>
			  <tr>
			  	<td colspan="2"><hr class="linea"></td>
			  </tr>	
			 <tr>
				<td width="194" height="26" class="derecha" >  DNI o codigo o MI:  </td>
				<td width="397" class="izquierda"  ><input name="tdni" type="text" disabled="disabled" class="select" 
													 value="<?php echo $row['dni'] ?>" maxlength="10"  /> 
				<label class="comentario" > Sin Puntos</label> </td>
			  <tr>
				<td height="26" class="derecha" >Nombre o entidad:</td>
				<td  class="izquierda" ><input type="text" name="tnom"	 size="60" 
										value="<?php echo $row['Nombre'] ?>"/> </td>
			  <tr>
				<td height="26"  class="derecha"  >     Apellido o entidad:   </td>
				<td   class="izquierda" ><input type="text" name="tape" size="60"
										 value="<?php echo $row['Apellido'] ?>"/> </td>
			  </tr>
			   
			  <tr>
				<td height="26"  class="derecha" >Domicilio:</td>
				
				<td  class="izquierda" ><input type="text" name="tdom" size="60"
										value="<?php echo $row['Direccion'] ?>"/> </td>
			  <tr>
				<td height="26"  class="derecha"  > Nro Tel&eacute;fono:</td>
				<td   class="izquierda"> <input type="text" name="ttelef" class="select" onkeypress="mascara(this,'-',patron5,true)" onclick="numerico(ttelef)" 
										 value="<?php echo $row['telefono'] ?>" /></td>
			  </tr>
			  <tr>
				<td colspan="2"><hr class="linea"></td>
			  </tr>
			  <tr>
				<td height="30" colspan="2" align="center" valign="baseline" ><input type="submit" name="guardar" value="Guardar"  class="boton" onclick="" /></td><!-- onclick="agregaIniciador();" -->
			  </tr>
			</table>
	</div>
	<input type="hidden" name="ope"  />
</form>

</body>
</html>
<script>
function validarDni(valor)
	{
	 if(valor.value.length <4)
	 	{
		 alert("El DNI o codigo ingresado no tiene el tamaño adecuado.");
		 valor.focus();
		 return false;
		}else
			{
			return true;
			}
	}
	
function validarSiEstaEnLaBase(valor)
	{
		if(valor.value == false)
			{
			document.finici.action = "altaexpediente.php?iniciador="+document.finici.idIniciador.value;
			document.finici.submit();
			}else
				{
				 //validamos los campos 
					 if(!tamaño(document.finici.tdni,4))
						 {mensaje("longitud_invalida","Dni");return false;}
 					 if(!tamaño(document.finici.tnom,2))
						 {mensaje("longitud_invalida","Nombre");return false;}	 
					 if(!tamaño(document.finici.tape,0))
						 {mensaje("longitud_invalida","Apellido");return false;}
					 /*if(!tamaño(document.finici.tdom,10))
						 {mensaje("longitud_invalida","Domicilio");return false;}*/
					/* if(!tamaño(document.finici.ttelef,6))
						 {mensaje("longitud_invalida","Dni");return false;}
					*/
					document.finici.action = "abm_iniciador_libreria.php";
			 		document.finici.submit();
				}
	}
function cambiarNombreBoton(valor)
	{
	 if(valor == 0)
	 	{
		 document.finici.guardar.value="Guardar";
		}else
			{
			 document.finici.guardar.value="Aceptar";
			}
	}
</script>