<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<link rel="stylesheet" href="assest/estilos.css" type="text/css" media="screen, projection"> 










</head>

<center>
<?php


class info
{
	
	public function info_cuotas($cliente)
	{   
	 $var = new conexion();
     $var->conectarse();
			
		// busco informacion del usuario	
			
			$consulta = "SELECT  U.nombre_real,U.direccion,U.telefono, U.id_grupo, TG.descripcion from  usuarios  U
							JOIN  tbl_grupos TG on  TG.id_grupo=U.id_grupo
					
			 where id_usuario=".$cliente;
			 //echo"$consulta";
			   
			  $resu = mysql_query($consulta);
			  
			   $r = mysql_fetch_array($resu);
   				
				echo'<div>';
				echo 'Cliente:'.$r[0].'<br>'; 
				echo'</div>';
				 
			 
			 if(mysql_num_rows($resu)>0)
			 	{
					 $i=$r[4];
					// echo"----$i";
					//bnusca tipo de usuario si es 1 es administrador 2, usuario, 3 propietario	
						switch ($i) 
						{
							case 'admin':
							{	
							$consulta = "SELECT D.estado,D.cuota 
							,D.fecha_vence,CO.fecha_alta,P.descripcion as 	   							
							producto,CO.descripcion as operacion,D.monto,D.recargo, 	
							(D.recargo+D.monto) as 	
							total,G.descripcion,U.nombre_real,D.id_deta,D.monto
							from detalle D 
							JOIN contrato CO on D.id_contrato=CO.id_contrato 
							JOIN usuarios U on CO.id_cliente=U.id_Usuario 
							JOIN producto P on CO.id_producto=P.id_producto
							JOIN grupo_cliente G on CO.id_grupocliente=G.id_grupocliente
							WHERE   D.estado<>'P' AND D.estado <>'I'
							
							ORDER BY D.cuota ";
							
							//echo $consulta ;
						 $resu = mysql_query($consulta);
						  listarasigna($resu, $r[4]);
							
							   break;
							}
							case 'clientes':
							{
							$consulta = "SELECT D.estado,D.cuota ,D.fecha_vence,CO.fecha_alta,P.descripcion as 	
							producto,CO.descripcion as operacion,D.monto,D.recargo, (D.recargo+D.monto) as 	
							total,G.descripcion,U.nombre_real,D.id_deta,D.monto
							from detalle D 
							JOIN contrato CO on D.id_contrato=CO.id_contrato 
							JOIN usuarios U on CO.id_cliente=U.id_Usuario 
							JOIN producto P on CO.id_producto=P.id_producto
							JOIN grupo_cliente G on CO.id_grupocliente=G.id_grupocliente
							
							 where D.estado<>'P' AND D.estado<>'I' AND U.id_usuario=".$cliente." ORDER BY D.cuota desc";
							
							 $resu = mysql_query($consulta);
							 listarasigna($resu,$r[4] );
							   break;
					 		}
							case 'propietario':
					 		{	
							$consulta = "SELECT D.estado,D.cuota ,D.fecha_vence,CO.fecha_alta,P.descripcion as 	
								producto,CO.descripcion as operacion,D.monto,D.recargo, (D.recargo+D.monto) as 	
								total,G.descripcion,U.nombre_real,D.id_deta, G.id_usuario,D.monto
							from detalle D 
							JOIN contrato CO on D.id_contrato=CO.id_contrato 
							JOIN usuarios U on CO.id_cliente=U.id_Usuario 
							JOIN producto P on CO.id_producto=P.id_producto
							where D.estado<>'P'  AND D.estado<>'I' AND D.id_propietario=".$cliente." ORDER BY D.cuota desc
							 ";
							//echo"$consulta";
						 $resu = mysql_query($consulta);
						  listarasigna($resu, $r[4]);
							
							   break;	
							   
							 }
						}
			}				


	}	



public function info_detallecontrato($cliente,$contrato)
	{   
	 $var = new conexion();
     $var->conectarse();
			
		// busco informacion del usuario	
			
			$consulta = "SELECT  U.nombre_real,U.direccion,U.telefono, U.id_grupo, TG.descripcion from  usuarios  U
							JOIN  tbl_grupos TG on  TG.id_grupo=U.id_grupo
					
			 where id_usuario=".$cliente;
			 //echo"$consulta";
			   
			  $resu = mysql_query($consulta);
			  
			   $r = mysql_fetch_array($resu);
   				
				echo'<div>';
				echo 'Cliente:'.$r[0].'<br>'; 
				echo'</div>';
				 
			 
			 if(mysql_num_rows($resu)>0)
			 	{
					 $i=$r[4];
					// echo"----$i";
					//bnusca tipo de usuario si es 1 es administrador 2, usuario, 3 propietario	
						switch ($i) 
						{
							case 'admin':
							{	
							$consulta = "SELECT D.estado,D.cuota ,D.fecha_vence,CO.fecha_alta,P.descripcion as 	
								producto,CO.descripcion as operacion,D.monto,D.recargo, (D.recargo+D.monto) as 	
								total,G.descripcion,U.nombre_real,D.id_deta,
                                                                 ( SELECT
                                                                    IFNULL( SUM(`deta_comprobante`.`monto`),0)
                                                                    FROM
                                                                    `deta_comprobante`
                                                                     INNER JOIN `detalle`
                                                                     ON (`deta_comprobante`.`id_deta` = `detalle`.`id_deta`)
                                                                   WHERE deta_comprobante.`id_deta`= D.id_deta AND `detalle`.`id_contrato`= CO.`id_contrato`

                                                                    ) AS mpagado, CO.id_contrato
                                                        from detalle D 
							JOIN contrato CO on D.id_contrato=CO.id_contrato 
							JOIN usuarios U on CO.id_cliente=U.id_Usuario 
							JOIN producto P on CO.id_producto=P.id_producto
							JOIN grupo_cliente G on CO.id_grupocliente=G.id_grupocliente
							WHERE  (D.id_contrato=$contrato  and D.estado <>'I') 
							ORDER BY D.fecha_vence "; 
                                                        
						 $resu = mysql_query($consulta);
						  listarasigna($resu, $r[4]);
							
							   break;
							}
							case 'clientes':
							{
							$consulta = "SELECT D.estado,D.cuota ,D.fecha_vence,CO.fecha_alta,P.descripcion as 	
							producto,CO.descripcion as operacion,D.monto,D.recargo, (D.recargo+D.monto) as 	
							total,G.descripcion,U.nombre_real,D.id_deta,
                                                        ( SELECT
                                                                    IFNULL( SUM(`deta_comprobante`.`monto`),0)
                                                                    FROM
                                                                    `deta_comprobante`
                                                                     INNER JOIN `detalle`
                                                                     ON (`deta_comprobante`.`id_deta` = `detalle`.`id_deta`)
                                                                   WHERE deta_comprobante.`id_deta`= D.id_deta AND `detalle`.`id_contrato`= CO.`id_contrato`

                                                                    ) AS mpagado , CO.id_contrato
							from detalle D 
							JOIN contrato CO on D.id_contrato=CO.id_contrato 
							JOIN usuarios U on CO.id_cliente=U.id_Usuario 
							JOIN producto P on CO.id_producto=P.id_producto
							JOIN grupo_cliente G on CO.id_grupocliente=G.id_grupocliente
							
							 where D.id_contrato=$contrato AND  D.estado <>'I'  and U.id_usuario=".$cliente." ORDER BY D.fecha_vence desc";
							
							 $resu = mysql_query($consulta);
							 listarasigna($resu,$r[4] );
							   break;
					 		}
							case 'propietario':
					 		{	
							$consulta = "SELECT D.estado,D.cuota ,D.fecha_vence,CO.fecha_alta,P.descripcion as 	
								producto,CO.descripcion as operacion,D.monto,D.recargo, (D.recargo+D.monto) as 	
								total,G.descripcion,U.nombre_real,D.id_deta, G.id_usuario,
                                                                ( SELECT
                                                                    IFNULL( SUM(`deta_comprobante`.`monto`),0)
                                                                    FROM
                                                                    `deta_comprobante`
                                                                     INNER JOIN `detalle`
                                                                     ON (`deta_comprobante`.`id_deta` = `detalle`.`id_deta`)
                                                                   WHERE deta_comprobante.`id_deta`= D.id_deta AND `detalle`.`id_contrato`= CO.`id_contrato`

                                                                    ) AS mpagado
							from detalle D 
							JOIN contrato CO on D.id_contrato=CO.id_contrato 
							JOIN usuarios U on CO.id_cliente=U.id_Usuario 
							JOIN producto P on CO.id_producto=P.id_producto
							JOIN grupo_cliente G on CO.id_grupocliente=G.id_grupocliente
							where D.id_contrato=$contrato  AND  D.estado <>'I'  AND G.id_usuario=".$cliente." ORDER BY D.fecha_vence desc
							 ";
							//echo"$consulta";
						 $resu = mysql_query($consulta);
						  listarasigna($resu, $r[4]);
							
							   break;	
							   
							 }
						}
			}				


	}	

public function info_contratos($cliente)
	{   
	 $var = new conexion();
     $var->conectarse();
			
		// busco informacion del usuario	
			
			$consulta = "SELECT  U.nombre_real,U.direccion,U.telefono, U.id_grupo, TG.descripcion from  usuarios  U
							JOIN  tbl_grupos TG on  TG.id_grupo=U.id_grupo
					
			 where id_usuario=".$cliente;
			 //echo"$consulta";
			   
			  $resu = mysql_query($consulta);
			  
			   $r = mysql_fetch_array($resu);
   				
				echo'<div>';
				echo 'Cliente:'.$r[0].'<br>'; 
				echo'</div>';
				 
			 
			 if(mysql_num_rows($resu)>0)
			 	{
					 $i=$r[4];
					// echo"----$i";
					//bnusca tipo de usuario si es 1 es administrador 2, usuario, 3 propietario	
						switch ($i) 
						{
							case 'admin':
							{	
									$consulta = "SELECT E.Estado,C.codigo,C.fecha_alta, 	
									U.nombre_real,P.descripcion,C.descripcion,cuotas,recargo,documento,G.descripcion 
									as emprendimiento ,interes,montocontrato,montoinicial,PE.descripcion as periodo,C.id_contrato
									FROM contrato C
									JOIN usuarios as U on U.id_usuario=C.id_cliente
									JOIN producto as P on P.id_producto=C.id_producto
									JOIN grupo_cliente  G  on C.id_grupocliente=G.id_grupocliente
									JOIN periodo PE on C.id_periodo=PE.id_periodo 
									JOIN estados E on  C.estado=E.id_estado									";
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
							
							//echo"$consulta";
						 $resu = mysql_query($consulta);
						  listarcontrato($resu, $r[4]);
							
							   break;
							}
							case 'clientes':
							{
							
							$consulta = "SELECT E.Estado,C.codigo,C.fecha_alta, 	
									U.nombre_real,P.descripcion,C.descripcion,cuotas,recargo,documento,G.descripcion 
									as emprendimiento ,interes,montocontrato,montoinicial,PE.descripcion as periodo,C.id_contrato
									FROM contrato C
									JOIN usuarios as U on U.id_usuario=C.id_cliente
									JOIN producto as P on P.id_producto=C.id_producto
									JOIN grupo_cliente  G  on C.id_grupocliente=G.id_grupocliente
									JOIN periodo PE on C.id_periodo=PE.id_periodo 
									JOIN estados E on  C.estado=E.id_estado	
									where C.id_cliente=	$cliente ";
							 $resu = mysql_query($consulta);
							 listarcontrato($resu,$r[4] );
							   break;
					 		}
							case 'propietario':
					 		{	
							$consulta = "SELECT E.Estado,C.codigo,C.fecha_alta, 	
									U.nombre_real,P.descripcion,C.descripcion,cuotas,recargo,documento,G.descripcion 
									as emprendimiento ,interes,montocontrato,montoinicial,PE.descripcion as periodo,C.id_contrato
									FROM contrato C
									JOIN usuarios as U on U.id_usuario=C.id_cliente
									JOIN producto as P on P.id_producto=C.id_producto
									JOIN grupo_cliente  G  on C.id_grupocliente=G.id_grupocliente
									JOIN periodo PE on C.id_periodo=PE.id_periodo 
									JOIN estados E on  C.estado=E.id_estado	
									where G.id_usuario=	$cliente	";
							//echo"$consulta";
						 $resu = mysql_query($consulta);
						  listarcontrato($resu, $r[4]);
							
							   break;	
							   
							 }
						}
			}				


	}		



public function info_cliente($cliente)
	{   
	 $var = new conexion();
         $var->conectarse();
			
			
			$consulta = "SELECT  U.nombre_real,U.direccion,U.telefono, U.id_grupo, TG.descripcion from  usuarios  U
					
							
							JOIN  tbl_grupos TG on  TG.id_grupo=U.id_grupo 
					
			 where  id_usuario=".$cliente;
			   
			  $resu = mysql_query($consulta);
			   $r = mysql_fetch_array($resu);
   				
				 
			 
				 if(mysql_num_rows($resu)>0)
					{
						 
						 if($r[4]==4)
						 {
					 echo'<div>';
					 echo 'Cliente:'.$r[0].'<br>'; 
					 echo 'Direccion:'.$r[1].'<br>'; 
					 echo 'telefono:'.$r[2].'<br>'; 
					 echo'</div>';
						 }
						else
						{	 
						
						 echo 'Cliente:'.$r[0].'<br>'; 
						 echo 'Direccion:'.$r[1].'<br>'; 
						 echo 'telefono:'.$r[2].'<br>'; 
					
						}
				}


	}	

public function nom_cliente($cliente)
	{   
	 $var = new conexion();
     $var->conectarse();
			
			
			$consulta = "SELECT  U.nombre_real,U.direccion,U.telefono, U.id_grupo, TG.descripcion from  usuarios  U
					
							
							JOIN  tbl_grupos TG on  TG.id_grupo=U.id_grupo
					
			 where id_usuario=".$cliente;
			   
			  $resu = mysql_query($consulta);
			   $r = mysql_fetch_array($resu);
   				
				 
			 
				 if(mysql_num_rows($resu)>0)
					{
						 
						 if($r[4]==4)
						 {
					 
					 echo 'Cliente:'.$r[0].'<br>'; 
					 
					 
						 }
						else
						{	 
						
						 echo ''.$r[0].'<br>'; 
						 
						 
						}
				}


	}		



}

