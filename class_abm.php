<?php

class abm
	{
		function listado($nombreTabla)
			{
                echo $nombreTabla;
			 $var = new conexion();
			 $var->conectarse();
			 
			 $tama�oPagina = 25;
			 
			 $consulta1 = "Select * from tbl_tablas where descripcion ='".$nombreTabla."'";
               // echo $consulta1;

			 $resu = mysql_query($consulta1);
			 
			 if(mysql_num_rows($resu) != 1)
			 	{
					//echo'<script>alert("Error en lectura de tabla.");location.href="principal.php";</script>';
				}else
					{
					 $row = mysql_fetch_array($resu); 
					 $consulta2 = "Select * from tbl_campostablas where id_tabla ='".$row['id_tabla']."' order by orden ";
					 $resu2 = mysql_query($consulta2) or die(mysql_error());
					 
					 if(mysql_num_rows($resu2)== 0)
					 	{
							
							echo'<script>alert("Campos de tabla no asignados.");location.href="principal.php";</script>';
						}else
							{
							 //determinamos el numero de campos que contiene la tabla 
                             //para saber el tama�o de la ventana popUp
                             $Tama�oPopUp = DeterminarDimensiones($row['id_tabla']);
                             
							 echo '<p><label>Buscar: &nbsp;&nbsp;</label>';
							 echo "<input type=\"text\" id=\"buscador\" name=\"buscador\" size=\"60\" onkeyup=\"ajax2(this.value,'div_find','class_buscar.php','".$nombreTabla."');\"/>";
							 echo "&nbsp;&nbsp;&nbsp;
							 	   <input type=\"button\" name=\"nuevo\" value=\"Nuevo\" onclick=\"AbrirPop('".$nombreTabla."','I','0','".$Tama�oPopUp."')\" class=\"button\">";
							 echo "&nbsp;&nbsp;&nbsp;
							 	   <input type=\"button\" value=\"Principal\" class=\"button\" onClick=\"principalL()\"></p>";
							
							//comienzo div de grilla 
							echo '<div id="div_find" style="height:500px;">';
							
							//comienzo div de registros
							echo '<div id="registros" style="height:450px;">';
							
							echo '<table border="1"> <thead><tr>';
							//campos que se muestran
							$campos = "";
							//--
                            
                            //obtenemos el nombre de la base de datos 
                            $sqlx = "SELECT base FROM configuracionempresa top";
                            $rowx = mysql_query($sqlx);
                    	    $auxx = mysql_fetch_array($rowx);
                    	    $BaseDatos = $auxx[0];
							
							//campo id de la tabla 
							$cons = "SELECT COLUMN_NAME
									FROM INFORMATION_SCHEMA.COLUMNS
									WHERE table_name = '$nombreTabla'
									AND table_schema = '".$BaseDatos."'
									AND COLUMN_KEY = 'PRI'";
									
							$re = mysql_query($cons);
							$aux = mysql_fetch_array($re);
							$campos .= $aux[0];
							//echo $cons;
							//--
 							//area encabezado
												
							 while($row = mysql_fetch_array($resu2))
							 	{
								 if($row['visible'] == 1)
								 	{
									 echo '<td><label>'.htmlentities($row['nombreMuestra']).'</label></td>';
									 //$campos .= ",".$row['nombreCampo'];
									 
									 if($row['sql'] == "")
									 	{
											if(strtolower($row['tipo']) == "fecha")
												{
									 				$campos .= ", DATE_FORMAT(".$row['nombreCampo'].",'%d-%m-%Y')";
												}
												else
												{
													$campos .= ",".$row['nombreCampo'];
												}
										}
										else
											{
												$sqlAux = $row['sql'];
												
												//quitar el id de la consulta
												$inicio = strpos($sqlAux, " ");
												$fin 	= strpos($sqlAux, ",");
												
												$texto = substr($sqlAux, $inicio, $fin-$inicio);
												$texto = str_replace("as id","",$texto);
												
												$textoAremplazar = substr($sqlAux, $inicio, ($fin-$inicio) + 1);
												
												$textoFinal = str_replace($textoAremplazar,"",$row['sql']);
													
												//armar consulta 
												if(strrpos(strtolower($row['sql']), "where") == false ) #preguntar si contiene un Where 
													{
														if(strtolower($row['tipo']) == "entero") #preguntar por el tipo de dato
															{
																$campos .= ' ,( '.$textoFinal.' where '.$texto.' =  t.'.$row['nombreCampo'].') ';	
															}
															else
															{
																$campos .= ' ,( '.$textoFinal.' where '.$texto.' = \'t.'.$row['nombreCampo'].'\') ';	
															}
													}
													else
													{
														if(strtolower($row['tipo']) == "entero") #preguntar por el tipo de dato
															{
																$campos .= ' ,( '.$textoFinal.' and '.$texto.' = t.'.$row['nombreCampo'].') ';	
															}
															else
															{
																$campos .= ' ,( '.$textoFinal.' and '.$texto.' = \'t.'.$row['nombreCampo'].'\') ';	
															}
													}
											}
									 
									}else
										{
										 echo '';
										}
									
								}
							echo '<td style="text-align: center;"><label>Editar</label></td><td style="text-align: center;"><label>Eliminar</label></td></tr></thead>';
							
							//area cuerpo
							$consulta = "Select $campos from ".$nombreTabla." as t";
							$consulta3 = "Select $campos from ".$nombreTabla." as t Limit 0,".$tama�oPagina;
							//echo"$consulta3";
							$resu3 = mysql_query($consulta3);
							echo"<tbody>";
							
							if(mysql_num_rows($resu3) <= 0)
								{
								 echo '<tr><td colspan="10"></td></tr>';
								}else
									{
										while($row_1 = mysql_fetch_array($resu3))
											{
											echo '<tr>';
											 $i = 0;
											 foreach($row_1 as $value)
    											{
													if($i>1)
														{
														if($i%2)
															{
															 echo '<td>'.htmlentities($value).'</td>';	
															}
														}
													$i++;
												}
											//editar 
											echo "<td onclick=\"AbrirPop('".$nombreTabla."','U','$row_1[0]','".$Tama�oPopUp."')\" style=\"text-align: center;\" title=\"Editar\" ><img src=\"./assest/plugins/buttons/icons/pencil.png\" width='15' heigth='15' /></td>";
											//--
											
											//eliminar
											echo "<td onclick=\"AbrirPop('".$nombreTabla."','D','$row_1[0]','".$Tama�oPopUp."')\" style=\"text-align: center;\" title=\"Eliminar\" ><img src=\"./assest/plugins/buttons/icons/cancel.png\"   width='15' heigth='15' /></td>";
											//--
											 echo '</tr>';
											}
									}
							 echo '</tbody></table>';
							 
							 //fin div de registros
							 echo '</div>';
							 
							 
							 //comienzo div de paginaci�n
							 echo '<div id="Paginacion" style="height:50px;"><br><center>';
							 
							 //determinar la cantidad de p�ginas
							 $Mysql = "Select Count(*) from ".$nombreTabla."";
							 $resultado = mysql_query($Mysql);
							 
							 $row = mysql_fetch_array($resultado);
							 $cantRegistros = $row[0];
							 
							 $paginas = ceil($cantRegistros / $tama�oPagina);
							 
							 switch($paginas)
							 {
								 case 0:
								 	echo '<input type="button" value="<<" disabled>&nbsp;P�gina 0 de 0&nbsp;<input type="button" value=">>" disabled>';
									break;
								 
								 case 1: 
									echo '<input type="button" value="<<" disabled>&nbsp;P�gina 1 de '.$paginas.'&nbsp;<input type="button" value=">>" disabled>';
									break;
									
								 default:
								 	echo '<input type="hidden" name="consulta" value="'.$consulta.'">';
									echo '<input type="hidden" name="CantPaginas" value="'.$paginas.'">';
									echo '<input type="hidden" name="nomTabla" value="'.$nombreTabla.'">';
									echo '<input type="hidden" name="indice" value="'.( 1 * $tama�oPagina).'">';
								 	echo '<input type="button" value="<<" disabled>&nbsp;P�gina 1 de '.$paginas.'&nbsp;<input type="button" value=">>" onClick="SiguientePagina(2,indice.value,consulta.value,CantPaginas.value,nomTabla.value,\'class_abm_buscador.php\', \'div_find\')">';
									break;
								 	
							 }
							
							 //fin div de paginacion 
							 echo '</center></div>';
							 
							 //fin div de grilla 
							 echo '</div>';
							 
							}
					}
			}
	}
	
