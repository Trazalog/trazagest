<?PHP


include("conexion.php");
$var = new conexion();
$var->conectarse();
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
include("class_notifica.php") ;
$notifica= new notifica();
//print_r($_SESSION);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Nueva contraseña</title>

    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet">
	<script language="JavaScript" src="funciones_js.js"></script>
    
     
   
  </head>
  <body>
  
  <div class="container">
        <div class="card card-container">
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png" />
            <p id="profile-name" class="profile-name-card"></p>

<form  class="form-horizontal"  role="form" border="1" action="cambiar_clave.php" method="post" onSubmit="return enviar()">
                      <?php
					  if( isset($_GET['error']) )
					  		echo "<span>La clave actual no es correcta<span>";
					  ?>
					  
					   <div class="form-group">
                       <label  for="pass" class="col-lg-4 control-label">Usuario</label>
                       <div class="col-lg-10">
					   <p></p>
                        <?php
						   
						    if( isset($_SESSION["id_usuario"]) )
							{
							 $us= $_SESSION["id_usuario"];
						     $sql="SELECT * FROM usuarios where id_usuario=$us ";
						      $result2=mysql_query($sql,$var->links);

                                 while( $row2 =mysql_fetch_assoc($result2))
	                               {
		                               echo $row2['nombre_real'];
	 
	                               }

						   }
						   
						   ?>
                          </div>
                      </div>
					 						  
											  
                      <div class="form-group">
                        <label  for="pass" class="col-lg-4 control-label">Contraseña Actual</label>
                          <div class="col-lg-10">
						  <p></p>
                            <input type="password" class="input"  name="pass" id="pass" 
                                 placeholder="Contraseña">
                          </div>
                      </div>
					  
					   <div class="form-group">
                        <label  for="nueva" class="col-lg-4 control-label">Contraseña Nueva</label>
                          <div class="col-lg-10">
						  <p></p>
                            <input type="password" class="input"  name="nueva" id="nueva" 
                                 placeholder="Contraseña">
                          </div>
                      </div>
					  
					    <div class="form-group">
                        <label  for="rep" class="col-lg-4 control-label">Repita Contraseña Nueva</label>
                          <div class="col-lg-10">
						  <p></p>
                            <input type="password" class="input"  name="rep" id="rep" 
                                 placeholder="Contraseña">
                          </div>
                      </div>
					  
					    <div class="form-group">
                        <label  for="fecha" class="col-lg-4 control-label">fecha</label>
                          <div class="col-lg-10">
						 <p></p>						 						  
						  <?php echo date("d-m-Y" );?> 
						  <input type="hidden" name="fecha" readonly="true" value="<?php 	
				echo date("d-m-Y" );?>" class="select" >
                          
                          </div>
                      </div>
					  
					  <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10"> 
                            <button type="submit" class="btn btn-primary">Cambiar</button>
                            <!--<input type="hidden" name="oper" value="W"/>-->
                        </div>
                      </div>  
    
    </form>
	
	</div>
	</div>
  </body>
</html>

<script>
function enviar()
	{
		var nueva=$('#nueva').val();
		var rep=$('#rep').val();
		
		if( (nueva!='')&&(nueva!=rep) )
		{
			alert('las contraseñas nuevas no coinsiden');
			return false;
		}
		
	
	}
</script>
