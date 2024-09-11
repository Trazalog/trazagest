<!--<link rel="stylesheet" href="estilos.css" type="text/css" media="all" />-->
	<?php
	include("conexion.php");
	//ob_start(); 
	
	
	
	function inviertefecha($fec)
	{
	$datos = explode("-",$fec);
	$fecha[]= $datos[0];
	$fecha[] = $datos[1];
	$fecha[] = $datos[2];
	$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];
	
	return  $total;
	
	}
	
	
	function asignar($expi,$def,$cant,$fec,$obs)
	{ //1
	$est='A';
	$link= new conexion();
	$link->conectarse();

	$sql1="select id_reg from registrodefensor where id_expediente =$expi  and  estado = 'A'";
	$res1=mysql_query($sql1) or die($sql1);
	  if($row1=mysql_fetch_array($res1))
	  {//2
	
	    $sqlbusca="select * from registro_movimiento where id_reg ='".$row1[0]."' and id_usuario ='".$def."'";
        $resBusca=mysql_query($sqlbusca) or die ($sqlbusca);
	
	$consulta= "UPDATE registro_movimiento
 SET estado='T'  WHERE id_reg='".$row1[0]."'   " ;
 			$res33=mysql_query($consulta) or die($consulta);
			   
				$sqlinsert="INSERT INTO registro_movimiento (id_reg ,id_usuario ,fecha ,folios ,observaciones,estado) VALUES ( '".$row1[0]."', '".$def."', '".$fec."', '".$cant."', '".$obs."','".$est."')";
				
	  		  $res2=mysql_query($sqlinsert) or die($sqlinsert);
		
		
	
	   $sql3="select * from registro_movimiento where id_reg='".$row1[0]."' and  id_usuario = '".$def."'";
	   $res3=mysql_query($sql3)or die($sql3);//mysql_error());
	
	   if($row3=mysql_fetch_array($res3))
	 		 {//5
			 $sql4="select * from expedientes where id_expediente=".$expi;
	   		$res4=mysql_query($sql4)or die($sql4);//mysql_error());
			$row4=mysql_fetch_array($res4);
			volver($row4['id_expediente']);//nro_expedietne
	   		 }//5
	
     //}//4
	 }//2
	 else
	 {//6
	 	//no se como vamos a mostrar este cartel

	  //echo"<h3 align='center'>El Expediente debe estar asignado a un defensor para que se le asigne a Agente</h3>";
	 }//6	
	}	
	
	function volver($exp)
	{
		echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();;</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();;</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
		
		//header("Location:panelexpediente.php?expe=$exp");
	}	
	
	function rechazar($expe)
	{    $link= new conexion();
	$link->conectarse();
	$sql="select * from estados where descripcion ='Rechazado'";//Extrae el id del estado "Rechazado"
	$res1=mysql_query($sql,$link->links)or die($sql);
	
	$estado=mysql_fetch_row($res1);
	
	$sql="select * from expedientes where nro_expediente ='".$expe[0]."'";//Extrae el detalle del expediente para actualizarlo con el rechazo
	$res1=mysql_query($sql,$link->links)or die($sql);
	
	$result=mysql_fetch_row($res1);
	$concat=$result[5]."  \n  Rechazado  : \n  ".$expe[1];
	
	$resEmp="UPDATE `mi000652_gestionlegajos`.`expedientes` SET `detalle` = '".$concat."',`id_estado` = '".$estado[0]."' WHERE `nro_expediente` ='".$expe[0]."' ;";
	$res1=mysql_query($resEmp,$link->links)or die($resEmp);
	
	echo "<script>alert('Expediente Rechazado')</script>";
	echo "<br><a href='printexpediente.php?exped=".$expe[0]."'>Imprimir</a>";
	
	}
	
	$ope=$_POST['oper'];
	
	switch($ope)
	{
	case 'a':{
	        
			$expe=$_POST['idExp'];
			$def=$_POST['defen'];
			$canti=$_POST['cant'];
			$fec=$_POST['fechas'];  //date("Y-m-d")
			$obs=$_POST['obstext'];

			asignar($expe,$def,$canti,$fec,$obs); //inviertefecha(
			
			break;
		 }
	case 'r':{	 
			 $expe[]=$_POST['idExp'];
			 $expe[]=$_POST['det'];  
			
			 rechazar($expe); 
			 break;
		 }
	default : {
		 header("Location: principal.php");
		 break;
		}	
	
	}
	
	
	?>
	<!--<script languaje='javascript' type='text/javascript'>window.close();</script>;-->
    <!--<script>

function volver(expe)
	{
		location.href="asignausuario.php?expe="+expe;
	}
</script>-->	