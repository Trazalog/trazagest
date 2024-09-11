<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>Alta Informe</title>
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
    <div class="panel-heading"><h3 class="panel-title">Alta Informe</h3></div>
    <form name="rem" id="rem" action="guardar_detalleasignagente.php" method="post" enctype="multipart/form-data" class="form-horizontal" role="form">

      <div class="panel-body">

        <?php
          if(isset($_GET['mov'])) {
            $nro = $_GET['mov'];
            $sql = "SELECT E.id_expediente,
                E.caratula,
                RM.id_mov,
                E.nro_expediente,
                E.n_folio,
                E.fecha,
                E.fecha_entrada
                FROM expedientes E
                JOIN registrodefensor R ON R.id_expediente=E.id_expediente
                JOIN registro_movimiento RM ON RM.id_reg=R.id_reg
                WHERE RM.id_mov=$nro ";
            $res = mysql_query($sql)or die($sql);

            if($expe = mysql_fetch_array($res)) 
            {
              //print_r($expe);
              $mov       = $expe["id_mov"];
              $ex        = $expe["nro_expediente"];
              $habilitar = 1;
            }


            echo '<div class="panel-body">
              <h4>Datos del Expediente</h4>
              <div class="form-group">
                <label for="nroexp" class="col-sm-3 control-label">Nro Expediente:</label>
                <div class="col-sm-4">
                  <input type="text" name="nroexp" value='.$expe["nro_expediente"].' class="form-control" disabled="true"/>
                </div>
              </div>

              <div class="form-group">
                <label for="nroexp" class="col-sm-3 control-label">Nro. Folio:</label>
                <div class="col-sm-4">
                  <input type="text" name="nroexp" id="nroexp" value='.$expe["n_folio"].' class="form-control" disabled="true"/>
                </div>
              </div>

              <div class="form-group">
                <label for="nroexp" class="col-sm-3 control-label">Fecha:</label>
                <div class="col-sm-4">
                  <input type="text" name="nroexp" value='.invertirFecha($expe['fecha']).' class="form-control" disabled="true"/>
                </div>
              </div>

              <div class="form-group">
                <label for="nroexp" class="col-sm-3 control-label">Fecha Entrada:</label>
                <div class="col-sm-4">
                  <input type="text" name="nroexp" value='.invertirFecha($expe['fecha_entrada']).' class="form-control" disabled="true"/>
                </div>
              </div>

              <div class="form-group">
                <label for="nroexp" class="col-sm-3 control-label">Carátula:</label>
                <div class="col-sm-9">
                  <textarea name="cart_exp" rows="6" id="observa" class="form-control" value="'.$expe['caratula'].'" disabled="true">'.$expe['caratula'].'</textarea>
                </div>
              </div>';

            $sql2="select id_defen From registrodefensor, defensor where(defensor.id_defensor= registrodefensor.id_defen) and (registrodefensor.estado = 'A') and (registrodefensor.id_expediente='".$expe[0]."') ";
            $res2=mysql_query($sql2)or die($sql2);
            if($row2=mysql_fetch_array($res2)) {
              //echo" row: ".$row2[0];
              $sql3="select * from defensor where id_defensor = '".$row2[0]."'";
              $res3=mysql_query($sql3)or die($sql3);

              if( $row3=mysql_fetch_array($res3)) {
                echo '<div class="form-group">
                    <label for="nroexp" class="col-sm-3 control-label">Asignado a:</label>
                    <div class="col-sm-4">
                      <input type="text" name="nroexp" value="'.$row3[2].' '.$row3[1].'" class="form-control" disabled="true"/>
                    </div>
                  </div>';
              } else {
                echo '<div class="form-group">
                    <label for="nroexp" class="col-sm-3 control-label">Asignado a:</label>
                    <div class="col-sm-4">
                      <input type="text" name="nroexp" value="El expediente no está asignado" class="form-control" disabled="true"/>
                    </div>
                  </div>';
              }
            }
            echo '</div>';
          } 
          else {
            echo"<td><td colspan='5'><h2>No se Encuentra ningun Expediente con Nro: ".$nro."</h2></td></tr>";
            //echo $expe;
          }
        ?>

                <hr>
                <h4>Gestor de Expedientes</h4>
                <input type="hidden" name="idmov" id="idmov" value="<?php echo $mov; ?>">
                <input type="hidden" name="folio" id="folio" value="<?php echo $expe['n_folio']; ?>">
                <input type="hidden" name="id_expediente" id="id_expediente" value="<?php echo $expe['id_expediente']; ?>">
                <div class="form-group">
                    <label class="col-sm-3 control-label">Descripción *</label>
                    <div class="col-sm-9">
                        <textarea id="editor" name="editor" spellcheck="true"></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha" class="col-sm-3 control-label">Fecha *</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha" id="fecha" class="select form-control" value="" />
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
    $('#rem')
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
            fecha: {
                validators: {
                    notEmpty: {
                        message: 'Ingrese la fecha.'
                    }
                }
            },
            editor: {
                validators: {
                    callback: {
                        message: 'Descripción de informe no puede estar vacío.',
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


</html>
<?php 
function invertirFecha($valor)
{
  $valor = explode("-",$valor);
  $valor = $valor[2]."-".$valor[1]."-".$valor[0];
  return $valor;
}
?>