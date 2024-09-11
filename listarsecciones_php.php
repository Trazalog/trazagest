<?php

function expedienteprincipal($us,$result) { // inicio y seleccion de lo que quiero mostrar
	echo'<div class="panel panel-default">';
		echo'<div class="panel-heading"><h3 class="panel-title">Datos de Expedientes</h3></div>';
		echo'<div class="panel-body">';
		echo '<table class="table table-hover table-bordered table-striped" id="tbl_principal">';
		    echo '<thead>';
				echo '<tr>';
                	print '<th><strong> Nro. Expediente</strong> </th>';
					print '<th><strong> Iniciador</strong> </th>';
					print '<th><strong> Extracto</strong> </th>';
					print '<th><strong> Fecha Entrada </strong> </th>';
					print '<th><strong> Letra</strong> </th>';
					print '<th></th>';
					print '<th></th>';
				echo'</tr>';
            echo '</thead>';
            echo '<tbody>';

			    while ($registro = mysql_fetch_row($result)) {
					echo '<tr>';
						echo "<td>$registro[0]</th>";
						echo "<td>$registro[1]</th>";
						echo "<td>$registro[2]</th>";
						echo "<td>$registro[4]</th>";
						echo "<td>$registro[5]</th>";

						switch ($us) {
							case 'admin':
							{
								echo "<td></td>";
								echo "<td></td>";
								break;
							}
							case 'agentes':
							{
								echo '<td> <button type="button" onClick="edita('.$registro[0].');" on class="btn btn-default"> <span class=" glyphicon glyphicon-folder-open">
									</td>';
								echo '<td> <button type="button" onClick="edita('.$registro[0].');" on class="btn btn-default"> <span class="glyphicon glyphicon-chevron-down">
								   </td>';
								break;

							}
							case 'entrada':
							{
								echo "<td></td>";
								echo "<td></td>";
								break;
							}
							case 'info':
							{
								echo "<td></td>";
								echo "<td></td>";
								break;
							}
							case 'archivo':
							{
								echo '<td> <button type="button" onClick="edita('.$registro[0].');" on class="btn btn-default"> <span class=" glyphicon glyphicon-folder-open">
								   </td>';
								echo '<td> <button type="button" onClick="archiva('.$registro[0].');" on class="btn btn-default"> <span class="glyphicon glyphicon-folder-close" title="Archivar expediente">
								   </td>';
								break;
							}
							default:
							{
								echo "<td></td>";
								echo "<td></td>";
							}
						}
					echo "</tr>";
				}
			echo "</tbody>";
			/*echo '<tfoot>';
				echo '<tr>';
                	print '<th><strong> Nro. Expediente</strong> </th>';  //escribe el titulo de
					print '<th><strong> Iniciador</strong> </th>';
					print '<th><strong> Extracto</strong> </th>';
					print '<th><strong> Fecha Entrada </strong> </th>';
					print '<th><strong> Letra</strong> </th>';
				echo'</tr>';
            echo '</tfoot>';*/
		echo "</table>";
	echo'</div></div>';
}

