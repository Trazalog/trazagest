<?PHP
include("conexion.php");
	  $link= new conexion();
      $link->conectarse();
	 
$busca=$_GET['id'];

//incluir la libreria para generar PDF 
require_once("dompdf/dompdf_config.inc.php");

$html = 
'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head  >
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title class="print2" >Respuesta Expediente <?php echo $busca; ?></title>
</head>
<link rel="stylesheet" href="stylePrint.css" type="text/css"  media="screen" />
<link rel="stylesheet" href="styleScreem.css" type="text/css" media="print" />
<link rel="stylesheet" href="estilos.css" type="text/css"  media="screen" />
<link href="css/bootstrap.min.css/bootstrap/3.3.6" rel="stylesheet">
  <link href="css/estilos.css/bootstrap/3.3.6" rel="stylesheet">
  <link href="bootstrap.css/bootstrap/3.3.6" rel="stylesheet">
  
   <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/estilos.css" rel="stylesheet">
  <link href="bootstrap.css" rel="stylesheet">

 ';
$consulta = "SELECT * FROM notas where id_nota=$busca";
$res=mysql_query($consulta);
$respueta=mysql_fetch_assoc($res);

//$expediente=extraeconsulta("expedientes", "nro_expediente",$busca);//$busca);






function inviertefecha($f)
{	
  $datos = explode("-",$f);
  $cad=  $datos[2]."-".$datos[1]."-".$datos[0];
  return   $cad;
}
function nombremes($mes){
 setlocale(LC_TIME, 'spanish');  
 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
 return $nombre;
} 
function fecha_larga($f)
{	
  $datos = explode("-",$f);
  $dia=$datos[2];
  $mes=nombremes($datos[1]);
  $año=$datos[0];
  $cad=  $dia ." de ".$mes." del ".$año;
  return   $cad;
}


 
 function data_text($data, $tipus=1)
 {
	 if ($data != '' && $tipus == 0 || $tipus == 1)
	 {$setmana = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');$mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');if ($tipus == 1)
	 {preg_match('[0-9]{}[0-9]{}[0-9]{}', $data, $data);
	 
	 $data = mktime(0,0,0,$data[2],$data[1],$data[3]);}
	 
	 return $setmana[date('w', $data)].', '.date('d', $data).' '.$mes[date('m',$data)-1].' de '.date('Y', $data);}else{return 0;}
	 
}
 



$html .=
'
<body  class="display:none; " >
<div class="container">

 <div class="thumbnail">
<form  name="forprint" id="forprint" action="" method="post" class="form-horizontal" role="form">
<br />
<table width="95%" style="text-align:justify">
  <!--DWLayoutTable-->
  	<tr>
		<td  colspan="4"  align="center" valign="top"><div class="text-center"> <img src="imag/logo.jpg" width="140" height="118" /> </div></td>
	</tr>
	
    <tr>
      <td height="4" colspan="4"  align="right"><hr /></td>
	<tr align="right">
		
		<td align="right"> <b > San Juan : '.fecha_larga($respueta['fecha'],1).'	
	
	    </b>
		
	
	    </b>
		
		</td>
	</tr> 
    <tr><td height="4" colspan="4" > <hr /></td>
    </tr>
	<tr>
	  <td height="41" colspan="4" >Detalle de Nota  <br />';  
	 
            
			//<p style="text-align:justify">
		 $html.= '<p  style="font-size:medium "align="justify" > .'.$respueta['detalle_cedula'].'.</p>    
    </td>
   </tr>
   <tr><td height="4" colspan="4" > <hr /></td>
    </tr>
	<tr>
	  <td height="41" colspan="4" >Datos  <br />';  
	 
            
			//<p style="text-align:justify">
		 $html.= '<p  style="font-size:medium "align="justify" > .'.$respueta['datos'].'.</p>    
    </td>
   </tr>
   <tr>
	<td height="4" colspan="4"><hr /></td>
    </tr>
	<tr> <td width="50%" height="23" > Expediente:   '.$respueta['numero_expediente'].'  </td>  
	  <td colspan="4"  >Copias: '.$respueta['copias'].'</td>
    </tr>

	<tr>
	  <td height="4" colspan="4"><hr /></td>
    </tr>
	<tr><td width="50%" height="23">Fecha de Entrada: '.$respueta['fecha_entrada'].'</td>
		<td colspan="4" >Oficina: '.$respueta['oficina'].'</td>
	</tr>
	<tr>
	  <td height="4" colspan="4" ><hr /></td>
    </tr>
	<tr><td width="250" height="23">Plazo: '.$respueta['plazo'].'</td>
		<td colspan="2" >Expediente Destino: '.$respueta['expedinte_destino'].'</td>
	</tr>
	<tr>
	  <td height="4" colspan="4" ><hr /></td>
    </tr>
	<tr><td height="23" colspan="2">Fecha de Notificacion: '.$respueta['fecha_notificacion'].'</td>
		<td colspan="2" >Fecha de Devolucion: '.$respueta['fecha_devolucion'].'</td>
	</tr>
	<tr>
	  <td height="4" colspan="4" ><hr /></td>
    </tr>
	<tr><td height="23" colspan="2">Fecha Profesional: '.$respueta['fecha_profesional'].'</td>
		
	</tr>
   
	
</table>
</form>
</div>
</div>
</body>
</html>
';	

/*
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("expediente.pdf");
*/
echo $html;
?>


