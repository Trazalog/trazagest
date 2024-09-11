<?php session_start();


include ("conexion.php");
$var=new conexion();
$var->conectarse();

//$id=$_GET["nroexpe"];
$id=$_POST['idexpe'];
//$id=$_POST['idexpe'];

$fecha=$_POST['fecha'];
//$exp=$_POST['expediente'];

//if(isset($_POST['idexp']))
//{

//cuando lo desarchivo pasa a estado asignado al expediente ???
    $consulta1= "UPDATE expedientes SET id_estado='1' WHERE id_expediente=$id
    ";
	 
	if(mysql_query($consulta1,$var->links))
	{
		$consulta="UPDATE ccajas   SET estado='D',
		fechade=$fecha WHERE id_expediente=$id" ;
	
	   if(mysql_query($consulta,$var->links))
		{
			header("Location: principal.php" );
			
		}else
			{
			 
			  //header("Location: nexito.php");
			 echo"$consulta";
			}
    }
//}

//$id=$_POST['idexp'];

//$consulta="select * from expedientes join ccajas where expedientes.id_expediente= ccajas.id_expediente and ccajas.id_expediente=$id";

// $consulta= "UPDATE ccajas   SET estado='D' WHERE id_expediente=$id" ;
 
/*if(mysql_query($consulta,$var->links))
	{    
	   
	                      header("Location: exito.php" );
		
		 
	     }
		 else
		             {
		 
		                    echo"$consulta";
		                   }
	
		
/*if(isset($_POST['expediente']))
{

$consulta1= "UPDATE ccajas join expedientes  SET ccajas.estado='A' WHERE ccajas.estado='D' and expedientes.nro_expediente=$id" ;

mysql_query($consulta1,$var->links)or die(mysql_error());



	if(mysql_query($consulta1,$var->links))
		{
			header("Location: exito.php" );
			
		}else
			{
			 
			  //header("Location: nexito.php");
			  echo"$consulta";
			 echo"$consulta1";
			}
}
	*/	
		

 ?>