function datosexpdiente($us,$result) { // inicio y seleccion de lo que quiero mostrar
	echo '<br><div class="panel panel-default">';
	echo '<div class="panel-heading"><h4>Datos de Expedientes</h4></div>';
	echo '<table class="table table-bordered">';
	    echo '<thead>';
			echo '<tr>';
				print '<th><strong> Nro. Expediente</strong> </th>';
				print '<th><strong> Fecha Entrada </strong> </th>';
				print '<th><strong> Extracto</strong> </th>';
				print '<th><strong> Iniciador</strong> </th>';
				print '<th><strong> Estado</strong> </th>';
				print '<th><strong> Letra</strong> </th>';
				print '<th colspan="2"></th>';
			echo '</tr>';
	    echo '</thead>';
	    echo '<tbody>';

		    while ($registro = mysql_fetch_row($result)) {
				echo '<tr>';
				echo "<td class='info'>$registro[0]</td>";
				echo "<td class='info'>$registro[4]</td>";
				echo "<td class='info'>$registro[2]</td>";
				echo "<td class='info'>$registro[1]</td>";
				echo "<td class='info'>$registro[7]</th>";
				echo "<td class='info'>$registro[5]</td>";
				echo "<td class='info'>
					<img src=\"assest\plugins\buttons\icons/printer.png\" onClick=\"Imprime('".$registro[0]."');\" title=\"Imprimir expediente.\" style='cursor:pointer' />
					   </td>";

				switch ($us) {
					case 'admin':
					{
						echo "<td class='info'>
						<img src=\"assest\plugins\buttons\icons/editar.png\" onClick=\"editaexpe('".$registro[0]."');\"title=\"Edita expediente.\" style='cursor:pointer' /></td>";
					    break;
					}
					case 'agentes':
					{
						echo "<td class='info'></td>";
					    break;
					}
					case 'entrada':
					{
						echo "<td class='info'></td>";
					    break;
					}
					case 'info':
					{
						echo "<td class='info'></td>";
					    break;
					}
					default:
					{
						echo "<td class='info'></td>";
					}
				}
				echo "</tr>";
				//echo "</body>";
			}
		echo "</tbody>";
	echo "</table>";
	echo '<div class="panel-body">';
}

function listarvincu($exp ,$result,$us) { // inicio y seleccion de lo que quiero mostrar
	echo'<div class="panel panel-default">';
	  	echo'<div class="panel-heading">EXPEDIENTES VINCULADOS ';
		if ($us=='admin') {
			echo'<button   align="rigths" type="button" onClick="vincula('.$exp.');" on class="btn btn-default">
				<span class="glyphicon glyphicon-retweet"></span>
				</button>';
  		}
  		echo'</div> ';
  		echo '<div class="panel-body">';
		echo "<div id='abm'  styles='display:none;'/></div>";

		echo '<table class="table table-hover table-bordered table-striped">';
	        echo '<thead>';
				echo'<tr >';
					print "<th><strong>Expediente Vinculado</strong></th>";  //escribe el titulo de la tabla
					print "<th><strong>fecha</strong></th>";
					//print "<th><strong>Observación</strong></th>";
					print "<th></th>";
				echo'</tr>';
			echo '</thead>';
			echo '<tbody>';

			while ($registro = mysql_fetch_row($result)) {
				echo '<tr>';
  			 		echo "<td>$registro[0]</td>";
					echo "<td>$registro[1]</td>";
					//echo "<td>$registro[2]</td>";

					switch ($us) {
						case 'admin':
						{
							echo "<td><img src=\"assest\plugins\buttons\icons/editar.png\"
					    		onClick=\"asigadef('".$registro[2]."');\" title=\"edita vínculo\" style='cursor:pointer' />
					   			</td>";
							break;
						}
						case 'agentes':
						{
							echo "<td></td>";
							break;
						}
						case 'entrada':
						{
							echo "<td></td>";
							break;
						}
						case 'info':
						{
							echo "<td></td>";
							break;
						}
						default:
						{
							echo "<td></td>";
						}
					}
				echo '</tr>';
			}

			echo "</tbody>";
		echo "</table>";
	echo '</div>';
	echo '</div>';
}

