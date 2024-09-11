
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Trazagest</title>
	<link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/3.3.6/js/bootstrap.min.js"></script>

  </head>

<script type="text/javascript">
		  var _gaq = _gaq || [];
		  _gaq.push(['_setAccount', 'UA-10143667-20']);
		  _gaq.push(['_trackPageview']);
		  _gaq.push(['_trackPageLoadTime']);

		  (function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		  })();

</script>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js" type="text/javascript"></script>
<script src="jquery.uitablefilter.js" type="text/javascript"></script>

<script language="javascript">
	$(function() {
	theTable = $("#personas");
	$("#q").keyup(function() {
	$.uiTableFilter(theTable, this.value);
	 });
	});
</script>

  <body>
  <div id="busqueda">
<p> Busqueda
			<input type="text" id="q" name="q"  value="" />

			   <a href="principal.php"  class="glyphicon glyphicon-home"  role="button">Principal</a>

</div>

<?php
include("conexion.php");
		$link= new conexion();
	$link->conectarse();
	//ob_start();
	function inviertefecha($f)
	{
	$datos = explode("-",$f);
	$fecha[]= $datos[0];
	$fecha[] = $datos[1];
	$fecha[] = $datos[2];
	$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];
	return  $total;

	}

		$sql3=" SELECT
        nro_expediente,
		fecha,
        e.extraxto,
		concat_ws(' ', TRIM(i.Apellido), TRIM(i.Nombre)) as iniciad,
			es.descripcion,
		  e.id_estado,
           id_iniciador,
           t.descripcion,
           fecha_entrada,
           letras,

           motivo_final,
           e.id_estado,

		   e.id_resolucion,e.id_expediente, e.estado_final
        FROM
           expedientes e

        JOIN tipo_expedientes t
    	   on e.id_tipo = t.id_tipolegajos
        JOIN estados es
    	   on e.id_estado = es.id_estado
        join iniciador i
    	   on e.id_iniciador = i.dni
    	 WHERE e.id_estado=11



        ORDER BY
            nro_expediente";


			$res3=mysql_query($sql3) or die($sql3);
			listarasigna($res3);//Lista los datos del Funcionario


function listarasigna($result)// inicio y seleccion de lo que quiero mostrar
{
echo '<table class="table table-striped table-hover">';
                // Establish the output variable
        echo '<thead>';
			echo'<tr class="success" >';
        	   print "<th> Nro expediente</th>";  //escribe el titulo de la tabla
			   print "<th>Fecha</th>";
			   print "<th>Extracto</th>";
			   print "<th>Iniciador</th>";
			   print "<th>Estado</th>";
			echo'</tr>';
        echo '</thead>';



    while ($registro = mysql_fetch_row($result))
    {

       echo "<tr onClick=\"archi('".$registro[0]."');\">";
			$estado=$registro[5];
			echo "<td >$registro[0]</td>";
			echo "<td >$registro[1]</td>";
			echo "<td >$registro[2]</td>";
			echo "<td >$registro[3]</td>";
			echo "<td >$registro[4]</td>";

				switch ($estado)
				{
				    case "Ingresado":
				      echo "<td class='cont3' align=\"center\">$registro[4]</td>";
				        break;
				    case "Asignado":
				        echo "<td class='cont4' align=\"center\">$registro[4]</td>";
				        break;
				    case "Solucionado":
				       echo "<td class='cont5' align=\"center\">$registro[4]</td>";
				        break;
				}




        echo "</tr>";


    }
echo "</TABLE>";

}






	?>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>










<script>
function principal()
	{
	 document.formlitexp.action = "principal.php";
	 document.formlitexp.submit();
	}
	function archi(expe)
    {
		var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,width=1024,height=1024" ;

      window.open("desarchivar.php?nroexpe="+expe,"nombreventa na", opciones);



    }
</script>