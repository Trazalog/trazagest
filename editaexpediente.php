<?php
include("conexion.php");
$link= new conexion();
$link->conectarse();

$habilitar = 0;

if(isset($_GET['nroexpe'])) {
    $nroExp=$_GET['nroexpe'];//Cambiar por metodo POST;

    $sql3="SELECT * FROM expedientes where nro_expediente='".$nroExp."'";

    $res=mysql_query($sql3) or die($sql3);
    $expe=mysql_fetch_array($res);
    


    if(mysql_num_rows($res)>0) {
        $habilitar = 1;

    } else {
        echo '<script>alert("No existe el numero de expediente buscado");</script>';
    }
}


function inviertefecha($f) {
    // echo $f;
    $datos = explode("-",$f);//2008-12-02 --> 02-12-2008
    $fecha[]= $datos[0];
    $fecha[] = $datos[1];
    $fecha[] = $datos[2];

    $total=$fecha[2]."-".$fecha[1]."-".$fecha[0];
    return  $total;
}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>Editar Expediente nro: <?php echo ($expe['nro_expediente']); ?></title>
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet">
    <link href="css/estilo.css" rel="stylesheet">

    <!--
    <link type="text/css" rel="stylesheet" href="assets/dhtmlgoodies_calendar/dhtmlgoodies_calendar.css?random=20110101" media="screen"></LINK>
    <SCRIPT type="text/javascript" src="assets/dhtmlgoodies_calendar/dhtmlgoodies_calendar.js?random=20110101"></script>

    <link rel="stylesheet" href="assest\estilo.css" type="text/css"  media="screen"/>
    <link rel="stylesheet" href="assest/screen.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="assest/default.css" type="text/css" media="screen, projection">
    <link rel="stylesheet" href="assest/print.css" type="text/css" media="print">
    <script   type="text/javascript" src="abm_expediente_js.js"></script>

    <!--  estilo calendario y jquery -->
    <!--<link href="calendario_dw/calendario_dw-estilos.css" type="text/css" rel="STYLESHEET" >
    <script type="text/javascript" src="calendario_dw/calendario_dw.js"></script>--->

    <!--<script type="text/javascript">
    $(document).ready(function()
    {
    $(".campofecha").calendarioDW();
    }
              )
    </script> -->
    <!-- -->
</head>

