<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$exp    = $_POST['nroexp']; //numero de expediente 
$idc    = $_POST['idca']; //id de caja nueva seleccionada 
$idcv   = $_POST['idgo'];//id de caja vieja 
$idexpe = $_POST['idgobla']; //id de expediente 

$sql = "UPDATE ccajas SET id_cajas='$idc'
    WHERE id_expediente=$idexpe AND id_cajas=$idcv";
$res = mysql_query($sql,$var->links);


$sql2 = "UPDATE expedientes SET id_estado=14
    WHERE id_expediente=$idexpe";
$res2 = mysql_query($sql2,$var->links);

//var_dump($result);
//$option = mysql_fetch_assoc($result);
return 1;

 /*   $expe=mysql_fetch_array($res);
    if(mysql_num_rows($res)>0) {
         return 1;
    } else {
        echo '<script>alert("No existe el cambio");</script>';
    }
*/
