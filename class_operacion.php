<?php
echo '
<style type="text/css">

#CambioEstado {
	
	width:100%;
	height:100%;
	z-index:1;
	background-color: #000;
	border: 1px #212121 solid;
	-moz-opacity: 0.50; 
	filter: alpha(opacity=85);
	-khtml-opacity: .85;
	opacity: .85; 
	display:block;
}
</style>
<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
<link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection"> 
<link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
<link rel="stylesheet" href="assest/print.css" type="text/css" media="print"> 
<center>
<br>
<form name="error" action="">
<div id="CambioEstado">
	<br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
        	<div id="mensajeInformativo" style="width:400px; height:200px; background:#C0C0C0">
            <table width="100%" height="100%" style="text-align:center; background-color:#C90;">
				<tr>
	                
                </tr>
            	<tr style="background-color:#C90;background-color:#C90;">
                	<td style="text-align:center;background-color:#C90;" valign="middle">
						<br>
						<img id="Cargando" src="assest/plugins/buttons/icons/loading11.gif">
						<br>
						<br>
						<!--<input type="button" value="Aceptar" onClick="Atras();" class="button">-->
        			</td>
                </tr>
            </table>
            </div>
</div>
</form>
</center>
';

include("conexion.php");

$var = new conexion();
$var->conectarse();

//nombre de la tabla 
$tabla = $_POST['tablaNom'];

//id del registro
$Id = $_POST['Pk'];

//accion que se va a ejecutar
//U : modificacion
//I : insercion
//D : eliminacion
$accion = $_POST['accion'];

//obtenemos el nombre de la base de datos 
$sqlx = "SELECT base FROM configuracionempresa top";
$rowx = mysql_query($sqlx);
$auxx = mysql_fetch_array($rowx);
$BaseDatos = $auxx[0];
                            
$cons = "SELECT COLUMN_NAME
			FROM INFORMATION_SCHEMA.COLUMNS
			WHERE table_name = '$tabla'
			AND table_schema = '".$BaseDatos."'
			AND COLUMN_KEY = 'PRI'";
			
	$re = mysql_query($cons);
	$aux = mysql_fetch_array($re);
	$Pk = $aux[0];

