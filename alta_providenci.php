<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>Alta Providencia</title>
    <link rel="stylesheet" href="plugin/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugin/bootstrapvalidator/bootstrapValidator.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="summernote.css">

    <style type="text/css" media="print">
        @media print {
            body { font-size:9px; }
            #listado { display:none; }
            #parte2 { display:none; }
        }
    </style>

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

<script type="text/javascript">
  function digitalizar(mov){
    document.listado.action = "ejecutar.php?nexpediente="+mov;
    document.listado.submit();
  }

  function visulizar(){
    document.listado.action = "listar.php";
    document.listado.submit();
  }

  var ruta = location.protocol + '//' + location.host;

  function subirarchivo(data, name)
  { 
    $foli=listado.folio.value;
    var urlRequest = "altaexp_provi.php?idmov="+'<? echo $_GET['mov']?>'+"&fol="+$foli; 
    $.ajax({
      url: urlRequest,
      type: 'POST',
      headers: {              
        'Access-Control-Allow-Origin': '*'
      },
      data: data,
      cache: false,
      processData: false, // Don't process the files
      contentType: false, // Set content type to false as jQuery will tell the server its a query string request
      beforeSend: function() {
        var li = $('#listarchivos :contains("'+name+'")').parent('div').parent('li');
        $(li).find('.sizefile').after("<img id='loadingUP' src='imag/giphy.gif' height='45' width='45' />");
      },
      success: function(data, textStatus, jqXHR)
      {   
        var data = jQuery.parseJSON( data ); 
        if(data['error'])
        {  
          console.log(data);
          alert("error");
          var li = $('#listarchivos :contains("'+data['nombre']+'")').parent('div').parent('li');
          $(li).remove();
        }
        else{ 
          data = data['files'];
          for(var i=0; i < data.length; i++) //aca coloco id de archivo al li. y agrego tilde suces
          { 
            var li = $('#listarchivos :contains("'+data[i]['nombre']+'")').parent('div').parent('li');
            $(li).attr('id', data[i]['id']);

            var tilde = '<i class="fa fa-check-circle-o" alt="Se adjunto correctamente" height="20" width="20"></i>'; 

            $(li).find('#loadingUP').remove();

            $(li).find('.sizefile').append(tilde);
          } 
        }
      },
      error: function(jqXHR, textStatus, errorThrown)
      {
        console.log('ERRORS: ' + textStatus);
        // STOP LOADING SPINNER
        $('#loadingUP').remove();
      }
    });
  }

var cantArchivos=5;
var sizeArchivo=10; //MB
//boton examinar
function prepareUpload(event)
{  
    event.stopPropagation(); // Stop stuff happening
    event.preventDefault(); // Totally stop stuff happening

    //console.log('prepareUpload');

    var ecxedesize=0;

    files = event.target.files;  //esta lina es la unica diferencia con el prepareUpload2
    
    $.each(files, function(key, value)
    {
        var data = new FormData();
        data.append(key, value);

        var size = value.size;
        if( size > 1024)
        {
            var temp = size/1024;
            //temp = number_format(temp, 2, '.', '');
            if (temp > 1024)
            {
                size = (temp/1024).toFixed(2)+" MB";
                if( (temp/1024).toFixed(2) > sizeArchivo )
                    ecxedesize=1;
            }
            else
                size = temp.toFixed(2)+" KB";
        }
        else 
            size = size.toFixed(2)+" Bytes";

        
        var cantActual=$("#listarchivos li").size();

        if(cantActual < cantArchivos)
        {
          if(ecxedesize==0)
          {
            //alert(value.name); alert(alta);
           
            var li = $('#listarchivos :contains("'+value.name+'")').parent('div').parent('li');
        
            
            if(li.length == 0)
            {
                var li = '<li> <div class="itemfile"><div class="namefile">'+value.name +'</div> <div class="sizefile"> &nbsp;&nbsp;&nbsp;  ('+size+') </div>'+
                                '<button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true">×</button>'+
                          '</div></li>';
                
                
                $('#listarchivos').append(li);
                

                //delete_files(alta);
                subirarchivo(data, value.name);
            }else 
              //$.notify("El archivo ya fue añadido", "warn");
              alert("El archivo ya fue añadido");


          }
          else 
             
              //$.notify("No puede superar los "+sizeArchivo+" MB", "warn");
           alert("No puede superar los "+sizeArchivo+" MB");

        }
        else
             
             // $.notify("Alcanzó el límite de arhivos", "warn");
          alert("Alcanzó el límite de arhivos");


    });   
  
}


$(document).ready(function() 
{

  //draganddropUpload();

  $('input[type=file]').on('change', function(event) { prepareUpload(event); });


});
</script>

</head>
<body>
<div class="container">
    <br />
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Alta Providencia</h3>
        </div>
    <form name="listado" method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data" data-ng-controller="DemoFileUploadController" > 
      <div class="panel-body">
        
<?php
include("conexion.php");
$link= new conexion();
$link->conectarse();
//ob_start();

