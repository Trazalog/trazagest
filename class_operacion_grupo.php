<?php
$tabla   = $_POST['tablaNom'];
$idGrupo = $_POST['Pk'];
$accion  = $_POST['accion'];
$indices = $_POST['indicesMenu'];
$nombre  = $_POST['descripcion'];

include("conexion.php");
$var = new conexion();
$var->conectarse();

switch($accion)
	{
		case "I":
			$sql = "Insert into ".$tabla." (descripcion, permisos) values ('".$nombre."', '".$indices."')";
			mysql_query($sql);
			break;
		case "U":
			$sql = "Update ".$tabla." set descripcion = '".$nombre."', permisos='".$indices."' Where id_grupo = ".$idGrupo;
			mysql_query($sql);
			break;
		case "D":
			$sql = "Delete from ".$tabla." Where id_grupo = ".$idGrupo ; 
			mysql_query($sql);
			break;	
	}
echo "<script>window.history.back(1);</script>";
?>