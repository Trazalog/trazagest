<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

if(isset($_GET["expe"]))
{
	//buscamos el registro
	$exp = $_GET["expe"];
	$consulta = "Select * from expedientes where id_expediente='$exp'";
	$res=mysql_query($consulta);
	if(mysql_num_rows($res)<= 0)
	{
		$habilitar = 0;
		echo "<script>alert(\"Número de expediente no válido.\");</script>";
	}
	else
	{
		$expediente=mysql_fetch_array($res);
		$habilitar = 1;
	}
}
else
{
	//no buscamos el registro
	$habilitar = 0;
}

if(isset($_GET["expedientevin"]))
{
	//buscamos el registro
	$expv = $_GET["expedientevin"];
	$consulta1 = "Select * from expedientes where nro_expediente='$expv'";
	$res1=mysql_query($consulta1);
	if(mysql_num_rows($res1)<= 0)
 	{
		echo"-----------------------------";
	    $habilitar = 0;
	    echo "<script>alert(\"Número de expediente no válido.\");</script>";
	}
	else
	{
		$expedientevin=mysql_fetch_array($res1);
		$habilitar = 1;
	}
}
else
{

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<title>Vincular expediente</title>
	<link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
	<link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet">
	<link href="css/estilo.css" rel="stylesheet">
</head>
<body class="body">
    <div class="container">
    	<br />
    	<div class="panel panel-default">
			<div class="panel-heading"><h3 class="panel-title">Vincular Expediente</h3></div>
			<form name="cedu" action="altavincula_php.php" method="post" onSubmit="return validar(cedu)" enctype="multipart/form-data" class="form-horizontal">
				<div class="panel-body">
					<div class="form-group">
						<label for="caratula" class="col-sm-3 control-label">Carátula del Expediente</label>
						<div class="col-sm-9">
							<textarea name="caratula" class="form-control" rows="10" disabled="true"><?php echo $expediente["caratula"]?></textarea>
							<input type="hidden" name="id_expediente" value="<?php echo isset($expediente["id_expediente"]) ? $expediente["id_expediente"]:"";?>">
		              		<input type="hidden" name="nro_expedi" value="<?php echo($expediente["nro_expediente"]);?>">
						</div>
					</div>
					<div class="form-group">
						<label for="expedientevin" class="col-sm-3 control-label">Expediente a Vincular</label>
						<div class="col-sm-4">
							<div class="input-group">
								<input type="text" name="expedientevin" id="expedientevin" class="form-control">
								<span class="input-group-btn">
									<button type="button" name="buscar" class="btn btn-primary" onClick="busqueda1(expedientevin,id_expediente)"><span class='glyphicon glyphicon-search'></span> Buscar</button>
								</span>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label for="caratula" class="col-sm-3 control-label">Carátula del Expediente Vinculado</label>
						<div class="col-sm-9">
							<textarea name="caratula" class="form-control" rows="10" disabled="true" value="<?php echo $expedientevin['caratula'];?>"><?php echo $expedientevin['caratula']; ?></textarea>
							<input type="hidden" name="expvin" value="<?php echo isset($expedientevin["id_expediente"]) ? $expedientevin["id_expediente"]:"";?>">
						</div>
					</div>
					<div class="form-group">
						<label for="fecha" class="col-sm-3 control-label">Fecha</label>
						<div class="col-sm-4">
							<input type="date" name="fecha" class="select form-control" id="fecha">
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<center>
						<!--<button type="button" onClick="principal()" class="btn btn-primary"><span class='glyphicon glyphicon-home'></span> Principal</button>-->
						<button type="button" name="princ" id="princ" onclick="window.open('','_self').close();" class="btn btn-primary">Cerrar</button>
						<button type="submit" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-disk'></span> Guardar</button>
						<!--<button type="reset" class="btn btn-primary"><span class='glyphicon glyphicon-refresh'></span> Limpiar</button>-->
					</center>
				</div>
			</form>
		</div>
	</div>
</body>

<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type="text/javascript" src="abm_iniciador_js.js"></script>
<script type="text/javascript" src="validacionesDeEntrada.js"></script>

<script>
	function busqueda(valor)
	{
		if(valor.value.length == 0)
		{
			alert("Ingrese un número de expediente para realizar la busqueda.");
			document.cedu.expediente.focus();
		}
		else
		{
			document.cedu.action = "alta_vincula.php?expediente="+valor.value;
			document.cedu.submit();
		}
	}

	function busqueda1(valor,valor1)
	{
		if(valor.value.length == 0)
	 	{
			alert("Ingrese un número de expediente para realizar la busqueda.");
			document.cedu.expediente.focus();
		}
		else
		{
			document.cedu.action = "alta_vincula.php?expedientevin="+valor.value+"&"+"expe="+valor1.value;
		 	document.cedu.submit();
		}
	}

	function principal()
	{
		document.cedu.action="principal.php";
		document.cedu.submit();
	}

	function validar(obj)
	{
		if((obj.detalle.value.length==0)||(obj.detalle.value.length<5))
		{
			alert("Es necesario ingresar Detalle de cédula.")
			obj.detalle.focus();
			return false;
		}
		/*if((obj.caratula.value.length==0)&&(obj.expediente.value.length==0))
		{
			alert("Es necesario ingresar número de copias.")
			obj.expediente.focus();
			return false;
		}*//*else
			if(obj.expediente.value.length==0)
			{
				alert("Selecciona Numero De Expediente")
		 		obj.expediente.focus();
		 		return false;
			}*/
		if(obj.copias.value.length==0 )
		{
			alert("Es necesario ingresar el número de copias.")
			obj.copias.focus();
			return false;
		}
		if((obj.oficina.value.length==0)||(obj.oficina.value.length<2))
		{
			alert("Es necesario ingresar el nombre de oficina.")
			obj.oficina.focus();
			return false;
		}
		if(obj.datos.value.length==0)
		{
			if(confirm("Desea Agregar Algun Dato Mas?"))
	 		{
				obj.datos.focus();
				return false;
			}
      	}
	}

</script>

</html>
