<?php 
/*echo'<pre>';
print_r( $_POST );
print_r( $_GET );
echo'</pre>';*/


include("conexion.php");
$var = new conexion();
$var->conectarse();
$conec = $var->conectarse();

if(isset($_GET["idexp"])) { //nroexpe
    $nro = $_GET["idexp"];

    //Buscar id estado Asignado
    /*$sql = "select id_estado from estados Where descripcion = 'Asignado' Limit 0,1";
    $resu = mysql_query($sql);

    $row = mysql_fetch_array($resu);
    $id_asignado = $row['id_estado'];*/

    $sql  = "select * from expedientes where id_expediente='$nro'"; //and  id_estado != ".$id_ingresado."
    $res  = mysql_query($sql)or die(mysql_error());
    $expe = mysql_fetch_assoc($res);
    if(mysql_num_rows($res) > 0) {
        $consulta = "Select * From expedientespdf Where idExpediente=".$expe["id_expediente"];
        $ejecuta  = mysql_query($consulta) or die(mysql_error());

        if(mysql_num_rows($ejecuta) > 0) {
            $habilitar = 0;
            //mostrar mensaje
            echo "<script>alert(\"el expediente ya tiene cargada resolucion.\");</script>";
        } else {
            $habilitar = 1;
            //mostrar mensaje
            echo "<script>alert(\"expediente valido\");</script>";
        }
    } else {
        $habilitar = 0;
    }
}