// funcion para listar en el detalle de contrato por cada unos la lista de estdo de cuotas el listado de recibos por cada cuota	
function listarecibo($xc) 
	{  //xp numero de cuota
  
     

   $sql="SELECT   `detalle`.`cuota` , `deta_comprobante`.`id_comprobante` FROM  `deta_comprobante`
   					INNER JOIN `detalle` 
        			ON (`deta_comprobante`.`id_deta` = `detalle`.`id_deta`)
					WHERE ( `detalle`.`id_contrato`=".$xc.")";
					//echo $sql;
	$xs= mysql_query($sql); 
		
        $listado=" "; 
        $valor=0;
		while ($rec=mysql_fetch_array($xs))
       {
         
          //$valor=$rec['id_comprobante'];
        
         if($valor!=$rec['id_comprobante'])
		 {  
		 	$listado .= $listado . " - <a href='recibovista.php?comp=" . $rec['id_comprobante']. "'>" . $rec['id_comprobante']. "  </a>";
		    $valor=$rec['id_comprobante'];
         }

      }

 echo "<tr>".$listado."</tr>";
						
   //echo $listado;
	
	}


function listarasigna($result,$GR)// inicio y seleccion de lo que quiero mostrar
{   
		
		echo "<table border=\"0\" width=\"100%\">";
        
	   print "<th class=' fondo2'>ESTADO</th>";
	   
	   switch ($GR)
					 {
							case "admin":
							{
						   print "<th class='fondo2'>CLIENTE</th>";
						   print "<th class='fondo2'>CUOTA</th>";
						   print "<th class='fondo2'>VENCIMIENTO</th>";  //escribe el titulo de la tabla 
						   print "<th class='fondo2'>FECHA</th>";
						   print "<th class='fondo2'>PRODUCTO</th>";
						   print "<th class='fondo2'>DESCRIPCION</th>";
						   print "<th class='fondo2'>MONTO</th>";
						   print "<th class=' fondo2'>Pagado </th>";
                                               //   print "<th class='fondo2'>GRUPO</th>";
                                                   print "<th class='fondo2'>Saldo</th>";
						  
						   
						   
						    while ($registro = mysql_fetch_row($result))
				      		{
		  
								echo "<TR >";
								$estado=$registro[0];
								switch ($estado)
									 {
										case "C":
										  echo "<td class='cont3' title='CURSO' align=\"center\">$registro[0]</td>";
											break;
										case "P":
											echo "<td class='cont4'  title='PAGO'align=\"center\">$registro[0]</td>";
											break;
										case "V":
										   echo "<td class='cont5'  title='VENCIDO' align=\"center\">$registro[0]</td>";
											break;
										case "G":
										   echo "<td class='cont6'  title='GENERADO' align=\"center\">$registro[0]</td>";
											break;
											case "A":
										   echo "<td class='cont3'  title='ADICIONAL' align=\"center\">$registro[0]</td>";
											break;	
									}
						
					                echo "<td class='cont2' align=\"center\">$registro[10]</td>";
									echo "<td class='cont2' align=\"center\">$registro[1]</td>";
									echo "<td  class='cont2'align=\"center\">$registro[2]</td>";
									echo "<td class='cont2' align=\"center\">$registro[3]</td>";
									echo "<td class='cont2' align=\"center\">$registro[4]</td>";
									echo "<td class='cont2' align=\"left\">$registro[5]</td>";
									echo "<td class='cont2' align=\"left\">$registro[6]</td>";
  									echo "<td class='cont2' align=\"left\">$registro[12]</td>";
                                     $saldo=($registro[6]-$registro[12]);
                                     echo "<td class='cont2' align=\"left\">$saldo</td>";
								
    							   
									echo "</tr>";  

									 //echo $registro[13];
								   echo "Recibos:";
								    listarecibo($registro[13]);
								   
								
									}
								break;	
							
							}
							case "clientes":
							{
						  
						   print "<th class='fondo2'>CUOTA</th>";
						   print "<th class='fondo2'>VENCIMIENTO</th>";  //escribe el titulo de la tabla 
						   print "<th class='fondo2'>FECHA CONTRATO</th>";
						   print "<th class='fondo2'>PRODUCTO</th>";
						   print "<th class='fondo2'>DESCRIPCION</th>";
						   print "<th class='fondo2'>MONTO</th>";
						   print "<th class=' fondo2'>Pagado </th>";
                           print "<th class='fondo2'>Saldo</th>";
						   print "<th class=' fondo2'>Cupon </th>";
						   
						   
						    while ($registro = mysql_fetch_row($result))
				      		{
		  
								echo "<TR >";
								$estado=$registro[0];
								switch ($estado)
									 {
										case "C":
										  echo "<td class='cont3' title='CURSO' align=\"center\">$registro[0]</td>";
											break;
										case "P":
											echo "<td class='cont4'  title='PAGO'align=\"center\">$registro[0]</td>";
											break;
										case "V":
										   echo "<td class='cont5'  title='VENCIDO' align=\"center\">$registro[0]</td>";
											break;
										case "G":
										   echo "<td class='cont6'  title='GENERADO' align=\"center\">$registro[0]</td>";
										   break;
										   case "A":
										   echo "<td class='cont3'  title='ADICIONAL' align=\"center\">$registro[0]</td>";
											break;	
									}
						
					                
									echo "<td  class='cont2' align=\"center\">$registro[1]</td>";
									echo "<td  class='cont2'align=\"center\">$registro[2]</td>";
									echo "<td class='cont2' align=\"center\">$registro[3]</td>";
									echo "<td class='cont2' align=\"center\">$registro[4]</td>";
									echo "<td class='cont2' align=\"left\">$registro[5]</td>";
									echo "<td class='cont2' align=\"left\">$registro[6]</td>";
									echo "<td class='cont2' align=\"center\">$registro[9]</td>";
									echo "<td class='cont2' align=\"left\">$registro[12]</td>";
                                                                        echo "<td class='cont2' align=\"left\">$registro[12]</td>";
                                                                        $saldo=($registro[6]-$registro[12]);
                                                                        echo "<td class='cont2' align=\"left\">$saldo</td>";
									echo "<td class='cont2' style=\"text-align: center;\">
												<img src=\"assest/plugins/buttons/icons/page_white_acrobat.png\" 
												onClick=\"pago('".$registro[11]."');\" title=\"click para detalle de 	
												requerimiento\" /> </td>";
									
								   
    							   
									echo "</tr>";        
								listarecibo($registro[13]);
									
									}
								break;	
							
							}
							case "propietario":
							{
						   print "<th class='fondo2'>CLIENTE</th>";
						   print "<th class='fondo2'>CUOTA</th>";
						   print "<th class='fondo2'>VENCIMIENTO</th>";  //escribe el titulo de la tabla 
						   print "<th class='fondo2'>FECHA</th>";
						   print "<th class='fondo2'>PRODUCTO</th>";
						   print "<th class='fondo2'>DESCRIPCION</th>";
						   print "<th class='fondo2'>MONTO</th>";
						   //print "<th class='fondo2'>GRUPO</th>";
                                                   print "<th class=' fondo2'>Pagado </th>";
                                                   print "<th class='fondo2'>Saldo</th>";
						   print "<th class=' fondo2'>Cupon </th>";
						   
						   
						    while ($registro = mysql_fetch_row($result))
				      		{
		  
								echo "<TR >";
								$estado=$registro[0];
								switch ($estado)
									 {
										case "C":
										  echo "<td class='cont3' title='CURSO' align=\"center\">$registro[0]</td>";
											break;
										case "P":
											echo "<td class='cont4'  title='PAGO'align=\"center\">$registro[0]</td>";
											break;
										case "V":
										   echo "<td class='cont5'  title='VENCIDO' align=\"center\">$registro[0]</td>";
											break;
										case "G":
										   echo "<td class='cont6'  title='GENERADO' align=\"center\">$registro[0]</td>";
											break;	
									}
						
					                echo "<td class='cont2' align=\"center\">$registro[10]</td>";
									echo "<td  class='cont2' align=\"center\">$registro[1]</td>";
									echo "<td  class='cont2'align=\"center\">$registro[2]</td>";
									echo "<td class='cont2' align=\"center\">$registro[3]</td>";
									echo "<td class='cont2' align=\"center\">$registro[4]</td>";
									echo "<td class='cont2' align=\"left\">$registro[5]</td>";
									echo "<td class='cont2' align=\"left\">$registro[6]</td>";
								        echo "<td class='cont2' align=\"left\">$registro[12]</td>";
                                                                        echo "<td class='cont2' align=\"left\">($registro[6]-$registro[12])</td>";
									
									echo "<td class='cont2' style=\"text-align: center;\">
												<img src=\"assest/plugins/buttons/icons/page_white_acrobat.png\" 
												onClick=\"pago('".$registro[11]."');\" title=\"Click para ver cupon\" /> </td>";
								   
    							   
									echo "</tr>";        
								
									listarecibo($registro[13]);

									}
								break;	
							
							}
								
						
						}
	   
	   
	
	  
     
						
			echo "</TABLE>";
						
 }
	