function BuscarReferencia($campo, $tabla)
	{
		$sql = "Select id_tabla from tbl_tablas Where descripcion = '".$tabla."'";
		$resu = mysql_query($sql);
		
		$row = mysql_fetch_array($resu);
		
		$idTabla = $row[0];
		
		
	}
function DeterminarDimensiones($idTabla)
    {
        //modo de evaluaci�n para determinar el tama�o del PopUp
        /*
        Si en el catalogo que se vaya a armar existen mas de 8 campos 'que se deban cargar'
        se debe generar una tabla con 2 columnas; caso contrario los campos se deben generar
        en forma vertical.
        (los TextArea se multiplican x 5).    
        */
        
        $sql = "Select * from tbl_campostablas Where id_tabla = ".$idTabla ; 
       	$rows = mysql_query($sql);
        
        $cantidad = 0;
        $cantidadTextArea = 0;
        $fecha = 0;
        
         while($row = mysql_fetch_array($rows))
         {
            if($row['seCarga'] == 1)
                {
                    //aumento en 1 la cantidad de campos para saber de que tama�o se debe armar 
                    //el PopUp
                    $cantidad++;
                    
                    if($row['tipo'] == "textarea")
                    {
                        $cantidadTextArea ++;
                    }
                    else
                    {
                        if($row['tipo'] == "fecha") 
                            {
                                $fecha ++;
                            }   
                    }
                }
         }
         
         //tama�o del titulo
         $alto = 60;
         $ancho = 500;
         
         if($cantidad < 8)
            {
                //se armara con una unica columna
                //a�adir mas alto a la ventana dependiendo de la cantidad de elementos
                $alto += $cantidad * 40;
                $alto += 30;       
            }
            else
            {
                //se armara con 2 columnas
                //a�adir mas alto a la ventana dependiendo de la cantidad de elementos
                $alto += ($cantidad * 40) / 2;
                $ancho = 800;
            }
         
         //si hay algun TextArea entre los elementos, aumentar el alto, debido a que el 
         //elemento este es mas alto que los demas
         if($cantidadTextArea > 0)
            {
                $alto += $cantidadTextArea * 40;
            }
            
         //si hay algun componente tipo fecha Agrandar un poco mas la ventana para que
         //se pueda visualizar el calendario
         if($fecha > 0)
            {
                $alto += 40;
            }
            
         //mas el alto para los botones Aceptar y Cancelar
         $alto += 40;
         
         $tama�o = "width=".$ancho.",height=".$alto."";
         
         return $tama�o;
    }
