<?php
/*echo'<pre>Post<br>';
print_r( $_POST );
print_r( $_FILES );
echo'</pre>';
exit;*/

$idMov        = $_POST['idmov']; //id_mov 
$folio        = $_POST['folio'];
$idExpediente = $_POST['id_expediente'];
$detalle      = trim($_POST['editor']);
$fecha        = $_POST['fecha'];


include ("conexion.php");
$var=new conexion();
$var->conectarse();

$archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;
if ($archivo['name'] != '') {
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $extension = strtolower($extension);
    $extension_correcta = ($extension == 'pdf');
    if ($extension_correcta) {
        $archivo["name"]      = "informe-exp".$idExpediente."-mov".$idMov."_".md5( date("Y-m-d H:i:s")).".pdf";
        $ruta_destino_archivo = BASE_URL."/informe/".$archivo['name'];
        $archivo_ok           = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);
        $archivoPDF           = $archivo["name"];
    }
    else { echo "Error: extension incorrecta";exit; }
} else { 
    //echo "Error: no hay archivo";exit; 
    $archivoPDF = '';
}

$consulta = "INSERT INTO respuesta_agente(extracto, fecha, id_mov, folio, pdf)
VALUES('".$detalle."', '".$fecha."', '".$idMov."', '".$folio."', '".$archivoPDF."')";
//echo $consulta; exit;
if(mysql_query($consulta))
{
	//echo $consulta; exit;
	echo "<script type='text/javascript'>opener.Refrescar();</script>";
	echo "<script type='text/javascript'>window.opener.location.reload();</script>";
	echo "<script type='text/javascript'>window.close();</script>";
}
else
{
	echo "<script>alert('Hubo un error al crear el informe');</script>";
	//echo $consulta; exit;
}