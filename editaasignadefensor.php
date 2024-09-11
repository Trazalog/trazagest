<?php
include("conexion.php");
$link= new conexion();
$link->conectarse();








?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Asignación de Expediente a Defensor</title>
    <link rel="shortcut icon" type="image/x-icon" href="assest/plugins/buttons/icons/folder.png" />
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">

    <!--<link rel="stylesheet"  href="estilo.css" type="text/css" media="all" />
    <link type="text/css" rel="stylesheet" href="assets/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
    <SCRIPT type="text/javascript" src="assets/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script><link type="text/css" rel="stylesheet" href="assets/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"></link>
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
            <div class="panel-heading"><h3 class="panel-title">Asignación de Expediente a Defensor</h3></div><!-- action="altavincula_php.php" onSubmit="renctype="multipart/form-data"
            action="acciones.php"-->
            <form name="form1"  method="post"   type="multipart/form-data" class="form-horizontal"   onsubmit="return validar(this)" > <!-- action="guardar_cambios_def.php"  onSubmit="renturn validar()"-->
                <div class="panel-body">
                    <?php
                    //$nro=$_POST['buscatx'];
                    $nro=$_GET['mov'];
                    //echo $nro;
                    if($nro) {  //echo $nro;
                        $sql="select * from registrodefensor where id_reg = '".$nro."';";
                        $res=mysql_query($sql)or die($sql);
                        if($expe=mysql_fetch_array($res)) {
                            $habilitar = 1;
                        } else {
                            echo '<div class="form-group"><label class="col-sm-12">No se Encuentra ningun Expediente con Nro: '.$nro.'</label></div>';
                        }
                    }

                    $cons = "SELECT registrodefensor.id_defen, defensor.apellido 
                    FROM registrodefensor  
                    JOIN defensor  ON defensor.id_defensor=registrodefensor.id_defen
                    WHERE registrodefensor.id_reg='".$nro."'; ";
                    $result = mysql_query($cons);
                                                            
                    $option = mysql_fetch_array($result);


                    ?>

                    <?php
                    if(isset($habilitar)) {
                    ?>
                        <input type="hidden" name="mov" id="oper" value="<?php echo $expe['id_reg'] ?>"/>

                        <div class="form-group">
                            <label for="caratula" class="col-sm-3 control-label">Usuario</label>
                            <div class="col-sm-3">
                            <input type="hidden" name="usu1" id="usu1" value="<?php echo $option['id_defen'] ?>" disabled="true" >

                            

                            <select name="usu" id="usu" onchange="cant.disabled = false ; cant.focus();" class="select form-control" >
                            <option value="<?php echo $option['id_defen'] ?>" division="" selected><?php echo $option['apellido'] ?></option>";
                                    <?php
                                    $cons = " SELECT id_usuario, nombre_real FROM usuarios order by nombre_real ";
                                    $result = mysql_query($cons) or die(mysql_error());
                                    //echo $result;
                                    while($option = mysql_fetch_row($result)) {
                                        echo" <option value=\" ". $option[0]."\" >".$option[1]."  </option>";
                                    }
                                    ?>
                                </select>
                              
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-3">Nro de Folios</label>
                            <div class="col-sm-3">
                                
                                <input type="text" name="nrofolio" id="nrofolio" class="select form-control" value="<?php echo $expe['folios'] ?>" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-xs-3">Fecha de Asignación</label>
                            
                            <div class="col-xs-3">
                            
                             <input type="date" name="fechas" id="fechas" class="select form-control" value="<?php echo $expe['fecha'] ?>"/>
                               <!-- <?php //echo "<div class='form-control' disabled='true'>".$expe['fecha']."</div>" ;?>-->
                            </div>
                          <!--  <div class="col-xs-3">
                                <input type="date" name="fechas" class="select form-control" >
                            </div>-->
                        </div>

                    <?php
                    }
                    ?>
                </div>
                <div class="panel-footer">
                    <?php
                    if(isset($habilitar)) {
                    ?>
                        <center>
                            <input type="hidden" name="idExp" id="idExp" value="<?php echo $expe[0] ?>" />
                            <input type="hidden" name="oper" id="oper" value="a" />
                           <button type="submit" name="guar" class="btn btn-primary"><span class='glyphicon glyphicon-floppy-disk'></span> Guardar</button>
                          <!--<button type="button" name="guar" class="btn btn-primary" onclick="guardar" ><span class='glyphicon glyphicon-floppy-disk'></span> Guardar</button>-->
                            <button type="reset" class="btn btn-primary"><span class='glyphicon glyphicon-refresh'></span> Limpiar</button>
                        </center>
                    <?php
                    }
                    ?>
                </div>
            </form>
        </div>
    </div>
</body>

<?php
function invertirFecha($valor){
	$valor = explode("-",$valor);
	$valor = $valor[2]."-".$valor[1]."-".$valor[0];
	return $valor;
}

function BuscarNombre($valor){
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

    function guardar(nro){
        if( nro != "")
        {
         document.cedu.action = "acciones.php?nro="+nro;/*"ValidarNumeroExpediente.php?nroExp="+valor+"&iniciador="+document.formexp.iniciador.value;*/
         document.cedu.submit();
        }
    }
 
 
</script>

<script>
/*  function validar()
	{
	    if(document.form1.nrofolio.value =="")
		{
		    alert("N�mero de folio incorrecto.");
		    document.form1.nrofolio.focus();
		    return ;
		}
	    if(document.form1.fechas.value =="")
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
	   // document.form1.action="guardar_cambios_def.php";
	   // document.form1.submit();
	}*/

    function validar()
    {      //alert('entra');
    //if (form.usu.options[form.usu.selectedIndex].value !=0)
      if(document.getElementById('usu').value =="")
        {
            alert("Seleccione usuario antes de guardar");
        }
        else
        {
            //grabar
            //document.getElementById('oper').value = "g";
           // document.listado.submit();
            alert ("Edicion guardada");
            document.form1.action="guardar_cambios_def.php";
        }
         
    }
</script>