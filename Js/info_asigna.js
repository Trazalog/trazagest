function OAjax() {
    /* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
     lo que se puede copiar tal como esta aqui */
    var xmlhttp=false;
    try {
        // Creacion del objeto AJAX para navegadores no IE
        xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e) {
        try {
            // Creacion del objet AJAX para IE
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        catch(E) { xmlhttp=false; }
    }
    if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); }

    return xmlhttp;
}



function AbrirInfo(id, idcontrato) {// id  id contrato

    var archivo = "Class_detalle_asigna.php";
    var tabla='contrato';

    div = document.getElementById('abm');
    div.style.display = 'block';

    // Obtendo la capa donde se muestran las respuestas del servidor
    var capa=document.getElementById('d'+id);
    // Creo el objeto AJAX
    var ajax=OAjax();
    // Coloco el mensaje "Cargando..." en la capa
    capa.innerHTML="Cargando...";
    // Abro la conexión, envío cabeceras correspondientes al uso de POST y envío los datos con el método send del objeto AJAX
    ajax.open("POST",archivo, true);
    ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    // ajax.send("co="+idcontrato);
    ajax.send("variable="+tabla+"~"+idcontrato+"~"+id);
    ajax.onreadystatechange=function() {
        if (ajax.readyState==4) {
            // Respuesta recibida. Coloco el texto plano en la capa correspondiente
            capa.innerHTML=ajax.responseText;
        }
    }
    document.getElementById('d'+id).innerHTML =capa;
}



function visor (id,data,idexpe ) {
    //alert('id es:'+id);
    //alert('contrato '+data);
    AbrirInfo(data,idexpe);
    document.getElementById('d'+data).style.display = 'block';
    document.getElementById('d'+data).style.backgroundColor='aliceblue';
    // alert ('d'+data);
}