function listarfuncionario($in,$result,$us) { //(PASES) inicio y seleccion de lo que quiero mostrar
	echo '<div class="panel panel-default">';
		echo '<div class="panel-heading">PASES';
	    if ($us=='admin') {
			echo' <button type="button" onClick="asignadefensor('.$in.');" on class="btn btn-default"> <span class="glyphicon glyphicon-plus">';
	    }
	    echo '</div>';
	    echo '<div class="panel-body">';
	    echo "<div id='abm' styles='display:none;'/></div>";

		echo '<table class="table table-hover table-bordered table-striped" id="tbl_pasos">';
	        echo '<thead>';
				echo'<tr >';
					print '<th></th>';
					print "<th><strong>Funcionario</strong></th>";
					print "<th><strong>Cargo</strong></th>";
					print "<th><strong>Fecha Asignación</strong></th>";
					print "<th><strong>folios recibidos</strong></th>";
					print "<th colspan='2'></th>";
				echo'</tr>';
	        echo '</thead>';
	        echo '<tbody>';

			while ($registro = mysql_fetch_row($result)) {
			    echo "<tr name='$registro[4]' >"; $estado=$registro[0];
					echo"<td class='info'> <button type='button' onclick='visor(this.id,$registro[4],$registro[5])''
				        	class='btn btn-default'>++</button></td>";
					echo "<td class='info'>$registro[0]</td>";
					echo "<td class='info'>$registro[1]</td>";
					echo "<td class='info'>$registro[2]</td>";
					echo "<td class='info'>$registro[3]</td>";

				    switch ($us) {
						case 'admin':
						{
							echo "<td class='info' ><img src=\"assest\plugins\buttons\icons/editar.png\" onClick=\"asigadef('".$registro[4]."');\" title=\"edita movimiento\" style='cursor:pointer'/></td>";
							
			   		 		echo "<td class='info'><strong><img src=\"assest\plugins\buttons\icons\add.png\" onClick=\"asignaagente('".$in ."');\" title=\"edita movimiento.\" style='cursor:pointer' /></td>";
			   		 		break;
						}
						case 'agentes':
						{
							echo "<td class='info'></td>";
					    	break;
						}
						case 'entrada':
						{
							echo "<td class='info'></td>";
					    	break;
						}
						case 'info':
						{
							echo "<td class='info'></td>";
					    	break;
						}
						default:
						{
							echo "<td class='info'></td>";
						}
					}
				echo '</tr>';
				echo "<tr class='test'>";
					echo "<td colspan='7'><div id='d$registro[4]' name='d$registro[4]' style='display:none;'></div></td>";
				echo"</tr>";
			}


			echo "</tbody>";
		echo "</table>";
	echo'</div>';
	echo'</div><!-- Fin .panel .panel-default -->';
}

function listarresolucion($exp ,$result, $us) {// inicio y seleccion de lo que quiero mostrar
	echo'<div class="panel panel-default">';

		echo'<div class="panel-heading">RESOLUCION ';
		if ($us=='agentes' || $us=='admin')	{
			echo'<button type="button" onClick="resolucion('.$exp.');" on class="btn btn-default"> <span class="glyphicon glyphicon-plus">';
		}
		echo'</div>';
		echo'<div class="panel-body">';
		echo "<div id='abm' styles='display:none;'/></div>";

		echo '<table class="table table-hover table-bordered table-striped" id="tbl_resolucion">';
	        echo '<thead>';
				echo'<tr >';
				print "<th><strong>Nro</strong></th>";  //escribe el titulo de la tabla
				print "<th><strong>Fecha</strong></th>";
				print "<th><strong>Descripción</strong></th>";
				print "<th><strong>PDF</strong></th>";
				print "<th width='10%'></th>";
				echo'</tr>';
	        echo '</thead>';
	        echo '<tbody>';
			while ($registro = mysql_fetch_row($result)) {
				echo '<tr>';
					echo "<td>$registro[0]</td>";
					echo "<td>$registro[2]</td>";

					//echo "<td>".strip_tags(trim($registro[1]))."</td>";
					if (strlen($registro[1]) > 60)
						echo "<td>". substr(strip_tags(trim($registro[1])),0,60).'...<a onclick="rmostrar(event, '.$registro[0].')" style="cursor:pointer" href="">[ver]</a></td>';
    				else
    					echo "<td>".strip_tags($registro[1])."</td>";
					if ($registro[4] != '')
						echo "<td><a href='expedientesPDF/".$registro[4]."' title='Cédula PDF' rel='noopener noreferrer' target='_blank'>Ver archivo</a></td>";
					else
						echo "<td></td>";
					switch ($us) {
						case 'admin':
						{
							echo "<td class='info'>
							<img src=\"assest\plugins\buttons\icons/printer.png\" onClick=\"ImprimeResolucion('".$registro[3]."');\" title=\"Imprimir Resolución.\" style='cursor:pointer' /></td>";
							break;
						}
						case 'agentes':
						{
							echo "<td class='info'>
							<img src=\"assest\plugins\buttons\icons/printer.png\" onClick=\"ImprimeResolucion('".$registro[3]."');\" title=\"Imprimir Resolución.\" style='cursor:pointer' /></td>";
							break;	
						}
						case 'entrada':
						{
							echo "<td></td>";
							break;
						}
						case 'info':
						{
							echo "<td></td>";
							break;
						}
						default:
						{
							echo "<td></td>";
						}
					}
				echo '</tr>';
		    }
		    echo "</tbody>";
		echo "</table>";
	echo'</div>';
	echo'</div>';
}

