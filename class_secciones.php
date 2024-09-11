<?PHP
include("listarsecciones_php.php") ;

class seccion
{
	public function seccion_principal($usuario) {
		$var = new conexion();
    	$var->conectarse();

		// busco informacion del usuario
		$consulta = "SELECT
			U.nombre_real,
			U.id_grupo,
			TG.descripcion,
			U.id_usuario
			FROM  usuarios  U
			JOIN  tbl_grupos TG on  TG.id_grupo=U.id_grupo
			where id_usuario=$usuario";

		$resu = mysql_query($consulta);
		$r = mysql_fetch_array($resu);

		if(mysql_num_rows($resu)>0) {
			$us=$r[3];
			$i=$r[2];

			$sql2="SELECT
				E.nro_expediente,
				M.fecha,
				M.observaciones,
				E.extraxto,
				M.estado,
				M.id_mov,
				M.fecha_aceptado,
				E.id_expediente
				FROM registro_movimiento  M
				JOIN registrodefensor R on M.id_reg = R.id_reg
				JOIN expedientes  E on R.id_expediente = E.id_expediente
				WHERE M.id_usuario =$us  AND  E.id_estado=5 and  (M.estado='C' or M.estado='A')  "  ;// Retorna los datos del Expediente

			$res2=mysql_query($sql2) or die($sql2);
		 	expedienteprincipal($i,$res2);
		}//fin usuario
 	} //fin function principal


	public function seccion_expe($usuario, $expe) {
		$var = new conexion();
    	$var->conectarse();

		// busco informacion del usuario
		$consulta = "SELECT
			U.nombre_real,
			U.id_grupo,
			TG.descripcion,
			U.id_usuario
			FROM usuarios  U
			JOIN tbl_grupos TG on  TG.id_grupo=U.id_grupo
			WHERE id_usuario=$usuario";
		//echo"$consulta";

		$resu = mysql_query($consulta);
		$r = mysql_fetch_array($resu);

		if(mysql_num_rows($resu)>0) {
			$i=$r[2];
			$us=$r[1];

			$sql2="SELECT nro_expediente,
				concat_ws(' ', TRIM(i.Apellido),
				TRIM(i.Nombre)) asiniciad,
				e.extraxto,
				t.descripcion,
				fecha,
				letras,
				fecha_entrada,
				es.descripcion,
				e.estado_final,
				motivo_final,
				e.id_estado,
				e.id_resolucion
				FROM expedientes e
				JOIN tipo_expedientes t	on e.id_tipo = t.id_tipolegajos
				JOIN estados es	 on e.id_estado = es.id_estado
				JOIN iniciador i on e.id_iniciador = i.dni
				WHERE e.id_expediente= '".$expe."'"; // Retorna los datos del Expediente

			$res2=mysql_query($sql2) or die($sql2);
			datosexpdiente($i,$res2);
		}//fin usuario
 	} //fin function seccion_expe



 	public function seccion_funcionario($usuario, $expe) {
 		$var = new conexion();
 		$var->conectarse();

		// busco informacion del usuario
 		$consulta = "SELECT  U.nombre_real,
	 		U.id_grupo,
	 		TG.descripcion,
	 		U.id_usuario
	 		from  usuarios  U
	 		JOIN  tbl_grupos TG on  TG.id_grupo=U.id_grupo
	 		WHERE id_usuario=$usuario";
		//echo"$consulta";

 		$resu = mysql_query($consulta);
 		$r = mysql_fetch_array($resu);

 		if(mysql_num_rows($resu)>0) {
 			$i=$r[1];
 			$us=$r[2];

 			$sql3="
 			SELECT
 			CONCAT(D.apellido,' ',D.nombre) ,
 			D.cargo ,
 			RD.fecha ,
 			RD.folios ,
 			RD.id_reg,
 			RD.id_expediente
 			FROM defensor AS D
 			JOIN registrodefensor RD  on RD.id_defen=D.id_defensor
 			WHERE  RD.id_expediente=$expe   ORDER BY RD.fecha DESC";

 			$res3=mysql_query($sql3) or die($sql3);
			listarfuncionario($expe,$res3,$us);//Lista los datos del Funcionario
		}
		//fin function seccion_expe
	} //fin function seccion_funcionario



