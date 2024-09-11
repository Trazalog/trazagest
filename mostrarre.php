
<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();

$busca=$_POST['nro_resolucion']; //numero de resolucion
$busca1=$_POST['nu']; //idexp

$consulta = "Select
         R.id_resolu,
         R.idExpediente,
    	 R.direccionDocumento,
    	 R.observacion,
    	 R.fecha,
    	 R.nro_resolucion
    	 

    from  expedientespdf R
    where R.nro_resolucion =$busca AND R.idExpediente=$busca1";

$res=mysql_query($consulta);
$oficio=mysql_fetch_array($res);

if(isset($oficio['observacion'])){
   echo $oficio['observacion'];
}


?>




