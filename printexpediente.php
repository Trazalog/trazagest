<?php

include("conexion.php");
  $link= new conexion();
    $link->conectarse();

$busca= $_GET['iniciador'];

//incluir la libreria para generar PDF
require_once("dompdf/dompdf_config.inc.php");

$html =
'<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Respuesta Expediente '.$busca.'</title>
  <link rel="stylesheet" href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/stylePrint.css" type="text/css">
</head>';

$consulta = "SELECT * FROM expedientes where nro_expediente=".$busca;
$res=mysql_query($consulta);
$expediente=mysql_fetch_array($res);

//$expediente=extraeconsulta("expedientes", "nro_expediente",$busca);//$busca);


$consulta = "SELECT * FROM iniciador where dni='".$expediente['id_iniciador']."'";

$res = mysql_query($consulta);
$iniciador = mysql_fetch_array($res);

//echo mysql_num_rows($res);
//$iniciador=extraeconsulta("iniciador", "dni",$expediente['id_iniciador']);

$consulta = "SELECT * FROM estados where id_estado=".$expediente['id_estado'];
$res = mysql_query($consulta);
$estado = mysql_fetch_array($res);

//$estado=extraeconsulta("estados", "id_estado",$expediente['id_estado']);

$consulta = "SELECT * FROM tipo_expedientes where id_tipolegajos=".$expediente['id_tipo'];
$res = mysql_query($consulta);
$tipo = mysql_fetch_array($res);

//$tipo=extraeconsulta("tipo_expedientes", "id_tipolegajos",$expediente['id_tipo']);



function inviertefecha($f)
{
  $datos = explode("-",$f);
  $cad=  $datos[2]."-".$datos[1]."-".$datos[0];
  return   $cad;
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
                <hr />
              </td>
            </tr>
	<tr>
		<td colspan="4" ><b> Expediente Nro : '.$expediente['nro_expediente'].'</b></td>
	</tr>
    <tr>
      <td height="4" colspan="4" ><hr /></td>
	<tr>
		<td colspan="3"  ><b> Nro de Folio: '.$expediente['n_folio'].'</b></td>
		<td > <b> Fecha: '.inviertefecha($expediente['fecha']).'
	    </b></td>
	</tr>
    <tr><td height="4" colspan="4" > <hr /></td>
    </tr>
	<tr>
	  <td height="41" colspan="4" > Car&aacute;tula:  <br />';

            $f= explode("-",$expediente['fecha_entrada']);
			//<p style="text-align:justify">
		 $html.= '<p align="justify">San Juan, ..'.$f[2].'.. de ...'.$f[1].'... de....'.$f[0].'...
                  En el día de la fecha se presenta ante la Mesa de Entradas de esta Defensoría del Pueblo el/la señor/a  ...'.$iniciador['Apellido'].'
                  ...'.$iniciador['Nombre'].'................,    D.N.I Nro: ....'.$iniciador['dni'].'.....Domiciliado/a en ........'.$iniciador['Direccion'].'
                  .................Teléfono: ...'.$iniciador['telefono'].'......,quien solicita la intervención del Señor Defensor del Pueblo:.............
                  .'.$expediente['caratula'].'.........................................................</p>
    </td>
   </tr>
   <tr>
	<td height="4" colspan="4" ><hr /></td>
    </tr>
	<tr> <td width="250" height="23" > Letra:   '.$expediente['letras'].'  </td>
	  <td colspan="3"  > Extracto: '.$expediente['extraxto'].'</td>
    </tr>

	<tr>
	  <td height="4" colspan="4" ><hr /></td>
    </tr>
	<tr><td height="23" colspan="2">Estado: '.$estado['descripcion'].'</td>
		<td colspan="2" >Tipo: '.$tipo['descripcion'].'</td>
	</tr>
	<tr><td height="4" colspan="4" ><hr /></td>
    </tr>
	<tr>
	<td height="41" colspan="4" >
    Observaci&oacute;n:<br /><p align="justify">'.$expediente['observaciones'].'</p></td>
	</tr>
	<tr><td height="40" colspan="4" align="center" >
<div  class="print2" >
 <input type="hidden" value="'.$expediente['nro_expediente'].'" id="busca" name="busca" />
 </div>
  </td>
  </tr>

</table>
</form>
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