// Permite <p> y <a>
//echo strip_tags($text, '<p><a>'); //lo comente

function listaroficio($exp,$result,$us) { // inicio y seleccion de lo que quiero mostrar
	echo'<div class="panel panel-default">';
		echo'<div class="panel-heading">OFICIO';
		if ($us=='agentes' || $us=='admin') {
			echo' <button type="button" onClick="oficio('.$exp.');" on class="btn btn-default">
    		<span class="glyphicon glyphicon-plus"></span>';
		}
  		echo'</button></div>';
  		echo'<div class="panel-body">';
		echo "<div id='abm'  styles='display:none;'/></div>";

		echo '<table class="table table-hover table-bordered table-striped" id="tbl_oficio">';
	        echo '<thead>';
				echo'<tr >';
					//print "<th><strong>Nro</strong></th>";
					print "<th><strong>Fecha</strong></th>";  //escribe el titulo de la tabla
					print "<th><strong>Descripción</strong></th>";
					print "<th><strong>copias</strong></th>";
					print "<th><strong>PDF</strong></th>";
					print "<th width='10%'></th>";
	 	 		echo'</tr>';
	        echo '</thead>';
	        echo '<tbody>';

			while ($registro = mysql_fetch_row($result)) {
				echo '<tr>';
					//echo "<td>$registro[0]</td>";
  			 		echo "<td>$registro[1]</td>";

				    //echo "<td >$registro[2]</td>"; mmostrar
					if (strlen($registro[2]) > 60)
						echo "<td>". substr(strip_tags(trim($registro[2])),0,60).'...<a onclick="mmostrar(event, '.$registro[0].')" style="cursor:pointer" href="">[ver]</a></td>';
    				else
    					echo "<td>".strip_tags($registro[2])."</td>";
					//echo "<td>$registro[2]</td>";
					echo "<td>$registro[3]</td>";
					if ($registro[4] != '')
						echo "<td><a href='oficio/".$registro[4]."' title='Cédula PDF' rel='noopener noreferrer' target='_blank'>Ver archivo</a></td>";
					else
						echo "<td></td>";
					switch ($us) {
						case 'admin':
						{
							echo "<td><img src=\"assest\plugins\buttons\icons/editar.png\"
					    		onClick=\"moficio('".$registro[0]."');\" title=\"edita oficio\" style='cursor:pointer' />&nbsp;&nbsp;
					    		<img src=\"assest\plugins\buttons\icons/printer.png\" onClick=\"ImprimeOficio('".$registro[0]."');\" title=\"Imprimir oficio.\" style='cursor:pointer' />
					   			</td>";

								break;
						}
						case 'agentes':
						{
							echo "<td class='info'>
							<img src=\"assest\plugins\buttons\icons/printer.png\" onClick=\"ImprimeOficio('".$registro[0]."');\" title=\"Imprimir oficio.\" style='cursor:pointer' /></td>";
							break;
						}
						case 'entrada':
						{
							echo "<td></td>";
							break;
						}
						case 'info':
						{
							echo "<td></td>";
							break;
						}
						default:
						{
							echo "<td></td>";
						}
					}
				echo '</tr>';
		    }
		    echo "</tbody>";
		echo "</table>";
	echo'</div>';
	echo'</div>';
}

