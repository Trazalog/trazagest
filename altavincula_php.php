<?php
$idexp=$_POST['id_expediente'];
$expe=$_POST['nro_expedi'];
$idexpv=$_POST['expvin'];
$fep=$_POST['fecha'];//echo $_POST['plazo']."plazo<br>";

include("conexion.php");
$var=new conexion();
$var->conectarse();

$consulta="INSERT INTO expedientevincula(id_expediente,id_expedientevincula,fecha) VALUES ('$idexp','$idexpv','$fep')";
if(mysql_query($consulta)) {
	// header("Location: exito.php");
	//volver($expe['nroexpe']);
	// header("Location:panelexpediente.php?expe=$exp"); esta biene sta linea

	echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();;</script>";
	echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();;</script>";
	echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
} else {
	echo"$consulta";
	//header("Location: error.php");
}

function inviertefecha($f) {
	$datos = explode("-",$f);
	$fecha[]= $datos[0];
	$fecha[] = $datos[1];
	$fecha[] = $datos[2];
	$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];
	return  $total;
}

?>