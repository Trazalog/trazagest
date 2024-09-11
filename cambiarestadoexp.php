<?php
include ("conexion.php");
$var=new conexion();
$var->conectarse();

$nro=$_POST['mov'];


 $sql2="UPDATE registro_movimiento SET
         estado='A' 
          
 WHERE id_mov='$nro' AND estado='T'  ";
 $res2=mysql_query($sql2,$var->links);

/*$consulta2="SELECT id_reg                           
          FROM registro_movimiento
          where id_mov=$nro ";
                         
                            
$result2=mysql_query($consulta2,$var->links);
                     
    while( $row2 = mysql_fetch_assoc($result2)){
                     
        $reg=$row2['id_reg'];
        $sql="SELECT id_expediente                           
          FROM registrodefensor
          where id_reg=$reg ";
        $res=mysql_query($sql,$var->links);
        $row22 = mysql_fetch_assoc($res);
        $exp=$row22['id_expediente'];
//5 - asignado . no hay estado en curso 
        $sql2="UPDATE regitra_movimiento SET
						 estado='  C' 
						  
		 WHERE id_mov='$nro'  ";
		 $res2=mysql_query($sql2,$var->links);
//AND id_estado=15
    }*/


return 1;

?>