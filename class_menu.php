<?php
class menu
{
	function menu_ppal($Cadena)	{
		//en la variable cadena viene todos los indices del menu que
		//se mostraran
		$rol = $Cadena;

	    $var = new conexion();
	    $var->conectarse();

		//contar las cabezas de menu
		$Permisos = explode("-",$Cadena);
		$contador = 0;

		foreach($Permisos as $value) {
			if($value != '')
			{
				$consulta = "Select * From tbl_menu Where id_menu = $value and imagen != ''";
				$resu = mysql_query($consulta);
				if($a = mysql_num_rows($resu)>0) {
					$contador++;
				}
			}
		}
		//------
		$i=1;

		echo '<nav class="navbar navbar-default">';
		echo '<div class="collapse navbar-collapse">';
	    echo '<ul class="nav navbar-nav">';

		foreach($Permisos as $value) {
			if($value != '') {
				$i++;

				$consulta = "Select * From tbl_menu Where id_menu = $value and imagen !='' ";
				$resu = mysql_query($consulta);
				if(mysql_num_rows($resu)>0) {
					$row = mysql_fetch_array($resu);

					echo '
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$row['descripcion'].'<span class="caret"></span></a>
							<ul class="dropdown-menu">';
								$inicio = $row[1].'/';

								foreach($Permisos as $valores) {
									if($valores != '') {
										$cons = "Select * From tbl_menu Where id_menu = $valores and ubicacion Like '$inicio%'" ;

										$res = mysql_query($cons);
										if(mysql_num_rows($res)> 0) {
											$r = mysql_fetch_array($res);
											echo'<li><a href="'.$r['link'].'">'.htmlentities($r['descripcion']).'</a></li>';
										}
									}
								}

					echo '
							</ul>
						</li>';
				}
			}
		}

		echo '</ul>';
		echo '</div>';
		echo '</nav>';
	}
}
?>
