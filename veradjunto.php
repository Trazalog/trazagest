
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
    <title>Ver Adjunto</title>
    <link rel="shortcut icon" type="image/x-icon" href="assest/plugins/buttons/icons/folder.png" />
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet" />
    <link href="css/estilo.css" rel="stylesheet" />
    <link href="summernote.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="jQuery/jquery.autocomplete.css" rel="stylesheet" />

   
</head>

<body>  <!--onload="traer_datos()"-->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
        <br>
          <h3 class="box-title"></h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
  
    <div class="panel panel-default">
      <div class="panel-heading"><h2 class="panel-title">Ver Imagenes Adjuntas</h2></div>

        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">
                <h4 class="box-title"></h4>
                <div class="col-xs-2">
                <?php               
                ?>  
                </div>
                <div class="col-xs-2">
                <?php 

                ?>
                </div>
              </div><!-- /.box-header -->
        <form name="listado" id="listado" action="" method="post" class="form-form-inline" role="form">
          <div class="panel-body">
          <a href="principal.php" class="glyphicon glyphicon-home btn btn-default col-md-offset-8" role="button"> Principal</a>
            <div class="form-group">
              <label for="fecha" class="col-sm-3 control-label"></label>
              <div class="col-sm-9">
              </div>
            </div>
              <div align="center">
                  <table width="100%" align="center" id='tabladatos' name='tabladatos' class="table table-bordered table-hover" style="text-align: center">
                   <thead>
                   <thear>
                                
                      <tr> 
                      <th style="text-align: center" > Imagen </th>                        
                        <th style="text-align: center">Expediente</th>
                       
                      
                        
                      </tr>
                      </thear>
                      <tbody>
                      <?php

                      
                	$nroExp=$_GET['nroexpe'];//Cambiar por metodo POST;
			        $sql="SELECT
							id_mov,
							fecha,
							file
							FROM adjunto_expediente AS ad
							WHERE ad.id_mov=$nroExp
							";

					$result2=mysql_query($sql,$var->links);
                      //$row2 = mysql_fetch_assoc($result2);
                      while( $row2 = mysql_fetch_assoc($result2)){
                    

                    echo '<tr >';
                      
                    
 echo "<td><img src=\"ruta/fileexp/".$row2['file']."'\" onClick=\"muestra('fileexp/".$row2['file']."' );\"width='32' height='32'title=\"click para ver \" style='cursor:pointer' /></td>";

                       //echo "<td colspan='7'><div id='d$registro[2]' name='d$registro[2]' style='display:none;'></div></td>";
                      
                     //   echo "<a ><img src='fileexp' id='mi_imagen' style='width:150px;' />  </a>";
                  
                    // echo '<i class="fa fa-fw fa-search-plus" style="color: #0000FF; cursor: pointer; margin-left: 15px;" data-toggle="modal" data-target="#modalvista" title="Consultar"></i> ';
                      // echo"<td class='info'> <button type='button' onclick='visor(this.id,$registro[0],$registro[2])''
                //  class='btn btn-default'>++</button></td>";
                      
            //echo "<td colspan='7'><div id='d$registro[2]' name='d$registro[2]' style='display:none;'></div></td>";
                  
                      
                    echo '<td style="text-align: center">'.$row2['id_mov'].'</td>';
                     //  echo '<td style="text-align: center">'.$row2['file'].'</td>';
                
                 echo '</tr >';
                  

                   }
                    
                      ?>

                      
       
                  </tbody>
                  </table>
              </div>
        </div>
      </form>
      </div>
      </div>
       </div>
      </div>
       </div>
      </div>
       </div>
      
 </div>
      </div>
       </div>
     
       </section>
      </body>
      </html>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type="text/javascript" src="Js/ajax.js"></script>
<script type="text/javascript" src="jQuery/jquery-ui-1.8.10.custom.min.js"></script>
<script type="text/javascript" src="paginas/generarStock/js/funcion.js"></script>
<script type="text/javascript" src="jQuery/jquery.autocomplete.js"></script>  
<!-- El CSS de DataTables -->
 
<script src="plugin/datatables/jquery.dataTables.min.js"></script>
<script src="plugin/datatables/dataTables.bootstrap.min.js"></script>

<script type="text/javascript" src="js/info_asigna.js"></script>


	<script type="text/javascript">
		var loc = window.location;
var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
var ruta=loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));

jQuery('img').each(function() {
var path=jQuery(this).attr('src');
var newPath= path.replace('ruta','');
jQuery(this).attr('src',newPath);
});
 //document.getElementById("mi_imagen").src="fileexp/registro";

	function muestra(imagen)
	{
		var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		window.open(imagen,"nombreventa na", opciones);
	}


function visor (id,data,idexpe ) {
    //alert('id es:'+id);
    //alert('contrato '+data);
    AbrirInfo(data,idexpe);
    document.getElementById('d'+data).style.display = 'block';
    document.getElementById('d'+data).style.backgroundColor='aliceblue';
    // alert ('d'+data);
}
	</script>