	public function seccion_resolucion($usuario, $expe) {
	 	$var = new conexion();
     	$var->conectarse();

		// busco informacion del usuario
		$consulta = "SELECT  U.nombre_real, U.id_grupo, TG.descripcion,U.id_usuario from usuarios U
			JOIN  tbl_grupos TG on TG.id_grupo=U.id_grupo
			WHERE id_usuario=$usuario";
			//echo"$consulta";

		$resu = mysql_query($consulta);
		$r = mysql_fetch_array($resu);

		if(mysql_num_rows($resu)>0) {
			$i=$r[2];
			$us=$r[1];
			//echo"----$i";

			//bnusca tipo de usuario si es 1 es administrador 2, usuario, 3 propietario
			$sql3="SELECT
				re.nro_resolucion,
				re.observacion,
				re.fecha,
				re.id_resolu,
				re.direccionDocumento
				FROM expedientespdf AS re
				WHERE re.idexpediente=$expe
				ORDER BY re.fecha DESC";

			$res3=mysql_query($sql3) or die($sql3);
			listarresolucion($expe,$res3,$i);//Lista los datos del Funcionario
		} //fin usuario
	} //fin function seccion_resolucion



	public function seccion_oficio($usuario, $expe) {
		$var = new conexion();
    	$var->conectarse();

		// busco informacion del usuario
		$consulta = "SELECT
			U.nombre_real,
			U.id_grupo,
			TG.descripcion,
			U.id_usuario
			FROM usuarios  U
			JOIN tbl_grupos TG on TG.id_grupo = U.id_grupo
		    WHERE id_usuario = $usuario";
			//echo"$consulta";

		$resu = mysql_query($consulta);
		$r    = mysql_fetch_array($resu);

		if(mysql_num_rows($resu)>0) {
			$i  = $r[2];
			$us = $r[1];
			//echo"----$i";

			//bnusca tipo de usuario si es 1 es administrador 2, usuario, 3 propietario
            $sql3 = "SELECT
	            OF.id_oficio,
	            OF.fecha_entrada,
	            OF.detalle_cedula,
	            OF.copias,
	            OF.pdf
	            FROM oficio OF
				JOIN expedientes E ON E.nro_expediente = OF.numero_expediente
				WHERE E.id_expediente = $expe
				ORDER BY OF.fecha_entrada DESC";

			$res3=mysql_query($sql3) or die($sql3);
			listaroficio($expe,$res3,$i);//Lista los datos del Funcionario
		} //fin usuario
	} //fin function seccion_oficio



	public function seccion_nota($usuario, $expe) {
		$var = new conexion();
		$var->conectarse();

		// busco informacion del usuario
		$consulta = "SELECT
			U.nombre_real,
			U.id_grupo,
			TG.descripcion,
			U.id_usuario
			FROM  usuarios  U
			JOIN  tbl_grupos TG on TG.id_grupo=U.id_grupo
		    WHERE id_usuario = $usuario";
		//echo"$consulta";

		$resu = mysql_query($consulta);
		$r    = mysql_fetch_array($resu);

		if(mysql_num_rows($resu)>0) {
		    $i  = $r[2];
			$us = $r[1];
			//echo"----$i";

			//bnusca tipo de usuario si es 1 es administrador 2, usuario, 3 propietario
            $sql3 = "SELECT 
            	N.detalle_cedula,
	            N.fecha_entrada,
	            N.copias,
	            N.pdf,
	            N.id_nota
				FROM notas AS N
				JOIN expedientes E ON E.nro_expediente = N.numero_expediente
				WHERE E.id_expediente = $expe
				ORDER BY fecha_entrada DESC";

			$res3 = mysql_query($sql3) or die($sql3);
			listarnota($expe,$res3,$i);//Lista los datos del Funcionario
		} //fin usuario
	} //fin function seccion_nota



