<?php
include "conexion.php";

$conecta = new conexion();
$conecta ->conectarse();

$dato=$_POST['variable'];

$arre = explode('~',$dato);

$dato = $arre[0];

$nombreTabla = $arre[1];

//-------------- variables para la paginación ------------

$TamañoPagina = 25;

//--------------------------------------------------------

$consulta1 = "Select * from tbl_tablas where descripcion ='".$nombreTabla."'";
$resu = mysql_query($consulta1);
$row = mysql_fetch_array($resu);

$consulta2 = "Select * from tbl_campostablas where id_tabla ='".$row['id_tabla']."' order by orden";
$resu2 = mysql_query($consulta2);

//determinamos el numero de campos que contiene la tabla 
//para saber el tamaño de la ventana popUp
$TamañoPopUp = DeterminarDimensiones($row['id_tabla']);
				
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

//--
					//comienzo div de registros
					echo '<div id="registros" style="height:450px;">';

						echo '<table border="1"><thead><tr>';					
						 while($row = mysql_fetch_array($resu2))
							{
							 if($row['visible'] == 1)
								{
								 echo '<td><label>'.htmlentities($row['nombreMuestra']).'</label></td>';
								 
								 if($row['sql'] == "")
									 	{
											if(strtolower($row['tipo']) == "fecha")
												{
									 				$campos .= ", DATE_FORMAT(".$row['nombreCampo']."~'%d-%m-%Y')";
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
							echo '<td style="text-align: center;"><label>Editar</label></td><td style="text-align: center;"><label>Eliminar</label></td> </thead></tr>';
														
							$camposAbuscar = explode(',',$campos);
							
							$cantidad = count($camposAbuscar);
							$condicion = "";

							for($i=1 ; $i<$cantidad ; $i++)
								{
								 if($i!= ($cantidad -1))
								 	{
								 	$condicion .= str_replace("~",",",$camposAbuscar[$i])." Like '%".$dato."%' or  ";
									}else
										{
										 $condicion .= str_replace("~",",",$camposAbuscar[$i])." Like '%".$dato."%' ";
										}
								}
							
							//area cuerpo
							$campos = str_replace("~",",",$campos);
							$consulta = "Select count(*) from ".$nombreTabla." as t where ".$condicion;
							$consulta2 = "Select $campos from ".$nombreTabla." as t where ".$condicion;
							$consulta3 = "Select $campos from ".$nombreTabla." as t where ".$condicion." limit 0,".$TamañoPagina;
							$resu3 = mysql_query($consulta3);
							
							echo"<tbody>";
							//echo '<tr></td>'.$consulta3.'</td></tr>';

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
											echo "<td onClick=\"AbrirPop('".$nombreTabla."','U','$row_1[0]','".$TamañoPopUp."')\" style=\"text-align: center;\" title=\"Editar\"><img src=\"./assest/plugins/buttons/icons/pencil.png \" aling='center' /></td>";


											//--
											
											//eliminar
											echo "<td onClick=\"AbrirPop('".$nombreTabla."','D','$row_1[0]','".$TamañoPopUp."')\" style=\"text-align: center;\" title=\"Eliminar\"><img src='./assest/plugins/buttons/icons/cancel.png ' aling='center' /> </td>";

											//--
											 echo '</tr>';
											}
									}
							 echo "</tbody></table>";
							 
							 //fin div de registros
							 echo '</div>';
							 
							 //comienzo div de paginación
							 echo '<div id="Paginacion" style="height:50px;"><br><center>';
							 
							 //determinar la cantidad de páginas
							 //$Mysql = "Select Count(*) from ".$nombreTabla."";
							 $resultado = mysql_query($consulta);
							 
							 $row = mysql_fetch_array($resultado);
							 $cantRegistros = $row[0];
							 
							 $paginas = ceil($cantRegistros / $TamañoPagina);
							 
							 switch($paginas)
							 {
								 case 0:
								 	echo '<input type="button" value="<<" disabled>&nbsp;Página 0 de 0&nbsp;<input type="button" value=">>" disabled>';
									break;
								 
								 case 1: 
									echo '<input type="button" value="<<" disabled>&nbsp;Página 1 de '.$paginas.'&nbsp;<input type="button" value=">>" disabled>';
									break;
									
								 default:
								 	echo '<input type="hidden" name="consulta" value="'.$consulta2.'">';
									echo '<input type="hidden" name="CantPaginas" value="'.$paginas.'">';
									echo '<input type="hidden" name="nomTabla" value="'.$nombreTabla.'">';
									echo '<input type="hidden" name="indice" value="'.( 1 * $TamañoPagina).'">';
								 	echo '<input type="button" value="<<" disabled>&nbsp;Página 1 de '.$paginas.'&nbsp;<input type="button" value=">>" onClick="SiguientePagina(2,indice.value,consulta.value,CantPaginas.value,nomTabla.value,\'class_abm_buscador.php\', \'div_find\')">';
									break;
								 	
							 }
							
							 //fin div de paginacion 
							 echo '</center></div>';
	
function DeterminarDimensiones($idTabla)
    {
        //modo de evaluación para determinar el tamaño del PopUp
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
                    //aumento en 1 la cantidad de campos para saber de que tamaño se debe armar 
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
         
         //tamaño del titulo
         $alto = 60;
         $ancho = 500;
         
         if($cantidad < 8)
            {
                //se armara con una unica columna
                //añadir mas alto a la ventana dependiendo de la cantidad de elementos
                $alto += $cantidad * 40;
                $alto += 30;       
            }
            else
            {
                //se armara con 2 columnas
                //añadir mas alto a la ventana dependiendo de la cantidad de elementos
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
         
         $tamaño = "width=".$ancho.",height=".$alto."";
         
         return $tamaño;
    }													 
?>