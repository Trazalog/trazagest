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

function ajaxx(valor1,id_div,controller, lmtMenor, lmtMayor, opcion)
{
	//alert(opcion);
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", controller, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+valor1+"~"+lmtMenor+"~"+lmtMayor+"~"+opcion);// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion
ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}

function ajaxp(valor1,id_div,controller)
{
	//alert(opcion);
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", controller, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+valor1);// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion
ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}

function ajaxx2(valor1,id_div,controller)
{
	//alert(opcion);
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", controller, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+valor1);// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion
ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}

function ajaxxx(valor1,depId,id_div,controller)
{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", controller, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+valor1+"~"+depId);// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   //RESPONDE CAJETON !!!! 
//c="+id_in+"~"+id_des

ajax.onreadystatechange=function()
	{
		if (ajax.readyState==4)
		{
			// Respuesta recibida. Coloco el texto plano en la capa correspondiente
			capa.innerHTML=ajax.responseText;
		}
	}
}

function Agregar(agregar,idProd,idDep,Cantidad,Bultos,Kg,id_div,archivo)
{
	if(agregar == "valido")
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", archivo, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+idProd+"~"+idDep+"~"+Cantidad+"~"+Bultos+"~"+Kg);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}
		
		Limpiar();
	 /*
	 */
	}else
	{
		return false();
	}
}

function AgregaraEgreso(agregar,idProd,idDep,Cantidad,Bultos,Kgs,id_div,archivo)
{
	if(agregar == "valido")
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", archivo, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+idProd+"~"+idDep+"~"+Cantidad+"~"+Bultos+"~"+Kgs);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}
		
		Limpiar();
	}else
	{
		return false;
	}
}

function Busque(idDep,idDiv,Archivo)
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(idDiv);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", Archivo, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+idDep);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}	
	}
	
function eliminar(valor,id_div,archivo)
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", archivo, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+valor);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}
	}

function eliminar2(valor,depId,id_div,archivo)
	{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", archivo, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	// Al parecer esto crea una variable con nombre d que luego es utilizada en la pagina a la que llama esta accion   
	ajax.send("variable="+valor+"~"+depId);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}
	}		

function ajax2(valor1,id_div,controller,nombreTabla)
{
	// Obtendo la capa donde se muestran las respuestas del servidor
	var capa=document.getElementById(id_div);
	// Creo el objeto AJAX
	var ajax=nuevoAjax();
	// Coloco el mensaje "Cargando..." en la capa
	capa.innerHTML="Cargando...";
	// Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
	ajax.open("POST", controller, true);
	ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	
	
	ajax.send("variable="+valor1+"~"+nombreTabla);

	ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				// Respuesta recibida. Coloco el texto plano en la capa correspondiente
				capa.innerHTML=ajax.responseText;
			}
		}
}

function ShowDiv(id) //oculta DIV
{
    
	if(document.getElementById(id).style.display=='none')
	{ 
     document.getElementById(id).style.display='';
    }
	else
	{
     document.getElementById(id).style.display='none';
    }
}

function ShowDiv2(id) //oculta DIV
{
    
	if(document.getElementById(id).style.display=='none')
	{ 
     document.getElementById(id).style.display='';
    }
	
}

function PopWindows(ventana,titulo, alto , ancho)
{ 
window.open(ventana,titulo, "directories=no, menubar =no,status=no,toolbar=no,location=no,scrollbars=yes,fullscreen=no,height="+alto+",width="+ancho+"");
}


function ShowDiv(id) //oculta DIV
{
    
	if(document.getElementById(id).style.display=='')
	{ 
     document.getElementById(id).style.display='none';
    }
	else
	{
     document.getElementById(id).style.display='';
    }
}