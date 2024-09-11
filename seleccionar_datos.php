<?php


include("conexion.php");
$var = new conexion();
$var->conectarse();
$usu=$_POST['ide'];

$sql="SELECT tbl_grupos.descripcion, tbl_grupos.id_grupo, usuarios.id_usuario, usuarios.nombre, usuarios.nombre_real, usuarios.contrasena, usuarios.id_grupo
                                          FROM usuarios 
                                          JOIN tbl_grupos ON tbl_grupos.id_grupo=usuarios.id_grupo 
                                          WHERE usuarios.id_usuario=$usu ";
                                    $result2=mysql_query($sql,$var->links);
                                    //$expediente=mysql_fetch_array($result2);
                                               
                                    //echo $expediente['descripcion'];   

                                    while ( $row2 = mysql_fetch_assoc($result2) )	

{
		
		$data['descripcion']=$row2['descripcion'];
		$data['nombre_real']=$row2['nombre_real'];
            $data['nombre']=$row2['nombre'];
		//$i++;
	echo json_encode($data);
	}

?>