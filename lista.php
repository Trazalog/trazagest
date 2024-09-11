<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Lista de Cajas</title>
    <link rel="shortcut icon" type="image/x-icon" href="assest/plugins/buttons/icons/folder.png" />
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet" />
    <link href="css/estilo.css" rel="stylesheet" />
    <link href="summernote.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="jQuery/jquery.autocomplete.css" rel="stylesheet" />

    
    


    
</head>

<body>  <!--onload="traer_datos()"-->
<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box">
        <div class="box-header">
        <br>
          <h3 class="box-title"></h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
  
    <div class="panel panel-default">
      <div class="panel-heading"><h2 class="panel-title">Cajas</h2></div>

        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">

            
                <h4 class="box-title"></h4>
                <div class="col-xs-2">
                <?php
                   
                  echo '<button class="btn btn-primary " style="width: 100px; margin-top: 10px;" id="btnAgre" title="Alta de caja" data-toggle="modal" data-target="#modalcaja">Nueva Caja</button>';
                 echo '<br>';

                  echo '<button class="btn   btn-primary " style="width: 100px; margin-top: 15px;" id="btnest" title="Alta de estanteria" data-toggle="modal" data-target="#modalnuevaest"> Estanteria</button>';
                  ?>  
                </div>
                <div class="col-xs-2">
                <?php                

                  
                
                ?>
                </div>
              </div><!-- /.box-header -->
        <form name="listado" id="listado" action="" method="post" class="form-form-inline" role="form">
          <div class="panel-body">
          <a href="principal.php" class="glyphicon glyphicon-home btn btn-default col-md-offset-8" role="button"> Principal</a>
            <div class="form-group">
              <label for="fecha" class="col-sm-3 control-label"></label>
              <div class="col-sm-9">
              </div>
            </div>
              <div align="center">
                  <table width="100%" align="center" id='tabladatos' name='tabladatos' class="table table-bordered table-hover" style="text-align: center">
                   <thead>
                   <thear>
                                
                      <tr> 
                      <th style="text-align: center" > Acciones </th>                        
                        <th style="text-align: center">Descripcion</th>
                        <th style="text-align: center">Codigo</th>
                        <th style="text-align: center">Fila</th>
                        <th style="text-align: center">Estanteria</th>
                        
                        
                      </tr>
                      </thear>
                      <tbody>
                      <?php

                      $consulta2="SELECT cajas.id_cajas, cajas.codigo, cajas.descrip, cajas.fila, cajas.id_estanteria, estanteria.descripcion FROM  cajas  JOIN estanteria ON  cajas.id_estanteria= estanteria.id_estanteria
      
                            ";
                         
                            
                      $result2=mysql_query($consulta2,$var->links);
                      //$row2 = mysql_fetch_assoc($result2);
                      while( $row2 = mysql_fetch_assoc($result2)){
                    $id=$row2['id_cajas'];

                    echo '<tr id="'.$id.'" >';
                    echo '<td>';
                    
                       echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" title="Editar" data-toggle="modal" data-target="#modaleditar"></i>' ;
                   
                      echo '<i href="#" class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;"  title="Eliminar caja"></i>';

                      echo '<i href="#" class="fa fa-fw fa fa-server" style="color:   #0000FF; cursor: pointer; margin-left: 15px;"  title="Cambiar caja de estanteria" data-toggle="modal" data-target="#modalestanteria"></i>';
                       
                       echo '<i href="#" class="fa fa-fw fa fa-file" style="color:   #0000FF; cursor: pointer; margin-left: 15px;"  title="Ver Expedientes"></i>';

                      
                    echo '</td>';
                    
                    echo '<td style="text-align: center">'.$row2['descrip'].'</td>';
                    echo '<td style="text-align: center">'.$row2['codigo'].'</td>';
                    echo '<td style="text-align: center">'.$row2['fila'].'</td>';
                    echo '<td style="text-align: center">'.$row2['descripcion'].'</td>';
                   }
                    
                      ?>

                      
       
                  </tbody>
                  </table>
              </div>
        </div>
      </form>
      </div>
      </div>
       </div>
      </div>
       </div>
      </div>
       </div>
      
 </div>
      </div>
       </div>
     
       </section>
      </body>
      </html>
