<?php
ob_start(); 

include("conexion.php");


function insertarIniciador($ini)
{
	  $link= new conexion();
      $link->conectarse();
	 $consulta = "Select * from iniciador where dni='".$ini[0]."'";
	 $resu = mysql_query($consulta);
	 $cantidad = mysql_num_rows($resu);
	 if($cantidad > 0)
		{
			//no encontrado en la db 
			echo "<script>alert(\" El DNI ya se encuentra almacenado en la base de datos.\");location.href=\"abminiciador.php?iniciador=".$ini[5]." \";</script>";		 
		}else
			{
			  $queEmp= "INSERT INTO iniciador (dni ,Nombre ,Apellido ,Direccion ,telefono)VALUES ('".$ini[0]."', '".$ini[1]."', '".$ini[2]."', '".$ini[3]."', '".$ini[4]."');";
			  $resEmp = mysql_query($queEmp, $link->links) or die(mysql_error());
			  
			  echo "<script>alert(\" La operación se realizó con éxito.\");location.href=\"altaexpediente.php?iniciador=".$ini[0]." \";</script>";		 
			}
}
//Fin de Incertar


 $ini[]=$_POST['tdni'];//id Iniciador de tabla iniciador
 $ini[]=ucwords($_POST['tnom']);
 $ini[]=ucwords($_POST['tape']);
 $ini[]=ucwords($_POST['tdom']);
 $ini[]=$_POST['ttelef'];
 $ini[]=$_POST['idIniciador'];
		 
insertarIniciador($ini);

ob_end_flush(); 
?>