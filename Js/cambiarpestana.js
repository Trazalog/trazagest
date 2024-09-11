// JavaScript Document
// Dadas la division que contiene todas las pesta�as y la de la pesta�a que se
// quiere mostrar, la funcion oculta todas las pesta�as a excepcion de esa.
function cambiarPestanna(pestannas,pestanna) {
    
    // Obtiene los elementos con los identificadores pasados.
    pestanna = document.getElementById(pestanna.id);
    listaPestannas = document.getElementById(pestannas.id);
    
    // Obtiene las divisiones que tienen el contenido de las pesta�as.
    cpestanna = document.getElementById('c'+pestanna.id);
    listacPestannas = document.getElementById('contenido'+pestannas.id);
    
    i=0;
    // Recorre la lista ocultando todas las pesta�as y restaurando el fondo
    // y el padding de las pesta�as.
    while (typeof listacPestannas.getElementsByTagName('div')[i] != 'undefined'){
        $(document).ready(function(){
            $(listacPestannas.getElementsByTagName('div')[i]).css('display','none');
            $(listaPestannas.getElementsByTagName('li')[i]).css('background','');
            $(listaPestannas.getElementsByTagName('li')[i]).css('padding-bottom','');
        });
        i += 1;
    }
 
    $(document).ready(function(){
        // Muestra el contenido de la pesta�a pasada como parametro a la funcion,
        // cambia el color de la pesta�a y aumenta el padding para que tape el  
        // borde superior del contenido que esta juesto debajo y se vea de este
        // modo que esta seleccionada.
        $(cpestanna).css('display','');
        $(pestanna).css('background','#FFF');
        $(pestanna).css('padding-bottom','2px');
    });
 
}