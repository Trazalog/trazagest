
<?php 

include("conexion.php");
$var = new conexion();
$var->conectarse();
$conec = $var->conectarse();




	if(isset($_POST["defensor"])) 
	{
		$defensor = $_POST["defensor"];
		
		$secretarias= $_POST['secretaria'];
		echo count($secretarias);
		for ($i=0;$i<count($secretarias);$i++)    
		{     
			echo "<br> Cerveza " . $i . ": " . $secretarias[$i];  
			$sql=" INSERT INTO asignacion_terceros(id_usuario,id_defensor) VALUES ('$secretarias[$i]','$defensor ')";
		
				$res=mysql_query($sql)or die($sql);
		} 
		header("Location: principal.php" );
				
			/*	$sql=" SELECT 
				O.id_expediente,
				O.nro_expediente,
				O.caratula, 
				O.fecha,
				 O.id_iniciador,
				   C.nombre
				     FROM expedientes O
					join iniciador C  on C.dni=O.id_iniciador
					Where O.nro_expediente = $id"; 
		
				$res=mysql_query($sql)or die($sql);
				$req=mysql_fetch_array($res);*/
				
			
	}			
				
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="http://code.jquery.com/jquery.min.js"></script>
<link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet" type="text/css" />
<script src="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/js/bootstrap.min.js"></script>

<script type="text/javascript" src="http://davidstutz.github.io/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>
<link rel="stylesheet" href="http://davidstutz.github.io/bootstrap-multiselect/dist/css/bootstrap-multiselect.css" type="text/css"/>

    <meta charset="UTF-8">
    <title> </title>
	 <link rel="stylesheet" href="css/bootstrap.css">
	 <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1">
		
	
	 
     <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	 

  <link href="css/bootstrap.min.css/bootstrap/3.3.6" rel="stylesheet">
  <link href="css/estilos.css/bootstrap/3.3.6" rel="stylesheet">
  <link href="bootstrap.css/bootstrap/3.3.6" rel="stylesheet">
   <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
  <script src="jquery.js"></script>
  
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	
	
	

   
    <script type="text/javascript" src="Js/ajax.js"></script>
   <!-- <script type="text/javascript" src="Js/Botones.js"></script>-->
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script type="text/javascript" src="jQuery/jquery-1.6.1.min.js"></script>
    <script type="text/javascript" src="jQuery/jquery-ui-1.8.10.custom.min.js"></script>
    <script type="text/javascript" src="paginas/generarStock/js/funcion.js"></script>
    <link rel="stylesheet" type="text/css" href="jQuery/jquery.autocomplete.css" /></script>
    <script type="text/javascript" src="jQuery/jquery.js"></script>
    <script type="text/javascript" src="jQuery/jquery.autocomplete.js"></script>

   <!-- <script type="text/javascript" src="calendario_dw/calendario_dw.js"></script>-->


  

  
	
  <script type="text/javascript">
  
 <!--$(function () {
  <!--      $('#secretaria').multiselect({
  <!--   includeSelectAllOption: true
<!--  });-->
  $(document).ready(function() {
        $('#secretaria').multiselect();
    });
});
	
	
	<!--$(document).ready(function() {-->
	$('#defensor').multiselect();
	});
</script>

    

    </head>
    <body> 
	 
	
	   <div class="container"> 
	   <form name="listado" method="post" id="listado" action="#" "form-horizontal" role="form" >
		<br>
		<div class="form-group">
		<h3 class="text-center"> Asiganacion de Secretaria
		</h3>
		</div>
		
	    <fieldset>
	    <fieldset>
        <legend > </legend>
							
				
	    <fieldset>
	    <fieldset>
				
		<div class="form-group">
		<legend ></legend>
	    	   <table width="100%" align="center">
               <tbody>
			   <tr>
			   <td align="center">
			   <div class="form-group" id="lo">
			   <label >Defensor</label>
			   <h3></h3>
               <p></p>
			   
			   <!--<select name="defensor"  id="defensor"  size='10' style='color:CDEAFB ;background-color:#CDEAFB' >-->
                   <select name="defensor"  id="defensor" >
                   <option value='<?php
							                $consulta2="SELECT * FROM usuarios WHERE tipo='1' ";
							                $result2=mysql_query($consulta2,$var->links);
							                 while($row2=mysql_fetch_array($result2))
								                {
									                echo "<option value='".$row2['id_usuario']."'>".$row2['nombre_real']."</option>";
								 
								                 }
							
						                  ?>'></option>
            </select>
            </div>
			</center>
			</td>
			<center>
			<td align="center">
			<center>
		    <div class="form-group" id="lo">
			<h3></h3>
            <p></p>
            <label><center> Secretaria</center></label> 
			<h3></h3>
            <p></p>
			</center>
			<select name="secretaria[]" id="secretaria" multiple="multiple">
    
		    <!--<select name="secretaria[]"  id="secretaria" multiple size='10' style='color:CDEAFB ;background-color:#CDEAFB'>-->
                   <option value='<?php
						          $consulta2="SELECT * FROM usuarios where tipo='0' ";
						          $result2=mysql_query($consulta2,$var->links);
						          while($row2=mysql_fetch_array($result2))
							           {
								          echo "<option value='".$row2['id_usuario']."'>".$row2['nombre_real']."</option>";
							 
							           }
						
					              ?>'></option>
             </select>
             </div>
			 </td>
			 </center>
			 </tr>
		     </tbody>
			 </table>
		     </fieldset>
	         </fieldset>
			 </fieldset>
	         </fieldset>
	
    <fieldset> 
    <legend></legend>
    <center>
    <input type="button" value="Guardar" class="btn btn-primary"onclick="validaAsignacion()" >
    &nbsp;&nbsp;&nbsp;
	<input type="button" value="Principal" class="btn btn-primary" onclick="principal()">
    </center>
	</fieldset>
    </form>
	
</div> <!--fin container-->

    
    </body>
    </html>
	
<script>

function principal()
	{
		location.href="./principal.php";
	}

	

	
function validaAsignacion()
	{
		
		document.listado.submit();
      
	 
	} 
	
</script>
