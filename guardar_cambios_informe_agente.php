<?php
//$fe=inviertefecha($_POST['fecha']);//echo $_POST['fecha_entre'];
$fecha=$_POST['fecha'];


//$idmov=$_POST['mov']; //id_mov 
//echo $fol,"folio<br>";
$det=$_POST['descripcion'];

$idi=$_POST['id'];

include ("conexion.php");
$var=new conexion();
$var->conectarse();


$consulta="UPDATE respuesta_agente SET extracto='$det',
                                        fecha='$fecha'
							           
							  
							   WHERE id='$idi'";


$res=mysql_query($consulta)or die($consulta);
$req=mysql_fetch_assoc($res);
if($req)
		{
		    echo"$consulta";
			//header("Location: exito.php");
		header("Location: principal.php" );
		
		 
			
		}else
			{
			 
			  //header("Location: nexito.php");
			 echo"$consulta";
			}
//mysql_query($consulta,$var->links);

//sheader("Location: exito.php");

?>