<?php
@session_start();
$us= $_SESSION["id_usuario"];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>EXPEDIENTE</title>
    <link rel="shortcut icon" type="image/x-icon" href="assest/plugins/buttons/icons/folder.png" />
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet">
    <link href="css/font-awesome.min.css">

    <script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="Js/info_asigna.js"></script>

    <script type="text/javascript"  src="plugin/datatables/jquery.dataTables.min.js"></script>
    <script  type="text/javascript"  src="plugin/datatables/dataTables.bootstrap.min.js"></script>
    <link href="plugin/datatables/dataTables.bootstrap.css" rel="stylesheet">
    <style type="text/css">
        #panel_length{
            margin-bottom: 10px;
        }
        
    </style> 
</head>
<body>
    <div class="container">

        <?php
        include("conexion.php");
        $link= new conexion();
        $link->conectarse();
    	
		$caja=$_GET['num'];

		$tdop="<td align='center'>";
		$sql3="SELECT * FROM  ccajas 
            JOIN cajas ON ccajas.id_cajas = cajas.id_cajas
            JOIN expedientes ON expedientes.id_expediente = ccajas.id_expediente
            WHERE ccajas.id_cajas=$caja";

		$res3=mysql_query($sql3)or die($sql3);
		
		$cod=00;

       listarexpeCaja($res3,$cod);

      function listarexpeCaja($result,$caja) {
        echo'<div class="panel panel-default">';
        echo'<div class="panel-heading">Caja numero:  '.$caja;
        
        echo'</button></div>';

        echo "<div id='abm'  styles='display:none;'/></div>";
        echo "<div class='panel-body'>";
        echo '<table id="panel" class="table table-hover table-bordered">';
            echo '<thead>';
                echo'<tr >';
                    print "<th style='width:10%;'><strong>Fecha</strong></th>";  //escribe el titulo de la tabla
                    print "<th style='width:10%;'><strong>Numero Epediente</strong></th>";
                    print "<th><strong>Caratula</strong></th>";
                    //print "<th></th>";
                echo'</tr>';
            echo '</thead>';
            echo '<tbody>';

            while ($registro = mysql_fetch_row($result)) {
                echo '<tr>';
                    echo "<td class='info' >$registro[4]</td>";
                    echo "<td class='info' >$registro[27]</td>";
                    echo "<td class='info' >$registro[15]</td>";
                echo '</tr>';
            }
            echo "</tbody>";
        echo "</table>";
        echo "</div>";
    echo'</div>';
}
  
        ?>
    </div>
</body>

<script>  

  /* cargo plugin DataTable (debe ir al final de los script) */
    $("#panel").DataTable({
        "aLengthMenu": [ 10, 25, 50, 100 ],
        "autoWidth": true,
        "info": true,
        "ordering": true,
        "order": [[0, "asc"]],
        "paging": true,
        "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Sig.",
                "sPrevious": "Ant."
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "lengthChange": true,
        "searching": true,
        "sPaginationType": "full_numbers",
        "sScrollX": '100%',
        "sScrollXInner": "100%",
        "bScrollCollapse": true,
    });
</script>

</html>
