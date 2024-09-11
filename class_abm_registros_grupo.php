<?php  
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

echo '<input type="hidden" name="tablaNom" value="'.$tabla.'">';
echo '<input type="hidden" name="Pk" value="'.$idRegistro.'">';
echo '<input type="hidden" name="accion" value="'.$accion.'">';

$permisos = "";
$descrip  = "";

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
	 
	 $permisos = $fila['permisos'];
	 $descrip  =  $fila['descripcion'];
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
	 
	 //encabezado tabla
	 echo '<center>';
	 echo '<br><h3>'.htmlentities($row['Titulo']).'</h3><br/>';
	 
	 //-----------------------------

	$consulta = "select * from tbl_menu where imagen != ''";
	$resu = mysql_query($consulta);

	$array = explode('-',$permisos);
	
	echo '<label>Nombre Grupo: </label>';
	echo '<input type="text" name="descripcion" value="'.$descrip.'" placeholder="Descripción"><br><br>';
		
     echo '<div style=" overflow-y: scroll; text-align: left;background-color: #bababa; width:350px;height:300px;">';
	
	while($row = mysql_fetch_array($resu))
	  {
		  $Actual = false;
		  foreach ($array as &$value) 
				{
					if($value == $row['id_menu'])
					{
						$Actual = true;
						break;
					}
				}
		  if($Actual == false)
		  {
			  echo '<input type="checkbox" name="'.$row['id_menu'].'" onClick="seleccionar('.$row['id_menu'].')" style="margin-left:120px;">';
			  echo "<label>".htmlentities($row['descripcion'])."</label><br>";
			  echo '<div id="'.$row['id_menu'].'div" style="display:none;">';
		  }
		  else
		  {
			  echo '<input type="checkbox" name="'.$row['id_menu'].'" onClick="seleccionar('.$row['id_menu'].')" checked="checked" style="margin-left:120px;">';
			  echo "<label>".htmlentities($row['descripcion'])."</label><br>";
			  echo '<div id="'.$row['id_menu'].'div" style="display:block;">';
		  }

			   $item = $row['ubicacion'].'/';
			   $consulta2 = "select * from tbl_menu where ubicacion like '$item%' Order By ubicacion";
			   $resul = mysql_query($consulta2);
			   
			   while($row2 = mysql_fetch_array($resul))
				{
				  echo "&nbsp;&nbsp;&nbsp;&nbsp;";
				  $ActualHijo = false;
				  foreach ($array as &$value) 
					{
						if($value == $row['id_menu'])
						{
							$ActualHijo = true;
							break;
						}
					}
					
				  if($ActualHijo == false)
				  	{
					    echo '<input type="checkbox" name="'.$row2['id_menu'].'" style="margin-left:150px;">';	
					}
					else
					{
					    echo '<input type="checkbox" name="'.$row2['id_menu'].'" style="margin-left:150px;" checked="checked">';	
					}
				  echo htmlentities($row2['descripcion'])."<br>";
				}
			  ?>
	   </div>
	  <?php
	  }
	 //-----------------------------
	 
	 echo '</div>';
	
	echo '<br><br>';
	echo " <p> <input type=\"button\" value=\"Aceptar\" class=\"button\" onClick=\"Aceptar('$accion')\"> &nbsp;&nbsp;&nbsp;";
	echo '<input type="button" value="Cancelar" class="button" onClick="Cerrar()"> </p>';
	echo '<input type="hidden" name="indicesMenu" value="">';
	echo '</center>';
	 }


?>