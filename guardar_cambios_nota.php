<?php
$idnota  = $_POST['nota'];
$expedi  = $_POST['expediente'];

$detalle = trim($_POST['detalle']);
$feentra = $_POST['fecha_serv'];//fecha_entre
$copias  = $_POST['copias'];
$oficina = $_POST['oficina'];
$fnot    = $_POST['fecha_not'];//fecha notificacion
$folio   = $_POST['folio']; //expediente destino

include ("conexion.php");
$var=new conexion();
$var->conectarse();

$consulta = "UPDATE notas SET
	detalle_cedula     ='$detalle',
	fecha_entrada      ='$feentra',
	copias             ='$copias',
	oficina            ='$oficina',
	fecha_notificacion ='$fnot',
	expedinte_destino  ='$folio'
	WHERE id_nota = $idnota ";
		 
if(mysql_query($consulta,$var->links))
{   
	echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();;</script>";
	echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();;</script>";
	echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
}
else
{ 
	echo $consulta;
	//header("Location: error.php");
}