<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="bootstrap/3.3.6/js/bootstrap.min.js"></script>

<script type="text/javascript" src="Js/ajax.js"></script>
<script type="text/javascript" src="jQuery/jquery-ui-1.8.10.custom.min.js"></script>
<script type="text/javascript" src="paginas/generarStock/js/funcion.js"></script>
<script type="text/javascript" src="jQuery/jquery.autocomplete.js"></script>  
<!-- El CSS de DataTables -->
 
<script src="plugin/datatables/jquery.dataTables.min.js"></script>
<script src="plugin/datatables/dataTables.bootstrap.min.js"></script>

   


<script>

$(document).ready(function(event) {

$(".fa-file").click(function(e){
  var num = $(this).parent('td').parent('tr').attr('id');
  var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,height=screen.availHeight,width=screen.availWidth";
    window.open("panelcajas.php?num="+num,"nombreventa na", opciones);
});



 
  $(".fa-server").click(function (e) { 

    var id_cajas = $(this).parent('td').parent('tr').attr('id');
    console.log("El id de caja es :");
    console.log(id_cajas);
    $.ajax({
          type: 'POST',
          data: { id_cajas: id_cajas},
          url: 'ajax_get_lista.php', //index.php/
          success: function(data){
                  console.log("entre por el editar");                 
                  console.log(data);
                  console.log(data['codigo']);
          
                  $('#codigo').val(data['codigo']);
                  $('#cajas').val(data['descrip']);
                  $('#id_cajas').val(data['id_cajas']);
                  $('#estanteria').val(data['descripcion']);
                  $('#fila').val(data['fila']);
                  
                },
            
          error: function(result){
                console.log ("Entro x el error");
                console.log(result);
              },
              dataType: 'json'
          });
  });


  $("#adde").click(function (e) {

    var $estanteria = $("select#est option:selected").html();
    var id_estanteria= $('#est').val();  
    var caja= $('#cajas').val();
    var id_caja= $('#id_cajas').val();  
    console.log("el id de estanteria :" +id_estanteria);
    console.log("el id de caja :" +id_caja);
    console.log("la descripcion de la estanteria:" +$estanteria);
    console.log("la descripcion de la caja :" +caja);
      
    var tr = "<tr id='"+id_cajas+"'>"+
                  "<td ><i class='fa fa-ban elirow' style='color: #f39c12'; cursor: 'pointer'></i> </td>"+
                  "<td>"+caja+"</td>"+
                  "<td>"+$estanteria+"</td>"+
                     
              "</tr>";
      
     
    $('#tablaempresa tbody').append(tr);
    $(document).on("click",".elirow",function(){
      var parent = $(this).closest('tr');
    $(parent).remove();
    });
   

  });

  $(".fa-times-circle").click(function (e) { 
    
    console.log("Estoy eliminando"); 
    var idcaja = $(this).parent('td').parent('tr').attr('id');
    console.log(idcaja);
    var parent = $(this).closest('tr');

    $.ajax({
            type: 'POST',
            data: { idcaja: idcaja},
            url: 'elimina_caja.php', //index.php/
            success: function(data){
                    //var data = jQuery.parseJSON( data );
                    console.log(data);

                    alert("Caja ELIMINADA");
                    $(parent).remove();
                  
                  },
              
            error: function(result){
                  
                  console.log(result);
                },
                dataType: 'json'
      });

  });

  //Editar 
  $(".fa-pencil").click(function (e) { 
       
        var id_cajas = $(this).parent('td').parent('tr').attr('id');
        console.log(id_cajas);
        $.ajax({
            type: 'POST',
            data: { id_cajas: id_cajas},
            url: 'ajax_get_lista.php', //index.php/
            success: function(data){
                                      
                    console.log(data);

                     datos={
               
                        'codigo':data['codigo'],
                        'caja':data['descrip'],
                        'id_cajas':data['id_cajas'],
                        'id_estanteria':data['id_estanteria'],
                        'descripcion':data['descripcion'], 
                        'fila': data['fila'],
                        
                  }
                completarEdit(datos);
                            

                 
                    


                  },
              
            error: function(result){
                  
                  console.log(result);
                },
                dataType: 'json'
            });
  });

   $('#tabladatos').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "info": true,
      "autoWidth": true,
      "language": {
            "lengthMenu": "Ver _MENU_ filas por página",
            "zeroRecords": "No hay registros",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrando de un total de _MAX_ registros)",
            "sSearch": "Buscar:  ",
            "oPaginate": {
                "sNext": "Sig.",
                "sPrevious": "Ant."
              }
        }
        
        
    });


});
function completarEdit(datos){
  $('#estanteriaedit').html('');
  console.log("datos que llegaron");
  console.log(datos);

  $('#codigoe').val(datos['codigo']);
  $('#cajase').val(datos['caja']);
  $('#id_cajas').val(datos['id_cajas']);
 // $('#estanteriae ').val(data['descripcion']);
  $('#filae').val(datos['fila']);

//$('select#estanteriaedit').val(datos['id_estanteria']);
  $('select#estanteriaedit').append($('<option />', { value: datos['id_estanteria'],text: datos['descripcion']}));
  traer_estanteria2();

}


