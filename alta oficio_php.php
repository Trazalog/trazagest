<?php
$fe=$_POST['fecha_serv'];
$fee=$_POST['fecha_entre'];//echo $_POST['fecha_entre']."facha entrega<br>";
$fen=$_POST['fecha_not'];//echo $_POST['fecha_not']."fecha notificacion<br>";
$fed=$_POST['fecha_dev'];//echo $_POST['fecha_dev']."fecha devolucion<br>";
$feen=$_POST['fecha_ent'];//echo $_POST['fecha_ent']."fecha profesional<br>";
$fep=$_POST['plazo'];//echo $_POST['plazo']."plazo<br>";

include ("conexion.php");
$var=new conexion();
$var->conectarse();

$_FILES["archivo"]["name"] = $_POST['id_expediente']."_".md5( date("Y-m-d H:i:s")).".pdf";

$sDirGuardar = $_SERVER["DOCUMENT_ROOT"]."/legajos/oficio/".$_FILES["archivo"]["name"]; 

move_uploaded_file($_FILES["archivo"]["tmp_name"], $sDirGuardar);

$consulta="INSERT INTO oficio(expediente_destino,detalle_cedula,numero_expediente,fecha_entrada,copias,fecha,oficina,fecha_notificacion
,fecha_devolucion,fecha_profesional,plazo,datos,nuemro_folio,pdf) VALUES ('".$_POST['folio']."','".$_POST['detalle']."','".$_POST['id_expediente']."',
'".$fe."','".$_POST['copias']."','".$fee."','".$_POST['oficina']."','".$fen."','".$fed."','".$feen."','".$fep."','".$_POST['observacion']."',
'".$_POST['folio']."','".$_FILES["archivo"]["name"]."')";
if(mysql_query($consulta))
	{
	header("Location: exito.php");
	}else
		{
		// header("Location: error.php");
		echo $consulta;
		}
 ?>