<?php

include("conexion.php");
$link = new conexion();
$link->conectarse();
	 
$busca = $_GET['id'];

$html = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Informe</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/stylePrint.css" type="text/css">
</head>
';

$consulta = "SELECT * FROM respuesta_agente where id=".$busca;
$res      = mysql_query($consulta);
$respueta = mysql_fetch_array($res);

function inviertefecha($f)
{	
  $datos = explode("-",$f);
  $cad   = $datos[2]."-".$datos[1]."-".$datos[0];
  return $cad;
}
function nombremes($mes){
  setlocale(LC_TIME, 'spanish');  
  $nombre = strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
  return $nombre;
} 
function fecha_larga($f)
{	
  $datos = explode("-",$f);
  $dia   = $datos[2];
  $mes   = nombremes($datos[1]);
  $año   = $datos[0];
  $cad   = $dia ." de ".$mes." de ".$año;
  return $cad;
}
function data_text($data, $tipus=1)
{
  if ($data != '' && $tipus == 0 || $tipus == 1) {
    $setmana = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
    $mes     = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    if ($tipus == 1){
      preg_match('[0-9]{}[0-9]{}[0-9]{}', $data, $data);
      $data = mktime(0,0,0,$data[2],$data[1],$data[3]);
    }
  return $setmana[date('w', $data)].', '.date('d', $data).' '.$mes[date('m',$data)-1].' de '.date('Y', $data);
  } else {
    return 0;
  }
}

$html .=
'
<body onload="window.print();" >
  <div class="container">
    <div class="thumbnail">
      <form name="forprint" id="forprint" action="" method="post">
          <br />
          <table width="100%" style="text-align:justify">
            <!--DWLayoutTable-->
            <tr>
              <td colspan="4" align="center" valign="top">
                <div class="text-center">
                  <img src="imag/logo.jpg" width="140" height="118" />
                </div>
              </td>
            </tr>
            <tr>
              <td height="4" colspan="4" class="text-right" align="right"> 
                <!--<hr />
                <h3><center>OFICIO</center></h3>-->
                <hr />
              </td>
          <tr>
            <td align="right">
              <b> San Juan '.fecha_larga($respueta['fecha'],1).'</b>
            </td>
          </tr> 
          <tr>
            <td height="4" colspan="4" >
              <br />
            </td>
          </tr>
          <tr>
            <td height="41" colspan="4" >
              <br />';  
              //<p style="text-align:justify">
               $html.= '<p style="font-size:medium "align="justify" >'.$respueta['extracto'].'</p>    
            </td>
          </tr>
        </table>
      </form>
    </div><!-- /thumbnail -->
  </div><!-- /container -->

</body>
</html>
';	

echo $html;
