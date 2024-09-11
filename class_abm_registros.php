<?php
error_reporting(0);
session_start();
include("class_sesion.php");
$sesion= new Sesion();
$CadenaPermisos = $sesion->iniciar();

include ("conexion.php");
$var = new conexion();
$var->conectarse();



//parametro de busqueda
$arre = explode('~',$_POST['variable']);

$tabla = $arre[0];
$accion = $arre[1];
$idRegistro = $arre[2];
$tamaño = $arre[3];
$colu = $arre[4];
$lado = 0;

echo '<input type="hidden" name="tablaNom" value="'.$tabla.'">';
echo '<input type="hidden" name="Pk" value="'.$idRegistro.'">';
echo '<input type="hidden" name="accion" value="'.$accion.'">';

//preguntar si se debe buscar o no un registro
if($idRegistro != 0)
	{
	 //buscar un registro 
       //obtenemos el nombre de la base de datos 
       $sql = "SELECT base FROM configuracionempresa top";

       $row = mysql_query($sql);
	   $aux = mysql_fetch_array($row);
	   $BaseDatos = $aux[0];
       
	   //obtenemos el nombre del campo clave primaria de la tabla seleccionada
	   $cons = "SELECT COLUMN_NAME
				FROM INFORMATION_SCHEMA.COLUMNS
				WHERE table_name = '$tabla'
				AND table_schema = '".$BaseDatos."'
				AND COLUMN_KEY = 'PRI'";
				
		$re = mysql_query($cons);
		$aux = mysql_fetch_array($re);
		$Pk = $aux[0];
		
	 $consulta = "Select * From ".$tabla." where ".$Pk." = ".$idRegistro;
	 $registro = mysql_query($consulta);
	 $fila = mysql_fetch_array($registro);
	}


$consulta1 = "Select * from tbl_tablas where descripcion ='".$tabla."'";
$resu = mysql_query($consulta1);