function listarcontrato($result,$GR)// inicio y seleccion de lo que quiero mostrar
{   
		echo "<div id='abm'  styles='display:none;'/></div>";
		echo "<table border=\"0\" width=\"100%\">";
        
	   
	   
	   switch ($GR)
					 {
							case "admin":
							{
						   print "<th class='fondo2' >Contrato.</th>";
						   print "<th class='fondo2'>Fecha</th>";
						   print "<th class='fondo2'>CLIENTE</th>";  //escribe el titulo de la tabla 
						   print "<th class='fondo2'>Producto</th>";
						   print "<th class='fondo2'>Detalle Contrato.</th>";
						   print "<th class='fondo2'>Cuotas</th>";
						   print "<th class='fondo2'>Emprendimiento</th>";
						   print "<th class='fondo2'>Monto Contrato </th>";
						   print "<th class=' fondo2'>Saldo </th>";
						   
						   print "<th class=' fondo2'>++ </th>";
						   
						// echo($result);
						    while ($registro = mysql_fetch_row($result))
				      		{
		  
								echo "<TR name='t$registro[1]' >";
								$estado=$registro[0];
								
						                    
					               
									echo "<td  class='cont2' align=\"center\" id='v$registro[1]' name='v$registro[1]' onclick=visor(this.id,'$registro[1]',$registro[14]) ><a>$registro[1]</a></td>";
									echo "<td  class='cont2'align=\"center\">$registro[2]</td>";
									echo "<td class='cont2' align=\"center\">$registro[3]</td>";
									echo "<td class='cont2' align=\"center\">$registro[4]</td>";
									echo "<td class='cont2' align=\"left\">$registro[5]</td>";
									echo "<td class='cont2' align=\"left\">$registro[6]</td>";
									echo "<td class='cont2' align=\"center\">$registro[9]</td>";
									echo "<td class='cont2' align=\"center\">$registro[11]</td>";
									echo "<td class='cont2' align=\"center\">$registro[12]</td>";
									/*echo "<td class='cont2' style=\"text-align: center;\">
									<img src=\"assest/plugins/buttons/icons/page_white_acrobat.png\"
									onClick=\"documento('".$registro[8]."');\" title=\"click para detalle de
									requerimiento\" /> </td>";*/

    							   
									echo "</tr>";
                                                                        echo "<tr><td colspan='10'><div id='d$registro[1]' name='d$registro[1]' styles='display:none;'/></div><td></tr>";
								
									}
								break;	
							
									}
									case "clientes":
									{
						   print "<th class='fondo2'>Contrato</th>";
						   print "<th class='fondo2'>Fecha</th>";
						   print "<th class='fondo2'>Producto</th>";
						   print "<th class='fondo2'>Descripcion</th>";
						   print "<th class='fondo2'>Cuotas</th>";
						   print "<th class='fondo2'>Recargo</th>";
						   print "<th class='fondo2'>Interes</th>";
						   print "<th class=' fondo2'>Monto </th>";
						   print "<th class=' fondo2'>Documento </th>";
						    print "<th class='fondo2'>++ </th>";
						   
						   
						    while ($registro = mysql_fetch_row($result))
				      		{

                                echo "<TR name='t$registro[1]' >";
                                $estado=$registro[0];

								switch ($estado)
									 {
										case "C":
										  echo "<td class='cont3' title='CURSO' align=\"center\">$registro[0]</td>";
											break;
										case "P":
											echo "<td class='cont4'  title='PAGO'align=\"center\">$registro[0]</td>";
											break;
										case "V":
										   echo "<td class='cont5'  title='VENCIDO' align=\"center\">$registro[0]</td>";
											break;
										case "G":
										   echo "<td class='cont6'  title='GENERADO' align=\"center\">$registro[0]</td>";
											break;	
									}


                                    echo "<td  class='cont2' align=\"center\" id='v$registro[1]' name='v$registro[1]' onclick=visor(this.id,'$registro[1]',$registro[14]) ><a>$registro[1]</a></td>";
									//echo "<td  class='cont2' align=\"center\">$registro[1]</td>";
									echo "<td  class='cont2'align=\"center\">$registro[2]</td>";
									echo "<td class='cont2' align=\"center\">$registro[4]</td>";
									echo "<td class='cont2' align=\"left\">$registro[5]</td>";
									echo "<td class='cont2' align=\"left\">$registro[6]</td>";
									echo "<td class='cont2' align=\"center\">$registro[9]</td>";
									echo "<td class='cont2' align=\"center\">$registro[11]</td>";
									echo "<td class='cont2' align=\"center\">$registro[12]</td>";
									echo "<td class='cont2' style=\"text-align: center;\">
												<img src=\"assest/plugins/buttons/icons/page_white_acrobat.png\" 
												onClick=\"documento('".$registro[8]."');\" title=\"click para detalle de 	
												requerimiento\" /> </td>";

    							   
									echo "</tr>";
                                    echo "<tr><td colspan='10'><div id='d$registro[1]' name='d$registro[1]' styles='display:none;'/></div><td></tr>";
									}
								   
										break;	
									
									}
									case "propietario":
									{
								  print "<th class='fondo2'>Contrato</th>";
						   print "<th class='fondo2'>Fecha</th>";
						   print "<th class='fondo2'>CLIENTE</th>";  //escribe el titulo de la tabla 
						   print "<th class='fondo2'>Producto</th>";
						   print "<th class='fondo2'>Descripcion</th>";
						   print "<th class='fondo2'>Cuotas</th>";
						   print "<th class='fondo2'>Recargo</th>";
						   print "<th class='fondo2'>Interes</th>";
						   print "<th class=' fondo2'>Monto </th>";
						   print "<th class=' fondo2'>Documento </th>";
						   print "<th class=' fondo2'>++ </th>";
						   
						   
						    while ($registro = mysql_fetch_row($result))
				      		{

                                echo "<tr name='t$registro[1]' >";
								$estado=$registro[0];
								switch ($estado)
									 {
										case "C":
										  echo "<td class='cont3' title='CURSO' align=\"center\">$registro[0]</td>";
											break;
										case "P":
											echo "<td class='cont4'  title='PAGO'align=\"center\">$registro[0]</td>";
											break;
										case "V":
										   echo "<td class='cont5'  title='VENCIDO' align=\"center\">$registro[0]</td>";
											break;
										case "G":
										   echo "<td class='cont6'  title='GENERADO' align=\"center\">$registro[0]</td>";
											break;	
									}


                                    echo "<td  class='cont2' align=\"center\" id='v$registro[1]' name='v$registro[1]' onclick=visor(this.id,$registro[1],$registro[14]) ><a>$registro[1]</a></td>";
								//	echo "<td  class='cont2' align=\"center\">$registro[1]</td>";
									echo "<td  class='cont2'align=\"center\">$registro[2]</td>";
									echo "<td class='cont2' align=\"center\">$registro[3]</td>";
									echo "<td class='cont2' align=\"center\">$registro[4]</td>";
									echo "<td class='cont2' align=\"left\">$registro[5]</td>";
									echo "<td class='cont2' align=\"left\">$registro[6]</td>";
									echo "<td class='cont2' align=\"center\">$registro[9]</td>";
									echo "<td class='cont2' align=\"center\">$registro[11]</td>";
									echo "<td class='cont2' align=\"center\">$registro[12]</td>";
									
									echo "<td class='cont2' style=\"text-align: center;\">
												<img src=\"assest/plugins/buttons/icons/page_white_acrobat.png\" 
												onClick=\"documento('".$registro[8]."');\" title=\"click para detalle de 	
												requerimiento\" /> </td>";
								   echo "<td class='cont2' style=\"text-align: center;\">
												<img src=\"assest/plugins/buttons/icons/page_white_acrobat.png\" 
												onClick=\"deta('".$registro[14]."');\" title=\"Click para ver cupon\" /> 
												</td>";		
    							   
									echo "</tr>";
                                    echo "<tr><td colspan='10'><div id='d$registro[1]' name='d$registro[1]' styles='display:none;'/></div><td></tr>";
								
									}
										break;	
									
									}
								
						
						}
	   
	   
	
	  
     
						
			echo "</TABLE>";
						
 }
	


	
	
	

?>


<script>


function pago(id)
    {
		var opciones = "toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,resizable=yes,width=800,height=400" ;

      window.open("printpago.php?id="+id,"nombreventa na", opciones);
	  
    
    }	
	
function documento(doc)
    {
var opciones = "toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,resizable=yes,width=800,height=400" ;		
window.open("\documentos/"+doc,"nombreventa na", opciones);
     

    }	
function deta(co)
    {
var opciones = "toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,resizable=yes,width=800,height=400" ;		

window.open("detallecontrato.php?co="+co,"nombreventa na", opciones);
     

    }		
	
	
</script>

