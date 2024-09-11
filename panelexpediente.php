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
    <title>Expedientes</title>
    <link rel="stylesheet" href="plugin/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugin/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="plugin/bootstrapvalidator/bootstrapValidator.min.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>
    <div class="container">

        <?php
        include("conexion.php");
        $link = new conexion();
        $link->conectarse();
        //ob_start();

        include("class_secciones.php") ;
        $info= new seccion();

        $info  = new seccion();
        $expe  = $_GET['expe'];
        $tdop  = "<td align='center'>";
        $sql3  = "select id_expediente from expedientes where nro_expediente=$expe";
        $res3  = mysql_query($sql3)or die($sql3);
        $row3  = mysql_fetch_row($res3);
        $idExp = $row3[0];

        $info->seccion_expe($us,$idExp);
        $info->seccion_vincula($us,$idExp);
        $info->seccion_funcionario($us,$idExp);
        $info->seccion_resolucion($us,$idExp);
        $info->seccion_oficio($us,$idExp);
        $info->seccion_nota($us,$idExp);
        $info->seccion_cedula($us,$idExp);
        $info->seccion_estado($us,$idExp);

        // movimiento llamarlo pases
        // expedientes vinculados
        ?>
    </div>
</body>

<script src="plugin/jquery/jquery-1.12.4.min.js"></script>
<script src="plugin/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="plugin/datatables/jquery.dataTables.min.js"></script>
<script src="plugin/datatables/dataTables.bootstrap.min.js"></script>
<script>
    $("#tbl_nota").DataTable({
        "aLengthMenu": [ 10, 25, 50, 100 ],
        "columnDefs": [ {
          "targets": [ 4, 5 ], 
          "searchable": false
        },
        {
          "targets": [ 4, 5 ], 
          "orderable": false
        } ],
        "order": [[0, "asc"]],
    });

    $("#tbl_oficio, #tbl_resolucion, #tbl_cedula").DataTable({
        "aLengthMenu": [ 10, 25, 50, 100 ],
        "columnDefs": [ {
          "targets": [ 3, 4 ], 
          "searchable": false
        },
        {
          "targets": [ 3, 4 ], 
          "orderable": false
        } ],
        "order": [[0, "asc"]],
    });

    $("#tbl_estadoFinal").DataTable({
        "aLengthMenu": [ 10, 25, 50, 100 ],
        "columnDefs": [ {
          "targets": [ 3 ], 
          "searchable": false
        },
        {
          "targets": [ 3 ], 
          "orderable": false
        } ],
        "order": [[0, "asc"]],
    });

</script>
</html>