<?php include 'indexxx.php'; ?>
<!--
//**********************************************************************************
 Archivo p4rincipal donde se abriran todas las paginas.
- - >

<frameset rows="0%,*" frameborder="0" framespacing="0" border="0">
	<frame name="" src="principal.php" marginwidth="0" marginheight="0" scrolling="auto" >
	<frame name="" src="indexxx.php" marginwidth="10" marginheight="10" scrolling="auto" style="height:950px; background-color:#003D78;" >
</frameset><noframes></noframes>

</html>

<script>

function Cargar()
	{
		var capa=document.getElementById('Contenido');
		// Creo el objeto AJAX
		var ajax=nuevoAjax();
		// Coloco el mensaje "Cargando..." en la capa
		capa.innerHTML="Cargando...";
		// Abro la conexi?n, env?o cabeceras correspondientes al uso de POST y env?o los datos con el m?todo send del objeto AJAX
		ajax.open("POST", "nuevo.php", true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("variable="+0);

		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}

	}


	function nuevoAjax()
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
