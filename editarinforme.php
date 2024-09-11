
<?php
 
include("conexion.php");
	  $link= new conexion();
      $link->conectarse();
if(isset( $_GET['id']))
{	 
$busca=$_GET['id'];

$consulta = "SELECT R.id,
                    R.extracto,
					R.fecha,
					R.id_mov
					 FROM respuesta_agente R where R.id=".$busca;
$res=mysql_query($consulta)or die($consulta);
$respueta=mysql_fetch_assoc($res);
}

	 

?>

<html>
<head>
<meta charset="UTF-8">
<title>Respuesta</title>
<link rel="stylesheet" href="css/bootstrap.css">
	 <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
	 
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
     <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

  <link href="css/bootstrap.min.css/bootstrap/3.3.6" rel="stylesheet">
  <link href="css/estilos.css/bootstrap/3.3.6" rel="stylesheet">
  <link href="bootstrap.css/bootstrap/3.3.6" rel="stylesheet">
  
   
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <script src="jquery.js"></script>
	

<!--<script   type="text/javascript" src="validacionesDeEntrada.js"></script>
<script type="text/javascript" src="modificar cedula.js"></script>
<script type="text/javascript" src="alta cedula.js"></script>
<script type="text/javascript" src="ajax_oficio.js"></script> metodo ajax --> 
<!-- -->
<link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet"> 
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.js"></script> 
<script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.js"></script> 
<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css">

<link href="summernote.css" rel="stylesheet">
<script src="summernote.min.js"></script>

<!-- include summernote-ko-KR -->
<script src="lang/summernote-es-ES.js"></script>

<script>
$(document).ready(function() {

  $('#editor').summernote({
    lang: 'es-ES' // default: 'en-US'
  }); 


   $('.note-editable').css("height","300");

});


</script> 


</head>
<body class="body">
    <div class="container">
    <div class="jumbotron">
    <div class="row">
    <div class="col-sm-12 col-md-12">
    <div class="thumbnail">
    <div class="caption">

<form name="rem" method="post" action="guardar_informe.php" >
<input type="hidden" name="mov" id="mov" value="<?php echo $_GET['id_mov'];?>">

                    <br>
					<div class="form-group">
					<h3 class="text-center">Edici&oacute;n de Informe </h3>
					<input name="id" type="hidden" id="id" value='<?php if(isset($respueta)) echo"  ".$respueta['id'];?>' size="20"/>
					</div>

    <fieldset>
	<fieldset>
	<legend> </legend>
    <fieldset>
	</fieldset>
	</fieldset>
	</fieldset> 
	
	<div class="row">
    <div class="col-sm-12 col-md-12">
    <div class="thumbnail">
	<div class="caption">  	
	<fieldset>
	<fieldset>
	<legend></legend>
    <fieldset>
	</fieldset>
	</fieldset>
	</fieldset>
	          
	<fieldset>
    <fieldset>
	<legend><h5>Descripci&oacute;n</h5></legend>
    <fieldset>
	
	<div id="contenedor1">
		<div id="editor" class="" >
		 <?php
		 
	     if(isset($respueta['extracto']))
	       echo $respueta['extracto'];
		?>  
	  	</div>
  	</div>

  <input name="extracto" type="hidden" id="extracto" value='' size="20"/>   <!-- </div> -->
<script data-main="src/js/app" data-editor-type="bs3" src="//cdnjs.cloudflare.com/ajax/libs/require.js/2.1.9/require.min.js"></script>
<script>

</script>
<div class="col-xs-6">
        <h5>Fecha</h5> 
		<p><?php
	            if(isset($respueta['fecha']))
	             echo $respueta['fecha'];
	         ?>
		</p> 
        
		<input type="date" name="fecha" id="fecha" class="select"/>
 </div>
	
			</fieldset>
			</fieldset>
			</fieldset>
			</div>
			</div>
			</div>
			</div>
 

	<fieldset>
	<fieldset>
	<legend></legend>
    <fieldset>
	<center>
	<input type="button" name="guar" value="Modificar"  onclick="validar()" class="btn btn-primary" >
	</center>
	</fieldset>
	</fieldset>
	</fieldset>
	
	
</form>
    </div>
	</div>
	</div>
	</div>
	</div>
	</div>

</body>
</html>
<script>
function validar()
	{
	
	 var edi=$("#editor").parent('div').find('.note-editable').html();
	  console.log(edi);
	  $( "#extracto" ).val(edi);
	 
	 document.rem.submit();
	}
</script>
