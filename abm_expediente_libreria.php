﻿<?php
include("conexion.php");

function insertarExpediente($expe)
{	  
$link= new conexion();
$link->conectarse();

$fehs=date("Y-m-d H:i:s");
$fehen=date("Y-m-d H:i:s");
//$fehs = $_POST['tfecha'];
//$fehen = $_POST['tfechain'];

//preguntar si este expediente ya fue almacenado 
$consulta = "Select * from expedientes where nro_expediente = ".$expe["nroexpe"];
$resu = mysql_query($consulta);
$cantidad = mysql_num_rows($resu);
if($cantidad == 0)
	   {
		
		   
	    //no esta guardado un expediente con ese numero 
		$queEmp  = "INSERT INTO expedientes(id_expediente ,caratula ,n_folio , id_tipo , detalle , fecha ,";
		$queEmp .= "fecha_entrada , letras , observaciones , datos , id_estado ,extraxto, id_iniciador,nro_expediente ,";
		$queEmp .= "id_estanteria , fichero , id_resolucion , comentario)"; 
		$queEmp .= " VALUES ( '' , '".$expe['caratula']."', '". $expe['folio']."', '". $expe['tipoexpe']."', '".$expe['detallexpe']."',";
		$queEmp .= " '".$fehs."', '".$fehen."' , '".$expe['letra']."', '".$expe['observacionexp']."', ";
		$queEmp .= " '".$expe['dato']."', '1', '".$expe['estracto']."', '".$expe['iniciador']."', '".$expe['nroexpe']."','0' , '0' , '0' , '' ); ";
		
		//'".$expe['fecha']."', '".$expe['fechaIn']."'
		$resEmp = mysql_query($queEmp) or die(mysql_error());
		
		  echo "<script>alert(\"Expediente almacenado.\");
				window.open('printexpediente.php?iniciador=".$expe['nroexpe']."','','menubar=1,width=700,height=700');
			    location.href=\"principal.php\";
			</script>";

			//window.open(\"printexpediente.php?iniciador=".$expe['nroexpe']."\",\"\",\"menubar=1;toolbar=1;resizable:no\"); 
		}
		else
			{
			 //ya hay un expediente con ese numero 
			 echo "<script>alert(\"Ya hay un expediente cargado con ese número.\");
			        window.open('printexpediente.php?iniciador=".$expe['nroexpe']."','','menubar=1,width=700,height=700');
					location.href=\"principal.php\";		
				</script>";		 
			}//location.href=\"printexpediente.php?iniciador=".$expe['nroexpe']." \";
 
$link->cerrar_conexion();
}


function listar()
{

$cons = "SELECT * FROM expedientes";
$result = mysql_query($cons) or die("falla la consulta");

while($option = mysql_fetch_row($result))
{
 echo  " <option value=\" ". $option[0]."\" >".$option[1 ]." </option>"; 
} 

}


function editarExpediente($expe)
{

    $link= new conexion();
    $link->conectarse();//,detalle = '".$expe['detallexpe']."'
   
	$resEmp="UPDATE 
                expedientes JOIN iniciador 
             SET 
                expedientes.caratula = '".$expe['caratula']."',
                expedientes.n_folio = '".$expe['n_folio']."',
                expedientes.id_tipo = '".$expe['tipoexpe']."',
                expedientes.fecha = '".$expe['fecha']."',
                expedientes.fecha_entrada = '".$expe['fechaIn']."',
                expedientes.letras = '".$expe['letra']."',
                expedientes.observaciones = '".$expe['observacionexp']."',
                expedientes.datos = '".$expe['dato']."',
                expedientes.extraxto = '".$expe['estracto']."'
				
            WHERE 
                expedientes.nro_expediente = '".$expe['nroexpe']."'   
                "; //nroexpe
	

	$res = mysql_query($resEmp, $link->links) or die($resEmp);
	//$expe['nroexpe'];
	volver($expe['nroexpe']);  //nroexpe
	//header("Location:panelexpediente.php?expe=$exp");
}

function volver($exp){

 	//echo "<script languaje='javascript' type='text/javascript'>opener.Refrescar();;</script>";
	//echo "<script languaje='javascript' type='text/javascript'>window.opener.location.reload();;</script>";
	//echo "<script languaje='javascript' type='text/javascript'>window.close();</script>";
	header("Location:panelexpediente.php?expe=$exp");
		//panelexpediente.php?expe=2221
		//header("Location:editaexpediente.php?nroexpe=$exp");
}

function inviertefecha($f)
{
$datos = explode("-",$f);
$fecha[]= $datos[0];
$fecha[] = $datos[1];
$fecha[] = $datos[2];
$total=$fecha[2]."-".$fecha[1]."-".$fecha[0];
return  $total;

}

switch ($_POST['ope'])
{
 case "Ie":{
 			 $expe['nroexpe']=$_POST['tnroexp'];		   				
   			 $expe['iniciador']=$_POST['tnroini'];
			 $expe['folio']=$_POST['nrofolio'];
			 $expe['fecha']=$_POST['tfecha'];
			 $expe['fechaIn']=$_POST['tfechain'];
			 $expe['caratula']=$_POST['cart_exp'];
			 $expe['estracto']=$_POST['testract'];
			 $expe['tipoexpe']=$_POST['tpo_exp'];
			 $expe['detallexpe']=$_POST['dtll_exp'];
			 $expe['letra']=strtoupper($_POST['lt_exp']);
			 $expe['observacionexp']=$_POST['obs_exp'];
			 $expe['dato']=$_POST['dt_exp'];
			 $expe['estado']=$_POST['std_exp'];
			  
			 
		     insertarExpediente($expe);
			  
			 break;
		 
		  }
 case "Ee":{ $expe['nroexpe']=$_POST['tnnnn'];
 			 $expe['fecha']=$_POST['tfecha'];
             $expe['fechaIn']=$_POST['tfechain'];
			 $expe['caratula']=$_POST['cart_exp'];
			 $expe['n_folio']=$_POST['nrofolio'];
			 $expe['estracto']=$_POST['testract'];
			 $expe['tipoexpe']=$_POST['tpo_exp'];
			 //$expe['detallexpe']=$_POST['dtll_exp'];
			 $expe['letra']=strtoupper($_POST['lt_exp']);
			 $expe['observacionexp']=$_POST['obs_exp'];
			 $expe['dato']=$_POST['dt_exp'];
			 //$expe['tnroini']=$_POST['tnroini'];
			// $expe['apell']=$_POST['apell'];
			// $expe['dni']=$_POST['dni'];
			 editarExpediente($expe);
			 break;
 			}
 
default : {
             echo "<script>location.href=\"principal.php\";<script>";		 
             break;
			}			 
}


?>