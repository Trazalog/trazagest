<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

<title>Resolución de Expediente</title>
</head>
<link href="estilo.css" rel="stylesheet" type="text/css">
<link type="text/css" rel="stylesheet" href="assets/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
<SCRIPT type="text/javascript" src="assets/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script><link type="text/css" rel="stylesheet" href="assets/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>


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
</script>
<script language="javascript" src="reporteExpedientes_js.js" ></script>
<script type="text/javascript" src="ajax_post.js"></script><!-- metodo ajax -->
<body >
<form name="cedu" action="alta_cliente_php.php" method="post" onSubmit="" >
 <table width="87%" class="fondo2">
      <tr>
	  	<td colspan="5" align="center" class="tituloformulario">cliente
          <input type="hidden" name="op" value="A"  >
        </td>
		<?php
					$consulta2="SELECT * FROM ipo";
	   				$result2=mysql_query($consulta2,$var->links);
					?>
	  </tr>
	  <tr class="fondo3">
        <td width="100%"><table width="100%" >
          <tr>
            <td colspan="8"><hr class="linea">            </td>
          </tr>
          <tr>
            <td width="17%" class="derecha" >Nombre y apellidol</td>
            <td width="46%" class="izquierda"><input type="text" name="nombre"  size="60" class="select" id="nombre">
                <span class="Estilo1">* </span></td>
          </tr>
          <tr>
            <td width="17%" class="derecha" >Direccion</td>
            <td width="46%" class="izquierda"><input type="text" name="direccion"  size="60" class="select" id="direccion">
                <span class="Estilo1">* </span></td>
          </tr>
          <tr>
            <td width="17%" class="derecha" >Telefono</td>
            <td width="46%" class="izquierda"><input type="text" name="telefono"  size="60" class="select" id="telefono">
                <span class="Estilo1">* </span></td>
          </tr>
          <tr>
            <td width="17%" class="derecha" >e-mail </td>
            <td width="46%" class="izquierda"><input type="text" name="email"  size="60" class="select" id="email">
                <span class="Estilo1">* </span></td>
          </tr>
		  <tr>
            <td width="17%" class="derecha" >Departamento </td>
            <td width="46%" class="izquierda"><select name='dep'  id='dep'  class='select'>
                <option value="0" division="" selected></option>
                 <?php
					$consulta2="SELECT * FROM departamento  ";
	   				$result2=mysql_query($consulta2,$var->links);
	  				while($row2=mysql_fetch_array($result2))
	   					{
							 echo "<option value='".$row2['id_localidad']."'>".$row2['nom_localidad']."</option>";
			 			 
						}
                    
	  			?>
              </select> <span class="Estilo1">* </span></td>
            
            <td>&nbsp;</td>
          </tr>
		  <tr>
            <td width="17%" class="derecha" >Zona </td>
            <td width="46%" class="izquierda"><input type="text" name="zona"  size="60" class="select" id="zona">
                <span class="Estilo1">* </span></td>
          </tr>
		  <tr>
            <td width="17%" class="derecha" >Punto de referencia</td>
            <td width="46%" class="izquierda"><input type="text" name="referencia"  size="60" class="select" id="referencia">
                <span class="Estilo1">* </span></td>
          </tr>
          
          
          
        </table></td>
	  </tr>
  <tr class="fondo3">
  <td><span class="Estilo1">*</span> <span class="comentario">datos obligatorios</span>
    <table align="center">
		<tr>
			
			<td ><input type="submit" value="Guardar" class="boton"></td>
		</tr>
	</table>  </td>
  </tr>	
  </table>
  </form>
</center>
</body>
</html>