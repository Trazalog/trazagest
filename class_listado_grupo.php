<?php  
session_start();
include("class_sesion.php");
$sesion= new Sesion();
$CadenaPermisos = $sesion->iniciar();

include ("conexion.php");
 ?>
 <br />
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
<script   type="text/javascript" src="assest/Js/Botones.js"></script>
  
<script language="javascript" src="abm_iniciador_js.js" type="text/javascript"></script>

<script   type="text/javascript" src="Js/validacionesDeEntrada.js"></script>
<script   type="text/javascript" src="Js/ajax.js"></script>

<style type="text/css">
#popUp 
{
	width:105%;
	height:96%;
	z-index:1;
	background-color: #000;
	border: 1px #212121 solid;
	-moz-opacity: 0.50; 
	filter: alpha(opacity=85);
	-khtml-opacity: .85;
	opacity: .85; 
	display: none;
	margin-top: -610px;
	margin-left: -20px;
	-moz-border-radius: 20px;border-radius: 20px;
}

#abm
{
	background-color:#999;
	border: 1px #212121 solid;
	-moz-opacity: 0.95; 
	filter: alpha(opacity=95);
	-khtml-opacity: .95;
	opacity: .95; 
	display: block;
	margin-top: 5%;
	margin-left: 10%;
	margin-right: 10%;
	-moz-border-radius: 20px;border-radius: 20px;
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

<form name="listado" action="class_operacion_grupo.php" method="post">

<?php
include("class_abm_grupo.php");

$tabla = new abm();
$tabla->listado($_GET['tabla']);

?>

<div id="popUp">
	<div id="abm" style="height:500px;">
		
    </div>
</div>

</form>
</div>
</div>
</div>

</body>
</html>
<script>
function seleccionar(valor)
	{
	 div = document.getElementById(valor+'div');

	 if (div.style.display == 'block')
	 	{
		 div.style.display = 'none';
		}
		else
			{
			 div.style.display = 'block';
			}

	}

function AbrirPop(tabla, accion, id, tamaño)
	{
		var archivo = "class_abm_registros_grupo.php";
		
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

function Aceptar(accion)
{
	document.listado.indicesMenu.value = "";
	
	var elementos = document.listado.elements.length;

	for(i=0; i<elementos; i++)
		{
	
		if(document.listado.elements[i].type == 'checkbox')
			{
			 if(document.listado.elements[i].checked == true)
			 	{
					if(document.listado.indicesMenu.value == "")
					{
				 		document.listado.indicesMenu.value = document.listado.elements[i].name;
					}else
						{
							document.listado.indicesMenu.value = document.listado.indicesMenu.value +"-"+ document.listado.elements[i].name;
						}
				}
			}

		}
	//alert(document.listado.indicesMenu.value);
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
</script>