if(isset($_POST["fecha_serv"])) {
    $idExpediente = $_POST['idexp'];

    $consulta = "SELECT COUNT(*) FROM expedientespdf WHERE idExpediente=".$_POST["idexp"];
    $ejecuta  = mysql_query($consulta) or die(mysql_error());
    $resu     = mysql_fetch_array($ejecuta);
    $cantidad = $resu[0] + 1;

    $archivo = (isset($_FILES['archivo'])) ? $_FILES['archivo'] : null;
    if ($archivo['name'] != '') {
        $extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        $extension_correcta = ($extension == 'pdf');
        if ($extension_correcta) {
            $archivo["name"]      = "exp".$idExpediente."_".md5( date("Y-m-d H:i:s")).".pdf";
            $ruta_destino_archivo = BASE_URL."/expedientesPDF/".$archivo['name'];
            $archivo_ok           = move_uploaded_file($archivo['tmp_name'], $ruta_destino_archivo);
            $archivoPDF           = $archivo["name"];
        }
        else { echo "Error: extension incorrecta";exit; }
    } else { 
        //echo "Error: no hay archivo";exit; 
        $archivoPDF = '';
    }

    $fet = $_POST['fecha_serv'];
    $nro = $_POST['nro'];
    //echo "<pre>";
    //print_r($archivoPDF);
    //echo "</pre>";
    //exit;

    $PDF = "INSERT INTO expedientespdf ( idExpediente, direccionDocumento, observacion, fecha, nro_resolucion ) values (".$idExpediente.", '".$archivoPDF."', '".$_POST["editor"]."', '".$fet."', '".$nro."' )";
    $query = mysql_query($PDF) or die(mysql_error());

    if($query == 1) {
        echo "<script>alert(\"Resolucion almacenada.\");</script>";
        //header('Location: principal.php');
        echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();</script>";
        echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();</script>";
        echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
        //header("Location:panelexpediente.php?expe=$exp");
    } else {
        echo "<script>alert(\"Se produjo un error al intentar almacenar la resolucion.\");</script>";
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
    <title>Nueva Resolución</title>
    <link rel="stylesheet" href="plugin/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugin/bootstrapvalidator/bootstrapValidator.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="summernote.css">
</head>
<body>
<div class="container">
    <br />
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Resolución de Expediente</h3></div>
        <form name="listado" id="listado" action="" method="post" class="form-horizontal" role="form" enctype="multipart/form-data">
            <div class="panel-body">
                <h4>Datos del Expediente</h4>
                <hr>

                <div class="form-group">
                    <label for="nroexp" class="col-sm-3 control-label">Nro</label>
                    <div class="col-sm-4">
                        <input type="text" name="nroexp" value='<?php if(isset($expe)) echo $expe["nro_expediente"];?>' class="form-control" disabled="true"/>
                        <input name="expediente" type="hidden" id="expediente" value='<?php if(isset($expe)) echo $expe["nro_expediente"];?>' />
                        <input  name="idexp" type="hidden" id="idexp" value='<?php echo $expe["id_expediente"];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="observa" class="col-sm-3 control-label">Carátula</label>
                    <div class="col-sm-9">
                        <textarea name="observa" rows="6" id="observa" class="form-control" value='<?php if(isset($expe)) echo"  ".$expe["caratula"];?>' disabled="true"><?php if(isset($expe)) echo $expe["caratula"];?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="iniciador" class="col-sm-3 control-label">Iniciador</label>
                    <div class="col-sm-4">
                        <?php
                        $sqll = "SELECT Nombre, Apellido FROM iniciador WHERE dni='".$expe['id_iniciador']."'";
                        $resuu = mysql_query($sqll)or(die(mysql_error()));
                        $roww = mysql_fetch_array($resuu);
                        $iniciador = $roww['Nombre']." ".$roww['Apellido'];
                        ?>
                        <input type="text" name="iniciador" id="iniciador" class="select form-control" value='<?php echo $iniciador;?>' disabled="true" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fechaentrada" class="col-sm-3 control-label">Fecha Entrada</label>
                    <div class="col-sm-4">
                        <input type="date" name="fechaentrada" id="fechaentrada" class="select form-control" value='<?php if(isset($expe)) echo $expe['fecha_entrada'];?>' disabled="true" />
                        <input type="hidden" name="fechaen" value="<?php echo $expe['fecha_entrada'];?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nroexpe" class="col-sm-3 control-label">Fecha</label>
                    <div class="col-sm-4">
                        <input type="date" name="nroexpe" id="nroexpe" class="select form-control" value='<?php echo $expe['fecha'];?>' disabled="true" />
                        <input type="hidden" name="fecha" value="<?php echo $expe['fecha'];?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nroexpe" class="col-sm-3 control-label">Número Folio</label>
                    <div class="col-sm-4">
                        <input type="text" name="nroexpe" id="nroexpe" class="select form-control" value='<?php if(isset($expe)) echo $expe['n_folio'];?>' disabled="true" />
                        <input  type="hidden" name="folio" id="folio" value='<?php if(isset($expe)) echo $expe['n_folio'];?>' />
                    </div>
                </div>

                <br>
                <h4>Detalle de Resolucion</h4>
                <hr>
                <div class="form-group">
                    <label class="col-sm-3 control-label">Observación *</label>
                    <div class="col-sm-9">
                        <textarea id="editor" name="editor" spellcheck="true"></textarea>
                        <!--<input name="observaciones" type="hidden" id="observaciones" value="" />-->
                    </div>
                </div>

                <div class="form-group">
                    <label for="nro" class="col-sm-3 control-label">Nro *</label>
                    <div class="col-sm-4">
                        <input type="text" name="nro" id="nro" class="select form-control" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_serv" class="col-sm-3 control-label">Fecha *</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha_serv" id="fecha_serv" class="select form-control" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="plazo" class="col-sm-3 control-label">Archivo PDF *</label>
                    <div class="col-sm-9">
                        <input type="file" class="form-control" name="archivo" id="archivo" placeholder="Ubicación archivo PDF" >
                    </div>
                </div>

            </div><!-- Fin .panel-body -->
            <div class="panel-footer">
                <center>
                    <!--<button type="button" name="princ" id="princ" class="btn btn-primary" onclick="document.listado.action='principal.php'; document.listado.submit();"><span class='glyphicon glyphicon-home'></span> Principal</button>-->
                    <button type="button" name="princ" id="princ" onclick="window.open('','_self').close();" class="btn btn-primary">Cerrar</button>
                    <button type="submit" name="rechazar" id="rechazar" class="btn btn-primary">Guardar</button>
                </center>
            </div><!-- Fin .panel-footer -->

        </form>

    </div><!-- Fin .panel -->
</div><!-- Fin .container -->
</body>

<?php
function invertirfecha($f) {
    $datos   = explode("-",$f);
    $fecha[] = $datos[0];
    $fecha[] = $datos[1];
    $fecha[] = $datos[2];
    $total   = $fecha[2]."-".$fecha[1]."-".$fecha[0];
    return $total;
}
?>

<script src="js/jquery-1.11.3.min.js"></script>
<script src="plugin/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="plugin/bootstrapvalidator/bootstrapValidator.min.js"></script>
<script src="summernote.min.js"></script>
<script src="lang/summernote-es-ES.js"></script>
<script>
$(document).ready(function() {
    $('#editor').summernote();
    $('.note-editable').css("height","180");

        // valido datos 
    $('#listado')
    .bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            archivo: {
                validators: {
                    file: {
                        extension: 'pdf',
                        type: 'application/pdf',
                        message: 'Solo puede cargar un archivo pdf.'
                    },
                    /*notEmpty: {
                        message: 'Debe cargar un archivo.'
                    }*/
                }
            },
            fecha_serv: {
                validators: {
                    notEmpty: {
                        message: 'Ingrese la fecha.'
                    }
                }
            },
            nro: {
                validators: {
                    notEmpty: {
                        message: 'Ingrese Nro de resolución.'
                    },
                    remote: {
                        url: 'checkNroResoluc.php',
                        type:'POST',
                        delay: 500,
                        message: 'La resolución ya existe.'
                    }
                }
            },
            editor: {
                validators: {
                    callback: {
                        message: 'El campo Observación no puede estar vacío.',
                        callback: function(value, validator, $field) {
                            var hayTexto = $('#editor').summernote('isEmpty');
                            return !hayTexto;
                        }
                    }
                }
            }
        }
    }).on('success.form.bv', function(e) {
        e.preventDefault();
        document.listado.submit();
    });

    // onChange callback
    $('#editor').summernote({
        callbacks: {
            onChange: function(contents, $editable) {
                console.log('onChange:', contents, $editable);
            }
        }
    });
    // summernote.change
    $('#editor').on('summernote.change', function(we, contents, $editable) {
        // Revalida el contenido cuando cambia el texto del editor Summernote
        $('#listado').bootstrapValidator('revalidateField', 'editor');
    });
});
</script>

<script>
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

    function validaAsignacion()
    {
        document.listado.submit();
    }
</script>

</html>