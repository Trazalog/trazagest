<?PHP
include("conexion.php");
	  $link= new conexion();
      $link->conectarse();
	 
$busca=$_GET['id'];

//incluir la libreria para generar PDF 
require_once("dompdf/dompdf_config.inc.php");

$html = 
'<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Nota</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/stylePrint.css" type="text/css">
</head>';
$consulta = "SELECT * FROM notas where id_nota=$busca";
$res      = mysql_query($consulta);
$respueta = mysql_fetch_assoc($res);

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
<body oload="window.print();" >
  <div class="container">
    <div class="thumbnail">
      <form name="forprint" id="forprint" action="" method="post">
          <br />
          <table width="100%" style="text-align:justify">
            <!--DWLayoutTable-->
            <!--<tr>
              <td colspan="4" align="center" valign="top">
                <div class="text-center">
                  <img src="imag/logo.jpg" width="140" height="118" />
                </div>
              </td>
            </tr>
            <tr>-->
              <td height="4" colspan="4" valign="top"> 
                <!--<hr />
                <h3><center>NOTA</center></h3>
                <hr />-->
              </td>
	          <tr align="right">
	            <td width="50%" height="23"> <td/>
		        <td colspan="4" align="right"> <b > San Juan : '.fecha_larga($respueta['fecha_entrada'],1).'	
		        </td>
	        </tr> 
            <tr><td height="4" colspan="4" > <br /></td>
            </tr>
        	<tr>
        	  <td height="41" colspan="4" ><br /><!-- Detalle de Nota -->';  
        		 $html.= '<p  style="font-size:medium "align="justify" >'.$respueta['detalle_cedula'].'</p>    
              </td>
            </tr>
	        <tr>
                <td height="41" colspan="4" ><br /><!-- Datos -->'; 
                    $html.= '<p  style="font-size:medium "align="justify" >'.$respueta['datos'].'</p>    
                </td>
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
