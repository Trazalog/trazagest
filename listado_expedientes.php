<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>Trazagest</title>
    <link rel="stylesheet" href="plugin/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugin/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container"> <!-- Contenerdor margen de Pantalla standarizado -->
        <br>
        <div class="panel panel-default">
            <div class="panel-body">
                <a href="principal.php" class="btn btn-default" role="button">
                    <span class="glyphicon glyphicon-home"></span> Principal
                </a><br><br>

                <?php
                include("conexion.php");
                $link = new conexion();
                $link->conectarse();
                //ob_start();
                function inviertefecha($f) {
                    $datos   = explode("-",$f);
                    $fecha[] = $datos[0];
                    $fecha[] = $datos[1];
                    $fecha[] = $datos[2];
                    $total   = $fecha[2]."-".$fecha[1]."-".$fecha[0];
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
                    JOIN iniciador i
                       on e.id_iniciador = i.dni
                    ORDER BY
                        nro_expediente";

                $res3 = mysql_query($sql3) or die($sql3);
                listarasigna($res3);//Lista los datos del Funcionario


                function listarasigna($result) { // inicio y seleccion de lo que quiero mostrar
                    echo'<div class="panel panel-default">';
                    echo'<div class="panel-heading"><h3 class="panel-title">Expedientes</h3></div>';
                    echo'<div class="panel-body">';
                    echo'<table class="table table-hover table-bordered table-striped" id="expedientes">';
                    // Establish the output variable
                    echo '<thead>';
                    echo '<tr>';
                        echo "<th><strong>Nro expediente</strong></th>";
                        echo "<th><strong>Fecha</strong></th>";
                        echo "<th><strong>Extracto</strong></th>";
                        echo "<th><strong>Iniciador</strong></th>";
                        echo "<th><strong>Estado</strong></th>";
                    echo '</tr>';
                    echo '</thead>';
                    echo '<tbody>';
                    while ($registro = mysql_fetch_row($result)) {

                        echo "<tr style='cursor:pointer' onClick=\"edita('".$registro[0]."');\">";
                        $estado=$registro[5];
                            echo "<td >$registro[0]</td>";
                            echo "<td >$registro[1]</td>";
                            echo "<td >$registro[2]</td>";
                            echo "<td >$registro[3]</td>";
                            echo "<td >$registro[4]</td>";

                        switch ($estado) {
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
                    echo '</tbody>';
                    echo "</table>";
                    echo "</div></div>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
</body>

<script src="js/jquery-1.11.3.min.js"></script>
<script src="plugin/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="plugin/datatables/jquery.dataTables.min.js"></script>
<script src="plugin/datatables/dataTables.bootstrap.min.js"></script>
<script>
    function principal() {
        document.formlitexp.action = "principal.php";
        document.formlitexp.submit();
    }
    function edita(expe) {
        //abre en nueva pestaña (mejor usabilidad, pero se puede)
        var win = window.open("panelexpediente.php?expe="+expe, "_blank");
        win.focus();
        //var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
        //window.open("panelexpediente.php?expe="+expe,"nombreventa na", opciones);
    }

    /* cargo plugin DataTable (debe ir al final de los script) */
    $("#expedientes").DataTable({
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