function listarnota($exp ,$result,$us) { // inicio y seleccion de lo que quiero mostrar
	echo'<div class="panel panel-default">';
		echo'<div class="panel-heading">NOTA';
		if ($us=='agentes' || $us=='admin') {
			echo' <button type="button" onClick="nota('.$exp.');" on class="btn btn-default">
				<span class="glyphicon glyphicon-plus"></span>
				</button>';
		}
		echo'</div>';
		echo'<div class="panel-body">';
		echo "<div id='abm' styles='display:none;'/></div>";

		echo '<table class="table table-hover table-bordered table-striped" id="tbl_nota">';
	        echo '<thead>';
				echo'<tr >';
					print "<th><strong>Folio</strong></th>";  //escribe el titulo de la tabla
					print "<th><strong>Fecha</strong></th>";
					print "<th><strong>Descripción</strong></th>";
					print "<th><strong>Copias</strong></th>";
					print "<th><strong>PDF</strong></th>";
					print "<th width='10%'></th>";
				echo'</tr>';
			echo '</thead>';
			echo '<tbody>';

			while ($registro = mysql_fetch_row($result)) {
				echo '<tr>';
					echo "<td>$registro[4]</td>";
					echo "<td>$registro[1]</td>";

					if (strlen($registro[0]) > 60)
						echo "<td>".substr(strip_tags(trim($registro[0])),0,60).'...<a onclick="nmostrar(event, '.$registro[4].')" style="cursor:pointer" href="">[ver]</a></td>';
    				else
    					echo "<td>".strip_tags($registro[0])."</td>";

    				echo "<td>$registro[2]</td>";
    				if ($registro[3] != '')
						echo "<td><a href='nota/".$registro[3]."' title='Cédula PDF' rel='noopener noreferrer' target='_blank'>Ver archivo</a></td>";
					else
						echo "<td></td>";
					switch ($us) {
						case 'admin':
						{
							echo "<td><img src=\"assest\plugins\buttons\icons/editar.png\"
								onClick=\"mnota('".$registro[4]."');\" title=\"edita nota\" style='cursor:pointer' />&nbsp;&nbsp;
								<img src=\"assest\plugins\buttons\icons/printer.png\" onClick=\"ImprimeNota('".$registro[4]."');\" title=\"Imprimir nota.\" style='cursor:pointer' />
								</td>";
							break;
						}
						case 'agentes':
						{
							echo "<td class='info'>
							<img src=\"assest\plugins\buttons\icons/printer.png\" onClick=\"ImprimeNota('".$registro[4]."');\" title=\"Imprimir nota.\" style='cursor:pointer' /></td>";
							break;
						}
						case 'entrada':
						{
							echo "<td></td>";
							break;
						}
						case 'info':
						{
							echo "<td></td>";
							break;
						}
						default:
						{
							echo "<td></td>";
						}
					}
				echo '</tr>';
			}

			echo "</tbody>";
		echo "</table>";
	echo'</div>';
	echo'</div>';
}

