<?php
//session_start();

class Sesion
{
	function iniciar() {
		//valdiar que el usuario este logueado
		if(!isset($_SESSION['Nombre'])) {
			//no iniciaste sesio' n
			header("Location: no_login.php");
		} else {
			//validar datos para armar el menu y para validar el ingreso
			$Permisos = explode("-",$_SESSION['permisos']);
			$CadenaPermisos = $_SESSION['permisos'];//("";
		}
		return $CadenaPermisos;
	}

	public function usuario($usu) {
		$var = new conexion();
		$var->conectarse();

		$consulta = "SELECT  U.nombre_real
			FROM  usuarios  U
			WHERE id_usuario=$usu";
		$resu = mysql_query($consulta);
		$r = mysql_fetch_array($resu);
		//echo"$consulta";

		if(mysql_num_rows($resu)>0) {
			echo $r[0];
		}
	}

	public function datosUsuario($idUsuario) {
		$var = new conexion();
		$var->conectarse();

		$consulta = "SELECT 
				U.id_usuario,
			    U.nombre_real,
			    U.contrasena,
			    U.fecha,
			    U.foto,
			    TG.descripcion AS grupo
			FROM usuarios u
			JOIN tbl_grupos TG ON TG.id_grupo = U.id_grupo
			WHERE id_usuario = $idUsuario";
		$resultado = mysql_query($consulta);
		$r = mysql_fetch_array($resultado, MYSQL_ASSOC);
		//echo"$consulta";

		if(mysql_num_rows($resultado)>0) {
			return $r;
		}
	}

	public function foto($usu) {
		$var = new conexion();
		$var->conectarse();

		$consulta = "SELECT U.nombre_real,
			U.id_grupo,
			TG.descripcion,
			U.foto
			FROM  usuarios  U
			JOIN  tbl_grupos TG on  TG.id_grupo=U.id_grupo
			WHERE id_usuario=$usu";
		$resu = mysql_query($consulta);
		$r = mysql_fetch_array($resu);
		//echo"$consulta";

		if(mysql_num_rows($resu)>0) {
			echo'<div class="row">';
			echo'<div class="col-sm-6 col-md-3">';
			echo'<a href="#" class="thumbnail">';
			echo'<img data-src="/imag/usuarios.jpg">';
			echo'</a>';
			echo'</div>';
			echo'</div>';
			echo 'Usuario:'.$r[0].'<br>';
		}
	}

	public function cambiar($usu) {
		$var = new conexion();
		$var->conectarse();

		$consulta = "SELECT U.nombre_real,
			U.id_grupo,
			TG.descripcion,
			U.foto,
			U.contrasena
			FROM  usuarios  U
			JOIN  tbl_grupos TG on  TG.id_grupo=U.id_grupo
			WHERE id_usuario=$usu";
		$resu = mysql_query($consulta);
		$r = mysql_fetch_array($resu);

		if(mysql_num_rows($resu)>0) {
			if ($r[4]=='81dc9bdb52d04dc20036dbd8313ed055') {
				print "<meta http-equiv=Refresh content=\"0 ; url=cambiar.php\">";
			}
		}
	}

}