if(mysql_num_rows($resu) != 1)
{
	echo'<script>alert("Error en lectura de tabla.");location.href="principal.php";</script>';
}else
	{
	 //comenzamos a armar la tabla 
	 $row = mysql_fetch_array($resu);
	 
	 
	 echo '<center>';
	 //div para mostrar algun error de campo requerido
	 echo '<div id="mensaje">
	 	   <br><br><br><br><br><br><br>
	 			<div style=" background-color: #fff; height: 150px; width:300px;-moz-border-radius: 10px;border-radius: 10px;">
					<br><br><br>
					<label id="textoMensaje"></label>
					<br><br><br>
	 				<input type="button" value="Cancelar" class="button" onClick="CerrarMensaje()">
				</div>
		   </div>';

	//encabezado tabla	   
	 echo '<table border="1"><tr><td colspan="4" style="text-align: center;"><br><h3>'.htmlentities($row['Titulo']).'</h3><hr></td></tr>';
	 
	 echo '<tr>';
	 $consulta2 = "Select * from tbl_campostablas where id_tabla ='".$row['id_tabla']."' order by orden";
	 $resu2 = mysql_query($consulta2);

	 $validacionText = "";
	 $validacionSelect = "";
	 
	 while($row2 = mysql_fetch_array($resu2))
			{
			 if($row2['seCarga']== 1)
			 	{
				 switch($row2['tipo'])
				 	{
					 case "entero":
					 	$funcJs = "numerico(this)";
						break;
					 case "cadena":
					 	$funcJs = "letras(this)";
						break;
                     case "fecha":
					 	$funcJs = "alfanumerico(this)";
						break;
					 case "alfanumerico":
					 	$funcJs = "alfanumerico(this)";
						break;	
					 default:
					 	$funcJs = "alfanumerico(this)";
						break;
					}
				 //switch para determinar que componente es el que se va a armar 
				 switch($row2['tipoHTML'])
				 	{
					 case 'text':
					        $valor = ($idRegistro != 0) ? $fila[$row2['nombreCampo']]:"";
                            if($colu == 1)
                                {
    					 		echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td>';
    							echo '<td><input type="text" id="'.$row2['nombreCampo'].'" name="'.$row2['nombreCampo'].'" maxlength="'.$row2['tamano'].'" value="'.$valor.'" onKeyUp="'.$funcJs.'" class="top"></td></tr>';
                                }
                                else
                                {
                                    if($lado == 0)
                                        {
                                            echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td>';
                                            echo '<td><input type="text" id="'.$row2['nombreCampo'].'" name="'.$row2['nombreCampo'].'" maxlength="'.$row2['tamano'].'" value="'.$valor.'" onKeyUp="'.$funcJs.'" class="top"></td>';
                                            $lado = 1;
                                        }
                                        else
                                        {
                                            echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td>';
                                            echo '<td><input type="text" id="'.$row2['nombreCampo'].'" name="'.$row2['nombreCampo'].'" maxlength="'.$row2['tamano'].'" value="'.$valor.'" onKeyUp="'.$funcJs.'" class="top"></td></tr>';
                                            $lado = 0;
                                        }
                                }
							
							//preguntar si el campo es requerido
							if($row2['requerido'] == 1)
								{
									$validacionText .= $row2['nombreCampo'].'~'.htmlentities($row2['nombreMuestra']).'#';									
								}		
					 		break;
					 case 'button':
					 		echo '<tr><td><input type="button" class="button" name="'.$row2['nombreCampo'].'" value="'.htmlentities($row2['nombreMuestra']).'" class="top"></td></tr>';				
					 		break;
					 case 'textarea':
					 		$valor = ($idRegistro != 0) ? $fila[$row2['nombreCampo']]:"";
                            if($colu == 1)
                                {
					 		    echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td><td><textarea name="'.$row2['nombreCampo'].'" rows="20" cols="20">'.$valor.'</textarea></td></tr>';
                                }
								
							//preguntar si el campo es requerido
							if($row2['requerido'] == 1)
								{
									$validacionText .= $row2['nombreCampo'].'~'.htmlentities($row2['nombreMuestra']).'#';								
								}	
					 		break;
					case 'password':
							$valor = ($idRegistro != 0) ? $fila[$row2['nombreCampo']]:"";
                            if($colu == 1)
                                {
    					 		echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td>';
    							echo '<td><input type="password" id="'.$row2['nombreCampo'].'" name="'.$row2['nombreCampo'].'" maxlength="'.$row2['tamano'].'" value="" onKeyUp="'.$funcJs.'" class="top"></td></tr>';
                                }
                                else
                                {
                                    if($lado == 0)
                                        {
                                            echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td>';
                                            echo '<td><input type="password" id="'.$row2['nombreCampo'].'" name="'.$row2['nombreCampo'].'" maxlength="'.$row2['tamano'].'" value="" onKeyUp="'.$funcJs.'" class="top"></td>';
                                            $lado = 1;
                                        }
                                        else
                                        {
                                            echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td>';
                                            echo '<td><input type="password" id="'.$row2['nombreCampo'].'" name="'.$row2['nombreCampo'].'" maxlength="'.$row2['tamano'].'" value="" onKeyUp="'.$funcJs.'" class="top"></td></tr>';
                                            $lado = 0;
                                        }
                                }
								
							//preguntar si el campo es requerido
							if($row2['requerido'] == 1)
								{
									$validacionText .= $row2['nombreCampo'].'~'.htmlentities($row2['nombreMuestra']).'#';									
								}			
							break;
                    case 'date':
                           $valor = ($idRegistro != 0) ? invierteFecha($fila[$row2['nombreCampo']]) : date("d-m-Y");
                            if($colu == 1)
                                {
    					 		echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td>';
    							echo '<td>
                                        <input type="text" name="'.$row2['nombreCampo'].'" id="'.$row2['nombreCampo'].'" value="'.$valor.'" class="campofecha" readonly="readonly" onclick="AbrirCalendario()" >';





                                }
                                else
                                {
                                    if($lado == 0)
                                        {
                                           echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td>';
                                           echo '<td>
                                                   <input type="text" name="'.$row2['nombreCampo'].'" id="'.$row2['nombreCampo'].'" value="'.$valor.'" class="campofecha" readonly="readonly" onclick="AbrirCalendario()">

                                                 </td>';


                                           $lado = 1; 
                                        }
                                        else
                                        {
                                           echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td>';
                                           echo '<td>
                                                   <input type="text" name="'.$row2['nombreCampo'].'" id="'.$row2['nombreCampo'].'" value="'.$valor.'" class="campofecha" readonly="readonly" onclick="AbrirCalendario()" >
                                                 </td></tr>';


                                           $lado = 0;  
                                        }
                                }  
							
							//preguntar si el campo es requerido
							if($row2['requerido'] == 1)
								{
									$validacionText .= $row2['nombreCampo'].'~'.htmlentities($row2['nombreMuestra']).'#';									
								}		  
                            break;  
				    case 'select':
							$valor = ($idRegistro != 0) ? $fila[$row2['nombreCampo']]:"";
                            if($colu == 1)
                                {
    					 		echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td>';
    							echo '<td><select name="'.$row2['nombreCampo'].'" id="'.$row2['nombreCampo'].'">';
    							echo '<option value="0">Selecc. '.$row2['nombreMuestra'].'</option>';
    							$rec = mysql_query($row2['sql'])or die (mysql_error());
    							
    							if(mysql_num_rows($rec)> 0)
    							{
    								while($row4 = mysql_fetch_array($rec))	
    									{
    										if($valor == $row4[0])
    											{
    												echo '<option value="'.$row4[0].'" selected="selected">'.$row4[1].'</option>';
    											}else
    												{
    													echo '<option value="'.$row4[0].'">'.$row4[1].'</option>';
    												}
    									}
    							}
    							echo '</select>';
    							echo '</td></tr>';
                                }
                                else
                                {
                                    if($lado == 0)
                                        {
                                            echo '<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td>';
                							echo '<td><select name="'.$row2['nombreCampo'].'" id="'.$row2['nombreCampo'].'">';
                							echo '<option value="0">Selecc. '.$row2['nombreMuestra'].'</option>';
                							$rec = mysql_query($row2['sql'])or die (mysql_error());
                							
                							if(mysql_num_rows($rec)> 0)
                							{
                								while($row4 = mysql_fetch_array($rec))	
                									{
                										if($valor == $row4[0])
                											{
                												echo '<option value="'.$row4[0].'" selected="selected">'.$row4[1].'</option>';
                											}else
                												{
                													echo '<option value="'.$row4[0].'">'.$row4[1].'</option>';
                												}
                									}
                							}
                							echo '</select>';
                							echo '</td>';
                                            $lado = 1;
                                        }
                                        else
                                        {
                                            echo '<td>&nbsp;&nbsp;&nbsp;&nbsp;'.htmlentities($row2['nombreMuestra']).'</td>';
                							echo '<td><select name="'.$row2['nombreCampo'].'" id="'.$row2['nombreCampo'].'">';
                							echo '<option value="0">Selecc. '.$row2['nombreMuestra'].'</option>';
                							$rec = mysql_query($row2['sql'])or die (mysql_error());
                							
                							if(mysql_num_rows($rec)> 0)
                							{
                								while($row4 = mysql_fetch_array($rec))	
                									{
                										if($valor == $row4[0])
                											{
                												echo '<option value="'.$row4[0].'" selected="selected">'.$row4[1].'</option>';
                											}else
                												{
                													echo '<option value="'.$row4[0].'">'.$row4[1].'</option>';
                												}
                									}
                							}
                							echo '</select>';
                							echo '</td></tr>';
                                            $lado = 0;
                                        }
                                }
							
							//preguntar si el campo es requerido
							if($row2['requerido'] == 1)
								{
									$validacionSelect .= $row2['nombreCampo'].'~'.htmlentities($row2['nombreMuestra']).'#';								
								}		
							break;
					}
				}
			}
			
	//fin de la tabla 
	echo '</tr><tr><td colspan="4">&nbsp;&nbsp;&nbsp;<hr></td></tr></table>';
	
	//validacion 
	 echo '<input type="hidden" id="validacionText" name="validacionText" value="'.$validacionText.'">';
	 
	 echo '<input type="hidden" id="validacionSelect" name="validacionSelect" value="'.$validacionSelect.'">';
	 
	//botones
	// echo "<input type=\"button\" name=\"nuevo\" value=\"Nuevo\" onClick=\"AbrirVentana('$nombreTabla','I','0')\">";
	echo " <p> <input type=\"button\" value=\"Aceptar\" class=\"button\" onClick=\"Aceptar('$accion')\"> &nbsp;&nbsp;&nbsp;";//
	echo '<input type="button" value="Cancelar" class="button" onClick="Cerrar()"> </p>';
	echo '</center>';
	 }

function invierteFecha($valor)
{
	$array = explode('-', $valor);
	return $array[2].'-'.$array[1].'-'.$array[0];	
}




 ?>
