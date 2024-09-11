<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Modificar Cédula</title>
    <link rel="shortcut icon" type="image/x-icon" href="assest/plugins/buttons/icons/folder.png" />
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet" />
    <link href="css/estilo.css" rel="stylesheet" />
    <link href="summernote.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="jQuery/jquery.autocomplete.css" rel="stylesheet" />
</head>

<body>
<div class="container">
    <br />
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Alta caja</h3></div>
        <form name="cedu" action="alta_cajas_php.php" method="post" class="form-horizontal" role="form">
            <div class="panel-body">

                <div class="form-group">
                    <label for="cajas" class="col-sm-3 control-label">Caja</label>
                    <div class="col-sm-4">
                        <input name="cajas" type="text" id="cajas" value="" class="form-control" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha" class="col-sm-3 control-label">Estado</label>
                    <div class="col-sm-4">
                        <select name="estado" id="estado" class="select form-control">
                            <option value="0" division="" selected>Seleccione Estado</option>
                            <?php
                            $consulta2 = "SELECT * FROM estados";
                            $result2   = mysql_query($consulta2,$var->links);
                            while($row2=mysql_fetch_array($result2)) {
                                echo "<option value='".$row2['letra']."'>".$row2['descripcion']."</option>";
                                //letra
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="codigo" class="col-sm-3 control-label">Caja</label>
                    <div class="col-sm-4">
                        <input name="codigo" type="text" id="codigo" value="" class="form-control" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha" class="col-sm-3 control-label">Estantería</label>
                    <div class="col-sm-4">
                        <select name="estanteria" id="estanteria" class="select form-control">
                            <option value="0" division="" selected>Seleccione Estantería</option>
                            <?php
                            $consulta2 = "SELECT * FROM estanteria";
                            $result2   = mysql_query($consulta2,$var->links);
                            while($row2=mysql_fetch_array($result2)) {
                                echo "<option value='".$row2['id_estanteria']."'>".$row2['descripcion']."</option>";
                                //letra
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="fila" class="col-sm-3 control-label">Fila</label>
                    <div class="col-sm-4">
                        <input name="fila" type="text" id="fila" value="" class="form-control" />
                    </div>
                </div>

            </div><!-- Fin .panel-body -->
            <div class="panel-footer">
                <center>
                    <input type="submit" value="Guardar"  class="btn btn-primary" >
                </center>
            </div><!-- Fin .panel-footer -->

        </form>

    </div><!-- Fin .panel -->
</div><!-- Fin .container -->
</body>

<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script language="javascript" src="reporteExpedientes_js.js" ></script>
<script type="text/javascript" src="ajax_post.js"></script><!-- metodo ajax -->

<script language="javascript">
    function recha()
    {
        if(document.getElementById('observaciones').value == "" &&
        document.getElementById('archivo').value == "")
        {
            alert("Complete los campos de Observaci�n y/o Archivo PDF");
        }
        else
        {
            //grabar
            document.getElementById('oper').value = "g";
            document.form2.submit();
        }
    }

    function busqueda(valor)
    {
        document.form2.action = "resolucionPDF.php?nroExp="+valor;
        document.form2.submit();
    }
</script>

</html>
