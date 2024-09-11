<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

if(isset($_GET['nroExp'])) {
	$nro=$_GET['nroExp'];
	$sql="select * from expedientes where id_expediente='".$nro."';";
	$res=mysql_query($sql)or die($sql);
	$expe=mysql_fetch_array($res);
}
if(isset($_GET["habilitar"])) {
	$cadena = "desabilitar()"; //esto esta al pedo parece !!
} else {
	$cadena = "noha()";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>trazagest</title>
    <link rel="shortcut icon" type="image/x-icon" href="assest/plugins/buttons/icons/folder.png" />
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <br />
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Asignación de Expediente a Funcionario</h3></div>
        <form name="form1" id="form1" class="form-horizontal" action="acciones.php" method="post">
            <div class="panel-body">

                <div class="form-group">
                    <label for="expe" class="col-sm-3 control-label">Nro Expediente</label>
                    <div class="col-sm-4">
                        <input name="expe" type="text" class="form-control" disabled="true" placeholder="<?php if(isset($expe)) echo"  ".$expe['nro_expediente'];?>" />
                        <input name="expediente" type="hidden" id="expediente" class="form-control" value='<?php if(isset($expe)) echo"  ".$expe['nro_expediente'];?>' size="20"/>
                    </div>
                </div>
                <div class="form-group">
           	        <label for="inicia" class="control-label col-sm-3">Iniciador</label>
                    <div class="col-sm-4">
                        <?php if(isset($expe)) {
							$sqll = "Select I.Nombre, I.Apellido from iniciador I join expedientes E  Where I.dni=E.id_iniciador and E.id_expediente=$nro";
							$resuu = mysql_query($sqll)or(die(mysql_error()));
							$roww = mysql_fetch_array($resuu);
							echo '<input name="inicia" type="text" class="form-control" disabled="true" placeholder="'.$roww["Nombre"].' '.$roww["Apellido"].'" />';
						}
						?>

	                   	<input name="iniciador" type="hidden" id="iniciador" value='
                            <?php if(isset($expe)) {
							    $sqll = "Select I.Nombre, I.Apellido from iniciador I join expedientes E  Where I.dni=E.id_iniciador";
                                $resuu = mysql_query($sqll)or(die(mysql_error()));
                                $roww = mysql_fetch_array($resuu);
                                echo $roww["Nombre"]." ".$roww["Apellido"];
                                }
                            ?>' />
		            </div>
		        </div>

                <!--
                estado del archivo (archivado / desarchivado )
                -->
                <input type="hidden" name="estado" value="<?php echo $expe[''];?>">
                <!--
                -->

                <div class="form-group">
                    <label for="fecha" class="control-label col-sm-3">Fecha</label>
                    <div class="col-sm-4">
                        <input name="fecha" type="date" class="form-control" disabled="true" value="<?php echo $expe['fecha'] ?>"  placeholder>
                    </div>
                </div>

                <div class="form-group">
       	            <label for="fechaent" class="control-label col-sm-3">Fecha Entrada</label>
                    <div class="col-sm-4">
                        <input name="fecha" type="date" class="form-control" disabled="true"  value="<?php echo $expe['fecha_entrada'] ?>" placeholder>
                    </div>
                </div>

                <div class="form-group">
                    <?php
                    //echo"".$expe[0];
                    if(isset($expe)) {
                        $sql2="select id_defen from registrodefensor , defensor where (defensor.id_defensor= registrodefensor.id_defen) and (registrodefensor.estado = 'A') and (registrodefensor.id_expediente= $expe[0]) ";
                        $res2=mysql_query($sql2)or die($sql2);
                        if($row2=mysql_fetch_array($res2)) {
                            $sql3="select * from defensor where id_defensor = ".$row2[0];
                            $res3=mysql_query($sql3)or die($sql3);
                            //echo"<tr class=\"titulo_tabla\">";
                            if( $row3=mysql_fetch_array($res3)){
                                echo '<label for="fechaent" class="control-label col-sm-3">Expediente Asignado a Funcinario</label>';
                                echo '<div class="col-sm-9">';
                                echo '<input name="fecha" type="text" class="form-control" disabled="true" placeholder="'.$row3[2].' '.$row3[1].'">';
                                echo '</div>';
                            }else {
                                echo '<label for="fechaent" class="control-label col-sm-12">Expediente No esta asignado</label>';
                            }
                        }
                    }
                    ?>
                </div>

                <div class="form-group">
                    <label for="contenido" class="col-sm-3 control-label">Contenido</label>
                    <div class="col-sm-9">
                        <textarea name="caratula" class="form-control" rows="10"><?php if(isset($expe)) echo"".$expe['caratula'];?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="defen" class="control-label col-sm-3">Defensor</label>
                    <div class="col-sm-4">
                        <select name="defen" id="defen" class="select form-control">
                            <option value="0" division="" selected>Seleccione Defensor</option>
                            <?php
                            $cons = " SELECT * FROM defensor order by apellido";
                            $result = mysql_query($cons) or die($cons);
                            echo $result;
                            while($option = mysql_fetch_row($result)) {
                                echo" <option value=\" ". $option[0]."\" >".$option[2]."  ".$option[1]." </option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="cant" class="control-label col-sm-3">Nro de Folios</label>
                    <div class="col-sm-4">
                        <input type="text" name="cant" class="select form-control" onKeyUp="numerico(cant)" maxlength="10"/>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fechas" class="control-label col-sm-3">Fecha de Asignacion</label>
                    <div class="col-sm-4">
                        <input type="date" name="fechas" class="select form-control" >
                    </div>
                </div>

                <input type="hidden" name="idExp" id="idExp" value="<?php echo $expe[0] ?>" />
                <input type="hidden" name="oper" id="oper" value="a" />

            </div>
            <div class="panel-footer">
                <center>
                    <!--<input type="hidden" name="oper" id="oper" value="a" />-->
                    <button type="button" id="volver" onclick="principal()" class="btn btn-primary"><span class='glyphicon glyphicon-home'></span> Principal</button>
                    <button type="button" id="asignar" onclick="validaAsignacion()" class="btn btn-primary">Asignar</button>
                    <button type="reset" class="btn btn-primary"><span class='glyphicon glyphicon-refresh'></span> Limpiar</button>
                </center>
            </div>

        </form>
    </div>
</div>

</body>
</html>
<?php
/*function invertirFecha($valor)
	{
	 $var = explode('-',$valor);
	 $var = $var[2].'-'.$var[1].'-'.$var[0];
	 return $var;
	}*/
	function invertirFecha($valor)
    {
        $arre = explode('-',$valor);

        return $arre[2].'-'.$arre[1].'-'.$arre[0];
    }

function BuscarNombre($valor)
{
    $sql = "Select Nombre, Apellido from iniciador where dni='".$valor."'" ;
    $resu = mysql_query($sql)or (die(mysql_error()));

    $row = mysql_fetch_array($resu);

    return $row['Apellido']." ".$row['Nombre'];
}
?>

<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type="text/javascript">
    function setform()
    {
      document.form1.fechas=null;
      focument.form1.cant.value=null;
    }
    function Busqueda(valor)
    {
        if( valor != "")
        {
         document.form1.action = "BuscarExpediente.php?nroExp="+valor;/*"ValidarNumeroExpediente.php?nroExp="+valor+"&iniciador="+document.formexp.iniciador.value;*/
         document.form1.submit();
        }
    }
</script>

<script>
    function principal()
	{
	    location.href="./principal.php";
	}

    function Nuevo()
	{
	    aler("noha");
	}

    function validaAsignacion()
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
    	document.form1.action="acciones.php";
    	document.form1.submit();
    }
</script>