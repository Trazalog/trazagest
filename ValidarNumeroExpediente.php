﻿<?php

include("conexion.php");
$var = new conexion();
$var->conectarse();

$consulta = "Select * from expedientes where nro_expediente = ".$_GET["nroExp"];
$resu = mysql_query($consulta);
$cantidad = mysql_num_rows($resu);

if($cantidad == 0)
	{
	 echo "<script>alert(\" Número Disponible.\");location.href=\"altaexpediente.php?iniciador=".$_GET["iniciador"]."&nroExp=".$_GET["nroExp"]."&habilitar=0\";</script>";		 
	}
	else
		{
		 echo "<script>alert(\" Número No Disponible.\");location.href=\"altaexpediente.php?iniciador=".$_GET["iniciador"]."&nroExp=".$_GET["nroExp"]."\";</script>";		 
		}
?>