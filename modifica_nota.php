<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

if(isset($_GET["idnot"])) {
    //buscamos el registro
    $not = $_GET["idnot"];
    $consulta = "Select
            N.id_nota,
            N.numero_expediente,
            N.detalle_cedula,
            N.fecha_entrada,
            N.copias,
            N.oficina,
            N.fecha_notificacion,
            N.expedinte_destino
        from  notas N
        where N.id_nota = $not";

    $res=mysql_query($consulta);
    if(mysql_num_rows($res)<= 0) {
        $habilitar = 0;
        echo "<script>alert(\"Numero devnota no valido.\");</script>";
    } else {
        $nota=mysql_fetch_array($res);
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
    <title>Modificar Nota</title>
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
        <div class="panel-heading"><h3 class="panel-title">Modificación de nota</h3></div>
        <form name="rem" id="rem" action="guardar_cambios_nota.php" method="post" class="form-horizontal" role="form">
            <div class="panel-body">

                <div class="form-group">
                    <label for="nroexp" class="col-sm-3 control-label">Detalle de Expediente</label>
                    <div class="col-sm-4">
                        <input type="text" name="nroexp" value='Nro<?php if(isset($nota)) echo" ".$nota["numero_expediente"];?>' class="form-control" disabled="true"/>
                        <input name="expediente" type="hidden" id="expediente" value='<?php if(isset($nota)) echo"  ".$nota["numero_expediente"];?>'/>
                        <input name="nota" type="hidden" id="nota" value='<?php if(isset($nota)) echo"  ".$nota["id_nota"];?>'/>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Detalle de Nota *</label>
                    <div class="col-sm-9">
                        <textarea id="editor" name="editor" spellcheck="true">
                            <?php
                            if(isset($nota)) {
                                $detalleCedula = html_entity_decode($nota['detalle_cedula'], ENT_QUOTES, 'utf-8');
                                echo $detalleCedula; //1
                            }
                            ?>
                        </textarea>
                        <input name="detalle" type="hidden" id="detalle" value='' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_serv" class="col-sm-3 control-label">Fecha *</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha_serv" id="fecha_serv" class="select form-control" value='<?php if(isset($nota)) echo $nota['fecha_entrada'];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="copias" class="col-sm-3 control-label">Copias</label>
                    <div class="col-sm-4">
                        <input type="text" name="copias" id="copias" class="select form-control" value='<?php if(isset($nota)) echo $nota['copias'];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="oficina" class="col-sm-3 control-label">Oficina</label>
                    <div class="col-sm-4">
                        <input type="text" name="oficina" id="oficina" class="select form-control" value='<?php if(isset($nota)) echo $nota['oficina'];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_not" class="col-sm-3 control-label">Fecha de Notificación</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha_not" id="fecha_not" class="select form-control" value='<?php if(isset($nota)) echo $nota['fecha_notificacion'];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="folio" class="col-sm-3 control-label">Expediente Destino</label>
                    <div class="col-sm-4">
                        <input type="text" name="folio" id="folio" class="select form-control" value='<?php if(isset($nota)) echo $nota['expedinte_destino'];?>' />
                    </div>
                </div>

            </div><!-- fin .panel-body -->
            <div class="panel-footer">
                <center>
                    <!--<button type="button" name="prin" class="btn btn-primary" onclick="principal()"><span class='glyphicon glyphicon-home'></span> Principal</button>-->
                    <button type="button" name="princ" id="princ" onclick="window.open('','_self').close();" class="btn btn-primary">Cerrar</button>
                    <button type="button" name="modif" onclick="validar()" class="btn btn-primary">Guardar</button>
                </center>
            </div><!-- Fin .panel-footer -->
        </form>
    </div><!-- fin .panel -->
</div><!-- fin .container -->
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
    $('#rem')
    .bootstrapValidator({
        excluded: [':disabled'],
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            fecha_serv: {
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
        document.rem.submit();
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
        $('#rem').bootstrapValidator('revalidateField', 'editor');
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
        var edi=$("#editor").parent('div').find('.note-editable').html();
        console.log(edi);
        $( "#detalle" ).val(edi);

        var ed=$( "#editor2" ).parent('div').find('.note-editable').html();
        console.log(ed);
        $( "#observacion" ).val(ed);
        document.rem.submit();
    }
</script>

</html>
