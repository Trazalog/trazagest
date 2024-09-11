<?php
include("conexion.php");
$link= new conexion();
$link->conectarse();

$habilitar = 0;

if(isset($_GET['nroexpe'])) {
    $nroExp=$_GET['nroexpe'];//Cambiar por metodo POST;

    $sql3="SELECT * FROM expedientes where nro_expediente='".$nroExp."'";

    $res=mysql_query($sql3) or die($sql3);
    $expe=mysql_fetch_array($res);
    


    if(mysql_num_rows($res)>0) {
        $habilitar = 1;

    } else {
        echo '<script>alert("No existe el numero de expediente buscado");</script>';
    }
}


function inviertefecha($f) {
    // echo $f;
    $datos = explode("-",$f);//2008-12-02 --> 02-12-2008
    $fecha[]= $datos[0];
    $fecha[] = $datos[1];
    $fecha[] = $datos[2];

    $total=$fecha[2]."-".$fecha[1]."-".$fecha[0];
    return  $total;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Adjuntar Imagen a Expediente nro: <?php echo ($expe['nro_expediente']); ?></title>
       <link rel="shortcut icon" type="image/x-icon" href="assest/plugins/buttons/icons/folder.png" />
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />

   

    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet" />
    <!--<link href="css/estilo.css" rel="stylesheet" />-->
    <link href="summernote.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <!--<link href="jQuery/jquery.autocomplete.css" rel="stylesheet" />-->

    <link rel="stylesheet" href="//blueimp.github.io/Gallery/css/blueimp-gallery.min.css"/>
<!-- CSS to style the file input field as button and adjust the Bootstrap progress bars 
<link rel="stylesheet" href="css/jquery.fileupload.css">
<link rel="stylesheet" href="css/jquery.fileupload-ui.css">-->
<!-- CSS adjustments for browsers with JavaScript disabled 
<noscript><link rel="stylesheet" href="css/jquery.fileupload-noscript.css"></noscript>
<noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>-->

    <style type="text/css" media="print">
        @media print {
            body { font-size:9px; }
            #listado { display:none; }
            #parte2 { display:none; }
        }
    </style>

<style>
/* Hide Angular JS elements before initializing */
.ng-cloak {
    display: none;
}
</style>

</head>

<body>
    <div class="container">
        <br />
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Adjuntar imagen a Expediente</h3></div>
          <form name="listado" method="post" action="" class="form-horizontal" role="form" enctype="multipart/form-data" data-ng-controller="DemoFileUploadController" >
                <div class="panel-body">
                    <div class="panel-footer">
                       <center>
                            <div class="form-group">
                                <div class="col-xs-12"><label>Adjuntar Archivos</label></div>
                                    <input type="file" name="files[]" id="filer_input2" multiple="multiple" placeholder="Browse computer" style="color: transparent; max-width:120px" data-toggle="tooltip" title="Seleccione o arrastre hasta 5 archivos" />
                                    <!--<input type="checkbox" name="enviarsi" onclick="document.getElementById('enviar').disabled = ! document.getElementById('enviar').disabled;">Marca para enviar</input>-->
                                
                                    <ul id="listarchivos" style="padding-top:4px"></ul>
                                </div>
                               
                            </div>
                            <input type="hidden" name="exp" value="<?php echo $expe["nro_expediente"];?>">
                        </center>
                    	<center>
                            <button type="button" class="btn btn-primary" onclick="document.formexp.action='principal.php'; document.formexp.submit();"><span class='glyphicon glyphicon-home'></span> Principal</button>
                            <button type="button" name="nuevoexp" onclick="guardar();" class="btn btn-primary">Guardar</button>
                        </center>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type="text/javascript" src="index.js"></script>
<script type="text/javascript" src="abm_expediente_js.js"></script>

<script>
/*$(document).ready(function(){
 /* function editarExpediente(ope) /* esto esta comenatdo ,no se por que */
   /* {
        var opciones = "width=800,height=350,scrollbars=NO";
        window.open("abm_expediente_libreria.php?operacion="+ope,"nombreventa na", opciones);
    }*/
 

   /*$("edi").click(function(){
       $("#dni").removeAttr("disabled");
   });*/

//});
    function editadni(id)
    {
    	var opciones = "width=800,height=350,scrollbars=NO";
        window.open("editaabminiciador.php?iniciador="+id,"nombreventa na", opciones);
    }

    function editaini(id,nro)
    {
		var opciones = "width=800,height=350,scrollbars=NO";
        window.open("editainiciador.php?dni="+id+"&nro="+nro,"nombreventa na", opciones);
    }

	function buscarExped(valor)
    {
		if(valor!="")
        {
			location.href="adjuntarimg.php?nroexpe="+valor;
		}
		else
		{
            alert("Ingrese un numero de expediente para poder realizar la busqueda.");
		}
	}

/*$("#edi").click(function(){
         $("#dni").attr("disable",true);
     });*/
    /*function (){

       //$('#dni').removeAttr("disabled");
       $('#dni').click(){
        attr("disabled","");
    //formexp.dni.disabled = false;

//document.getElementById("dni").disabled=false;

        /*var dni=$('#dni').val();
        console.log(dni);*/

function refresca(){

//window.location.href='listado_expediente.php';
location.reload(true);

}


    function visulizar()
    {

        document.listado.action = "adjuntarimg.php";
        document.listado.submit();

    }

var ruta = location.protocol + '//' + location.host;

/*function delete_files(id)
{

  //if(alta='A')
    $('#'+id+' .close').click(function(e){
        e.stopPropagation();
        e.preventDefault();

          //console.log('delete');

          var li = $(this).parent('div').parent('li');
          var idfile = $(li).attr('id');

          $(li).remove();
          var urlRequest = urlApi+"/upload/delete_file";

          $.ajax({
                  url: urlRequest,
                  type: 'POST',
                  headers: {              
                  'APIKEY' : passApiKey,
                  'userid' : idUser
                },
                data:{idfile:idfile},
                success: function(data){  
                  if(data['status']==false)
                  { 
                    //console.log(data['message']);
                    if(data['message']=='NO LOGUIN')
                      location.href = "<?php //echo base_url('login'); ?>"; //no està logueado
                    //terminadoP4(1); terminadoP4(2); terminadoP4(3);
                  }
                  //else
                  //alert("Archivo Eliminado", "success");

                                           
              },
              error: function(response){
                  console.log(response);                   
              }           
          }); 
        
    });
  //else

}*/



function subirarchivo(data, name)
{ 
  // $foli=listado.folio.value;
    var urlRequest = ruta+"/trazagest/guardaradjuntar.php?nroexpe="+'<? echo $_GET['nroexpe']?>'; 
    //$('#folio').html('');

    //alert(urlRequest);
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
            //console.log(data);
            var data = jQuery.parseJSON( data ); 
            if(data['error'])
            {  
                console.log(data);

                //$.notify(data['error'], "danger");
                alert("error");


                
                var li = $('#listarchivos :contains("'+data['nombre']+'")').parent('div').parent('li');
               

                $(li).remove();
                
            }
            else{ 

                data = data['files'];

                for(var i=0; i < data.length; i++) //aca coloco id de archivo al li. y agrego tilde suces
                { 
                    //console.log(data[i]['nombre']);
                   
                    var li = $('#listarchivos :contains("'+data[i]['nombre']+'")').parent('div').parent('li');
                    

                    //console.log(li);
                    $(li).attr('id', data[i]['id']);

                    var tilde = '<i class="fa fa-check-circle-o" alt="Se adjunto correctamente" height="20" width="20"></i>'; 

                    $(li).find('#loadingUP').remove();

                    $(li).find('.sizefile').append(tilde);

                   // delete_files(data[i]['id']);
                } 
            }

          
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            // Handle errors here
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

function guardar(){
     // href=printexpediente.php?exped=".$expe[0].";

        //window.location="http://www.trazalog.com/soporte/";

       /* header("Location:panelexpediente.php?expe=$exp");*/
      
   window.opener.location.reload();
   window.close();
       //location.href="panelexpediente.php?expe=$ex";
}


$(document).ready(function() {
  //draganddropUpload();

  $('input[type=file]').on('change', function(event) { prepareUpload(event); });


});

  
</script>






