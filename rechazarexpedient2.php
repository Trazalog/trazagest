<?php
include("conexion.php");
$link= new conexion();
$link->conectarse();
$nro=$_GET["mov"];

//Buscar id estado Ingresado
$sql = "select id_estado from estados Where descripcion = 'Ingresado' Limit 0,1";
$resu = mysql_query($sql);
$row = mysql_fetch_array($resu);
$id_ingresado = $row['id_estado'];

//Buscar id estado Ingresado
$sql = "select id_estado from estados Where descripcion = 'Asignado' Limit 0,1";
$resu = mysql_query($sql);
$row = mysql_fetch_array($resu);
$id_asignado = $row['id_estado'];

$sql="select * from expedientes where id_expediente='".$nro."' and ( id_estado = ".$id_ingresado." or id_estado = ".$id_asignado." )";
$res=mysql_query($sql)or die($sql);
$expe=mysql_fetch_array($res);
if(mysql_num_rows($res)>0) {
    $habilitar = 1;
} else {
    $sql="select * from expedientes where id_expediente = '".$nro."' and id_estado != ".$row['id_estado']."";
    $res=mysql_query($sql)or die($sql);
    $expe=mysql_fetch_array($res);

    if(mysql_num_rows($res)>0) {
        echo "<script>alert(\"El estado actual del espediente no permite dar un estado final.\");</script>";
    } else {
        echo "<script>alert(\"Número de expediente no válido.\");</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>Estado Final</title>
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">
    <link href="summernote.css" rel="stylesheet">
    <link href="css/font-awesome.min.css">
</head>
<body>
<div class="container">
    <br />
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Estado Final</h3></div>
        <form name="form2" action="acciones.php" method="post" id="form2" class="form-horizontal" role="form">
            <div class="panel-body">

                <?php
                if(isset($habilitar)) {
                ?>

                    <h5>Datos Expedientes</h5>

                    <div class="form-group">
                        <label for="nroexpe" class="col-sm-3 control-label">Número Expediente</label>
                        <div class="col-sm-4">
                            <input type="text" name="nroexpe" id="nroexpe" class="select form-control" value='<?php echo $expe['nro_expediente'];?>' disabled="true" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="iniciador" class="col-sm-3 control-label">Iniciador</label>
                        <div class="col-sm-4">
                            <?php
                            $sqll = "Select Nombre, Apellido from iniciador Where dni = '".$expe['id_iniciador']."'";
                            $resuu = mysql_query($sqll)or(die(mysql_error()));
                            $roww = mysql_fetch_array($resuu);
                            $iniciador = $roww['Nombre']." ".$roww['Apellido'];
                            ?>
                            <input type="text" name="iniciador" id="iniciador" class="select form-control" value='<?php echo $iniciador;?>' disabled="true" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="nroexpe" class="col-sm-3 control-label">Fecha</label>
                        <div class="col-sm-4">
                            <input type="date" name="nroexpe" id="nroexpe" class="select form-control" value='<?php echo $expe['fecha'];?>' disabled="true" />
                            <input type="hidden" name="idExp" value="<?php echo $expe['id_expediente'];?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="caratula" class="col-sm-3 control-label">Carátula</label>
                        <div class="col-sm-9">
                            <textarea type="text" name="caratula" id="caratula" class="select form-control" value='<?php if(isset($expediente)) echo $expediente["caratula"];?>' rows="6" disabled="true"><?php echo $expe["caratula"];?></textarea>
                        </div>
                    </div>

                    <hr>

                    <h5>Estado Expediente</h5>

                    <div class="form-group">
                        <label for="fecha" class="col-sm-3 control-label">Fecha</label>
                        <div class="col-sm-4">
                            <input type="date" name="fecha" id="fecha" class="select form-control" value='<?php echo date("Y-m-d");?>' />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="radio">
                                <label class="pull-right">
                                    <input type="radio" name="cksolu" id="cksolu" value="S" <?php echo ($expe['estado_final'] == '6') ? "checked=\"checked\"":""; ?> onclick="Arriba()" />
                                    <b>Solucionado</b>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-9">&nbsp;</div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="radio">
                                <label class="pull-right">
                                    <input type="radio" name="cksolu" id="cksolu" value="U" <?php echo ($expe['id_estado'] == '9') ? "checked=\"checked\"":""; ?> onclick="Medio()" />
                                    <b>Suspendido</b>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-9">&nbsp;</div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="radio">
                                <label class="pull-right">
                                    <input type="radio" name="cksolu" id="cksolu" value="I" <?php echo ($expe['id_estado'] == '12') ? "checked=\"checked\"":""; ?> onclick="Medio()" />
                                    <b>incomparecencia</b>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-9">&nbsp;</div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="radio">
                                <label class="pull-right">
                                    <input type="radio" name="cksolu" id="cksolu" value="R" <?php echo ($expe['id_estado'] == '10') ? "checked=\"checked\"":""; ?> onclick="Abajo()"/>
                                    <b>Rechazado</b>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <select name="tpo_recha" id="tpo_recha" class="select form-control" <?php echo ($expe['id_estado'] == '10') ? "" : 'disabled=disabled'?> >
                                  <option value="F">Falta de Fundamento</option>
                                  <option value="A">Accionar Correcto</option>
                                  <option value="I">Incompetencia</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="radio">
                                <label class="pull-right">
                                    <input type="radio" name="cksolu" id="cksolu" value="O" <?php echo ($expe['id_estado'] == '12') ? "checked=\"checked\"":""; ?> onclick="Medio()" />
                                    <b>Otros</b>
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <input type="text" name="otro" id="otro" class="form-control" value="" />
                        </div>
                    </div>

                <?php
                }
                ?>
            </div><!-- fin .panel-body -->
            <div class="panel-footer">
                <center>
                  <input type="hidden" name="oper" id="oper" value="r" />
                    <button type="button" name="princ" id="princ" onclick="window.open('','_self').close();" class="btn btn-primary">Cerrar</button>
                    <button type="button" name="rechazar" id="rechazar" onclick="recha();" class="btn btn-primary">Guardar</button>
                </center>
            </div><!-- Fin .panel-footer -->
         </div><!-- Fin .panel-footer -->

        </form>

    </div><!-- Fin .panel -->
</div><!-- Fin .container -->

</body>

<?php
function invertirFecha($date) {
    $arre = explode('-',$date);
    return $arre[2].'-'.$arre[1].'-'.$arre[0];
}
?>

<script type="text/javascript" src="abm_iniciador_js.js"></script>
<script type="text/javascript" src="validacionesDeEntrada.js"></script>

<script language="javascript">
    function recha()
    {
        document.form2.action = "acciones.php";
        document.form2.submit();

    }

    function busqueda(valor)
    {
        document.form2.action = "rechazarexpedient2.php?nroExp="+valor;
        document.form2.submit();
    }

    function Arriba()
	{
		document.getElementById('cksolu').value = 'S';
		Ocultar();
	}

    function Medio()
	{
		document.getElementById('cksolu').value = 'U';
		Ocultar();
	}

    function Abajo()
	{
		document.getElementById('cksolu').value = 'R';
		Ocultar();
	}

    function Ocultar()
	{
		if(document.getElementById('cksolu').value == 'R')
		{
			//habilitar combo
			document.getElementById('tpo_recha').disabled = false;
		}
		else
		{
			//deshabilitar combo
			document.getElementById('tpo_recha').disabled = true;
		}
	}
</script>

</html>
