<?php session_start();
$idusuario = $_SESSION['id_usuario'];
//echo "id usuarioooo: ".$idusuario;
//$id=$_POST['expediente']; //nroexpe

$caja  = $_POST['cajas'];
$idexp = $_POST['idexp'];
$fehs  = $_POST['fecha']." 00:00:00";//." ".$_POST['hora'];

//$fe="1/1/01";
include ("conexion.php");
$var=new conexion();
$var->conectarse();

if(isset($_POST['idexp']))
{
    $consulta1 = "UPDATE expedientes SET id_estado='11' WHERE id_expediente='".$_POST['idexp']."'";
	if(mysql_query($consulta1,$var->links))
	{
		$consulta = "INSERT INTO ccajas(id_cajas,id_expediente,fechahora,id_usuario,estado) VALUES ('$caja', '$idexp', '$fehs','$idusuario','A')";	
	    if(mysql_query($consulta,$var->links))
		{
			header("Location: principal.php" );
		} else {
			//header("Location: nexito.php");
			echo"$consulta";
		}
    }
}
