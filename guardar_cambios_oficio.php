<?php
$fentra = $_POST['fecha_entrada'];
$fentre = $_POST['fecha_entre'];//echo $_POST['fecha_entre']."facha entrega<br>";
$fnot   = $_POST['fecha_not'];//echo $_POST['fecha_not']."fecha notificacion<br>";
$fdev   = $_POST['fecha_dev'];//echo $_POST['fecha_dev']."fecha devolucion<br>";
$fprof  = $_POST['fecha_prof'];//echo $_POST['fecha_ent']."fecha profesional<br>";
$plazo  = $_POST['plazo'];//echo $_POST['plazo']."plazo<br>";


//$fol=$_POST['nfolio'];
$detalle  = trim($_POST['detalle']); //detalle de oficio
//$obs    = trim($_POST['datos']); // datos
$expedi   = $_POST['exp']; //numero_expediente
$copias   = $_POST['copias'];//
$oficina  = $_POST['oficina']; //
$idoficio = $_POST['oficio'];        //no entiendo por q hace id de cedula si estamos en una oficio 
$folio    = $_POST['folio'];//exp_destino

include ("conexion.php");
$var = new conexion();
$var->conectarse();

$consulta = "UPDATE oficio SET
	nuemro_folio       ='$folio',
	detalle_cedula     ='$detalle',
	fecha_entrada      ='$fentra',
	copias             ='$copias',
	fecha              ='$fentre',
	oficina            ='$oficina',
	fecha_notificacion ='$fnot',
	fecha_devolucion   ='$fdev',
	fecha_profesional  ='$fprof ',
	plazo              ='$plazo',
	/*datos              ='$obs',*/
	expediente_destino ='$folio'
	WHERE id_oficio = $idoficio";

mysql_query($consulta,$var->links);

//header("Location: exito.php");
echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();</script>";
echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();</script>";
echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