function traer_estanteria2(){
  $('#estanteriaedit').html(); 
      $.ajax({
        type: 'POST',
        data: { },
        url: 'traer_estanteria.php', //index.php/
        success: function(data){
               
                 console.log("estoy llegando");
                 console.log(data);



             /*     
                for(var i=0; i < data.length ; i++) 
                {    
                      var nombre = data[i]['descripcion'];
                      var opcion  = "<option value='"+data[i]['id_estanteria']+"'>" +nombre+ "</option>" ; 

                    $('#estanteriaedit').append(opcion); 
                                   
                }*/
                
              },
        error: function(result){
              
              console.log(result);
            },
            dataType: 'json'
        });
}

var id="";
function guardarmov(){


    var idcajas = $(this).parent('td').parent('tr').attr('id');
    id=idcajas;
    console.log("caja guardada");
   

       var parametros = {
              'id_estanteria': $('#est').val(),
              'id_caja': $('#id_cajas').val(),
              //'variab' : variable,
        };
        //console.log(parametros);
        console.log(parametros);
      

      $.ajax({
          type:"POST",
          url: "guardarmov.php", //controlador /metodo
          data:{parametros:parametros},
          success: function(data){
            console.log("guarde con exito");

              console.log(data);
              refresca();
             
              },
              
              error: function(result){  

              console.log(result);
              },
               dataType: 'json'
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
        //console.log(parametros);
    console.log(parametros);
      

      $.ajax({
          type:"POST",
          url: "alta_cajas_php.php", //controlador /metodo
          data:{parametros:parametros},
          success: function(data){
            console.log("guarde con exito");

              console.log(data);
              refresca();
             
              },
              
              error: function(result){  

              console.log(result);
              },
               dataType: 'json'
          });

}


function guardarnuevaest(){

    console.log(" alta de estanteria guardada");
    var parametros = {
            'descripcion': $('#estanteriae').val(),
                      };
      //console.log(parametros);
    console.log(parametros);
    $.ajax({
        type:"POST",
        url: "alta_estanteria_php.php", //controlador /metodo
        data:{parametros:parametros},
        success: function(data){
                console.log("guarde con exito");
                console.log(data);
                refresca();

            },
            
            error: function(result){  
                  console.log(result);
            }
             //dataType: 'json'
      });

}

function guardareditar(){

    console.log(" EDITAR caja A guardada");
    var parametros = {
        'descripcion': $('#cajase').val(),
        'codigo': $('#codigoe').val(),
        'id_estanteria': $('#estanteriaedit').val(),
        'fila': $('#filae').val(),
        'estado': 'C',
        'id_cajas': $('#id_cajas').val(),

            };
        //console.log(parametros);
        console.log(parametros);
      

      $.ajax({
          type:"POST",
          url: "editar.php", //controlador /metodo
          data:{parametros:parametros},
          success: function(data){
            console.log("guarde con exito");

              console.log(data);
              refresca();
             
              },
              
              error: function(result){ 
              console.log("Entre por el error al editado"); 

              console.log(result);
              },
               dataType: 'json'
          });
}

function refresca(){

window.location.href='lista.php';
}

  </script>

<!-- Modal MOVER ESTANTERIA -->
<div id="modalestanteria" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Mover caja  de estanteria </h4>
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

                                    <div class="col-xs-4">Descripcion:
                                       <input name="cajas" type="text" id="cajas" value="" class="form-control" disabled>
                                    </div>

                                    <div class="col-xs-4">codigo:
                                    <input name="codigo" type="text" id="codigo" value="" class="form-control" disabled >
                                      <input type="hidden" id="id_cajas" name="id_cajas">
                    
                    
                                    </div>
                                    <div class="col-xs-4">Estanteria:
                                     <input name="estanteria" type="text" id="estanteria" value="" class="form-control" disabled>   
                                    </div>
                                    <div class="col-xs-4">Fila:
                                     <input name="fila" type="text" id="fila" value="" class="form-control" disabled>   
                                    </div>
                                    
                                    
                

                                  </div>
                               </div>
                              </div>
                            </div>
                          </div>
                          </div>
                          <div>
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#choras" aria-controls="home" role="tab" data-toggle="tab" class="fa fa-file-text-o icotitulo">   Cambio de estanteria</a></li>

                          </ul>

                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="choras">

                          <div class="row" >
                            <div class="col-sm-12 col-md-12">
                              <br>
                              <fieldset><legend></legend></fieldset>
                                <div class="col-xs-4"> Estanteria
                                  <select id="est" name="est" class="form-control">
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
                                            
                                <div class="col-xs-4">
                                  <button type="button" class="btn btn-success" id="adde"><i class="fa fa-check">Agregar</i></button>
                                </div>

                                </div>

                              </div>
                            </div>
                             
                            <div class="row" >
                              <div class="col-sm-12 col-md-12">

                                <table class="table table-bordered" id="tablaempresa"> 
                                    <thead>
                                      <tr>                     
                                        <br>
                                        <th width="2%"></th>
                                        <th width="10%">Caja</th>
                                        <th width="10%">Estanteria</th>
                                      </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                              </div>
                          </div>
      </div>
       
      </div>
       
      </div>

      <div class="modal-footer">
       <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cerro()">Cancelar</button>
        <button type="button" class="btn btn-primary" id="reset" data-dismiss="modal" onclick="guardarmov()">Guardar</button>
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

<!-- Modal NUEVA Estanteria-->
<div id="modalnuevaest" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
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
        <button type="button" class="btn btn-primary" id="reset" data-dismiss="modal" onclick="guardarnuevaest()">Guardar</button>
    </div>
    </div>

     </div>
       
      </div>
       
      </div>


  </div>
</div>
<!-- Modal EDITAR-->
<div id="modaleditar" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Editar Datos de Caja</h4>
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
                      <input name="cajase" type="text" id="cajase" value="" class="form-control">
                    </div>

                    <div class="col-xs-6">codigo:
                      <input name="codigoe" type="text" id="codigoe" value="" class="form-control">
                      <input type="hidden" id="id_cajas" name="id_cajas">
                    </div>
                    <div class="col-xs-6">Estanteria:
                      <!--<select id="estanteriaedit" name="estanteriaedit" class="form-control">

                                      
                      </select> --> 

                     <!-- <select id="estanteriaedit" name="estanteriaedit" class="form-control">
                                     
                      </select>  -->
                      <select id="estanteriaedit" name="estanteriaedit" class="form-control">
                                  <option value="" division="" selected></option>
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
                       <input name="filae" type="text" id="filae" value="" class="form-control" >   
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
        <button type="button" class="btn btn-primary" id="reset" data-dismiss="modal" onclick="guardareditar()">Guardar</button>
    </div>
    </div>

     </div>
       
      </div>
       
      </div>


  </div>
</div>
<script >
  function listCaja(num)
  {
    var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,height=screen.availHeight,width=screen.availWidth";
    window.open("panelcajas.php?num="+num,"nombreventa na", opciones);
  }
</script>