<?php
session_start();
include("class_sesion.php");
$sesion= new Sesion();
$CadenaPermisos = $sesion->iniciar();

include ("conexion.php");
 ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Turnero</title>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<link type="text/css" rel="stylesheet" href="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20051112" media="screen"/>
<script type="text/javascript" src="assest/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20060118"></script>
<script type="text/javascript" src="assest/Js/Botones.js"></script>

<link href="calendario_dw/calendario_dw-estilos.css" type="text/css" rel="STYLESHEET" >
<script type="text/javascript" src="calendario_dw/jquery-1.4.4.min.js"></script> 
<script type="text/javascript" src="calendario_dw/calendario_dw.js"></script>


<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="Js/ajax.js"></script>

<style type="text/css">
#popUp 
{
	width:105%;
	height:96%;
	z-index:1;
	background-color: #fff;
	border: 1px #ffffff solid;
	-moz-opacity: 0.50; 
	filter: alpha(opacity=85);
	-khtml-opacity: -5;
	opacity: .90; 
	display: none;
	margin-top: -610px;
	margin-left: -20px;
	-moz-border-radius: 20px;border-radius: 20px;
}

#abm
{
	background-color:#E8ECED;
	border: 1px #536B89 solid;
	-moz-opacity: 0; 
	filter: alpha(opacity=-5);
	-khtml-opacity: -5;
	opacity: .99; 
	display: block;
	margin-top: 5%;
	margin-left: 10%;
	margin-right: 10%;
	-moz-border-radius: 20px;border-radius: 20px;
}

#mensaje
{
	position:absolute;
	width:85%;
	height:100%;
	z-index:1;
	background-color: #111;
	border: 1px #E2E1DE solid;
	-moz-opacity: 0.99; 
	filter: alpha(opacity=99);
	-khtml-opacity: .99;
	opacity: .85; 
	display:none;
	-moz-border-radius: 20px;
	border-radius: 20px;
	margin-top: -5px;
	margin-left: -5px;
	margin-right: 150px;
	vertical-align: center;
	}

</style>

</head>

<body id="fondo">
            
<div class="container  succes" style="height:650px;"> <!-- Contenerdor margen de Pantalla standarizado -->
<br />
<div class="span-22  push-1"  id="titulo_main">
<center>
	<label>
        <?php
            $vari = new conexion();
            $vari->conectarse();
            
            $sql = "Select Titulo from tbl_tablas Where descripcion = '".$_GET['tabla']."'";
            $resultado = mysql_query($sql) or (die(mysql_error()));
            $row = mysql_fetch_array($resultado);
            
            echo $row['Titulo'];
            //echo ucwords($_GET['tabla']); 
        ?>
    </label>
</center>
</div>			
<div class="span-24">
<div id="menu_top" class="span-24 ">
	
<div class="span-22 push-1"> <!-- Cuerpo de Formulario -->

<form name="listado" action="class_operacion.php" method="post">

<?php
include("class_abm.php");

$tabla = new abm();
$tabla->listado($_GET['tabla']);

?>

<div id="popUp">
	<div id="abm">
    
    </div>
</div>

</form>
</div>
</div>
</div>

</body>
</html>
<script>


   function AbrirCalendario()
   {

           $(".campofecha").calendarioDW();

   }

     function principalL1()
	{
	document.listado.action = "principal.php";
	document.listado.submit();
	}

function AbrirPop(tabla, accion, id, tamaño)
	{

        var archivo = "class_abm_registros.php";
		
		div = document.getElementById('popUp');
		div.style.display = 'block';
		
		//alert(tamaño);
		var ancho = tamaño.split(",",1);
		var col = 1;
		if(ancho == "width=800")
		 {
			//usa dos columnas
			col = 2;
		 }
		
		// Obtendo la capa donde se muestran las respuestas del servidor
		var capa=document.getElementById('abm');
		// Creo el objeto AJAX
		var ajax=ObjetoAjax();
		// Coloco el mensaje "Cargando..." en la capa
		capa.innerHTML="Cargando...";
		// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
		ajax.open("POST",archivo, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("variable="+tabla+"~"+accion+"~"+id+"~"+tamaño+"~"+col);
		
		ajax.onreadystatechange=function()
			{
				if (ajax.readyState==4)
				{
					// Respuesta recibida. Coloco el texto plano en la capa correspondiente
					capa.innerHTML=ajax.responseText;
				}
			}        
		document.getElementById('abm').innerHTML = tabla+"-"+accion+"-"+id+"-"+tamaño;
	}
	
function Cerrar()
	{
		div = document.getElementById('popUp');
		div.style.display = 'none';
	}

var General; 
	
function CerrarMensaje()
	{
		div = document.getElementById('mensaje');
		div.style.display = 'none';
		document.getElementById(General).focus();
	}

function Aceptar(accion)
{
	var text = document.getElementById('validacionText').value.split('#');
	
	for(var key in text) 
	{
    	if(text[key] != "")
			{
				var campos = text[key].split('~');
				
				if(document.getElementById(campos[0]).value == "")
					{
						General = campos[0];
						var div = document.getElementById('mensaje');
						div.style.display = 'block';
						document.getElementById('textoMensaje').innerHTML = "El campo "+ campos[1] +" es requerido.";
						return false;
					}
			}
	}
	
	var sele = document.getElementById('validacionSelect').value.split('#');
	
	for(var key in sele) 
	{
    	if(sele[key] != "")
			{
				var campos = sele[key].split('~');
				
				if(document.getElementById(campos[0]).value == "0")
					{
						General = campos[0];
						var div = document.getElementById('mensaje');
						div.style.display = 'block';
						document.getElementById('textoMensaje').innerHTML = "El campo "+ campos[1] +" es requerido.";
						return false;
					}
			}
	}
	document.listado.submit();
}

function ObjetoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objet AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
}

/*
function letras(campo) 
	{

	var charpos = document.getElementById(campo.id).value.search("[^A-Za-z ]"); 
	if(document.getElementById(campo.id).value.length > 0 &&  charpos >= 0) 
		{ 
		document.getElementById(campo.id).value= document.getElementById(campo.id).value.slice(0, -1);
		document.getElementById(campo.id).value.focus();
		return false; 
		}
		 else 
		 	{
			return true;
			}
}

function alfanumerico(campo)
	{ 
	var charpos = document.getElementById(campo.id).value.search("[^A-Za-z0-9. ]"); 
	if(document.getElementById(campo.id).value.length > 0 &&  document.getElementById(campo.id) >= 0) 
		{ 
		document.getElementById(campo.id).value =  document.getElementById(campo.id).value.slice(0, -1)
		document.getElementById(campo.id).focus();
		return false; 
		} 
			else 
				{
				return true;
				}
	}
	
function numerico(campo) 
	{
	var charpos = document.getElementById(campo.id).value.search("[^0-9]"); 
    if (document.getElementById(campo.id).value.length > 0 &&  charpos >= 0)  
		{ 
		document.getElementById(campo.id).value = document.getElementById(campo.id).value.slice(0, -1);
		document.getElementById(campo.id).focus();
	    return false; 
		} 
			else 
				{
				return true;
				}
	}
*/
</script>