<?php

/*echo '<pre>';
print_r( $_FILES );
echo '</pre>';
exit;*/

$idExp        = $_POST['idexp'];
$nroExp       = $_POST['expediente'];
$detalle      = trim($_POST['detalle']);
$fechaEntrada = $_POST['fecha_entrada'];
$copias       = $_POST['copias'];
$oficina      = $_POST['oficina'];
$fechaNotif   = $_POST['fecha_not'];
$folio        = $_POST['folio'];
//$fechaEntrega = $_POST['fecha_entre'];
//$fechaDevoluc = $_POST['fecha_dev'];
//$fechaProf    = $_POST['fecha_prof'];
//$plazo        = $_POST['plazo'];
//$ = $_POST[''];
$datos = '';


include ("conexion.php");
$var = new conexion();
$var->conectarse();

$archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;
if ($archivo['name'] != '') {
	$extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
	$extension = strtolower($extension);
	$extension_correcta = ($extension == 'pdf');
	if ($extension_correcta) {
		$archivo["name"]      = "nota-exp".$idExp."_".md5( date("Y-m-d H:i:s")).".pdf";
		$ruta_destino_archivo = BASE_URL."/nota/".$archivo['name'];
		$archivo_ok           = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);
		$archivoPDF           = $archivo["name"];
	}
	else { echo "Error: extension incorrecta";exit; }
} else { 
	//echo "Error: no hay archivo";exit; 
	$archivoPDF = '';
}


/* guardo los datos en la de datos */
/*$consulta = "INSERT INTO notas(expedinte_destino, detalle_cedula, numero_expediente, fecha_entrada, copias, fecha, oficina, fecha_notificacion, fecha_devolucion, fecha_profesional, plazo, datos ,nuemro_folio, pdf) 
	VALUES ('$folio', '$detalle', '$nroExp', '$fechaEntrada', '$copias', '$fechaEntrega', '$oficina', '$fechaNotif', '$fechaDevoluc', '$fechaProf', '$plazo', '$datos', '$folio', '".$archivoPDF."')";*/
$consulta = "INSERT INTO notas(expedinte_destino, detalle_cedula, numero_expediente, fecha_entrada, copias, oficina, fecha_notificacion, datos ,nuemro_folio, pdf) 
	VALUES ('$folio', '$detalle', '$nroExp', '$fechaEntrada', '$copias', '$oficina', '$fechaNotif', '$datos', '$folio', '".$archivoPDF."')";
/* segun */
if(mysql_query($consulta))
{
	//echo $consulta; exit;
	echo "<script type='text/javascript'>opener.Refrescar();</script>";
	echo "<script type='text/javascript'>window.opener.location.reload();</script>";
	echo "<script type='text/javascript'>window.close();</script>";
}
else
{ 
	echo "<script>alert('Hubo un error al crear Nota');</script>";
	//echo $consulta; exit;
}
