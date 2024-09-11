<html>
<head>
	<link media="all" type="text/css" href="estilo.css" rel="stylesheet">
	
	<script>
	function validarCampoExp(form){
	
	if(form.idExp.value=="" || form.idExp.value==null){
		alert('Debe ingresar un n\u00famero de expediente');
		return false;
	}else{
	return true;
	}
	}
	</script>
</head>

<body>

 
	<?php
	
	
	include("conexion.php");
		$link= new conexion();
	$link->conectarse();
	//ob_start(); 
	
	


include("class_secciones.php") ;

@session_start(); 

$clie= $_SESSION["id_usuario"];


$info= new info();
	
	



	
			$expe=$_GET['expe'];
			$tdop="<td  align='center'>";
			 $sql3="select id_expediente from expedientes where nro_expediente=$expe";
										 $res3=mysql_query($sql3)or die($sql3);
										 $row3=mysql_fetch_row($res3);
										 $idExp=$row3[0];
			 

	       // echo "<table width=2>";
		    echo"<h3 class='cont1'>Historial de Expediente</h3>";
			
			// obtengo id de expediente:
			
			echo"<hr>";
				
			
			// Listamos funcionarios/defensores ordenados por fecha, mostrando primero al último asignado.
			echo"<label class='cont1'><b>Funcionario/s asignado/s:  </b> </label>";
			$sql3="
			SELECT CONCAT(d.apellido,' ',d.nombre) \"Funcionario\", d.cargo \"Cargo\", rd.fecha \"Fecha de Asignado\", rd.folios \"Nro Folios\",rd.id_reg  
			FROM defensor AS d, registrodefensor AS rd 
			WHERE  rd.id_expediente=$idExp AND rd.id_defen=d.id_defensor ORDER BY rd.fecha DESC";
			// d.id_defensor=rd.id_defen and rd.id_reg= ".$filaRegDef.";";
			$res3=mysql_query($sql3) or die($sql3);
			listarfuncionario($idExp,$res3);//Lista los datos del Funcionario
			
			echo"<hr>";
			
			echo"<label class='cont1'><b>Agente/s:</b> </label>";
			$sql5="
			SELECT u.nombre_real , rm.fecha , rm.folios , rm.observaciones , rm.id_mov,rm.estado,u.tipo
			FROM expedientes as e , usuarios as u, registrodefensor as rd, registro_movimiento as rm 
			WHERE (e.id_expediente=rd.id_expediente) and (rd.id_reg=rm.id_reg)and(u.id_usuario=rm.id_usuario)and (e.id_expediente= ".$idExp.")
			ORDER BY rm.id_mov DESC";
			$res5=mysql_query($sql5);
			listaragente($idExp,$res5);//Lista Historial de Asignacion de Usuario
			
			echo"<hr>";
			
			
			/*
				cedula
			*/
			
			echo"<label class='cont1'><b>Cedulas</b> </label>";
			echo "<table border=\"0\" width=\"100%\">";
			$carpetaRaiz="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'];
			$iconoPDF=dirname($carpetaRaiz)."/imag/icono_pdf.gif";
			$carpetaPDF = dirname($carpetaRaiz)."/cedula/";
			$result = mysql_query("
			SELECT ce.detalle_cedula,ce.fecha_entrada,ce.copias,ce.pdf 
			FROM cedula AS ce
			WHERE ce.numero_expediente=$idExp 
			ORDER BY fecha_entrada DESC");
				for ($i = 0; $i < mysql_num_fields($result); $i++)
				{
					echo "<th class='botonmarron fondo2'>".mysql_field_name($result, $i)."</th>\n";  
				}  
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				echo "</tr>";
					$arrTime=explode(" ", $row[1]); 
					printf("
						$tdop%s</td>
						$tdop%s</td>
						$tdop%s</td>
						$tdop<a href='$carpetaPDF%s'><img src='$iconoPDF'/></a></td>", $row[0], $arrTime[0], $row[2], $row[3], $row[3]);  
						// 
				echo "</tr>";
			}
		   echo "</table>";
		   
			echo"<hr>";
			
			
			
			
			/*
				Respuestas a Cedula del expediente
			*/
			
			echo"<label class='cont1'><b>Respuesta/s c&eacute;dula/s:</b> </label>";
			echo "<table border=\"0\" width=\"100%\">";
			$carpetaRaiz="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'];
			$iconoPDF=dirname($carpetaRaiz)."/imag/icono_pdf.gif";
			$carpetaPDF = dirname($carpetaRaiz)."/respuesta_cedula/";
			$result = mysql_query("
			SELECT   rc.fechacedula as Fecha, rc.detalle, rc.pdf
			FROM cedula AS ce, respuesta_cedula AS rc
			WHERE ce.numero_expediente=$idExp AND ce.id_cedula=rc.id_cedula
			ORDER BY rc.fechacedula DESC");
				echo "<th ></th>"; 
					echo "<th ></th>"; 
					echo "<th ></th>"; 
				for ($i = 0; $i < mysql_num_fields($result); $i++)
				{
					
					echo "<th class='fondo22'>".mysql_field_name($result, $i)."</th>\n";  
				}  
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				echo "</tr>";
					$arrTime=explode(" ", $row[1]); 
					printf("
						$tdop%s</td>
						$tdop%s</td>
						$tdop%s</td>
						$tdop<a href='$carpetaPDF%s'><img src='$iconoPDF'/></a></td>", $row[0], $arrTime[0], $row[2], $row[3], $row[3]);  
						// 
				echo "</tr>";
			}
		   echo "</table>";
		   
			echo"<hr>";
			
			
			/*
				oficio
			*/
			
			echo"<label class='cont1'><b>Oficios</b> </label>";
			echo "<table border=\"0\" width=\"100%\">";
			$carpetaRaiz="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'];
			$iconoPDF=dirname($carpetaRaiz)."/imag/icono_pdf.gif";
			$carpetaPDF = dirname($carpetaRaiz)."/oficio/";
			$result = mysql_query("
			SELECT of.detalle_cedula as Detalle_Oficio,of.fecha_entrada,of.copias,of.pdf 
			FROM oficio AS of
			WHERE of.numero_expediente=$idExp 
			ORDER BY fecha_entrada DESC");
				for ($i = 0; $i < mysql_num_fields($result); $i++)
				{
					echo "<th class='botonmarron fondo2'>".mysql_field_name($result, $i)."</th>\n";  
				}  
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				echo "</tr>";
					$arrTime=explode(" ", $row[1]); 
					printf("
						$tdop%s</td>
						$tdop%s</td>
						$tdop%s</td>
						$tdop<a href='$carpetaPDF%s'><img src='$iconoPDF'/></a></td>", $row[0], $arrTime[0], $row[2], $row[3], $row[3]);  
						// 
				echo "</tr>";
			}
		   echo "</table>";
		   
			echo"<hr>";
			
			
			
			
			/*
				Respuestas a oficios del expediente
			*/
			
			echo"<label class='cont1'><b>Respuesta/s oficio/s:</b> </label>";
			echo "<table border=\"0\" width=\"100%\">";
			$carpetaPDF = dirname($carpetaRaiz)."/respuesta_oficio/";
			$result = mysql_query("
			SELECT   rc.fecha, rc.detalle , rc.pdf
			FROM oficio AS ce, respuesta_oficio AS rc
			WHERE ce.numero_expediente=$idExp AND ce.id_oficio=rc.id_oficio
			ORDER BY rc.fecha DESC");
					echo "<th ></th>"; 
					echo "<th ></th>"; 
					echo "<th ></th>"; 
				for ($i = 0; $i < mysql_num_fields($result); $i++)
				{
					echo "<th class='fondo22'>".mysql_field_name($result, $i)."</th>\n";  
				}  
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				echo "</tr>";
					$arrTime=explode(" ", $row[1]); 
					printf("
						$tdop%s</td>
						$tdop%s</td>
						$tdop%s</td>
						$tdop<a href='$carpetaPDF%s'><img src='$iconoPDF'/></a></td>", $row[0], $arrTime[0], $row[2], $row[3], $row[3]);  
						// 
				echo "</tr>";
			}
			echo "</table>";
			
			echo"<hr>";
			
			
			/*
				nota
			*/
			
			echo"<label class='cont1'><b>Nota</b> </label>";
			echo "<table border=\"0\" width=\"100%\">";
			$carpetaRaiz="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'];
			$iconoPDF=dirname($carpetaRaiz)."/imag/icono_pdf.gif";
			$carpetaPDF = dirname($carpetaRaiz)."/nota/";
			$result = mysql_query("
			SELECT no.detalle_cedula as Detalle_Nota,no.fecha_entrada,no.copias,no.pdf 
			FROM notas AS no
			WHERE no.numero_expediente=$idExp 
			ORDER BY fecha_entrada DESC");
				for ($i = 0; $i < mysql_num_fields($result); $i++)
				{
					echo "<th class='botonmarron fondo2'>".mysql_field_name($result, $i)."</th>\n";  
				}  
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				echo "</tr>";
					$arrTime=explode(" ", $row[1]); 
					printf("
						$tdop%s</td>
						$tdop%s</td>
						$tdop%s</td>
						$tdop<a href='$carpetaPDF%s'><img src='$iconoPDF'/></a></td>", $row[0], $arrTime[0], $row[2], $row[3], $row[3]);  
						// 
				echo "</tr>";
			}
		   echo "</table>";
		   
			echo"<hr>";
			
			
			/*
				Respuestas a notas del expediente
			*/
					echo "<th ></th>"; 
					echo "<th ></th>"; 
					echo "<th ></th>";  
			echo"<label class='cont1'><b>Respuesta/s nota/s:</b> </label>";
			echo "<table border=\"0\" width=\"100%\">";
			$carpetaRaiz="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'];
			$iconoPDF=dirname($carpetaRaiz)."/imag/icono_pdf.gif";
			$carpetaPDF = dirname($carpetaRaiz)."/respuesta_nota/";
			$result = mysql_query("
			SELECT   rc.fechanota as fecha, rc.detallenota as detalle, rc.pdfnota
			FROM notas AS ce, respuesta_nota AS rc
			WHERE ce.numero_expediente=$idExp AND ce.id_nota=rc.idnota
			ORDER BY rc.fechanota DESC");
					echo "<th ></th>"; 
					echo "<th ></th>"; 
					echo "<th ></th>"; 
				for ($i = 0; $i < mysql_num_fields($result); $i++)
				{
					 
					echo "<th class='fondo22'>".mysql_field_name($result, $i)."</th>\n";  
				}  
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				echo "</tr>";
					$arrTime=explode(" ", $row[1]); 
					printf("
						$tdop%s</td>
						$tdop%s</td>
						$tdop%s</td>
						$tdop<a href='$carpetaPDF%s'><img src='$iconoPDF'/></a></td>", $row[0], $arrTime[0], $row[2], $row[3], $row[3]);  
						// 
				echo "</tr>";
			}

		   
			
		   echo "</table>";
		   
			echo"<hr>";
			
			/*
				************************resolucion
			*/
			
			echo"<label class='cont1'><b>Resolucion</b> </label>";
			echo "<table border=\"0\" width=\"100%\">";
			$carpetaRaiz="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'];
			$iconoPDF=dirname($carpetaRaiz)."/imag/icono_pdf.gif";
			$carpetaPDF = dirname($carpetaRaiz)."/expedientesPDF/";
			$result = mysql_query("
			SELECT re.observacion,  re.fecha, re.idexpediente, re.direccionDocumento
			FROM expedientespdf AS re
			WHERE re.idexpediente=$idExp 
			ORDER BY re.fecha DESC");
			
			
			
				for ($i = 0; $i < mysql_num_fields($result); $i++)
				{
					echo "<th class='botonmarron fondo2'>".mysql_field_name($result, $i)."</th>\n";  
				}  
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				echo "</tr>";
					$arrTime=explode(" ", $row[1]); 
					printf("
						$tdop%s</td>
						$tdop%s</td>
						$tdop%s</td>
						$tdop<a href='$carpetaPDF%s'><img src='$iconoPDF'/></a></td>", $row[0], $arrTime[0], $row[2], $row[3], $row[3]);  
						// 
				echo "</tr>";
			}
			
			echo "<tr align='center'>";
            echo "<td>";
			
			
			
			/*
				************************estado final
			*/
			
			echo"<label class='cont1'><b>Estado Final</b> </label>";
			echo "<table border=\"0\" width=\"100%\">";
			
			$sql6 = "	SELECT E.nro_expediente ,ES.descripcion ,R.descripcion,E.otro 
			FROM expedientes E 
			Join estados ES on E.estado_final=ES.id_estado 
			Join tipo_rechazo R on E.motivo_final=R.id_rechazo 
			WHERE E.id_expediente= $idExp ";
			
			$res6=mysql_query($sql6) or die($sql6);
			
				 listar_estadofinal($idExp,$res6);
			
			
			
			/*
				************************acumula
			*/
			
			echo"<label class='cont1'><b>Expedientes vinculados</b> </label>";
			echo "<table border=\"0\" width=\"100%\">";
			$carpetaRaiz="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['PHP_SELF'];
			$iconoPDF=dirname($carpetaRaiz)."/imag/icono_pdf.gif";
			$carpetaPDF = dirname($carpetaRaiz)."/expedientesPDF/";
			$result = mysql_query("
			SELECT exp.nro_expediente  ,re.fecha
			FROM expedientevincula  AS re,  expedientes as exp
			WHERE  re.id_expedientevincula=exp.id_expediente and re.id_expediente=$idExp 
			ORDER BY re.fecha DESC");
			
			
			
				for ($i = 0; $i < mysql_num_fields($result); $i++)
				{
					echo "<th class='botonmarron fondo2'>".mysql_field_name($result, $i)."</th>\n";  
				}  
			while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
				echo "</tr>";
					$arrTime=explode(" ", $row[1]); 
					printf("
						$tdop%s</td>
						$tdop%s</td>
						
						$tdop</td>", $row[0], $arrTime[0]);  
						// 
				echo "</tr>";
			}
			
			
		   
		   echo "</table>";
		   
			echo"<hr>";
			
			
			

	function inviertefecha($f)
	{
	$datos = explode("-",$f);
	$fecha[]= $datos[0];
	$fecha[] = $datos[1];
	$fecha[] = $datos[2];
	$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];
	return  $total;
	
	}
	
	function listar($result)
	{   
	echo "<table border=\"0\" width=\"100%\">";
	for ($i = 0; $i < mysql_num_fields($result); $i++)
		{  
		 echo "<th class='botonmarron fondo2'>".mysql_field_name($result, $i)."</th>\n";  
		}  
		 while ($registro = mysql_fetch_row($result))
			{
			 echo "<tr class='cont2'>";
			 for($i=0;$i<count($registro);$i++)
				{ 
	  			 echo "<td  class='cont2' align=\"center\">".$registro[$i]."</td>";
				}	
				
			 }
		 echo "</tr></table>";
	}
	
	
function listaragente($in ,$result)// inicio y seleccion de lo que quiero mostrar
{   
echo "<table border=\"0\" width=\"100%\">";
       
	   print "<th class=' fondo2'>Nombre y Apellido</th>";  //escribe el titulo de la tabla 
	   print "<th class=' fondo2'>Fecha Asignacion</th>";
	   print "<th class=' fondo2'>folios recibidos</th>";
	   print "<th class=' fondo2'>Observaciones</th>";
	   print "<th class=' fondo2'>Estado</th>";
	  
	   print "<th class=' fondo2'><img src=\"imag/add.png\" onClick=\"asignaagente('".$in ."');\" title=\"edita movimiento.\" />
	   
	   
	   </th>";
      while ($registro = mysql_fetch_row($result))
      {
  $tipo= $registro[6];
  
	   
	   echo "<TR >";
			   
        	echo "<td  class='cont2' align=\"center\">$registro[0]</td>";
			echo "<td  class='cont2'align=\"center\">$registro[1]</td>";
			echo "<td class='cont2' align=\"center\">$registro[2]</td>";
			echo "<td class='cont2' align=\"center\">$registro[3]</td>";
			echo "<td class='cont2' align=\"center\">$registro[5]</td>";
			echo "<td class='cont2' align=\"center\">$registro[4]</td>";
			
			echo "<td class='cont2' style=\"text-align: center;\">
                            <img src=\"imag/editar.png\" onClick=\"asigau('".$registro[4]."');\" title=\"edita movimiento.\" />
                   </td>";


if ($tipo==1)
	   {
		  
			echo "<td class='cont2' style=\"text-align: center;\">
                            <img src=\"imag/picture_go.png\" onClick=\"provi('".$registro[4]."');\" title=\"edita movimiento.\" />
                   </td>";	   
	   }
	   
if ($tipo==0)
	   {
		   
			echo "<td class='cont2' style=\"text-align: center;\">
                            <img src=\"imag/transform_shear.png\" onClick=\"info('".$registro[4]."');\" title=\"edita movimiento.\" />
                   </td>";	   
	   }	   
            
        echo "</tr>";
		
		echo "<TR>";
		if ($tipo==1)
	   {
			$sql5="SELECT fecha,foja,file  FROM deta_prov where id_mov=".$registro[4]."
				  ORDER BY fecha DESC";
				  //echo"$sql5";
			$res6=mysql_query($sql5);
			listar_providencia($res6);
	   }
	   if ($tipo==0)
	   {
			$sql5="SELECT * FROM respuesta_agente WHERE id_mov=".$registro[4]."
				  ORDER BY fecha DESC";
				  //echo"$sql5";
			$res6=mysql_query($sql5);
			
			listar_informe($res6);
	   }
	   
		echo "</tr>";
    }
echo "</TABLE>";

}	

function listarfuncionario($in ,$result)// inicio y seleccion de lo que quiero mostrar
{   
echo "<table border=\"0\" width=\"100%\">";
       
	   print "<th class=' fondo2'>Funcionario</th>";  //escribe el titulo de la tabla 
	   print "<th class=' fondo2'>Cargo</th>";
	   print "<th class=' fondo2'>Fecha Asignacion</th>";
	   print "<th class=' fondo2'>folios recibidos</th>";
	   
	  
	 print "<th class=' fondo2'><img src=\"imag/add.png\" onClick=\"asignadefensor('".$in ."');\" title=\"edita movimiento.\" />
	 
	  </th>";
      while ($registro = mysql_fetch_row($result))
      {
       echo "<TR >";
			
				   
        	echo "<td  class='cont2' align=\"center\">$registro[0]</td>";
			echo "<td  class='cont2'align=\"center\">$registro[1]</td>";
			echo "<td class='cont2' align=\"center\">$registro[2]</td>";
			echo "<td class='cont2' align=\"center\">$registro[3]</td>";
			
			
			echo "<td class='cont2' style=\"text-align: center;\">
                            <img src=\"imag/editar.png\" onClick=\"asigadef('".$registro[4]."');\" title=\"edita movimiento.\" />
                   </td>";
            
        echo "</tr>";
        
        
    }
echo "</TABLE>";

}


function listar_estadofinal($in ,$result)// inicio y seleccion de lo que quiero mostrar
{   
echo "<table border=\"0\" width=\"100%\">";
       
	   print "<th class=' fondo2'>Nro expediente</th>";  //escribe el titulo de la tabla 
	   print "<th class=' fondo2'>Estado Final</th>";
	   print "<th class=' fondo2'>Motivo Final</th>";
	    print "<th class=' fondo2'>Observacion</th>";
	  
	 print "<th class=' fondo2'><img src=\"imag/add.png\" onClick=\"cargaestado('".$in ."');\" title=\"edita movimiento.\" />
	 
	  </th>";
      while ($registro = mysql_fetch_row($result))
      {
       echo "<TR >";
			
				   
        	echo "<td  class='cont2' align=\"center\">$registro[0]</td>";
			echo "<td  class='cont2'align=\"center\">$registro[1]</td>";
			
			echo "<td class='cont2' align=\"center\">$registro[2]</td>";
			echo "<td class='cont2' align=\"center\">$registro[3]</td>";
			
			
			
            
        echo "</tr>";
        
        
    }
echo "</TABLE>";

}	

	
			
function listar_providencia($result)// inicio y seleccion de lo que quiero mostrar
{   
//echo "<table border=\"0\" width=\"100%\">";
       print "<th ></th>";
	   print "<th ></th>"; 
	   print "<th ></th>";  
	   print "<th class='fondo1'>fecha</th>";  //escribe el titulo de la tabla 
	   print "<th class='fondo1'>folio</th>";
	   print "<th class='fondo1'>Archivo</th>";
	   
	  
      while ($registro = mysql_fetch_row($result))
      {
       echo "<TR >";
			
			echo "<td  ></td>";
			echo "<td  ></td>";
			echo "<td  ></td>";	   
        	echo "<td  class='cont1' align=\"center\">$registro[0]</td>";
			echo "<td  class='cont1'align=\"center\">$registro[1]</td>";
			
	        echo "<td  style=\"text-align: center;\">
											<img src=\"filexpedientes/".$registro[2]."\" onClick=\"muestra('filexpedientes/".$registro[2]."' );\"width='32' height='32'title=\"click para ver \" /></td>";
			   
        echo "</tr>";
        
        
    }
//echo "</TABLE>";

}
function listar_informe($result)// inicio y seleccion de lo que quiero mostrar
{   
//echo "<table border=\"0\" width=\"100%\">";
       print "<th ></th>";
	   print "<th ></th>"; 
	   print "<th ></th>";  
	   print "<th class='fondo1'>fecha</th>";  //escribe el titulo de la tabla 
	   print "<th class='fondo1'>folio</th>";
	   print "<th class='fondo1'>informe</th>";
	   
	  
      while ($registro = mysql_fetch_row($result))
      {
       echo "<TR >";
			
			echo "<td  ></td>";
			echo "<td  ></td>";
			echo "<td  ></td>";	   
        	echo "<td  class='cont1' align=\"center\">$registro[0]</td>";
			echo "<td  class='cont1'align=\"center\">$registro[4]</td>";
			
	       echo "<td class='cont2' style=\"text-align: center;\">
                            <img src=\"imag/leer.png\" onClick=\"infoagente('".$registro[0]."');\" title=\"edita movimiento.\" />
                   </td>";   
        echo "</tr>";
        
        
    }
//echo "</TABLE>";

}		

	
	//ob_end_flush();
	?>
</body>
</html>
<script>
function Mensaje(nroExpediente)
    {
        location.href = "editaexpediente.php?nroexpe="+nroExpediente;
    }

function editaexpe(nroExpediente)
    {
		
		var opciones = "width=850,height=600,scrollbars=si";

      window.open("editaexpediente.php?nroexpe="+nroExpediente,"nombreventa na", opciones);
		
     
    }
function Imprime(nroExpediente)
    {
        location.href = "printexpediente.php?iniciador="+nroExpediente;
    }
	function principal()
	{
	 document.historialexpediente.action="principal.php";
	 document.historialexpediente.submit();
	}
function asigau(mov)
    {
		var opciones = "width=850,height=400,scrollbars=si";

      window.open("editaasignausuario.php?mov="+mov,"nombreventa na", opciones);
       
    }
function provi(mov)
    {
		var opciones = "width=850,height=400,scrollbars=si";

      window.open("alta_providenci.php?mov="+mov,"nombreventa na", opciones);
       
    }	
	
function info(mov)
    {
		var opciones = "width=850,height=400,scrollbars=si";

      window.open("informe_agente.php?mov="+mov,"nombreventa na", opciones);
       
	}
function infoagente(mov)
    {
		var opciones = "width=850,height=400,scrollbars=si";

      window.open("printrespuesta.php?id="+mov,"nombreventa na", opciones);
	  
       
	}	
	
function asigadef(mov)
    {
		var opciones = "width=850,height=400,scrollbars=si";

      window.open("editaasignadefensor.php?mov="+mov,"nombreventa na", opciones);
       
    }
function cargaestado(mov)
    {
		var opciones = "width=850,height=400,scrollbars=si";

      window.open("rechazarexpedient2.php?mov="+mov,"nombreventa na", opciones);
       
    }	
function asignaagente(expe)
{
	var win = window.open("asignausuario.php?expe="+expe, "_blank");
	win.focus();		
}
function asignadefensor(expe)
    {
		

     
	   location.href = "asignadefensor.php?nroExp="+expe;
       
    }	
function muestra(imagen)
    {
		

     
	   var opciones = "width=850,height=400,scrollbars=si";

      window.open(imagen,"nombreventa na", opciones);
       
    }				

</script>