if(isset($_GET['mov'])) //{
  $nro=$_GET['mov'];
  //echo $nro;

if($nro) {
  
  //echo $nro;
  $sql="SELECT E.id_expediente,
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

  $res=mysql_query($sql)or die($sql);

  if($expe=mysql_fetch_array($res)) {
    //print_r($expe);

    $mov=$expe["id_mov"];
    $ex=$expe["nro_expediente"];
    //echo"$mov";
    $habilitar = 1;

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
                <input type="text" name="nroexp" value='.$expe["n_folio"].' class="form-control" disabled="true"/>
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
    //echo"<td><td colspan='5'><h2>No se Encuentra ningun Expediente con Nro: ".$nro."</h2></td></tr>";
    echo $expe;
  }
}

?>

    <input name="nmov" id="nmov" type="hidden" value='php echo $mov;?' >
    <hr>
    <h4>Gestor de Expedientes</h4>

    <div class="form-group">
      <label for="nroexp" class="col-sm-3 control-label">Ingrese número de Folio:</label>
      <div class="col-sm-4">
        <input type="text" class="form-control" name="folio" id="folio" onclick="document.getElementById('filer_input2').disabled = ! document.getElementById('filer_input2').disabled;"/>
      </div>
    </div>

    <div class="form-group">
      <label for="folio" class="col-sm-3 control-label">Adjuntar archivo</label>
      <div class="col-sm-9">
        <input class="form-control" type="file" name="files[]" id="filer_input2" multiple="multiple"  placeholder="Ubicación archivo PDF" title="Seleccione o arrastre hasta 5 archivos">
        <br>
        <ul id="listarchivos" style="padding-top:4px"></ul>
      </div>
    </div>

     

</div><!-- Fin .panel-body -->
    <div class="panel-footer">
        <center>
            <!--<span>Adjuntar</span>-->
            <!--<button id="enviar" class="btn btn-primary fileinput-button ">Adjuntar</button>-->
            <!--<input type="submit" value="Enviar"/> editar-->

            <!--  <input type="file" name="imagenes[]" multiple="multiple">-->
            <!--name="files[]" multiple ng-disabled="disabled"-->

            <!--<input type="submit" value="Digitalizar" class="btn btn-primary" onclick="digitalizar(<?  //echo $mov ?>)"/>-->
            <button type="button" name="princ" id="princ" onclick="window.open('','_self').close();" class="btn btn-primary">Cerrar</button>
            <button type="button" value="Guardar" onclick="guardar()" class="btn btn-primary" >Guardar</button> 
            <!-- <input type="button" value="Guardar" class="btn btn-primary" > ESTE ES ELBOTON GUARDAR 
            -->
            <!--onclick="generar(<?php //echo $mov;?>)" -->
            <input type="hidden" name="exp" value="<?php echo $expe["nro_expediente"];?>">
        </center>
        </div><!-- Fin .panel-footer -->
        </form>
    </div><!-- Fin .panel -->
</div><!-- Fin .container -->
</body>
</html>

<?php
function invertirFecha($valor)
{
  $valor = explode("-",$valor);
  $valor = $valor[2]."-".$valor[1]."-".$valor[0];
  return $valor;
}

function BuscarNombre($valor)
{
  $sql  = "Select Nombre, Apellido from iniciador where dni='".$valor."'" ;
  $resu = mysql_query($sql)or (die(mysql_error()));
  $row  = mysql_fetch_array($resu);
  return $row['Apellido']." ".$row['Nombre'];
}

?>

<style type="text/css">
.dragandrophandler
{
  border:3px dashed #0B85A1;
  /*width:400px;*/
  height: auto;
  color:#92AAB0;
  text-align:left;vertical-align:middle;
  padding:10px 10px 10 10px;
  margin-bottom:10px;
  font-size:100%;
}

.namefile {
  display: inline-block;
  overflow: hidden;
  padding: 3px 0;
  text-overflow: ellipsis;
  vertical-align: bottom;
  white-space: nowrap;
  max-width: 315px;
  color: #15c;
}

.itemfile {
  background-color: #f5f5f5;
  border: 1px solid #dcdcdc;
  font-weight: bold;
  margin: 0 7px 9px;
  overflow-y: hidden;
  padding: 4px 4px 4px 8px;
  max-width: 448px;
  font-size: 13px;
}

.sizefile {
  color: #777;
  display: inline-block;
  padding: 3px 0;
}
</style>

<script type="text/javascript">
function guardar(){
  // href=printexpediente.php?exped=".$expe[0].";
  //window.location="http://www.trazalog.com/soporte/";
  /* header("Location:panelexpediente.php?expe=$exp");*/
  window.opener.location.reload();
  window.close();
  //location.href="panelexpediente.php?expe=$ex";
}
$("#folio").change(function(){
          
  // document.getElementById("filer_input2").disabled = true; // deshabilitar
  document.getElementById("filer_input2").disabled = false; // habilitar
    //$("input.filer_input2").attr("disabled", false);
  });


</script>