function listarcedula($exp ,$result,$us) {// inicio y seleccion de lo que quiero mostrar
	echo'<div class="panel panel-default">';
		echo'<div class="panel-heading">CEDULA';
		if ($us=='agentes' || $us=='admin') {
			echo' <button type="button" onClick="cedula('.$exp.');" on class="btn btn-default">
				<span class="glyphicon glyphicon-plus"></span>
				</button>';
		}
		echo'</div>';
		echo'<div class="panel-body">';

		echo "<div id='abm'  styles='display:none;'/></div>";

		echo '<table class="table table-hover table-bordered table-striped" id="tbl_cedula">';
	        echo '<thead>';
				echo'<tr >';
					//print "<th><strong>Nro</strong></th>";  //escribe el titulo de la tabla
					print "<th><strong>Fecha</strong></th>";
					print "<th><strong>Descripción</strong></th>";
					print "<th><strong>Copias</strong></th>";
					print "<th><strong>PDF</strong></th>";
					print "<th width='10%'></th>";
				echo'</tr>';
			echo '</thead>';
			echo '<tbody>';
			while ($registro = mysql_fetch_row($result)) {

				echo '<tr>';
					//echo "<td>$registro[4]</td>";
					echo "<td>$registro[1]</td>";
					//echo "<td>".strip_tags($registro[0])."</td>";

					if (strlen($registro[0]) > 60)
						echo "<td>".substr(strip_tags(trim($registro[0])), 0, 60) .'...<a onclick="cmostrar(event, '.$registro[4].')" style="cursor:pointer" href="">[ver]</a></td>';
    				else
    					echo "<td>".strip_tags($registro[0])."</td>";
    				echo "<td>$registro[2]</td>";
					if ($registro[3] != '')
						echo "<td><a href='cedula/".$registro[3]."' title='Cédula PDF' rel='noopener noreferrer' target='_blank'>Ver archivo</a></td>";
					else
						echo "<td></td>";
					switch ($us) {
						case 'admin':
						{
							echo "<td><img src=\"assest\plugins\buttons\icons/editar.png\"
								onClick=\"mcedula('".$registro[4]."');\" title=\"edita cédula\" style='cursor:pointer' />&nbsp;&nbsp;
								<img src=\"assest\plugins\buttons\icons/printer.png\" onClick=\"ImprimeCedula('".$registro[4]."');\" title=\"Imprimir cédula.\" style='cursor:pointer' />
								</td>";
							break;
						}
						case 'agentes':
						{
							echo "<td class='info'>
							<img src=\"assest\plugins\buttons\icons/printer.png\" onClick=\"ImprimeCedula('".$registro[4]."');\" title=\"Imprimir cédula.\" style='cursor:pointer' /></td>";
							break;
						}
						case 'entrada':
						{
							echo "<td></td>";
							break;
						}
						case 'info':
						{
							echo "<td></td>";
							break;
						}
						default:
						{
							echo "<td></td>";
						}
					}
				echo '</tr>';
			}

			echo "</tbody>";
		echo "</table>";
	echo'</div>';
	echo'</div>';
}

function estadofinal($exp ,$result,$us) {// inicio y seleccion de lo que quiero mostrar
	echo'<div class="panel panel-default">';
		echo'<div class="panel-heading">ESTADO FINAL ';
		if ($us=='admin') {
			echo'<button align="rigths" type="button" onClick="estadofinal('.$exp.');" on class="btn btn-default">
				<span class="glyphicon glyphicon-plus"></span>
				</button>';
		}
		echo'</div>';
		echo'<div class="panel-body">';
		echo "<div id='abm' styles='display:none;'/></div>";

		echo '<table class="table table-hover table-bordered table-striped" id="tbl_estadoFinal">';
	        echo '<thead>';
				echo'<tr >';
					print "<th><strong>Estado</strong></th>";  //escribe el titulo de la tabla
					print "<th><strong>Motivo</strong></th>";
					print "<th><strong>Fecha</strong></th>";
					print "<th></th>";
				echo'</tr>';
			echo '</thead>';
			echo '<tbody>';

			while ($registro = mysql_fetch_row($result)) {
				//echo '<pre>';
				//print_r( $registro );
				//echo '</pre>';
				echo '<tr>';
					echo "<td>$registro[1]</td>";
					echo "<td>".strip_tags(trim($registro[2]))."</td>";
					echo "<td>$registro[3]</td>";

					switch ($us) {
						case 'admin':
						{
							echo "<td><!-- <img src=\"assest\plugins\buttons\icons/editar.png\"
								onClick=\"mestadofinal('".$registro[2]."');\" title=\"edita movimiento\" style='cursor:pointer' />-->
								</td>";
							break;
						}
						case 'agentes':
						{
							echo "<td></td>";
							break;
						}
						case 'entrada':
						{
							echo "<td></td>";
							break;
						}
						case 'info':
						{
							echo "<td></td>";
							break;
						}
						default:
						{
							echo "<td></td>";
						}
					}
				echo '</tr>';
			}

			echo "</tbody>";
		echo "</table>";
	echo'</div>';
	echo'</div>';
}

