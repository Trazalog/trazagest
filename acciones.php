
<?php
	include("conexion.php");
	
	function inviertefecha($f)
	{
	$datos = explode("-",$f);
	$fecha[]= $datos[0];
	$fecha[] = $datos[1];
	$fecha[] = $datos[2];
	$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];
	return  $total;
	
	}
	
	function inviertefecha2($f)
	{
	$datos = explode("/",$f);
	$fecha[]= $datos[0];
	$fecha[] = $datos[1];
	$fecha[] = $datos[2];
	$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];
	return  $total;
	
	}
	
	
	function asignar($exp,$def,$cant,$f,$obser)
	{ 
	$link= new conexion();
	$link->conectarse();
	//exp tiene el nro de expedietnte 
	
	$sql1="select * from registrodefensor where (id_expediente = $exp) and (id_defen = $def) and (estado = 'A');";
	$res1=mysql_query($sql1) or die(mysql_error());
	
	if($row1=mysql_fetch_array($res1))//pregunta si el expediente y defensor estan en la misma fila
	{
	echo "<script>alert('El Expediente ya esta asignado a ese Funcionario');</script>";
	}
	else 
	{
		//buscar el estado asignado 
		
		//Buscar id estado archivado 
		$sqln = "select id_estado from estados Where descripcion = 'Asignado'";
		$resun = mysql_query($sqln);
		
		$rown = mysql_fetch_array($resun);
		
		$sqln = "update expedientes set id_estado = ".$rown['id_estado']." where id_expediente = ".$exp."";
		$resun = mysql_query($sqln);
		
		$sql2="select * from registrodefensor where (id_expediente = $exp)";		
		$res2=mysql_query($sql2) or die(mysql_error());
				
		if($row2=mysql_fetch_array($res2))//pregunta si el expediente esta en la fila y el estado es Activo
		{ 
		 $sql3="update registrodefensor set estado = 'T' where (id_expediente = $exp)  and (estado like 'A');";
		   $res3=mysql_query($sql3) or die(mysql_error());
		
		$sql4="insert into registrodefensor(id_defen,id_expediente,fecha,folios,estado) value('$def','$exp','$f','$cant','A');";
		$res4=mysql_query($sql4) or die(mysql_error());
		
		}
			else
			{
			 $sql4="insert into registrodefensor(id_defen,id_expediente,fecha,folios,estado) value('$def','$exp','$f','$cant','A');";
			
			$res4=mysql_query($sql4) or die(mysql_error());
			
			}
			//cambio de estado en la asignacion de expediente
		
	}
	
	
	$sql_busca="select  nro_expediente , n_folio, extraxto, fecha_entrada,letras from expedientes where id_expediente = '$exp' order by fecha_entrada ";
	
	$res2=mysql_query($sql_busca) or die(mysql_error());
	$expediente=mysql_fetch_row($res2);

	volver($expediente[0]);
	
	
		
	}	
	
	
	function volver($exp){
		
		echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();;</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();;</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
		header("Location:panelexpediente.php?expe=$exp");

	}	
	
	function rechazar2($expe)
	{ $staFin='';
	  $mot='';
	
		if($_POST['cksolu']=='S')
		{
			$link= new conexion();
	         $link->conectarse();
	         $sql="select id_rechazo from tipo_rechazo where descripcion ='Solucionado'";//Extrae el id del estado "Rechazado"
	         $res1=mysql_query($sql,$link->links)or die($sql);
			 $estado=mysql_fetch_row($res1);
			
			  $staFin='S';
			  $mot=$estado['id_rechazo'];	
		         
		}
		
		if($_POST['ckresu']=='R')
		{ 
		    $staFin='R';
			$mot=$_POST['tpo_recha'];
		  
		}
		
		     $link= new conexion();
	         $link->conectarse();
	         			 
			 $resEmp="UPDATE expedientes SET   estado_final = '".$staFin."',`motivo_final = '".$mot."' WHERE ` id_expediente` ='".$expe[0]."' ;";
			 
	$res1=mysql_query($resEmp,$link->links)or die($resEmp);
	
	
	echo "<script>alert('Expediente Modificado Correctamente')</script>";
	echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();;</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();;</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
		//header("Location:panelexpediente.php?expe=$expe");

	 
	}
	
	function rechazar($expe , $est, $mot, $fecha,$otro)
	{    
	$link= new conexion();
	$link->conectarse();
	
	switch($est)
		{
			//Solucionado
			case "S":
				$sql = "select id_estado from estados Where descripcion = 'Solucionado' Limit 0,1";
				break;
			//Suspendido
			case "U":
				$sql = "select id_estado from estados Where descripcion = 'Suspendido' Limit 0,1";
				break;
			//Rechazado
			case "R":
				$sql = "select id_estado from estados Where descripcion = 'Rechazado' Limit 0,1";
				break;
			case "I":
				$sql = "select id_estado from estados Where descripcion = 'incomparecencia' Limit 0,1";
				break;
			case "O":
				$sql = "select id_estado from estados Where descripcion = 'Otros' Limit 0,1";
				break;		
		}
	$resu = mysql_query($sql);
	
	$row = mysql_fetch_array($resu);
	
	//obtener id resolucion 'Archivado'
	$sql = "select id_resolucion from resolucion Where descripcion = 'Archivado' ";
	$resolucion = mysql_query($sql);
	
	$rowq = mysql_fetch_array($resolucion);
	
	//echo "eeeeeeeeeeeeeee$mot"; 
	
    if($mot != 0)
        {
	       $sql  = "Update expedientes  set motivo_final= '".$mot."' , estado_final ='".$row['id_estado']."' where id_expediente = '".$expe."' ";
           $sql2 = "Insert Into Registro_resolucion (id_expedinete,id_resolucion,fecha,rech_o_resu) Values (".$expe.",".$mot.",'".$fecha."','".$est."')";
        }
        else
        {
			//$mot="";
             $sql  = "Update expedientes  set otro= '".$otro."' ,motivo_final= '".$mot."' , estado_final ='".$row['id_estado']."' where id_expediente = '".$expe."' ";
            $sql2 = "Insert Into Registro_resolucion (id_expedinete,fecha,rech_o_resu) Values (".$expe.",'".$fecha."','".$est."')";
        }
        
		//echo "$sql";
	mysql_query($sql);	
	mysql_query($sql2);
	
	$sql = "Select * from expedientes where id_expediente = $expe";
	$resu = mysql_query($sql);
	$row = mysql_fetch_array($resu);
	echo" $row[0] ";

	echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();;</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();;</script>";
		echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
	//volver($row['nro_expediente']);
	echo "<script>alert(\"Estado Modificado.\");
			
		    
	</script>";
	//window.open('printexpediente.php?iniciador=".$row['nro_expediente']."','','menubar=1,width=700,height=700');
	//
	}
	
	
	
	$ope=$_POST['oper'];
	echo "..............$ope";
	switch($ope)
	{
	case 'a':{ echo" <table class=\"fondo2\"  width=\"80%\" align=\"center\"><tr><td align=\"center\" class=\"tituloformulario\">Historial de Asignación de Expediente a Funcionario</td></tr></table>";
			$expe=$_POST['idExp'];
			
			$def=$_POST['defen'];
			
			$canti=$_POST['cant'];
		
			$fec=$_POST["fechas"];
			
			$observ = isset($_POST["obstext"]) ? $_POST["obstext"]:"";
		
		    asignar($expe,$def,$canti,$fec,$observ);
			break;
		 }
	case 'r':{	 
	
	$nn=$_POST['cksolu'];
		echo "..............$nn";
			  //estado final
              switch($_POST['cksolu'])
              {
                case 'S':
                    //solucionado 
    			    $solucion='S';
					$motivo = "0";
                    break;
                case 'U':
                    //Suspendido
					$solucion = 'U';
					$motivo = "0";
                    break;
                case 'R':
                    //en tramite
                    $solucion = 'R';
                    $motivo = $_POST['tpo_recha'];
                    break;
			 case 'I':
                    //Suspendido
					$solucion = 'I';
					$motivo = "0";
                    break;	
			 case 'O':
                    //Suspendido
					$solucion = 'O';
					$motivo = "0";
					$otro = $_POST['otro'];
                    break;				
              }
	          
			  $fecha =$_POST['fecha'];//inviertefecha
			  $expe=$_POST['idExp'];
			 			
			 rechazar($expe,$solucion,$motivo,$fecha,$otro); 
			 break;
		 }
	default : {
		 header("Location: principal.php");
		 break;
		}	
	
	}



	
	?>
    
    
<!--<script>
	function volver(exp)
    {
		var opciones = "toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,resizable=yes,width=800,height=400" ;

      window.open("panelexpediente.php?expe="+exp,"nombreventa na", opciones);
    
    }
</script>-->	