<?PHP
include("conexion.php");
session_start();
include("class_sesion.php");
$sesion= new Sesion();
$CadenaPermisos = $sesion->iniciar();
include("class_menu.php") ;
include("class_listado.php") ;
@session_start(); 

$clie= $_SESSION["id_usuario"];

			$menu= new menu();
			$info= new info();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>Soporte tecnico</title>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">

 
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<script type="text/javascript" src="Js/cambiarpestana.js"></script>
    <script type="text/javascript" src="Js/jquery-1.7.2.min.js"></script>
<link href="estilos.css" rel="stylesheet" type="text/css">
<script   type="text/javascript" src="Js/Botones.js"></script>

</head>
<center>
<body id="fondo" >
<div style="height:15px;"></div>
<div class="container  large" style="height:850px;"> <!-- Contenerdor margen de Pantalla standarizado -->

    <div style="height:5px;"> </div>
    <div push-7 span-10>
                <?php
                    $menu->menu_ppal($CadenaPermisos);
					
                ?>
     </div>
 <div class="contenedor">
        <div class="titulo">Bienvenido <?php $info->nom_cliente($clie); ?></div>
        <div id="pestanas">
            <ul id=lista>
                <li id="pestana1"><a href='javascript:cambiarPestanna(pestanas,pestana1);'>Cuotas Pendientes</a></li>
                <li id="pestana2"><a href='javascript:cambiarPestanna(pestanas,pestana2);'>Informacion</a></li>
            </ul>
        </div>
 
        <body onload="javascript:cambiarPestanna(pestanas,pestana1);">
 
        <div id="contenidopestanas">
            <div id="cpestana1">
                <?php
                    
					$info->info_cuotas($clie);
                ?>
            </div>
            <div id="cpestana2">
			<?php
                    
					$info->info_cliente($clie);
                ?>
               
            </div>
    </div>   

<div/>


</body>
</center>
</html>
<script language=JavaScript>
<!--

function inhabilitar(){
    alert ('Esta funci?n est? inhabilitada.Comuniquese con el administrador.')
    return false
}

//document.oncontextmenu=inhabilitar

// -->
</script> 