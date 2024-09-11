<?php

/*echo'<pre>';
print_r( $_POST );
print_r( $_FILES );
echo'</pre>';
exit;*/

$detalle = trim($_POST['detalle']); //detalle de cedula
$des     = $_POST['destino']; //expediente destino
$copias  = $_POST['copias']; //copias
$oficina = $_POST['oficina'];
$idc     = $_POST['cedu']; //id de cedula
$fentra  = $_POST['fecha_entrada'];
$fentre  = $_POST['fecha_entre'];
$fnot    = $_POST['fecha_not'];
$fdev    = $_POST['fecha_dev'];
$fprof   = $_POST['fecha_prof'];
$plazo   = $_POST['plazo'];

include ("conexion.php");
$var = new conexion();
$var->conectarse();

$consulta = "UPDATE cedula SET
	detalle_cedula     = '$detalle',
	expedinete_destino = '$des',
	fecha_entrada      = '$fentra',
	copias             = '$copias',	
	fecha              = '$fentre',
	oficina            = '$oficina',
	fecha_notificacion = '$fnot',
	fecha_devolucion   = '$fdev',
	fecha_profesional  = '$fprof',
	plazo              = '$plazo' 
	WHERE id_cedula = $idc" ;
mysql_query($consulta,$var->links);

echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();;</script>";
echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();;</script>";
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
