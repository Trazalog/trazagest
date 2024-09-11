<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

if(isset($_GET["idofic"])) {
    //buscamos el registro
    $ofic     = $_GET["idofic"];
    $consulta = "SELECT
        C.numero_expediente,
        C.detalle_cedula,
        C.expediente_destino,
        C.datos,
        C.id_oficio,
        C.copias,
        C.plazo,
        C.nuemro_folio AS folio,
        C.fecha_entrada,
        C.fecha_profesional,
        C.fecha_notificacion,
        C.fecha_devolucion,
        C.oficina,
        C.fecha
        FROM  oficio C
        WHERE C.id_oficio = $ofic";

    $res = mysql_query($consulta);
    if(mysql_num_rows($res)<= 0) {
        $habilitar = 0;
        echo "<script>alert(\"Número de oficio no valido.\");</script>";
    } else {
        $oficio    = mysql_fetch_array($res);
        $habilitar = 1;
    }
} else {
    //no buscamos el registro
    $habilitar = 0;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>Modificar Oficio</title>
    <link rel="stylesheet" href="bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugin/bootstrapvalidator/bootstrapValidator.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="summernote.css">
</head>
<body>
<div class="container">
    <br />
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Modificación de oficio</h3></div>
        <form name="cedu" id="cedu" action="guardar_cambios_oficio.php" method="post" class="form-horizontal" role="form">
            <div class="panel-body">

                <div class="form-group">
                    <?php /*echo '<pre>'; print_r($oficio); echo '</pre>';*/ ?>
                    <label for="nroexp" class="col-sm-3 control-label">Detalle de Expediente</label>
                    <div class="col-sm-4">
                        <input type="text" name="nroexp" value='Nro<?php if(isset($oficio)) echo" ".$oficio[0];?>' class="form-control" disabled="true"/>
                        <input name="exp" type="hidden" id="exp" value='<?php if(isset($oficio)) echo"  ".$oficio[0];?>'/>
                        <input name="oficio" type="hidden" id="oficio" value='<?php if(isset($oficio)) echo"  ".$oficio['id_oficio'];?>'/>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Detalle de Oficio *</label>
                    <div class="col-sm-9">
                        <textarea id="editor" name="editor" spellcheck="true">
                            <?php
                            if(isset($oficio))
                                $detalleOficio = html_entity_decode($oficio['detalle_cedula'], ENT_QUOTES, 'utf-8');
                                echo $detalleOficio;
                            ?>
                        </textarea>
                        <input name="detalle" type="hidden" id="detalle" value='' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_entrada" class="col-sm-3 control-label">Fecha *</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha_entrada" id="fecha_entrada" class="select form-control" value='<?php if(isset($oficio)) echo $oficio['fecha_entrada'];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="copias" class="col-sm-3 control-label">Copias</label>
                    <div class="col-sm-4">
                        <input type="text" name="copias" id="copias" class="select form-control" value='<?php if(isset($oficio)) echo $oficio['copias'];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="plazo" class="col-sm-3 control-label">Plazo</label>
                    <div class="col-sm-4">
                        <input type="date" name="plazo" id="plazo" class="select form-control" value='<?php if(isset($oficio)) echo $oficio['plazo'];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="folio" class="col-sm-3 control-label">Expediente Destino</label>
                    <div class="col-sm-4">
                        <input type="text" name="folio" id="folio" class="select form-control" value='<?php if(isset($oficio)) echo $oficio['folio'];?>' />
                    </div>
                </div>
                
                <hr>

                <div class="form-group">
                    <label for="fecha_not" class="col-sm-3 control-label">Fecha de Notificación</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha_not" id="fecha_not" class="select form-control" value='<?php if(isset($oficio)) echo $oficio['fecha_notificacion'];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_dev" class="col-sm-3 control-label">Fecha de Devolución</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha_dev" id="fecha_dev" class="select form-control" value='<?php if(isset($oficio)) echo $oficio['fecha_devolucion'];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_prof" class="col-sm-3 control-label">Fecha a Profesional</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha_prof" id="fecha_prof" class="select form-control" value='<?php if(isset($oficio)) echo $oficio[9];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_entre" class="col-sm-3 control-label">Fecha Entrega</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha_entre" id="fecha_entre" class="select form-control" value='<?php if(isset($oficio)) echo $oficio['fecha'];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="oficina" class="col-sm-3 control-label">Oficina</label>
                    <div class="col-sm-4">
                        <input type="text" name="oficina" id="oficina" class="select form-control" value='<?php if(isset($oficio)) echo $oficio['oficina'];?>' />
                    </div>
                </div>

            </div><!-- Fin .panel-body -->
            <div class="panel-footer">
                <center>
                    <!--<button type="button" name="prin" class="btn btn-primary" onclick="principal()"><span class='glyphicon glyphicon-home'></span> Principal</button>-->
                    <button type="button" name="princ" id="princ" onclick="window.open('','_self').close();" class="btn btn-primary">Cerrar</button>
                    <button type="button" name="modif" onclick="validar()" class="btn btn-primary">Guardar</button>
                </center>
            </div><!-- Fin .panel-footer -->

        </form>

    </div><!-- Fin .panel -->
</div><!-- Fin .container -->
</body>

<script src="js/jquery-1.11.3.min.js"></script>
<script src="bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="plugin/bootstrapvalidator/bootstrapValidator.min.js"></script>
<script src="summernote.min.js"></script>
<script src="lang/summernote-es-ES.js"></script>
<script>
$(document).ready(function() {
    //$('#editor, #editor2').summernote();
    $('#editor').summernote();
    $('.note-editable').css("height","200");

    // valido datos 
    $('#cedu')
    .bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            fecha_entrada: {
                validators: {
                    notEmpty: {
                        message: 'Ingrese la fecha de entrada de la Cédula.'
                    }
                }
            },
            editor: {
                validators: {
                    callback: {
                        message: 'Detalle de Cédula no puede estar vacío.',
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
        //console.log('Form successfully validated.');
        var edi = $("#editor").parent('div').find('.note-editable').html();
        $("#detalle").val(edi);
        document.cedu.submit();
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
        $('#cedu').bootstrapValidator('revalidateField', 'editor');
    });

});
</script>

<script>
    function principal()
    {
        location.href="./principal.php";
    }

    function validar()
    {
        var edi = $("#editor").parent('div').find('.note-editable').html();
        console.log(edi);
        $("#detalle").val(edi);

        var ed = $( "#editor2" ).parent('div').find('.note-editable').html();
        console.log(ed);
        $("#datos").val(ed);
        document.cedu.submit();
    }
</script>

</html>
