<?php
include("conexion.php");
$link= new conexion();
$link->conectarse();

if(isset($_POST["dniBuscado"]))
{
	//buscamos si un iniciador con ese dni esta en la db
	$consulta = "Select * from iniciador where dni='".$_POST["dniBuscado"]."'";
	$resu = mysql_query($consulta);
	$cantidad = mysql_num_rows($resu);
	if($cantidad == 0)
	{
		//no encontrado en la db
		echo "<script>
			alert(\"No se encontró el DNI ingresado.\");
		</script>";
		$sePuedeGuardar = true;
	}else
	{
		//esta en la db
		$row = mysql_fetch_array($resu);
		$sePuedeGuardar = false;
	}
}
else
{
	$sePuedeGuardar = true;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>trazagest</title>
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">
</head>

<body class="body" onload="cambiarNombreBoton(<?php echo $sePuedeGuardar == false ? 1:0;?>)">
<div class="container">
	<br />
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">Iniciador</h3></div>

		<form name="finici" id="finici" class="form-horizontal" action="abminiciador.php"  method="post" onsubmit="return validarDni(dniBuscado)"> <!--onsubmit="return agregaIniciador()" >-->
			<div class="panel-body">

				<input type="hidden" name="siSePuedeGuardar" value="<?php echo $sePuedeGuardar;?>">
				<input type="hidden" name="idIniciador" value="<?php echo $sePuedeGuardar == false ? $row["dni"]:"";?>">

				<div class="form-group">
	                <label for="dniBuscado" class="control-label col-sm-3">DNI o Código</label>
	                <div class="col-sm-4">
	                	<div class="input-group">
	                    	<input type="text" name="dniBuscado" class="form-control" />
							<span class="input-group-btn">
								<button type="submit" name="buscar" class="btn btn-primary"><span class='glyphicon glyphicon-search'></span> Buscar</button>
							</span>
						</div>
					</div>
				</div>

				<hr>

				<div class="form-group">
	                <label for="tdni" class="control-label col-sm-3">DNI o código o MI</label>
	                <div class="col-sm-4">
                    	<input type="text" name="tdni" class="form-control" maxlength="10" value="<?php echo  $sePuedeGuardar == false ? $row["dni"]:""; ?>" />
					</div>
					<label class="control-label pull-left"> Sin Puntos</label>
				</div>

				<div class="form-group">
	                <label for="tnom" class="control-label col-sm-3">Nombre o entidad</label>
	                <div class="col-sm-4">
                    	<input type="text" name="tnom" class="form-control" value="<?php echo  $sePuedeGuardar == false ? $row["Nombre"]:""; ?>" />
					</div>
				</div>

				<div class="form-group">
	                <label for="tape" class="control-label col-sm-3">Apellido o entidad</label>
	                <div class="col-sm-4">
                    	<input type="text" name="tape" class="form-control" value="<?php echo  $sePuedeGuardar == false ? $row["Apellido"]:""; ?>" />
					</div>
				</div>

				<div class="form-group">
	                <label for="tape" class="control-label col-sm-3">Domicilio</label>
	                <div class="col-sm-4">
                    	<input type="text" name="tdom" class="form-control" value="<?php echo  $sePuedeGuardar == false ? $row["Direccion"]:""; ?>" />
					</div>
				</div>

				<div class="form-group">
	                <label for="ttelef" class="control-label col-sm-3">Nro Teléfono</label>
	                <div class="col-sm-4">
	                	<input type="text" name="ttelef" class="select form-control" onkeypress="mascara(this,'-',patron5,true)" onclick="numerico(ttelef)" value="<?php echo  $sePuedeGuardar == false ? $row["telefono"]:""; ?>" />
					</div>
				</div>

			</div>

			<div class="panel-footer">
				<center>
					<button type="button" class="btn btn-primary" onclick="finici.action='principal.php';finici.submit();"><span class='glyphicon glyphicon-home'></span> Principal</button>
					<button type="button" name="guardar" class="btn btn-primary" onclick="validarSiEstaEnLaBase(siSePuedeGuardar)"><span class='glyphicon glyphicon-floppy-disk'></span> Guardar</button>
					<button type="reset" class="btn btn-primary"><span class='glyphicon glyphicon-refresh'></span> Limpiar</button>
				</center>
			</div>

			<input type="hidden" name="ope"  />
		</form>
	</div>
</div>
</body>

<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type="text/javascript" src="abm_iniciador_js.js"></script>
<script type="text/javascript" src="validacionesDeEntrada.js"></script>
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
			if(!tamano(document.finici.tdni,4))
				{mensaje("longitud_invalida","Dni");return false;}
			if(!tamano(document.finici.tnom,2))
				{mensaje("longitud_invalida","Nombre");return false;}
			if(!tamano(document.finici.tape,0))
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
		}
		else
		{
			document.finici.guardar.value="Aceptar";
		}
	}
</script>

</html>
