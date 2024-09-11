<?php


include("conexion.php");
$var = new conexion();
$var->conectarse();




$exp = $_POST['datos']; //numero de expediente 


$idcv=$_POST['idgo'];

$consulta2="SELECT expedientes.id_expediente,
                                        expedientes.nro_expediente, 
                                         
                                        ccajas.id_cajas
                                     

                      FROM expedientes
                      JOIN ccajas ON ccajas.id_expediente= expedientes.id_expediente
                      
                      where ccajas.id_cajas=$idcv and expedientes.nro_expediente=$exp";
                         
                           // where expedientes.id_estado=11 AND expedientes.id_estado=14   
                      $result2=mysql_query($consulta2,$var->links);
                      //$row2 = mysql_fetch_assoc($result2);
                    while( $row2 = mysql_fetch_assoc($result2)){
                      //foreach($list['data'] as $a)
                   

                  // $nexp=$row2['nro_expediente'];
                    $nexp=$row2['id_expediente'];

                  }
                print_r($nexp);  

?>