?>
<script>
function principalL()
	{
	document.listado.action = "principal.php";
	document.listado.submit();
	}
	
function AbrirVentana(tabla,accion,id,tama�o)
	{
	 /*
	
	 */
	}

function SiguientePagina(pagina, indice, consulta, cantPaginas, nomTabla, archivo, div)
	{
		// Obtendo la capa donde se muestran las respuestas del servidor
		var capa=document.getElementById(div);
		// Creo el objeto AJAX
		var ajax=nuevoAjax();
		// Coloco el mensaje "Cargando..." en la capa
		capa.innerHTML="Cargando...";
		// Abro la conexi�n, env�o cabeceras correspondientes al uso de POST y env�o los datos con el m�todo send del objeto AJAX
		ajax.open("POST",archivo, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("variable="+pagina+"~"+consulta+"~"+cantPaginas+"~"+nomTabla+"~"+indice);
		
		ajax.onreadystatechange=function()
			{
				if (ajax.readyState==4)
				{
					// Respuesta recibida. Coloco el texto plano en la capa correspondiente
					capa.innerHTML=ajax.responseText;
				}
			}        
	}
	
function nuevoAjax()
{ 
	/* Crea el objeto AJAX. Esta funcion es generica para cualquier utilidad de este tipo, por
	lo que se puede copiar tal como esta aqui */
	var xmlhttp=false; 
	try 
	{ 
		// Creacion del objeto AJAX para navegadores no IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// Creacion del objet AJAX para IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') { xmlhttp=new XMLHttpRequest(); } 

	return xmlhttp; 
}
</script>