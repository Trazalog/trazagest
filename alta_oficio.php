<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

if(isset($_GET["idexp"]))
{
    //buscamos el registro
    $exp      = $_GET["idexp"];
    $consulta = "Select * from expedientes where id_expediente = $exp";
    $res      = mysql_query($consulta);
    if(mysql_num_rows($res)<= 0)
    {
        $habilitar = 0;
        echo "<script>alert(\"Número de expediente no valido.\");</script>";
    } else {
        $expediente = mysql_fetch_array($res);
        $habilitar  = 1;
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
    <title>Nuevo Oficio</title>
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
        <div class="panel-heading">
            <h3 class="panel-title">Nuevo Oficio</h3>
        </div>
        <form name="ofi" id="ofi" action="alta_oficio_php.php" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">
            <div class="panel-body">
                <h4>Datos del Expediente</h4>
                <div class="form-group">
                    <label for="nroexp" class="col-sm-3 control-label">Nro</label>
                    <div class="col-sm-4">
                        <input type="text" name="nroexp" value='<?php if(isset($expediente)) echo $expediente["nro_expediente"];?>' class="form-control" disabled="true"/>
                        <input name="expediente" type="hidden" id="expediente" value='<?php if(isset($expediente)) echo $expediente["nro_expediente"];?>' />
                        <input  name="idexp" type="hidden" id="idexp" value='<?php if(isset($_GET["idexp"])) echo $_GET["idexp"];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Carátula</label>
                    <div class="col-sm-9">
                        <textarea name="cart_exp" rows="6" id="observa" class="form-control" value='<?php if(isset($expediente)) echo"  ".$expediente["caratula"];?>' disabled="true" ><?php if(isset($expediente)) echo $expediente["caratula"];?></textarea>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Detalle de Oficio *</label>
                    <div class="col-sm-9">
                        <textarea id="editor" name="editor" spellcheck="true"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_entrada" class="col-sm-3 control-label">Fecha *</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha_entrada" id="fecha_entrada" class="select form-control" value="<?php echo date('Y-m-d');?>" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="copias" class="col-sm-3 control-label">Copias</label>
                    <div class="col-sm-4">
                        <input type="text" name="copias" id="copias" class="select form-control" value="" onKeyUp="numerico(copias)" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="plazo" class="col-sm-3 control-label">Plazo</label>
                    <div class="col-sm-4">
                        <input type="date" name="plazo" id="plazo" class="select form-control" value="" />
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
                    <!--<button type="button" name="prin" class="btn btn-primary" onclick="principal()"><span class='glyphicon glyphicon-home'></span> Principal</button>-->
                    <button type="button" name="princ" id="princ" onclick="window.open('','_self').close();" class="btn btn-primary">Cerrar</button>
                    <button type="submit" name="modif" class="btn btn-primary">Guardar</button>
                </center>
            </div><!-- Fin .panel-footer -->

        </form>

    </div><!-- Fin .panel -->
</div><!-- Fin .container -->
</body>

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
    $('#ofi')
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
            fecha_entrada: {
                validators: {
                    notEmpty: {
                        message: 'Ingrese la fecha de entrada del Oficio.'
                    }
                }
            },
            editor: {
                validators: {
                    callback: {
                        message: 'Detalle de Oficio no puede estar vacío.',
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
        document.ofi.submit();
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
        $('#ofi').bootstrapValidator('revalidateField', 'editor');
    });

});



    function principal()
    {
        document.ofi.action="principal.php";
        document.ofi.submit();
    }

    function busqueda(valor)
    {
        if(valor.value.length == 0)
        {
            alert("Ingrese un número de expediente para realizar la busqueda.");
            document.ofi.expediente.focus();
        }
        else
        {
            document.ofi.action = "alta cedula.php?expediente="+valor.value;
            document.ofi.submit();
        }
    }

    function validar(obj)
    {
        if((obj.detalle.value.length==0)||(obj.detalle.value.length<5))
        {
            alert("Es necesario ingresar Detalle de cédula.")
            obj.detalle.focus();
            return false;
        }
        /*if((obj.caratula.value.length==0)&&(obj.expediente.value.length==0))
        {
            alert("Es necesario ingresar número de copias.")
            obj.expediente.focus();
            return false;
        }*//*else
        if(obj.expediente.value.length==0)
        {
            alert("Selecciona Numero De Expediente")
            obj.expediente.focus();
            return false;
        }*/
        if(obj.copias.value.length==0 )
        {
            alert("Es necesario ingresar el número de copias.")
            obj.copias.focus();
            return false;
        }
        if((obj.oficina.value.length==0)||(obj.oficina.value.length<2))
        {
            alert("Es necesario ingresar el nombre de oficina.")
            obj.oficina.focus();
            return false;
        }

        if(obj.datos.value.length==0)
        {
            if(confirm("Desea Agregar Algun Dato Mas?"))
            {
                obj.datos.focus();
                return false;
            }
        }
    }
</script>

</html>
