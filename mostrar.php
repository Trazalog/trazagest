
<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$busca=$_POST['idofic'];

$consulta = "Select
         C.numero_expediente,
         C.detalle_cedula,
    	 C.expediente_destino,
    	 C.datos,
    	 C.id_oficio,
    	 C.copias,
    	 C.plazo,
    	 C.fecha,
    	 C.fecha_profesional,
    	 C.fecha_notificacion,
    	 C.fecha_devolucion,
    	 C.oficina,
    	 C.fecha_entrada

    from  oficio C
    where C.id_oficio =".$busca;

$res=mysql_query($consulta);
$oficio=mysql_fetch_array($res);


if(isset($oficio['detalle_cedula']))
    echo $oficio['detalle_cedula'];

?>
