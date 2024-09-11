<? header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=filtroordenpedido.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Filtro Expediente</title>
</head>
<link href="estilo.css" rel="stylesheet" type="text/css">

<body class="body">
<?php




    include("conexion.php");
	ob_start();
	$link= new conexion();
    $link->conectarse();
	
//************************************
//consulta general 
$sqlgral=" SELECT  
           O.id_expediente,
           O.nro_expediente,
           O.id_estado,
           E.descripcion,
           O.fecha
	 
        FROM expedientes O JOIN estados E on O.id_estado = E.id_estado 
		
		
       where ";

//************************************
$band = 0;	

if(isset($_POST['cfil']))
	{
	 $filtro = "";
	 foreach ($_POST['cfil'] as $value)
	 	 {
   	      switch($value)
		  	{
				///expediente destino 
				case 1:
						$filtro .= " O.nro_expediente = '".$_POST['nroexped']."' ";
						break;
				//detalle de cedula 
				
				//numero de expediente
				case 2: 
				$filtro .= "O.id_estado = '".$_POST['estado']."' ";
						break;
						
				case 3: 
						$filtro .= " fecha = '".$_POST['fecha']."' ";
						break;
				//rango de fechas de entradas
				case 4:
						$filtro .= " O.fecha >= '".$_POST['fechaIni']. "' and O.fecha <= '".$_POST['fechaHas']."' ";
						break;
				//otro tipo de fecha 

						//$filtro .= " O.fecha >= '".inviertefecha($_POST['fechaIni']). "' and O.fecha <= '".inviertefecha($_POST['fechaHas'])."' ";
		}		
		 }
	} 
	
$sqlgral.= $filtro;

function inviertefecha($f)
{
$datos = explode("-",$f);
$fecha[]= $datos[0];
$fecha[] = $datos[1];
$fecha[] = $datos[2];
$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];
return  $total;

}	


	
function listarnuevo($result)// inicio y seleccion de lo que quiero mostrar
{   
echo "<table  id=personas border=\"1\" width=\"100%\">";
       
	   print "<br>" ;
	   print "<th class='cont1'> Expediente </th>";  //escribe el titulo de la tabla 
	   print "<th class='cont1'>Nro Expediente</th>";
	   print "<th class='cont1'>Estado</th>";
	   print "<th class='cont1'>Fecha </th>";
	   	   
      while ($registro = mysql_fetch_row($result))
      {
		  
					   echo "<TR >";
							
						$estado=$registro[4];
						
								   
							echo "<td   class='cont2' align=\"center\">$registro[0]</td>";   
							echo "<td   class='cont2' align=\"center\">$registro[1]</td>";
							echo "<td   class='cont2'align=\"center\">$registro[3]</td>";
							echo "<td   class='cont2' align=\"center\">$registro[4]</td>";
							switch ($estado) {
					case "C":
					  echo "<td class='cont3' align=\"center\">$registro[4]</td>";
						break;
					case "V":
						echo "<td class='cont4' align=\"center\">$registro[4]</td>";
						break;
					case "P":
					   echo "<td class='cont5' align=\"center\">$registro[4]</td>";
						break;
					case "A":
					   echo "<td class='cont6' align=\"center\">$registro[4]</td>";
						break;
					case "T":
					   echo "<td class='cont7' align=\"center\">$registro[4]</td>";
					   break;
					case "TA":
					
					   echo "<td class='cont7' align=\"center\">$registro[4]</td>"; 
					   break;  
					case "TE":
					   echo "<td class='cont8' align=\"center\">$registro[4]</td>";      
						break;		
					case "R":
					   echo "<td class='cont7' align=\"center\">$registro[4]</td>";
						break;
					case "AV":
					   echo "<td class='cont7' align=\"center\">$registro[4]</td>";
						break;	
					case "AA":
					   echo "<td class='cont7' align=\"center\">$registro[4]</td>";
						break;	
						}
						
							
							
							
								   
						   
							
						echo "</tr>";
						
					
						
					}
				echo "</TABLE>";
				
				

}	
	
	







	$resgral= mysql_query($sqlgral)or die($sqlgral);
	

echo" <form name='form2' id='form2' method='post' ><div align='center'> ";
echo "<table width=\"80%\" style=\"text-align:center\" class=\"borde_tabla\"><tr><br><td class=\"tituloformulario\"  style=\"text-align:center\"><h3 style=\"text-align:center\"><center>Filtro de Expediente</center></h3></td></tr><br><tr><td></td></tr></table>";
listarnuevo($resgral,0);

echo "    ";
echo"<input type=\"button\" name=\"filtra\" id=\"filtrar\" value=\"Volver\" onclick=\"window.history.back();\" 
class=\"boton\" />";
echo"</form>";	
	
?>
<script>
function edita(expe)
    {
		var opciones = "toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,resizable=yes,width=690,height=532" ;

      window.open("historialexpediente.php?expe="+expe,"nombreventa na", opciones);
       

       
    }	
</script>    

</body>
</html>