switch($accion)
	{
	case "D":
		{	
		 $consulta = "Delete From ".$tabla." where ".$Pk." = ".$Id;
		 $registro = mysql_query($consulta);
		 
		 echo "<script>window.history.back(1);</script>";
		 
		 /*
		 echo"<script>alert('Los datos se guardaron correctamente');  window.opener.location.href = window.opener.location.href; window.opener.document.location.reload();self.close()
			 if (window.opener.progressWindow) { window.opener.progressWindow.close() }
			window.close();
			</script>";
		 */
		 break;
		}
	case "I":
		{
		 $consulta = "Select * From tbl_tablas where descripcion = '".$tabla."'";
		 $resu = mysql_query($consulta);
		 $row = mysql_fetch_array($resu);
		 $idTabla = $row['id_tabla'];
		
			//buscamos los campos de la tabla
			$consulta = "Select * from tbl_campostablas where id_tabla ='".$idTabla."'";
			$resu = mysql_query($consulta);
			
			$campos = "";
			$tipos = "";
			while($row = mysql_fetch_array($resu))
				{
				 if($row['seCarga'] != 0)
				 	{
					 //este campo se debe cargar desde el formulario
					 if($campos == "")
					 	{
						 $campos = $row['nombreCampo'];
						 $tipos = $row['tipo'];
						}else
							{
							 $campos .= ",".$row['nombreCampo'];
							 $tipos .= ",".$row['tipo'];
							}
					}
				}
				
			 $arreCamp = explode(",",$campos);
			 $arreTipo = explode(",",$tipos);
			 
			 //print_r($arreCamp);
 			 //print_r($arreTipo);
			 $values = "";
			 
			 for($i=0 ; $i< count($arreCamp) ; $i++)
			 	{
				 //echo $arreCamp[$i];
				 //echo $arreTipo[$i]."<br>";
				 if($i == (count($arreCamp)-1))
				 	{
					 //es el ultimo 
					 if($arreTipo[$i] == "entero")
					 	{
						 $values .= "".$_POST[$arreCamp[$i]]."";
						}else
							{
							 if($arreTipo[$i] == "fecha")
                                { 
                                  $values .= "'".invierteFecha($_POST[$arreCamp[$i]])."'";   
                                }
                                else
                                {
									if($arreTipo[$i] == "password")
										{
											$values .= "'".md5($_POST[$arreCamp[$i]])."'"; 
										}
										else
										{
                                  			$values .= "'".$_POST[$arreCamp[$i]]."'";  
										}
                                }
							}
					}else
						{
						 //no es el ultimo 
						 if($arreTipo[$i]== "entero")
						 	{
							 $values .= "".$_POST[$arreCamp[$i]].",";
							}else
								{
								    if($arreTipo[$i]== "fecha")
                                        {
                                            $values .= "'".invierteFecha($_POST[$arreCamp[$i]])."',";   
                                        }
                                        else
                                        {
                                            if($arreTipo[$i] == "password")
												{
													$values .= "'".md5($_POST[$arreCamp[$i]])."',"; 
												}
												else
												{
													$values .= "'".$_POST[$arreCamp[$i]]."',";  
												}
                                        }
								}
						}
				}
			 
			 $consulta = "Insert Into ".$tabla." (".$campos.") Values (".$values.")";
			 mysql_query($consulta);
			
			
			echo "<script>window.history.back(1);</script>";
			/*
			echo"<script>alert('Los datos se guardaron correctamente');  window.opener.location.href = window.opener.location.href; window.opener.document.location.reload();self.close()
		    if (window.opener.progressWindow) { window.opener.progressWindow.close() }
			window.close();
			</script>";
			
			header("listado.php");
			*/
		 break;
		}
	case "U":
		{
		 $consulta = "Select * From tbl_tablas where descripcion = '".$tabla."'";
		 $resu = mysql_query($consulta);
		 $row = mysql_fetch_array($resu);
		 $idTabla = $row['id_tabla'];
		
			//buscamos los campos de la tabla
			$consulta = "Select * from tbl_campostablas where id_tabla ='".$idTabla."'";
			$resu = mysql_query($consulta)or die(mysql_error());
			
			$campos = "";
			$tipos = "";
			
			while($row = mysql_fetch_array($resu))
				{
					//print_r($row);
				 if($row['seCarga'] != 0)
				 	{
					 //este campo se debe cargar desde el formulario
					 if($campos == "")
					 	{
						 $campos = $row['nombreCampo'];
						 $tipos = $row['tipo'];
						}else
							{
							 $campos .= ",".$row['nombreCampo'];
							 $tipos .= ",".$row['tipo'];
							}
					}
				}
				
			 $arreCamp = explode(",",$campos);
			 $arreTipo = explode(",",$tipos);
			 
			 $values = "";
			 
			 for($i=0 ; $i< count($arreCamp) ; $i++)
			 	{
				 //echo $arreCamp[$i];
				 //echo $arreTipo[$i]."<br>";
				 if($i == (count($arreCamp)-1))
				 	{
					 //es el ultimo 
					 if($arreTipo[$i] == "entero")
					 	{
						 $values .= "".$arreCamp[$i]." = ".$_POST[$arreCamp[$i]]."";
						}else
							{
							 if($arreTipo[$i] == "fecha")
                                {
                                    $values .= "".$arreCamp[$i]." = '".invierteFecha($_POST[$arreCamp[$i]])."'";
                                }
                                else
								{
									if($arreTipo[$i] == "password")
									  {
										if($_POST[$arreCamp[$i]] != "")
										{
											$values .= "".$arreCamp[$i]." = '".md5($_POST[$arreCamp[$i]])."'";
										}
									  }
									  else
									  {
									    $values .= "".$arreCamp[$i]." = '".$_POST[$arreCamp[$i]]."'";
									  }	
								}
							}
					}else
						{
						 //no es el ultimo 
						 if($arreTipo[$i]== "entero")
						 	{
							 $values .= "".$arreCamp[$i]." = ".$_POST[$arreCamp[$i]].",";
							}else
								{
				                if($arreTipo[$i]== "fecha")
                                    {
                                        $values .= "".$arreCamp[$i]." = '".invierteFecha($_POST[$arreCamp[$i]])."',";
                                    }
                                    else
                                    {
										if($arreTipo[$i] == "password")
										  {
											if($_POST[$arreCamp[$i]] != "")
											{
												$values .= "".$arreCamp[$i]." = '".md5($_POST[$arreCamp[$i]])."',";
											}
										  }
										  else
										  {
											$values .= "".$arreCamp[$i]." = '".$_POST[$arreCamp[$i]]."',";
										  }	
                                    }
								}
						}
				}
			 
			 $consulta = "Update ".$tabla." Set ".$values." where ".$Pk." = ".$Id;
			 //echo $consulta;
			 mysql_query($consulta);
			 
			 
			 echo "<script>window.history.back(1);</script>";
			/*
			echo"<script>alert('Los datos se guardaron correctamente');  window.opener.location.href = window.opener.location.href; window.opener.document.location.reload();self.close()
		    if (window.opener.progressWindow) { window.opener.progressWindow.close() }
			window.close();
			</script>";
			
			header("listado.php");
			*/
		 break;	
		}	
	}

//luego de la operacion cerrar la ventana 	
//echo '<script>window.close()

function invierteFecha($valor)
    {
        $arre = explode("-",$valor);
        
        return $arre[2]."-".$arre[1]."-".$arre[0];
    }

?>