<?php
session_start();
include("conexion.php");
$var = new conexion();
$var->conectarse();

include("class_sesion.php");
$sesion= new Sesion();
$CadenaPermisos = $sesion->iniciar();

$consulta = "Select * from configuracionempresa Where id_cliente = 1";
$row = mysql_query($consulta) or die(mysql_error());

$row = mysql_fetch_array($row);

?>
<br>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Turnero</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 

</head>
<center>
<body id="fondo"  >
<div class="container  succes" style="height:650px;"> <!-- Contenerdor margen de Pantalla standarizado -->
			<div class="span-22  push-1"  id="titulo_main">
					<center>
						<label ><br>
					    Configuración General</label>
					</center>
			</div>			


<div class="span-23 right" style="height:570px;">

	<form name="config" action="configuraciongeneralphp.php" method="post" onSubmit="return validarConfig()" >
		<!-- Comienzo de Tag -> Table-->
        <fieldset>
		<table>
			<tr>
            	<td><label>CUIT: </label></td>
                <td><input type="text" name="cuit" maxlength="13" value="<?php echo $row['cuit'];?>"></td>
            </tr>
            <tr>
            	<td><label>Razón Social: </label></td>
                <td><input type="text" name="razon" max="50" size="60" value="<?php echo $row['descripcion'];?>"></td>
            </tr>
            <tr>
            	<td><label>Dirección: </label></td>
                <td><input type="text" name="direccion" max="100" size="60" value="<?php echo $row['direccion'];?>"></td>
            </tr>
            <tr>
            	<td><label>Departamento: </label></td>
                <td><input type="text" name="departamento" value="<?php echo $row['departamento'];?>" alt="ddddd"></td>
            </tr>
            <tr>
            	<td><label>Provincia: </label></td>
                <td><input type="text" name="Provincia" value="<?php echo $row['provincia'];?>"></td>
            </tr>
            <tr>
            	<td><label>Teléfono: </label></td>
                <td><input type="text" name="telefono" value="<?php echo $row['telefonofax'];?>"></td>
            </tr>
            <tr>
            	<td><label>Correo Electrónico: </label></td>
                <td><input type="text" name="mail" max="50" size="40" value="<?php echo $row['mail'];?>"></td>
            </tr>
            <tr>
            	<td><label>Contacto: </label></td>
                <td><input type="text" name="contacto" max="50" size="60" value="<?php echo $row['contacto'];?>"></td>
            </tr>
            <tr>
            	<td colspan="2"><h2></td>
            </tr>
            <tr>
           		<td><label>Logo: </label></td>
                <td><img src="usuarios.jpg" class="top" height="100" width="100"></td>
           </tr>
            <tr>
            	<td colspan="2">
                <center>
                <br>
                <br>
                <input type="submit" value="Aceptar" class="button">&nbsp;&nbsp;&nbsp;
                <input type="button" value="Cancelar" class="button" onClick="Cancelar()">
                </center>
                </td>
           </tr>
		</table>
        </fieldset>
		<!-- Fin de Tag -> Table-->

	</form>	
	</div>
</div>
</body>
</center>
</html>
<script>
function validarConfig()
	{
		if(document.config.cuit.value == "" || document.config.cuit.value.length < 13)
			{
				alert("Ingrese un número de CUIT válido.");
				document.config.cuit.focus();
				return false;
			}
		
		if(document.config.razon.value == "" || document.config.razon.value.length < 3)
			{
				alert("Ingrese un nombre para la razón social.");
				document.config.razon.focus();
				return false;
			}
			
		if(document.config.direccion.value == "" || document.config.direccion.value.length < 10)
			{
				alert("Ingrese una dirección valida.");
				document.config.direccion.focus();
				return false;
			}
			
		if(document.config.departamento.value == "" || document.config.departamento.value.length < 5)
			{
				alert("Ingrese un nombre de departamento válido.");
				document.config.departamento.focus();
				return false;
			}
		
		if(document.config.Provincia.value == "" || document.config.Provincia.value.length < 5)
			{
				alert("Ingrese un nombre de provincia válido.");
				document.config.Provincia.focus();
				return false;
			}
		
		if(document.config.telefono.value == "" || document.config.telefono.value.length < 7)
			{
				alert("Ingrese un número de télefono válido.");
				document.config.telefono.focus();
				return false;
			}
			
		if(document.config.mail.value == "" || document.config.mail.value.length < 5)
			{
				alert("Ingrese una dirección de e-mail válida.");
				document.config.mail.focus();
				return false;
			}
			
		if(document.config.contacto.value == "" || document.config.contacto.value.length < 5)
			{
				alert("Ingrese un nombre de contacto válido.");
				document.config.contacto.focus();
				return false;
			}
		
		document.config.submit();
	}
	
function Cancelar()
	{
		document.config.action="principal.php";
		document.config.submit();
	}
</script>