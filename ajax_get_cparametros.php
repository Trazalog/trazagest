<?php


include("conexion.php");
$var = new conexion();
$var->conectarse();


$idmov = $_POST['idmov'];


$consulta2="$sql5="
							SELECT u.nombre_real , 
							rm.fecha , 
							rm.folios ,
							rm.observaciones , 
							rm.id_mov,rm.estado,u.tipo
							FROM expedientes as e ,
							usuarios as u, 
							registrodefensor as rd, 
							registro_movimiento as rm 
							WHERE (e.id_expediente=rd.id_expediente) and
							 (rd.id_reg=rm.id_reg)and(u.id_usuario=rm.id_usuario)and 
							 (e.id_expediente= ".$idmov.")	ORDER BY rm.id_mov DESC";
	    ";
   
	    
$result2=mysql_query($consulta2,$var->links);



	
	        echo '<thead>';
	      		echo"<tr>";
					print "<th><strong> Nombre y Apellido</strong> </th>";  //escribe el titulo de la tabla 
					print "<th><strong> Fecha Asignacion</strong></th>";
					print "<th><strong> folios recibidos</strong></th>";
					print "<th><strong> Observaciones</strong></th>";
					print "<th><strong> Estado</strong></th>";
					print "<th><strong> 
					<img src=\"assest\plugins\buttons\icons\add.png\" onClick=\"asignadefensor('".$in ."');\" title=\"edita movimiento.\" /></strong></th>";
				echo"</tr>";
		    echo "</thead>";

while( $row2 = mysql_fetch_assoc($result2))
	{
		 echo $row2['nombre_real'].",".$row2['fecha'].",".$row2['folios'].",".$row2['observaciones'].";";
	 
	}



?>