function getmodal($id) {  
	echo '<div class="modal fade">
  	<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 class="modal-title">Modal title</h4>
      </div>
      <div class="modal-body">
        <p>One fine body&hellip;</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->';
}
/*
	echo "<pre>";
	while ($regstro = mysql_fetch_row($result)) {
		print_r($regstro);
		echo "<hr>";
	}
	echo "</pre><hr>";
*/
?>
<script src="Js/info_asigna.js"></script>
<script>
	function Mensaje(nroExpediente)
	{
		location.href = "editaexpediente.php?nroexpe="+nroExpediente;
	}

	function editaexpe(nroExpediente)
	{
		/*var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		window.open("editaexpediente.php?nroexpe="+nroExpediente,"nombreventana", opciones);*/
		var win = window.open("editaexpediente.php?nroexpe="+nroExpediente, "_blank");
        win.focus();
	}

	function Imprime(nroExpediente)
	{
		var win = window.open("printexpediente.php?iniciador="+nroExpediente, "_blank");
        win.focus();
	}

	function ImprimeResolucion(idResolucion)
	{
		var win = window.open("printresolucion.php?id="+idResolucion, "_blank");
        win.focus();
	}

	function ImprimeOficio(nroOficio)
	{
		var win = window.open("printoficio.php?id="+nroOficio, "_blank");
        win.focus();
	}

	function ImprimeNota(nroNota)
	{
		var win = window.open("printnota.php?id="+nroNota, "_blank");
        win.focus();
	}

	function ImprimeCedula(nroCedula)
	{
		var win = window.open("printCedula.php?id="+nroCedula, "_blank");
        win.focus();
	}

	function principal()
	{
		document.historialexpediente.action="principal.php";
		document.historialexpediente.submit();
	}

	function asigau(mov)
	{
		var win = window.open("editaasignausuario.php?mov="+mov, "_blank");
		win.focus();
	}

	function provi(mov)
	{
		var win = window.open("alta_providenci.php?mov="+mov, "_blank");
        win.focus();
	}

	function info(mov)
	{
		var win = window.open("informe_agente.php?mov="+mov, "_blank");
		win.focus();
	}

	function infoagente(mov)
	{
		var win = window.open("printrespuesta.php?id="+mov, "_blank");
		win.focus();
	}

	function printProvidencia(prov)
	{
		var win = window.open("printprovidencia.php?id="+prov, "_blank");
		win.focus();
	}

	function printInforme(informe)
	{
		var win = window.open("printinforme.php?id="+informe, "_blank");
		win.focus();
	}

	function asigadef(mov)
	{
		//var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		//window.open("editaasignadefensor.php?mov="+mov,"nombreventa na", opciones);
		var win = window.open("editaasignadefensor.php?mov="+mov, "_blank");
        win.focus();
	}

	function cargaestado(mov)
	{
		var win = window.open("rechazarexpedient2.php?mov="+mov, "_blank");
		win.focus();
	}

	function asignaagente(expe)
	{
		var win = window.open("asignausuario.php?expe="+expe, "_blank");
		win.focus();
	}

	function asignadefensor(expe)
	{
		location.href = "asignadefensor.php?nroExp="+expe;
	}

	function muestra(imagen)
	{
		var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		window.open(imagen,"nombreventa na", opciones);
	}

	function resolucion(expe)
	{
		//var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		//window.open("resolucionexp.php?idexp="+expe,"nombreventa oficio", opciones); //nroexpe
		var win = window.open("resolucionexp.php?idexp="+expe, "_blank");
        win.focus();
	}

	function oficio(expe)
	{
		//var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		//window.open("alta_oficio.php?idexp="+expe,"nombreventa oficio", opciones);
		var win = window.open("alta_oficio.php?idexp="+expe, "_blank");
        win.focus();
	}

	function moficio(expe)
	{
		//var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		//window.open("modifica_oficio.php?idofic="+expe,"nombreventa oficio", opciones);
		var win = window.open("modifica_oficio.php?idofic="+expe, "_blank");
        win.focus();
	}

	function nota(expe)
	{
		//var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		//window.open("alta_nota.php?idexp="+expe,"nombreventa nota", opciones);
		var win = window.open("alta_nota.php?idexp="+expe, "_blank");
        win.focus();
	}

	function mnota(expe)
	{
		//var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		//window.open("modifica_nota.php?idnot="+expe,"nombreventa nota", opciones);
		var win = window.open("modifica_nota.php?idnot="+expe, "_blank");
        win.focus();
	}

	function cedula(expe)
	{
		//var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		//window.open("alta_cedula.php?idexp="+expe,"nombreventa cedula", opciones);
		var win = window.open("alta_cedula.php?idexp="+expe, "_blank");
        win.focus();
	}

	function mcedula(expe)
	{
		//var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		//window.open("modifica_cedula.php?idced="+expe,"nombreventa cedula", opciones);
		var win = window.open("modifica_cedula.php?idced="+expe, "_blank");
        win.focus();
	}

	function estadofinal(expe)
	{
		//var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		//window.open("rechazarexpedient2.php?mov="+expe,"nombreventa cedula", opciones);
		var win = window.open("rechazarexpedient2.php?mov="+expe, "_blank");
        win.focus();
	}

	function vincula(expe)
	{
		//var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		//window.open("alta_vincula.php?expe="+expe,"nombreventa cedula", opciones);
		var win = window.open("alta_vincula.php?expe="+expe, "_blank");
        win.focus();
	}

	function edita(expe) {
        var win = window.open("panelexpediente.php?expe="+expe, "_blank");
        win.focus();
        //var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
        //window.open("panelexpediente.php?expe="+expe,"nombreventa na", opciones);
    }

	function archiva(expe)
	{
		//var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		//window.open("archivar.php?nroexpe="+expe,"nombreventa na", opciones);
		var win = window.open("archivar.php?nroexpe="+expe, "_blank");
        win.focus();
	}

	function rmostrar(event, expe)
	{
		event.preventDefault();
		$(".modal-body").html("");
		var result = $.ajax({
	        type: "POST",
	        url: "mostrar_res.php",
	        data: {nroResolucion: expe},
	        success: function(respuesta){
				$('.modal-body').html(respuesta);
	   		}}
	   	);
		$('#modal1').modal('show');

		/*var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		window.open("mostrar.php?idofic="+expe,"nombreventa oficio", opciones);*/
	}

	function mmostrar(event, expe)
	{
		event.preventDefault();
		$(".modal-body").html("");
		var result = $.ajax({
	        type: "POST",
	        url: "mostrar.php",
	        data: {idofic: expe},
	        success: function(respuesta){
				$('.modal-body').html(respuesta);
		   	}});

		/*ajax llamar al archivo mmostrar php*/
		//$(".modal-body").appendTo(result);
		$('#modal1').modal('show');
			/*var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
			window.open("mostrar.php?idofic="+expe,"nombreventa oficio", opciones);*/
	}

	function nmostrar(event, expe)
	{
		event.preventDefault();
		$(".modal-body").html("");
		var result = $.ajax({
	        type: "POST",
	        url: "mostrar_nota.php",
	        data: {idnot: expe},
	        success: function(respuesta){
				$('.modal-body').html( $.parseHTML(respuesta) );
		   	}});
			$('#modal1').modal('show');

			/*var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
			window.open("mostrar_nota.php?idnot="+expe,"nombreventa oficio", opciones);*/
	}

	function cmostrar(event, expe)
	{
		event.preventDefault();
	 	$(".modal-body").html("");
	 	var result = $.ajax({
        	data: {idced: expe},
        	url: "mostrar_cedula.php",
        	type: "POST",
        	success: function(respuesta){
        		//alert(respuesta);
        		var str = respuesta;
        		var html = $.parseHTML( str );
        		$('.modal-body').html( html );
	   		}
	   	});
		$('#modal1').modal('show');
		/*var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
		window.open("mostrar_cedula.php?idced="+expe,"nombreventa oficio", opciones);*/
	}

</script>

<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Descripción</h4>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
