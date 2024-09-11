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
        <br>
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Asignación de Expediente a Agente</h3></div>
            <form name="form1" id="form1" class="form-horizontal" action="guardar_cambios_movimiento.php" method="post" onSubmit="renturn validarUsu()">
                <div class="panel-body">
                <br />
                <?php
                //$nro=$_POST['buscatx'];
                $nro=$_GET['mov'];
                //echo $nro;
                if($nro) {  //echo $nro;
                    $sql="select * from registro_movimiento where id_mov = '".$nro."';";
                    $res=mysql_query($sql)or die($sql);
                    if($expe=mysql_fetch_array($res)) {
                        $habilitar = 1;
                    } else {
                        echo '<div class="form-group"><label class="col-sm-12">No se Encuentra ningún Expediente con Nro: '.$nro.'</label></div>';
                    }
                }


                 $cons = "SELECT usuarios.nombre_real,usuarios.id_usuario
                    FROM usuarios 
                    JOIN registro_movimiento  ON registro_movimiento.id_usuario=usuarios.id_usuario
                    WHERE registro_movimiento.id_mov='".$nro."'; ";
                    $result = mysql_query($cons);
                                                            
                    $movim = mysql_fetch_array($result);

                ?>
                <?php
                if(isset($habilitar)) {
                ?>
                    <input type="hidden" name="mov" id="oper" value="<?php echo $expe['id_mov'] ?>"/>
                    <div class="form-group">
                        <label for="defen" class="control-label col-sm-3">Usuario</label>
                        <div class="col-sm-3">
                             <input type="hidden" name="defen" id="defen" value="<?php echo $movim['id_usuario'] ?>" disabled="true" >
                            <!--no esta guardando el id de usuario -->
                           <!--  <input type="text" class="select form-control" id="usu"   value="<?php //echo $option['nombre_real'] ?>" disabled="true" >-->
                             <select name="usu" id="usu"  class="select form-control" >
                             <option value="<?php echo $movim['id_usuario'] ?>"><?php echo $movim["nombre_real"];?></option>
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
                            <input type="text" name="cant" id="cant" class="select form-control" value="<?php echo $expe['folios'] ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="fechas" class="control-label col-sm-3">Fecha de Asignación</label>
                        <div class="col-sm-3">
                            <input type="date" name="fechas" id="fechas" value="<?php echo $expe['fecha'] ?>" class="form-control"  />
                            <!--<script type="text/javascript" >
                                window.onload = function() {
                                    Calendar.setup({
                                        inputField: "fechas",
                                        ifFormat:   "%d-%m-%Y",
                                        button:     "selector"
                                    });
                                }
                            </script>-->
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="obstext" class="control-label col-sm-3">Observación</label>
                        <div class="col-sm-9">
                            <textarea name="obstext" rows="10" class="form-control" value='<?php if(isset($expe)) echo"  ".$expe['observaciones'] ?>' ><?php if(isset($expe)) echo"  ".$expe['observaciones'];?></textarea>
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
                        <input type="submit" name="guar" value="Guardar"  class="btn btn-primary" />
                        <button type="reset" class="btn btn-primary"><span class='glyphicon glyphicon-refresh'></span> Limpiar</button>
                    </center>
                    <?php
                    }
                    ?>
               </div><!-- end .panel-footer -->
            </form>
        </div><!-- end .panel-default -->
   </div><!-- endo .container -->

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

        if(document.form1.usu.value == "")
        {
            alert("Por favor seleccione usuario.");
            document.form1.usu.focus();
            return ;
        }


    	if(document.form1.cant.value =="")
    	{
    		alert("Número de folio incorrecto.");
    		document.form1.cant.focus();
    		return ;
    	}
    	if(document.form1.cant.fechas =="")
    	{
    		alert("Fecha de asignacion no valida.");
    		document.form1.fechas.focus();
    		return ;
    	}
        if(document.form1.usu.value >0)
        {
            alert("Por favor seleccione usuario.");
            document.form1.usu.focus();
            return ;
        }
    	document.form1.action="accionesfuncionario.php";
    	document.form1.submit();
    }
</script>

</html>
