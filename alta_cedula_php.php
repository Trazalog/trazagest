<?php

/*echo'<pre>';
print_r( $_POST );
print_r( $_FILE );
echo'</pre>';
exit;*/

$idExp         = $_POST['idexp'];
$nroExpediente = $_POST['expediente'];
$detalle       = trim($_POST['detalle']);
$fechaEntrada  = $_POST['fecha_entrada'];
$copias        = $_POST['copias'];
$plazo         = $_POST['plazo'];

include ("conexion.php");
$var = new conexion();
$var->conectarse();

$archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;
if ($archivo['name'] != '') {
    $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
    $extension = strtolower($extension);
    $extension_correcta = ($extension == 'pdf');
    if ($extension_correcta) {
        $archivo["name"]      = "cedula-exp".$idExp."_".md5( date("Y-m-d H:i:s")).".pdf";
        $ruta_destino_archivo = BASE_URL."/cedula/".$archivo['name'];
        $archivo_ok           = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);
        $archivoPDF           = $archivo["name"];
    }
    else { echo "Error: extension incorrecta";exit; }
} else { 
    //echo "Error: no hay archivo";exit; 
    $archivoPDF = '';
}


$consulta = "INSERT INTO 
    cedula(numero_expediente, detalle_cedula, fecha_entrada, copias, plazo, pdf) 
    VALUES ('$nroExpediente', '$detalle', '$fechaEntrada', '$copias','$plazo', '".$archivoPDF."')";
//print_r($consulta);//exit;

if(mysql_query($consulta))
{
	//echo $consulta; exit;
	echo "<script type='text/javascript'>opener.Refrescar();</script>";
	echo "<script type='text/javascript'>window.opener.location.reload();</script>";
	echo "<script type='text/javascript'>window.close();</script>";
}
else
{
	echo "<script>alert('Hubo un error al crear la Cédula');</script>";
	//echo $consulta; exit;
}
