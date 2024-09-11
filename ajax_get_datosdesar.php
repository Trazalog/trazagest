<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$exp = $_POST['datos'];//nro expediente
$consulta = " SELECT 
		O.id_expediente,
		O.nro_expediente,
		O.caratula, 
		O.fecha,
		O.id_iniciador,
		C.nombre, C.apellido,
		S.descrip, S.fila, S.codigo,
		E.descripcion,
		A.estado 
	FROM expedientes O
	join iniciador C join ccajas A join cajas S join estanteria E on C.dni=O.id_iniciador and A.id_expediente=O.id_expediente and A.id_cajas=S.id_cajas and E.id_estanteria=S.id_estanteria
	Where O.nro_expediente = $exp and A.estado='A'";
			
	$result2 = mysql_query($consulta,$var->links);
	//$Arre = Array();
	if(mysql_num_rows($result2) > 0){
		while( $row2 = mysql_fetch_array($result2)) // se ejecuta una vez
		{
			echo json_encode($row2);
			//echo $row2[5]."**;".$row2[3]."**;".$row2[2]."**;".$row2[0]."**;".$row2[6]."**;".$row2[7]."**;".$row2[8];
		}
	} else 
		echo "Este expediente ya esta desarchivado";	
