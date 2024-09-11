<?PHP
include("conexion.php");
session_start();
include("class_sesion.php");
$sesion= new Sesion();
$CadenaPermisos = $sesion->iniciar();
@session_start();
$us= $_SESSION["id_usuario"];
include("class_menu.php") ;
$menu= new menu();
include("class_secciones.php") ;
$info= new seccion();
include("class_listado.php") ;
//notificaciones
include("class_notifica.php") ;
$notifica= new notifica();
//vencimiento de contraseña
$mostrarModal = false;
date_default_timezone_set('America/Argentina/Buenos_Aires');
$usuario      = $sesion->datosUsuario($us);
$fechaLimite  = strtotime(date("Y-m-d",strtotime('-3 month')));
$fechaPass    = strtotime($usuario['fecha']);
if( $fechaLimite > $fechaPass ) {
    $mostrarModal = true;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>Trazagest</title>
    <link rel="stylesheet" href="plugin/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugin/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="plugin/bootstrapvalidator/bootstrapValidator.min.css">
    <link rel="stylesheet" href="css/estilo.css">

    <style type="text/css">
        .navbar-inverse {
            border-radius: 0 !important;
        }
    </style>
</head>
<body>
<?php 
    $mostrarModal = false;
    $usuario      = $sesion->datosUsuario($us);
    $fechaLimite  = strtotime(date("Y-m-d",strtotime('-3 month')));
    $fechaPass    = strtotime($usuario['fecha']);
    if( $fechaLimite > $fechaPass ) {
        $mostrarModal = true;
    }
?>
    <nav class="navbar navbar-inverse" role="navigation">
        <!-- El logotipo y el icono que despliega el menú se agrupan
        para mostrarlos mejor en los dispositivos móviles -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
            data-target=".navbar-ex1-collapse">
                <span class="sr-only">Desplegar navegación</span>
                <span class="icon-bar">1</span>
                <span class="icon-bar">2</span>
                <span class="icon-bar">3</span>
            </button>
            <a class="navbar-brand" href="#">TrazaGest</a>
        </div>

        <!-- Agrupar los enlaces de navegación, los formularios y cualquier
        otro elemento que se pueda ocultar al minimizar la barra -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php">Cerrar Sesion</a></li>
                <li><a href="#">Usuario: <?php $sesion->usuario($us); ?></a></li>
                <li><a href="#" data-toggle="modal" data-target="#trd1">Notificaciones</a></li>
            </ul>
        </div>
    </nav>
    
    <div class="container"> <!-- Contenerdor margen de Pantalla standarizado -->
        <div class="panel panel-primary">
            <div class="panel-body">
                <?php $menu->menu_ppal($CadenaPermisos); ?>
                <?php $info->seccion_principal($us); ?>
            </div>
        </div>
    </div>

    <!-- Modal notificaciones -->
    <div class="modal modal--registration fade" id="trd1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Notificaciones</h4>
                </div><!--end modal-header-->
                <div class="modal-body">
                    <?php $notifica->notifica_usuario($us);?>
                </div><!--end modal-body-->
            </div><!--end modal-content-->
        </div>
    </div><!-- /.modal -->

    <!-- modal cambio de pass -->
    <div class="modal fade" role="dialog" id="modalPass">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cambio de Contraseña </h4>
                </div>
                <form class="form-horizontal" id="formPass" method="post" action="actualiza_pass.php">
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> Debe actualizar su contraseña!</strong>
                            <p>Usuario <strong><?php $sesion->usuario($us); ?></strong>, su contraseña tiene mas de 3 meses de antigüedad.<br>Por cuestiones de seguridad debe cambiarla.</p>
                        </div>
                    
                        <input type="hidden" name="id_usuario" value="<?php echo $usuario['id_usuario']; ?>">
                        <div class="form-group">
                            <label for="passActual" class="col-md-4 col-xs-12 control-label">Contraseña actual</label>
                            <div class="col-md-8 col-xs-12">
                                <input type="password" class="form-control" name="passActual">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">Contraseña nueva</label>
                            <div class="col-md-8 col-xs-12">
                                <input type="password" class="form-control" name="password" />
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 col-xs-12 control-label">Reescriba contraseña nueva</label>
                            <div class="col-md-8 col-xs-12">
                                <input type="password" class="form-control" name="confirmPassword" />
                            </div>
                        </div>
                    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" name="submitButton" class="btn btn-primary">Guardar Pass</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- modal mensajes -->
    <div class="modal fade" role="dialog" id="modalMensajes">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Cambio de Contraseña</h4>
                </div><!--end modal-header-->
                <div class="modal-body">
                    <!-- -->
                </div><!--end modal-body-->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div><!--end modal-content-->
        </div>
    </div><!-- /.modal -->
</body>

<script src="plugin/jquery/jquery-1.12.4.min.js"></script>
<script src="plugin/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="plugin/datatables/jquery.dataTables.min.js"></script>
<script src="plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugin/bootstrapvalidator/bootstrapValidator.min.js"></script>
<script src="plugin/jqueryMD5/jquery.md5.min.js"></script>
<script type="text/javascript">
    $('#formPass')
        .bootstrapValidator({
            framework: 'bootstrap',
            feedbackIcons: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh',
            },
            fields: {
                passActual: {
                    validators: {
                        notEmpty: {
                            message: 'La contraseña es requerida y no puede estar vacía.'
                        },
                        callback: {
                            message: 'La contraseña no es válida.',
                            callback: function(value, validator, $field) {
                                console.info( $.md5(value) );
                                console.log( '<?php echo $usuario['contrasena']; ?>' );
                                if ( $.md5(value) === '<?php echo $usuario['contrasena']; ?>') {
                                    return true;
                                } else {
                                    return false;
                                }
                            }
                        } /* fin callback */
                    },
                },
                password: {
                    validators: {
                        notEmpty: {
                            message: 'La contraseña es requerida y no puede estar vacía.'
                        },
                        stringLength: {
                            min: 8,
                            message: 'La contraseña debe tener al menos 8 caracteres.'
                        },
                        identical: {
                            field: 'confirmPassword',
                            message: 'La contraseña y su confirmación no son las mismas.'
                        },
                        callback: {
                            message: 'La contaseña no es válida',
                            callback: function(value, validator, $field) {
                                if (value.search(/[0-9]/) < 0) {
                                    return {
                                        valid: false,
                                        message: 'La contraseña debe tener al menos un número.'
                                    }
                                }
                                return true;
                            }
                        } /* fin callback */
                    },
                },
                confirmPassword: {
                    validators: {
                        notEmpty: {
                            message: 'La confirmación de la contraseña es requerida y no puede estar vacía.'
                        },
                        stringLength: {
                            min: 8,
                            message: 'La contraseña debe tener al menos 8 caracteres.'
                        },
                        identical: {
                            field: 'password',
                            message: 'La contraseña y su confirmación no son las mismas.'
                        },
                        callback: {
                            message: 'La contaseña no es válida',
                            callback: function(value, validator, $field) {
                                if (value.search(/[0-9]/) < 0) {
                                    return {
                                        valid: false,
                                        message: 'La contraseña debe tener al menos un número.'
                                    }
                                }
                                return true;
                            }
                        } /* fin callback */
                    },
                },
            },
        })
        .on('success.form.bv', function(e) {
            // Prevent form submission
            e.preventDefault();
            //alert("submit ok");
            var $form = $(e.target),
                bv    = $(e.target).data('formValidation');

            $.ajax({
                data: $form.serialize(),
                dataType: 'json',
                type: 'POST',
                url: $form.attr('action'),
            }).done( function(data) {
                console.table(data);
                $('#modalMensajes .modal-body').html('<div class="alert alert-success" role="alert"><span class="glyphicon glyphicon-info-sign"></span> Su contraseña fue actualizada!</div>');
            }).fail( function(){
                console.error('Error al cambiar la contraseña!');
                $('#modalMensajes .modal-body').html('<div class="alert alert-error" role="alert"><span class="glyphicon glyphicon-warning-sign"></span> Hubo un error al actualizar su contraseña!</div>');
            }).always(function() {
                $('#modalPass').modal('hide');
                $('#modalMensajes').modal('show');
            });

        });

    // Si la contraseña es antigua muestro modal para renovarla 
    var mostrarModal = '<?php echo $mostrarModal ?>';
    if(mostrarModal) {
        $('#modalPass').modal('show');
    }

    // reseteo el formulario al abrir el modal 
    $('#modalPass').on('shown.bs.modal', function (e) {
        $("#formPass").bootstrapValidator("resetForm",true)
    })

$(function() {
    $('[data-toggle="tooltip"]').tooltip(); 
    // cargo plugin DataTable (debe ir al final de los script) 
    $("#tbl_principal").DataTable({
        "aLengthMenu": [ 10, 25, 50, 100 ],
        "columnDefs": [ {
            "targets": [ 5, 6 ], 
            "searchable": false
        },
        {
            "targets": [ 5, 6 ], 
            "orderable": false
        } ],
        "order": [[0, "asc"]],
    });
});
</script>

</html>
