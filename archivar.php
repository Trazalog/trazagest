<?php
//session_start();
//var_dump($_SESSION);
include("conexion.php");
$var   = new conexion();
$var->conectarse();
$conec = $var->conectarse();

if(isset($_GET["nroexpe"])) {
    $id  = $_GET["nroexpe"];
    $sql ="SELECT
            O.id_expediente,
            O.nro_expediente,
            O.caratula,
            O.fecha,
            O.id_iniciador,
            C.nombre, C.apellido
        FROM expedientes O
        join iniciador C on C.dni=O.id_iniciador
        Where O.nro_expediente = $id";

    //and  id_estado != ".$id_ingresado."
    $res = mysql_query($sql)or die($sql);
    $req = mysql_fetch_array($res);
    $ide = $req[1];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Modificar Cédula</title>
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <link href="plugin/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <link href="css/estilo.css" rel="stylesheet" />
    <link href="summernote.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="jQuery/jquery.autocomplete.css" rel="stylesheet" />
    <link rel="stylesheet" href="plugin/bootstrapvalidator/bootstrapValidator.min.css">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>

<body >
<div class="container">
    <br />
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Archivar Expediente</h3></div>
        <form name="listado" id="listado" action="alta_archivar.php" method="post" class="form-horizontal" role="form">
            <div class="panel-body">

                <h5>Datos del Expediente</h5>
                <hr>

                <div class="form-group">
                    <label for="nroexp" class="col-sm-3 control-label">Nro</label>
                    <div class="col-sm-4">
                        <input name="expediente" type="text" id="expediente" value='<?php if(isset($req)) echo $req[1];?>' class="form-control" disabled="true"/>
                        <input name="idexp" type="hidden" id="idexp" value='<?php if(isset($req)) echo"  ".$req[0];?>' />
                    </div>
                </div>

                <div class="form-group">
                    <label for="iniciador" class="col-sm-3 control-label">Iniciador</label>
                    <div class="col-sm-4">
                        <input name="iniciador" type="text" id="iniciador" value='<?php if(isset($req)) echo $req[5]." ".$req[6];?>' class="select form-control" value='<?php echo $iniciador;?>' disabled="true" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_serv" class="col-sm-3 control-label">Fecha</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha" id="fecha" class="select form-control campofecha" value="<?php if(isset($req)) echo $req[3];?>" disabled="true" />
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-3 control-label">Carátula</label>
                    <div class="col-sm-9">
                        <textarea name="cart_exp" rows="6" id="observa" class="form-control" value='<?php if(isset($req)) echo $req[2];?>' disabled="true"><?php if(isset($req)) echo $req["caratula"];?></textarea>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <label for="fecha" class="col-sm-3 control-label">Fecha</label>
                    <div class="col-sm-4">
                        <input type="date" name="fecha" id="fecha" class="select form-control campofecha" value="" />
                    </div>
                </div>

                <div class="form-group">
                    <label for="fecha_serv" class="col-sm-3 control-label">Caja</label>
                    <div class="col-sm-4">
                        <select class='form-control' name='cajas' id='cajas' onchange='traer_datos()'>
                            <option value="1.1" division="" selected>Seleccione Caja</option>
                            <?php
                            $consulta2 = "SELECT * FROM cajas ORDER BY codigo";
                            $result2   = mysql_query($consulta2,$var->links);
                            while($row2=mysql_fetch_array($result2)) {
                                echo "<option value='".$row2['id_cajas']."' title='".$row2['descrip']."'>".$row2['codigo']."</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                       <button type="button" class="btn btn-default"  data-toggle="modal" data-target="#modalcaja">
                        <span class="glyphicon glyphicon-plus"> Nuevo</span>
                        </button>
                        <!--<button type="button" class="btn btn-default" onClick="abmcajas()" data-toggle="modal" data-target="#modalcaja">
                        <span class="glyphicon glyphicon-plus">Nuevo</span>
                        </button> -->

                    </div>
                </div>


                <div class="form-group">
                    <label for="fecha" class="col-sm-3 control-label">Datos de Caja:</label>
                    <div class="col-sm-9">
                    </div>
                    </div>
                        <div id='tabladatos' align="center">
                            <table width="100%" align="center" id='tabladatos' name='tabladatos' class="table table-active" >
                                <tbody>
                                    <tr class="active">
                                        <th>Descripcion</th>
                                        <th>Codigo</th>
                                        <th>Estanteria</th>
                                        <th>Fila</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                

                <div class="form-group">
                    <center>
                        <!--<a data-toggle="modal" class="btn btn-default btn-lg active" href="##myModal" role="button" onclick="contenido()" >Contenido</a>-->
                        <!-- <a data-toggle="modal" href="#myModal"  class="btn btn-default btn-lg active" role="button" >Contenido</a>
                        <input type="button" value="Contenido" class="button" onclick="contenido()" /> -->

                        <!-- <input data-toggle = "modal" data-target = "#myModal" class="btn btn-default btn-lg" type="button" value="Contenido"  onclick="contenido()" > este fue el ultimo-->

                    <button type="button" class="btn btn-primary btn-large" data-toggle = "modal" data-target = "#modal1"  > Contenido
                        </button> 

                      <!--  <button type="button" class="btn btn-primary btn-large" onclick="contenido()">Contenido</button>-->

                       <!-- <a  class="btn btn-primary btn-large" onclick="contenido()" role="button" style="cursor:pointer" href="#">Contenido</a>-->
                        <!-- <a class="btn" data-toggle="modal" href="#myModal" >Run!!!</a>-->
                        <!--data-toggle="modal" href="#"-->

                         <!--   <button type="button" class="btn btn-default btn-lg" onClick="contenido()" value="Contenido" >-->
                        
                          </button>
                    </center>
                </div>

            </div><!-- Fin .panel-body -->
            <div class="panel-footer">
                <center>
                    <button type="button" name="prin" class="btn btn-primary" onclick="principal()"><span class='glyphicon glyphicon-home'></span> Principal</button>
                    <button type="subbmit" name="archiv"  class="btn btn-primary">Guardar</button>
                </center>
            </div><!-- Fin .panel-footer -->

        </form>

    </div><!-- Fin .panel -->
</div><!-- Fin .container -->
</body>

<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="plugin/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="plugin/bootstrapvalidator/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="Js/ajax.js"></script>
<script type="text/javascript" src="jQuery/jquery-ui-1.8.10.custom.min.js"></script>
<script type="text/javascript" src="paginas/generarStock/js/funcion.js"></script>
<script type="text/javascript" src="jQuery/jquery.autocomplete.js"></script>

<script>
    $('#listado')
    .bootstrapValidator({
        framework: 'bootstrap',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh',
        },
        fields: {
            fecha: {
                validators: {
                    notEmpty: {
                        message: 'Ingrese la fecha.'
                    }
                }
            },
            cajas: {
                validators: {
                    integer: {
                        message: 'Debe ingresar una caja.'
                    }
                }
            },
        },
    }).on('success.form.bv', function(e) {
        e.preventDefault();
        console.log('Form successfully validated.');
        document.listado.submit();
    });





    function principal()
	{
		location.href="./principal.php";
	}

    function contenido()
    {
		var opciones = "toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,resizable=yes,width=350,height=400" ;
		var idcaja = $('#cajas').val(); //aca traido el el valor del select, lo que he seleccionado
        window.open("mostrar_contenido.php?idcaja="+idcaja,"nombreventa na", opciones);
    }

    /*function abmcajas(expe)
    {
		var opciones = "toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,resizable=yes,width=350,height=400" ;

        window.open("alta_cajas.php?idexp="+id ,"nombreventa na", opciones);
    }*/

    function abmcajas(expe)
    {
        var opciones = "toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,resizable=yes,width=350,height=400" ;
        window.open("alta_cajas.php","nombreventa na", opciones);
    
    }

    function validaAsignacion()
	{
	    /*if(document.altaped.fecha1.value ==0)
	 	{
			alert("no seleccino  Fecha");
			document.altaped.fecha1.focus();
			return false;
		}
    	if(document.altaped.txtHora.value ==0)
	 	{
			alert("no seleccino  Hora");
			return false;
		}	*/

		document.listado.submit();
	}

    function traer_datosExp(exp)
    {
        jQuery.post('ajax_get_datosexp.php',{exp:exp},function(datos)
        {
            //alert(datos);
            var arre = new Array();
            arre = datos.split("**;");

            if( arre[4]=='A')
            {
                alert('El expediente ya se encuentra en estado Archivado');
                $('#expediente').val("");
            }
            else
            {
                $('#iniciador').val(arre[0]);
                $('#fecha').val(arre[1]);
                $('#observa').val(arre[2]);
                $('#idexp').val(arre[3]);
            }
        });
    }

    function llenartabla(cadena)
    {
        var tablasize = $('#tabladatos tbody tr').length;
        for(var i=0; i < (tablasize-1); i++)  // -1 para no borrar la cabecera
        {
            $('#tabladatos tbody tr:last').remove();
        }

        var arre = new Array();
        arre = cadena.split(";");
        //console.log(arre);
        for(var i=0; i < (arre.length-1); i++)
        { //console.log(arre[i]);
            var arre2 = new Array();
            arre2 = arre[i].split(",");

            var tr = "<tr> <td>"+arre2[0]+"</td>  <td>"+arre2[1]+"</td>  <td>"+arre2[2]+"</td> <td>"+arre2[3]+"</td> </tr>";

            jQuery('#tabladatos tbody tr:last').after(tr);
        }
        jQuery('#estado').val(arre[0]);
    }

    function traer_datos()
    {
        var caja = jQuery('#cajas').val();

        jQuery.post('ajax_get_archivar.php',{idcajas:caja},llenartabla);
    }

    $(document).ready(function()
    {

        $.noConflict();

        $('#expediente').keypress(function(e) {
        //e.preventDefault();

        if(e.which == 13)
        {
            var newn = $('#expediente').val();
            if(newn != '')
            {   alert(newn);
                traer_datosExp(newn);
            }
            else alert('ingrese expediente');
            }
        });
    });

 /*
function contenido()
{ 

      // $('#modalSale').modal('show');
        var idcajas = $('#cajas').val(); //aca traido el el valor del select, lo que he seleccionado
        console.log("estoy mostrando el expediente que esta en esta caja");
        console.log(idcajas);
        $.ajax({
            type: "POST",
            url: "ajax_get_arch.php",
            data: {idcajas:idcajas},
            success: function(data){
                    console.log("entre por el exito contenido");
                    console.log(data);

                    
                   for(var i=0; i < data.length ; i++){
                    
                      var   table= "<tr id='"+i+"'>"+   
                                    "<td ></td>"+
                                   "<td>"+data[i]['nro_expediente']+"</td>"+
                                   "<td>"+data[i]['caratula']+"</td>"+
                                   
                                 "</tr>";
                        $('#tabladatos2').append(table); 
                      
                                }

                  },
             
          
        error: function(respuesta){
              console.log("entre por el error contenido");
              console.log(respuesta);
            
            }

    //dataType: 'json'
        });        

}
*/
    

function guardar(){ 

    var parametros = {
        'descripcion': $('#cajas').val(),
        'codigo': $('#codigo').val(),
        'id_estanteria': $('#estanteria').val(),
        'fila': $('#fila').val(),
        
    };
    console.log(parametros);
    $.ajax({
      type: 'POST',
      data: {data:parametros},
      url: 'alta_cajas_php.php',  //index.php/
      success: function(data){
              console.log("exito");
              console.log(data);
               
              if(data > 0)
               {  
                var texto = '<option value="'+data+'">'+ parametros.descripcion +'</option>';

                $('#cajas').append(texto);
                
              }
              
            },
      error: function(result){
            console.log("entro por el error");
            console.log(result);

            
          },
        // dataType: 'json'
    });

}

function guardarcaja(){

    console.log(" alta de caja guardada");
    var parametros = {
      'descripcion': $('#cajasc').val(),
      'codigo': $('#codigoc').val(),
      'id_estanteria': $('#estanteriac').val(),
      'fila': $('#filac').val(),
      'estado': 'C',

        };
    console.log(parametros);
    $.ajax({
      type:"POST",
      url: "alta_cajas_php.php", //controlador /metodo
      data:{parametros:parametros},
      success: function(data){
        console.log("guarde con exito");

          console.log(data);

          var datos= parseInt(data);
        console.log(datos);
          //alert(data);
          if(data > 0) //Agrego la descripcion dinamicamte en el select con id componente
          {  
            
              var texto = '<option value="'+data+'">'+ parametros.codigo +'</option>';
              console.log(texto);

              $('#cajas').append(texto);
          }
         
          },
          
          error: function(result){  

          console.log(result);
          },
           dataType: 'json'
    });

}

function llenartabla2(cadena){ console.log(cadena);
        var arre = new Array();
        arre = cadena.split(";;");
        
        console.log(arre.length);
        
        jQuery('#tabladatos2 tbody tr').remove();
        
        for(var i=0; i < (arre.length-1); i++)
        {  
            var arre2 = new Array();
            arre2 = arre[i].split(",,");
            console.log('entra');
            
            var tr = "<tr> <td>"+arre2[0]+"</td>  <td>"+arre2[1]+"</td> </tr>";
            
            $('#tabladatos2').append(tr);
        }
}

function traer_datos2(){ //alert('cambia');


    var caja= jQuery('#cajas').val();
    
    jQuery.post('ajax_get_arch.php',{caja:caja},llenartabla2);
}

</script>

</html>

<!-- Modal -->
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Contenido de Caja</h4>
      </div>
      <div class="modal-body">
      
      <table align="center" id='tabladatos2' name='tabladatos2' class="table table-active">
            <thead>
             <tr class="active">
                  <!-- <td> Expediente: </td> <td> Caratula: </td>-->
                  <th></th>
                 <th> Expediente:</th>
                  <th> Caratula:</th>
                  
                 </tr>
                 </thead>
                 <tbody> 
            </tbody>
    </table>
   

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal NUEVA CAJ-->
<div id="modalcaja" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Alta de Caja</h4>
      </div>
      <div class="modal-body">
        <div class="row" >
            <div class="col-sm-12 col-md-12">
              <div role="tabpanel" class="tab-pane">
                <div class="form-group">
                  <div class="panel panel-default">
                      <div class="panel-heading">
                        <h4 class="panel-title ">   Datos de la caja</h4>
                      </div>
     
                      <div class="panel-body">

                        <div class="col-xs-6">Descripcion:
                           <input name="cajasc" type="text" id="cajasc" value="" class="form-control">
                        </div>

                        <div class="col-xs-6">codigo:
                        <input name="codigoc" type="text" id="codigoc" value="" class="form-control">
                          <input type="hidden" id="id_cajas" name="id_cajas">
        
        
                        </div>
                        <div class="col-xs-6">Estanteria:
                         <select id="estanteriac" name="estanteriac" class="form-control">
                          <option value="0" division="" selected>Seleccione Estantería</option>
                            <?php
                            $consulta2 = "SELECT * FROM estanteria";
                            $result2   = mysql_query($consulta2,$var->links);
                            while($row2=mysql_fetch_array($result2)) {
                                echo "<option value='".$row2['id_estanteria']."'>".$row2['descripcion']."</option>";
                                //letra
                            }
                            ?>
                        </select>   
                        </div>
                        <div class="col-xs-6">Fila:
                         <input name="filac" type="text" id="filac" value="" class="form-control" >   
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
        <button type="button" class="btn btn-primary" id="reset" data-dismiss="modal" onclick="guardarcaja()">Guardar</button>
    </div>
    </div>

     </div>
       
      </div>
       
      </div>


  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalSale" tabindex="2000" aria-labelledby="myModalLabel" >
  <div class="modal-dialog" role="document" style="width: 60%">
    <div class="modal-content">
      
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="cerro()"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span id="modalActionSale"> </span> Contenido de caja</h4> 
      </div>

      <div class="modal-body" id="modalBodySale">
      <table align="center" id='tabladatos2' name='tabladatos2' class="table table-active">
            <thead>
             <tr class="active">
                  <!-- <td> Expediente: </td> <td> Caratula: </td>-->
                 <th> Expediente:</th>
                  <th> Caratula:</th>
                  
                 </tr>
                 </thead>
                 <tbody> 
            </tbody>
    </table>
        

    </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cerro()">Cancelar</button>
          <button type="button" class="btn btn-primary" id="btnSave" onclick="guardar()">Guardar</button>
        </div>

      </div>
  </div>
</div>