<body>
    <div class="container">
        <br />
        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Edición  de Expediente</h3></div>
            <form name="formexp" id="formexp" action="" method="POST" class="form-horizontal">
                <div class="panel-body">

                   <input type="hidden" name="ope" />

                    <!--<input type="hidden" name="ope" value="Ee"/>-->
                    <input type="hidden" name="tnnnn" value="<?php echo $nroExp;?>" />

                    <?php
                    if($habilitar == 1)
                    	{
                    ?>
                        <div class="form-group">
                            <label for="tnroini" class="control-label col-md-3">Nombre del Iniciador</label>
                            <div class="col-md-6">
                                <input type="text" name="tnroini" id="tnroini" class="form-control"  value="<?php
                                    $sqll = "Select Nombre, Apellido, dni from iniciador Where dni='".$expe['id_iniciador']."'";
                                    $resuu = mysql_query($sqll)or(die(mysql_error()));
                                    $roww = mysql_fetch_array($resuu);
                                    echo $roww['Nombre']." ".$roww['Apellido'];
                                    ?>"  disabled />
                        	</div>
                            <button type="button" class="btn btn-default " title="Editar" data-toggle="modal" data-target="#modaleditar" onclick="seedito()"><span class="glyphicon glyphicon-pencil" style="color:#f39c12" ></span></button>
                           <!-- 
                           class="fa fa-fw fa-pencil"
                           <button class="btn btn-default "  id="editar" title="Editar" data-toggle="modal" data-target="#modaleditar"></button>-->
                        </div>

                       <!-- class="btn btn-default "
                       <span class="glyphicon glyphicon-pencil" style="color:#f39c12" ></span>
                        <div class="form-group">
                            <label for="apellido" class="control-label col-md-3">Apellido</label>
                            <div class="col-md-9">
                                <input type="text" name="apell"  id="apell" class="form-control" value="<?php //echo $roww['Apellido'] ?>" />
                            </div>
                        </div>-->

                        <div class="form-group">

                            <label for="dni" class="control-label col-md-3">Dni</label>
                            <div class="col-md-6">
                                <input type="text" name="dni"  id="dni" class="form-control" value="<?php echo $roww['dni'] ?>" disabled>
                            </div>
                           <!-- <button class="btn btn-default " title="Editar DNI" data-toggle="modal" data-target="#myModal"  ><span class="glyphicon glyphicon-pencil" style="color:#f39c12" ></span></button>-->

                          <!--data-toggle="modal" data-target="#modalOrder"
                          onclick="click_dni()"-->
                          <button type="button" class="btn btn-default " title="Editar DNI"  data-toggle="modal" data-target="#exampleModalLong" onclick="click_dni()"><span class="glyphicon glyphicon-pencil" style="color:#f39c12" ></span>
                          </button>


                        </div>
                       <!-- <div class="col-xs-2">
                <button type="button" class="btn btn-success" id="addempresa"  data-toggle="modal" data-target="#modalOrder"><i class="fa fa-plus"> Agregar</i></button>
              </div>-->
                       
                        


                        <div class="form-group">
                            <label for="nrofolio" class="control-label col-md-3">Número de Folio</label>
                            <div class="col-md-9">
                                <input type="text" name="nrofolio" id="nrofolio" class="form-control" value="<?php echo $expe['n_folio'] ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tfecha" class="control-label col-md-3">Fecha</label>
                            <div class="col-md-3">
                                <input type="date" name="tfecha" id="tfecha" class="form-control input-md" value="<?php echo ($expe['fecha']); ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tfechain" class="control-label col-md-3">Fecha Entrada</label>
                            <div class="col-md-3">
                                <input type="date" name="tfechain" id="tfechain" class="campofecha form-control" value="<?php echo ($expe['fecha_entrada']); ?>" >
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="cart_exp" class="control-label col-md-3">Contenido</label>
                            <div class="col-md-9">
                                <textarea name="cart_exp" id="cart_exp" rows="6" class="form-control"><?php echo $expe['caratula'];?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="testract" class="control-label col-md-3">Extracto</label>
                            <div class="col-md-9">
                                <textarea name="testract" id="testract" rows="6" class="form-control"><?php echo $expe['extraxto'];?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="tpo_exp" class="control-label col-md-3">Tipo de Expediente</label>
                            <div class="col-md-3">
                                <select name="tpo_exp" id="tpo_exp" class="form-control" >
                                    <?php $cons = "SELECT *FROM tipo_expedientes";
                                    $result = mysql_query($cons) or die("falla la consulta");

                                    while($option = mysql_fetch_row($result)) {
                                        if($expe['id_tipo']==$option[0]) {
                                            echo" <option value=\" ". $option[0]."\" selected='selected' >".$option[1 ]." </option>";
                                        }
                                        else {
                                            echo" <option value=\" ". $option[0]."\"  >".$option[1]." </option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="lt_exp" class="control-label col-md-3">Letras</label>
                            <div class="col-md-3">
                                <?php echo"<input type=\"text\" name=\"lt_exp\" class=\"form-control\" value=\"  ".$expe['letras']." \"  /> ";	?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="obs_exp" class="control-label col-md-3">Observaciones</label>
                            <div class="col-md-9">
                                <textarea name="obs_exp" id="obs_exp" rows="6" class="form-control"><?php echo($expe['observaciones']);?></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="dt_exp" class="control-label col-md-3">Datos</label>
                            <div class="col-md-9">
                                <textarea name="dt_exp" id="dt_exp" rows="6" class="form-control"><?php echo($expe['datos']);?></textarea>
                            </div>
                        </div>

            		<?php
            		}
            		?>

                </div>
                <div class="panel-footer">
                	<center>
                        <!--<button type="button" class="btn btn-primary" onclick="document.formexp.action='principal.php'; document.formexp.submit();"><span class='glyphicon glyphicon-home'></span> Principal</button>-->
                        <button type="button" name="princ" id="princ" onclick="window.open('','_self').close();" class="btn btn-primary">Cerrar</button>
                        <button type="button" name="nuevoexp" onclick="editarExpediente();" class="btn btn-primary">Guardar</button>
                    </center>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="abm_expediente_js.js"></script>

<script>
/*$(document).ready(function(){
 /* function editarExpediente(ope) /* esto esta comenatdo ,no se por que */
   /* {
        var opciones = "width=800,height=350,scrollbars=NO";
        window.open("abm_expediente_libreria.php?operacion="+ope,"nombreventa na", opciones);
    }*/
 

   /*$("edi").click(function(){
       $("#dni").removeAttr("disabled");
   });*/

//});
    function editadni(id)
    {
    	var opciones = "width=800,height=350,scrollbars=NO";
        window.open("editaabminiciador.php?iniciador="+id,"nombreventa na", opciones);
    }

    function editaini(id,nro)
    {
		var opciones = "width=800,height=350,scrollbars=NO";
        window.open("editainiciador.php?dni="+id+"&nro="+nro,"nombreventa na", opciones);
    }

	function buscarExped(valor)
    {
		if(valor!="")
        {
			location.href="editaexpediente.php?nroexpe="+valor;
		}
		else
		{
            alert("Ingrese un numero de expediente para poder realizar la busqueda.");
		}
	}

/*$("#edi").click(function(){
         $("#dni").attr("disable",true);
     });*/
    /*function (){

       //$('#dni').removeAttr("disabled");
       $('#dni').click(){
        attr("disabled","");
    //formexp.dni.disabled = false;

//document.getElementById("dni").disabled=false;

        /*var dni=$('#dni').val();
        console.log(dni);*/

 function seedito() { 
     
    var dn = $('#dni').val();
    console.log(dn);       
    $.ajax({
        type: 'POST',
        data: {dn:dn},
        url: 'geteditar.php', //index.php/
        success: function(data){

                console.log("Estoy editando");
                console.log(data);
                console.log(data['Nombre']);
                datos={
                    'dni':dni,
                    'dni':data['Dni'], //codigo id_equipo
                    'Nombre':data['Nombre'],
                    'Apellido':data['Apellido'],
                    'Direccion':data['Direccion'],
                    'telefono':data['telefono'],
                    
                }
                    
                completarEdit(datos);
                       
        },
    
        error: function(result){
                console.log("Entre por el error");
                console.log(result);
            },
        dataType: 'json'
    });
}

function completarEdit(datos ,edit){
    
    console.log("datos que llegaron");
    $('#nombre').val(datos['Nombre']);
    $('#dnn').val(datos['dni']);
    $('#apellido').val(datos['Apellido']);
    $('#dire').val(datos['Direccion']);
    $('#tel').val(datos['telefono']);
}


function guardareditar(){ 

  var nom= $('#nombre').val(); 
  var apell= $('#apellido').val();
  var dire = $('#dire').val();
  var tel = $('#tel').val();
  var dni= $('#dnn').val();
  var dni2= $('#dni').val();
    var parametros = {
        'Dni': dni,
      'Nombre': nom,
      'Apellido': apell,
      'Direccion': dire,
      'telefono': tel,
      

  }; 

console.log("parametros");                         
console.log(nom); 
console.log(apell); 
console.log(dire); 
console.log(tel); 
console.log(dni); 
console.log(dni2); 

   $.ajax({
      type:"POST",
      url: "modificar_iniciador.php", //controlador /metodo
      data:{nom:nom,apell:apell, dire:dire, tel:tel, dni:dni},
      success: function(data){
        console.log("exito");
        var datos= parseInt(data);
        console.log(datos);
          
          if(data > 0) //Agrego la descripcion dinamicamte en el select con id componente
          {  
            var texto = '<option value="'+data+'">'+ parametros.Nombre +'</option>';
            console.log(texto);
            $('#tnroini').append(texto);
          }
          refresca();
          



        },
      
      error: function(result){
          console.log("entro por el error");
          console.log(result);
      },
       dataType: 'json'
    });

  
}

//traer_dni();
    function traer_dni(){

     
      var dni2= $('#dni').val();    
      $.ajax({
        type: 'POST',
        data: { },
        url: 'getdni.php', //index.php/
        success: function(data){
               
               var opcion  = "<option value='"+dni2+"'></option>" ; 

               console.log("Estoy mostrando el segundo dni");
               // datos= parseInt(data);
                 //console.log(datos);
                //var opcion  = "<option value='-1'>Seleccione...</option>" ; 
                $('#dnn2').append(opcion); 
                for(var i=0; i < data.length ; i++) 
                {    
                      var nombre = data[i]['dni'];
                      var opcion  = "<option value='"+data[i]['dni']+"'>" +nombre+ "</option>" ; 

                      $('#dnn2').append(opcion); 
                                   
                }

              },
        error: function(result){
              
              console.log(result);
            },
           //dataType: 'json'
        });
  }
var globdni="";
function click_dni(){ 
  var dn = $('#dni').val();
    //traer_dni();
    $('#dn1').val(dn);
    globdni=dn;
     
    console.log("dni para editarlo"); 
    console.log(dn); 
    console.log("variable global"); 
    console.log(globdni); 
    /*$.ajax({
        type: 'POST',
        data: {dn:dn},
        url: 'geteditar.php', //index.php/
        success: function(data){

                console.log("Estoy editando");
                console.log(data);
                console.log(data['Nombre']);
                datos={
                    'dni':dni,
                    'dni':data['dni'], //codigo id_equipo
                    
                    
                };
                completadni(datos);
                    
                       
        },
    
        error: function(result){
                console.log("Entre por el error");
                console.log(result);
            },
        dataType: 'json'
    });*/


  }

 /* function completadni(datos){
    $('#dnn2').val(datos['dni']);
    traer_dni(); 

  }*/



 function guardardni(){ 

  var dnn2= $('#dnn2').val();
  var dn= $('#dni').val();
  var tnroini= $('#tnroini').val();
  
    var parametros = {
        'dni': dnn2,
        'Nombre': tnroini,

    }; 

console.log("parametros");                         
console.log(parametros); 
console.log(dnn2); 

 if(dnn2 >0) {
       $.ajax({
          type:"POST",
          url: "modificar_dni.php", //controlador /metodo
          data:{dnn2:dnn2, dn:dn},
          success: function(data){
            console.log("exito");
            
            console.log(data);
            //console.log(data['nombre']);
            //console.log(data.nombre);
             console.log(data[0]);
             console.log(data[1]);

             
            /* $consulta3= "SELECT Nombre, Apellido
                        From iniciador
                        WHERE dni=$dn";

            $result = mysql_query($consulta3) or die(mysql_error());
            while($option = mysql_fetch_row($result)) {
                         $texto1 = " <option value=\" ". $option[0]."\" >".$option[0]."  </option>";
                                        }*/
            
              
              if(data > 0) //Agrego la descripcion dinamicamte en el select con id componente
              {  
                var texto = '<option value="'+data+'">'+ $option[0]+'.,.'+$option[1] +'</option>';
                console.log($texto1);
                $('#tnroini').append($texto1);
                var texto = '<option value="'+data+'">'+ parametros.dni  +'</option>';
                console.log(texto);
                $('#dni').append(texto);
              }

              refresca();

        
            },
          
          error: function(result){
              console.log("entro por el error");
              console.log(result);
          },
          dataType: 'json'
        });
    }
    else {
        alert("POR FAVOR SELECCIONE UN DNI");
        }
}

function refresca(){

//window.location.href='listado_expediente.php';
location.reload(true);

}

  
</script>
<!-- Modal editar-->
 <div class="modal fade" id="modaleditar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 60%">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="glyphicon glyphicon-pencil" style="color: #f39c12" > </span>  Editar Iniciador</h4>
       </div> <!-- /.modal-header  -->

      <div class="modal-body input-group ui-widget" id="modalBodyArticle">
        
        <div class="row" >
        <div class="col-sm-12 col-md-12">
        
        <div class="col-xs-8">Nombre:
          <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Ingrese Descripcion de desposito">
        </div>
        <br>
        <div class="col-xs-8">Apellido:
        <input type="text" id="apellido" name="apellido" class="form-control" placeholder="Ingrese Direccion" >                               
        </div>
        <div class="col-xs-8">Dni:
        <input type="text" id="dnn" name="dnn" class="form-control" disabled="">
         </div>                             
        
         <div class="col-xs-8">Direccion:
        <input type="text" id="dire" name="dire" class="form-control" placeholder="Ingrese Direccion" >
        </div>
         <div class="col-xs-8">Telefono:
        <input type="text" id="tel" name="tel" class="form-control" placeholder="Ingrese Direccion" >
        </div>
       

      </div>
      </div>
     
      
     

      <div class="modal-footer">
       
        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" ata-dismiss="modal" onclick="guardareditar()" >Guardar</button>
      </div>  <!-- /.modal footer -->

       </div>  <!-- /.modal-body -->
    </div> <!-- /.modal-content -->

  </div>  <!-- /.modal-dialog modal-lg -->
</div>  <!-- /.modal fade -->
<!-- / Modal -->

<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle" > 
        <span id="modalAction" class="glyphicon glyphicon-pencil" style="color: #f39c12" > </span>  Editar Dni</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row" >
            <div class="col-sm-12 col-md-12">
                <div class="col-xs-8">Dni:
                    <input topmargin="0" leftmargin="0" bottommargin="0" rightmargin="0" type="text" readonly="true" name="dn1" id="dn1">
                    <select id="dnn2" name="dnn2" class="form-control" >
                        <option value="0" division="" selected><?php echo "Seleccione Dni a cambiar...";?></option>";
                        <?php
                            $cons = " SELECT *FROM iniciador  ";
                            $result = mysql_query($cons) or die(mysql_error());
                                            //echo $result;
                            while($option = mysql_fetch_row($result)) {
                                echo" <option value=\" ". $option[0]."\" >".$option[0]."  </option>";
                                            }
                        ?>
                    </select>                      
                </div> 
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="guardardni()">Guardar </button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Dni1-->
 <!--<div class="modal fade" id="modaldni" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document" style="width: 60%">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"  id="myModalLabel"><span id="modalAction" class="glyphicon glyphicon-pencil" style="color: #f39c12" > </span>  Editar Dni</h4>
       </div> --><!-- /.modal-header  -->

      <!--<div class="modal-body input-group ui-widget" id="modalBodyArticle">
        
        <div class="row" >
        <div class="col-sm-12 col-md-12">
        
        <div class="col-xs-8">Dni:
        <select id="dnn2" name="dnn2" class="form-control" >
        </select>
         </div> 
   
      </div>
      </div>
     
      
     

      <div class="modal-footer">
       
        <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal" ata-dismiss="modal" onclick="guardared()" >Guardar</button>
      </div>-->  <!-- /.modal footer -->

      <!-- </div>-->  <!-- /.modal-body -->
   <!-- </div>--> <!-- /.modal-content -->

 <!-- </div>-->  <!-- /.modal-dialog modal-lg -->
<!--</div>-->  <!-- /.modal fade -->
<!-- / Modal -->

<!-- Modal DNI-->
<!--<div id="modaldni" class="modal fade" role="dialog">
  <div class="modal-dialog">-->

    <!-- Modal content-->
   <!-- <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Alta de Estanteria</h4>
      </div>
      <div class="modal-body">
        <div class="row" >
                        <div class="col-sm-12 col-md-12">
                          <div role="tabpanel" class="tab-pane">
                            <div class="form-group">
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h4 class="panel-title ">   Datos de estanteria</h4>
                                  </div>
     
                                  <div class="panel-body">

                                    <div class="col-xs-6">Descripcion:
                                       <input name="estanteriae" type="text" id="estanteriae"  class="form-control">
                                    </div>

                                    
                                  </div>
                               </div>
                              </div>
                            </div>
                          </div>
                          </div>
                          <div>
                          
                             
                            
     
      <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cerro()">Cancelar</button>
        <button type="button" class="btn btn-primary" id="reset" data-dismiss="modal" onclick="guardardni()">Guardar</button>
    </div>
    </div>

     </div>
       
      </div>
       
      </div>


  </div>
</div>-->





