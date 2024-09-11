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
</head>
<body>
    <div class="container">

        <?php
        include("conexion.php");
        $link= new conexion();
        $link->conectarse();
    	//ob_start();

		include("class_secciones.php") ;
		$info= new seccion();

		$expe=$_GET['expe'];

		$tdop="<td align='center'>";
		$sql3="select id_expediente from expedientes where nro_expediente=$expe";
		$res3=mysql_query($sql3)or die($sql3);
		$row3=mysql_fetch_row($res3);
		$idExp=$row3[0];

        $info->seccion_expe($us,$idExp);
		$info->seccion_vincula($us,$idExp);
        $info->seccion_funcionario($us,$idExp);
        $info->seccion_resolucion($us,$idExp);
        $info->seccion_oficio($us,$idExp);
        $info->seccion_nota($us,$idExp);
        $info->seccion_cedula($us,$idExp);
        $info->seccion_estado($us,$idExp);

        //movimiento llamarlo pases
        // expedientes vinculados
        ?>
    </div>
</body>

</html>
