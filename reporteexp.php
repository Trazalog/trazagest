<?php
//session_start();
//var_dump($_SESSION);
include("conexion.php");
$var = new conexion();
$var->conectarse();
$conec = $var->conectarse();

if(isset($_GET["nroexpe"])) {
    $id=$_GET["nroexpe"];
    $sql="SELECT
            O.id_expediente,
            O.nro_expediente,
            O.caratula,
            O.fecha,
            O.id_iniciador,
            C.nombre
        FROM expedientes O
        join iniciador C on C.dni=O.id_iniciador
        Where O.nro_expediente = $id";

    //and  id_estado != ".$id_ingresado."
    $res=mysql_query($sql)or die($sql);
    $req=mysql_fetch_array($res);
    $ide=$req[1];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Reporte</title>
    <link rel="shortcut icon" type="image/x-icon" href="assest/plugins/buttons/icons/folder.png" />
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet" />
    <link href="css/estilo.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="jQuery/jquery.autocomplete.css" rel="stylesheet" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>


</head>

<body >
<div class="container">
  <div class="row">
    <div class="col-sm-12 col-md-12">
      <br />
        <div class="panel panel-default">
        <br>
          <div ><br><h4 class="panel-title"> <center>  Reporte Expediente</center></h4></div>
          <br>
            <form name="formexp" id="formexp" action="" method="post" class="form-horizontal" role="form">

            <div class="row">
              <div class="col-sm-12 col-md-12">
              <div class="panel panel-default">
                <div class="panel-heading"><h2 class="panel-title">Datos para filtrar Expediente por:</h2></div>

                  <div class="panel-body">
              

              
                <br>

                  <div class="col-xs-4">
                    <input type="checkbox" name="cfil[]" id="cfil[]" value="1"  onclick="checket(this,nroexped);" />
                    Nro Expediente: 
                    <br>
                    <!--<input type="text" name="nroexped" id="nroexped"   class="form-control" size="35" > -->

                    <select name='nroexped'  id='nroexped' class="form-control" >
                    <option value="0" division=""  selected></option>
                    <?php
                      $consulta2="SELECT * FROM expedientes";
                      $result2=mysql_query($consulta2,$var->links);
                      while($row2=mysql_fetch_array($result2))
                       {
                           echo "<option value='".$row2['nro_expediente']."'>".$row2['nro_expediente']."</option>";
                       
                      }
                                          
                       ?>
               
                      </select>
                  </div>
                
                   <div class="col-xs-10">

                   </div>

                  <br>
                  <div class="col-xs-4">
                    <input type="checkbox" name="cfil[]2" id="cfil[]" value="2" size="35" onclick="checket(this,estado);"/>
                    Estado:
                    <br>
                     
                    <select name='estado'  id='estado' class="form-control" >
                    <option value="0" division="" selected></option>
                    <?php
                      $consulta2="SELECT * FROM estados";
                      $result2=mysql_query($consulta2,$var->links);
                      while($row2=mysql_fetch_array($result2))
                       {
                           echo "<option value='".$row2['id_estado']."'>".$row2['descripcion']."</option>";
                       
                      }
                                          
                       ?>
               
                      </select>
                    </div>
                    <br>

                      
                    <div class="col-xs-10">
                    </div>
                    <br>

                    <div class="col-xs-4">
                          
                      <input type="checkbox" name="cfil[]2" id="cfil[]" value="4" size="35" /> 
                        Rango de Fecha:
                    </div>
                    
                    <div class="col-xs-4"> Desde:   
                                  
                      <input type="date" name="fechaIni" id="fechaIni" class="form-control" value="<?php echo date("d-m-Y");?>">
                  
                    </div> 

                    <br>
                    <br>       
                    <div class="col-xs-4"> Hasta:
                    <br>
                      <input type="date" name="fechaHas" class="form-control fecha" id="fechaHas">
                                  
                    </div> 
                   
                              
                           
                    <div class="col-xs-10">    
                    </div>
                    <div class="col-xs-10">  
               
                    
                    </div>
              

            </div><!-- Fin .panel-body -->
            </div>
            </div>
            </div>
            <center>

                      <button type="button"  class="btn btn-primary btn-large glyphicon glyphicon-search" onclick="validaop()"  title="click para Vista Previa de Filtro "></button>
                      <button type="button"   class="btn btn-primary btn-large  glyphicon glyphicon-cloud-download" onclick="validaopexcel()"  title="click para exportar a excel "></button>
                          
                      </center>


            <br>
            <div class="panel-footer">
                <center>
                    <button type="button" name="prin" class="btn btn-primary" onclick="principal()"><span class='glyphicon glyphicon-home'></span> Principal</button>
                    <button type="button" name="archiv" onclick="validaAsignacion()" class="btn btn-primary">Guardar</button>
                </center>
            </div><!-- Fin .panel-footer -->

        </form>

    </div><!-- Fin .panel -->
    </div>
    </div>
</div><!-- Fin .container -->
</body>

<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type="text/javascript" src="Js/ajax.js"></script>
<script type="text/javascript" src="jQuery/jquery-ui-1.8.10.custom.min.js"></script>
<script type="text/javascript" src="paginas/generarStock/js/funcion.js"></script>
<script type="text/javascript" src="jQuery/jquery.autocomplete.js"></script>

<script>
     
  $("#fechaIni").datepicker({
    dateFormat: 'dd/mm/yy',
    firstDay: 1
  }).datepicker("setDate", new Date());
   


$("#fechaHas").datepicker({
    dateFormat: 'dd/mm/yy',
    firstDay: 1
  }).datepicker("setDate", new Date());

function principal(){
     document.formexp.action = "principal.php";
     document.formexp.submit();
    }

function validaop()//Listo
{        
   
        document.formexp.action="reporteexp_tod_php.php";    
        document.formexp.submit();
   
    
}

/*function validaop(){
<?PHP
   //if($_POST['H'] == 'HOM'){
     //   echo "HAS SELECCIONADO HOMBRE";
  //}
  //IF($_POST['M'] == 'MUJ'){
    //ECHO "HAS SELECCIONADO MUJER";
  //}
  ?>
}*/
function validaopexcel(){        
   
        document.formexp.action="reporteexp_tod_php_excel.php";  
        document.formexp.submit();
        }
  
</script>

</html>

