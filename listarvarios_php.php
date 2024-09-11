<?php

function notificaciones($result,$usu) { // inicio y seleccion de lo que quiero mostrar
	echo' <ul class="list-group">';
	while ($registro = mysql_fetch_row($result)) {
		echo'<li class="list-group-item">'.$registro['2'].'-'.$registro['1'].'</li>';
	}
	echo'</ul>';
}
?>

<script>
	function principal()
	{
		document.formlitexp.action = "principal.php";
		document.formlitexp.submit();
	}

	function edita(expe)
    {
		var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,width=1024,height=1024" ;
	    window.open("panelexpediente.php?expe="+expe,"nombreventa na", opciones);
    }
</script>