	public function seccion_cedula($usuario, $expe) {
		$var = new conexion();
		$var->conectarse();

		// busco informacion del usuario
		$consulta = "SELECT
			U.nombre_real,
			U.id_grupo,
			TG.descripcion,
			U.id_usuario
			FROM  usuarios  U
			JOIN  tbl_grupos TG on TG.id_grupo=U.id_grupo
			WHERE id_usuario = $usuario";
		//echo"$consulta";

		$resu = mysql_query($consulta);
		$r    = mysql_fetch_array($resu);

		if(mysql_num_rows($resu)>0) {
			$i  = $r[2];
			$us = $r[1];

			//bnusca tipo de usuario si es 1 es administrador 2, usuario, 3 propietario
			$sql3 = "SELECT 
				C.detalle_cedula,
				C.fecha_entrada,
				C.copias,
				C.pdf,
				C.id_cedula
				FROM cedula AS C
				JOIN expedientes E ON E.nro_expediente = C.numero_expediente
				WHERE E.id_expediente = $expe
				ORDER BY C.fecha_entrada DESC";

			$res3 = mysql_query($sql3) or die($sql3);
			listarcedula($expe,$res3,$i);//Lista los datos del Funcionario
		} //fin usuario
	} //fin function seccion_cedula



	public function seccion_estado($usuario, $expe) {
		$var = new conexion();
		$var->conectarse();

		// busco informacion del usuario
		$consulta = "SELECT
			U.nombre_real,
			U.id_grupo,
			TG.descripcion,
			U.id_usuario
			FROM usuarios  U
			JOIN tbl_grupos TG on TG.id_grupo=U.id_grupo
			WHERE id_usuario=$usuario";
		//echo"$consulta";

		$resu = mysql_query($consulta);
		$r    = mysql_fetch_array($resu);

		if(mysql_num_rows($resu)>0) {
			$i  = $r[2];
			$us = $r[1];
			//echo"----$i";

			//bnusca tipo de usuario si es 1 es administrador 2, usuario, 3 propietario
			$sql3 = "SELECT 
				E.nro_expediente,
				ES.descripcion,
				R.descripcion,
				E.fecha
				FROM expedientes E
				JOIN estados ES on E.estado_final = ES.id_estado
				JOIN tipo_rechazo R on E.motivo_final = R.id_rechazo
				WHERE E.id_expediente = $expe";

			$res3 = mysql_query($sql3) or die($sql3);
			estadofinal($expe,$res3,$i);//Lista los datos del Funcionario
		} //fin usuario
	} //fin function seccion_estado



	public function seccion_vincula($usuario, $expe) {
		$var = new conexion();
		$var->conectarse();

		// busco informacion del usuario
		$consulta = "SELECT
			U.nombre_real,
			U.id_grupo,
			TG.descripcion,
			U.id_usuario
			FROM  usuarios  U
			JOIN  tbl_grupos TG on  TG.id_grupo=U.id_grupo
		    WHERE id_usuario=$usuario";
		//echo"$consulta";

		$resu = mysql_query($consulta);
		$r = mysql_fetch_array($resu);

		if(mysql_num_rows($resu)>0) {
			$i=$r[2];
			$us=$r[1];
			//echo"----$i";

			//bnusca tipo de usuario si es 1 es administrador 2, usuario, 3 propietario
			$sql3="SELECT
				exp.nro_expediente,
				re.fecha,
				re.id_expedientevincula
				FROM expedientevincula AS re,  expedientes as exp
				WHERE  re.id_expedientevincula=exp.id_expediente and re.id_expediente=$expe
				ORDER BY re.fecha DESC ";

			$res3=mysql_query($sql3) or die($sql3);
			listarvincu($expe,$res3,$i);//Lista los datos del Funcionario
		} //fin usuario
	} //fin function_vincula
}
