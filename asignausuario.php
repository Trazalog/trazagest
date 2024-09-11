<?php
include("conexion.php");
$link= new conexion();
$link->conectarse();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asignación de Expediente a Agente</title>
    <link rel="shortcut icon" type="image/x-icon" href="assest/plugins/buttons/icons/folder.png" />
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">

    <!--<link rel="stylesheet"  href="estilo.css" type="text/css" media="all" />
    <style type="text/css">
    @import url("jscalendar-1.0/calendar-blue.css");
    </style>
    <script type="text/javascript" src="jscalendar-1.0/calendar.js" ></script>
    <script type="text/javascript" src="jscalendar-1.0/lang/calendar-es.js"></script>
    <script type="text/javascript" src="jscalendar-1.0/calendar-setup.js"></script>
    <script language="javascript" src="reporteExpedientes_js.js" ></script>-->
</head>
<body class="body">
    <div class="container">
        <br />
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Asignación de Expediente a Agente</h3></div>
            <form name="form1" action="accionesfuncionario.php" method="post" class="form-horizontal">
                <div class="panel-body">
                    <?php
                    if(isset($_GET['expe'])) {
                        $nro=$_GET['expe'];
                        //echo $nro;
                        if($nro) {  //echo $nro;
                            $sql="select * from expedientes where id_expediente = '".$nro."';";
                            $res=mysql_query($sql)or die($sql);
                            if($expe=mysql_fetch_array($res)) {
                                $habilitar = 1;
                                ?>
                                <div class="form-group">
                                    <label for="caratula" class="col-sm-3 control-label">Nro Expediente</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" disabled="true" value="<?php echo $expe["nro_expediente"] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="caratula" class="col-sm-3 control-label">Iniciador</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="form-control" disabled="true" value="<?php echo BuscarNombre($expe['id_iniciador']) ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="folio" class="col-sm-3 control-label">Nro. Folio</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="folio" class="form-control" disabled="true" value="<?php echo $expe['n_folio'] ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fecha" class="col-sm-3 control-label">Fecha</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="fecha" class="form-control" disabled="true" value="<?php echo invertirFecha($expe['fecha']) ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fecha_entr" class="col-sm-3 control-label">Fecha Entrada</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="fecha_entr" class="form-control" disabled="true" value="<?php echo invertirFecha($expe['fecha_entrada']) ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cart_exp" class="col-sm-3 control-label">Carátula del Expediente</label>
                                    <div class="col-sm-9">
                                        <textarea name="cart_exp" rows="6" class="form-control" disabled="true"><?php echo $expe['caratula'];?></textarea>
                                    </div>
                                </div>

                                <?php
                                $sql2="select id_defen from registrodefensor, defensor where (defensor.id_defensor= registrodefensor.id_defen) and (registrodefensor.estado = 'A') and (registrodefensor.id_expediente='".$expe[0]."') ";
                                $res2=mysql_query($sql2)or die($sql2);
                                if($row2=mysql_fetch_array($res2)) {
                                    //echo" row: ".$row2[0];
                                    $sql3="select * from defensor where id_defensor = '".$row2[0]."'";
                                    $res3=mysql_query($sql3)or die($sql3);


                                    echo '<div class="form-group">';
                                    if( $row3=mysql_fetch_array($res3)) {
                                		echo '<label for="asignadoa" class="col-sm-3 control-label">Expediente Asignado a Funcionario</label>';
                                        echo '<div class="col-sm-3">';
                                        echo '<input name="asignadoa" class="form-control" value="'.$row3[2].' '.$row3[1].'" disabled="true" />';
                                        echo '</div>';
                                	}
                                	else
                                	{
                                        echo '<div class="form-group"><label class="col-sm-12">Elexpediente No está asignado</label></div>';
                                    }
                                    echo "</div>";
	                           }

	                        } else { // end if(expe=...)
                                echo '<div class="form-group"><label class="col-sm-12">No se Encuentra ningún Expediente con Nro: '.$nro.'</label></div>';
                            }
                        } // end if(nro)
                    } // end if(isset($_GET[expe]))
	                ?>

                    <?php
                    if(isset($habilitar)) {
                    ?>

                        <div class="form-group">
                            <label for="defen" class="control-label col-sm-3">Usuario</label>
                            <div class="col-sm-3">
                                <select name="defen" id="defen" onchange="cant.disabled = false ; cant.focus();" class="select form-control" >
                                    <option value="0" division="" selected>Seleccione Usuario</option>
                                    <?php
                                    $cons = " SELECT * FROM usuarios order by nombre_real ";
                                    $result = mysql_query($cons) or die(mysql_error());
                                    echo $result;
                                    while($option = mysql_fetch_row($result)) {
                                        echo" <option value=\" ". $option[0]."\" >".$option[2]."  </option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cant" class="control-label col-sm-3">Nro. de Folios</label>
                            <div class="col-sm-3">
                                <input type="text" name="cant" id="cant" class="select form-control" />
                            </div>
                        </div>

                    	<div class="form-group">
                            <label for="fechas" class="control-label col-sm-3">Fecha de Asignación</label>
                        	<div class="col-sm-3">
                        	   <input type="date" name="fechas" id="fechas"  value="<?php echo date("d-m-Y");?>" class="form-control"  />
                            	<script type="text/javascript" >


                                    window.onload = function() {
                                        Calendar.setup({
                                            inputField: "fechas",
                                            ifFormat:   "%d-%m-%Y",
                                            button:     "selector"
                                        });
                                    }
                                </script>
                        	</div>
                    	</div>

                        <div class="form-group">
                            <label for="obstext" class="control-label col-sm-3">Observación</label>
                            <div class="col-sm-9">
                                <textarea name="obstext" id="obstext" rows="10" class="form-control"></textarea>
                            </div>
                        </div>

                    <?php
                    }
                    ?>
                </div> <!-- end .panel-body -->
                <div class="panel-footer">
                    <?php
                    if(isset($habilitar)) {
                    ?>
                	<center>
                        <input type="hidden" name="idExp" id="idExp" value="<?php echo $expe[0] ?>" />
                        <input type="hidden" name="oper" id="oper" value="a" />
                        <button type="button" name="asignar" id="asignar" value="Asignar"  class="btn btn-primary" onclick="validarUsu()"  /><span class='glyphicon glyphicon-refresh'></span>Asignar</button>
                        <button type="reset" class="btn btn-primary"><span class='glyphicon glyphicon-refresh'></span> Limpiar</button>
                    </center>
                    <?php
                    }
                    ?>
               </div><!-- end .panel-footer -->
           </form>
       </div><!-- end .panel-default -->
   </div><!-- endo .conteiner -->

</body>

<?php
function invertirFecha($valor) {
    $valor = explode("-",$valor);
    $valor = $valor[2]."-".$valor[1]."-".$valor[0];
    return $valor;
}

function BuscarNombre($valor) {
    $sql = "Select Nombre, Apellido from iniciador where dni='".$valor."'" ;
    $resu = mysql_query($sql)or (die(mysql_error()));
    $row = mysql_fetch_array($resu);
    return $row['Apellido']." ".$row['Nombre'];
}
?>

<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script language="javascript">
    function setform()
    {
        document.form1.fechas=null;
        focument.form1.cant.value=null;
    }
</script>

<script>
    function validarUsu()
	{
        if(document.form1.cant.value =="")
		{
            alert("N�mero de folio incorrecto.");
            document.form1.cant.focus();
            return ;
		}
        if(document.form1.cant.fechas =="")
        {
            alert("Fecha de asignacion no valida.");
            document.form1.fechas.focus();
            return ;
        }
        document.form1.action="accionesfuncionario.php";
        document.form1.submit();
    }
</script>

</html>
