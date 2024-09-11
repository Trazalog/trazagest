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
    <title>Lista de Usuario</title>
    <link rel="shortcut icon" type="image/x-icon" href="assest/plugins/buttons/icons/folder.png" />
    <link href="bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
    <link href="bootstrap/3.3.6/css/estilo.css" rel="stylesheet" />
    <link href="css/estilo.css" rel="stylesheet" />
    <link href="summernote.css" rel="stylesheet" />
    <link href="css/font-awesome.min.css" rel="stylesheet" />
    <link href="jQuery/jquery.autocomplete.css" rel="stylesheet" />

    
</head>

<body>  <!--onload="traer_datos()"-->
<section class="content" >
  <div class="row" width="80%" >
    <div class="col-xs-12" >
      <div class="box">
        <div class="box-header">
        <br>
          <h3 class="box-title"></h3>
          
        </div><!-- /.box-header -->
        <div class="box-body">
  
    <div class="panel panel-default" width="80%"  >
      <div class="panel-heading"><h2 class="panel-title">Usuarios</h2></div>

        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <div class="box-header">

            
                <h4 class="box-title"></h4>
                <div class="col-xs-2">
                <?php
                   
                  echo '<button class="btn btn-primary " style="width: 100px; margin-top: 10px;" id="btnAgre" title="Alta de grupo" data-toggle="modal" data-target="#modalcaja">   Nuevo   </button>';
                  echo '<br>';

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
                  <table width="80%" align="center" id='tabladatos' name='tabladatos' class="table table-bordered table-hover" style="text-align: center">
                   <thead>
                   <thear>
                                
                      <tr> 
                      <th style="text-align: center" > Acciones </th>                        
                        <th style="text-align: center">Usuario</th>
                        <th style="text-align: center">Grupo</th>
                                               
                      </tr>
                      </thear>
                      <tbody>
                      <?php

                      $consulta2="SELECT tbl_grupos.id_grupo, tbl_grupos.descripcion, tbl_grupos.permisos, usuarios.id_usuario, usuarios.nombre_real, usuarios.nombre
                      FROM  tbl_grupos  
                      JOIN usuarios ON usuarios.id_grupo=tbl_grupos.id_grupo
                      WHERE usuarios.estado='AC' ORDER BY usuarios.nombre_real ASC 


                            ";
                         
                            
                      $result2=mysql_query($consulta2,$var->links);
                      //$row2 = mysql_fetch_assoc($result2);
                      while( $row2 = mysql_fetch_assoc($result2)){
                    $id=$row2['id_usuario'];
                  

                    echo '<tr  id="'.$id.'">';
                    echo '<td>';
                    
                       //echo '<i class="fa fa-fw fa-pencil" style="color: #f39c12; cursor: pointer; margin-left: 15px;" title="Editar" data-toggle="modal" data-target="#modaleditar"></i>' ;
                   
                      echo '<i href="#" class="fa fa-fw fa-times-circle" style="color: #dd4b39; cursor: pointer; margin-left: 15px;"  title="Eliminar"></i>';

                      echo '<i class="fa fa-fw  fa fa-user" style="color: #00008B; cursor: pointer; margin-left: 15px;" title="Modificar contraseña" data-toggle="modal" data-target="#modaleditar"></i>';

                                            
                    echo '</td>';
                    
                    echo '<td style="text-align: center">'.$row2['nombre_real'].'</td>';
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
var ide="";
$(document).ready(function(event) {


  $(".fa-times-circle").click(function (e) { 
    
    console.log("Estoy eliminando"); 
    var idu= $(this).parent('td').parent('tr').attr('id');
    console.log(idu);
    $.ajax({
            type: 'POST',
            data: { idu: idu},
            url: 'elimina_usu.php', //index.php/
            success: function(data){
                    //var data = jQuery.parseJSON( data );
                    console.log(data);

                    alert("Usuario ELIMINADO");
                    refresca();
                  
                  },
              
            error: function(result){
                  
                  console.log(result);
                },
                dataType: 'json'
    });

  });

  $(".fa-user ").click(function (e) { 
    
    
    var id_usu = $(this).parent('td').parent('tr').attr('id');
    console.log(id_usu);
    ide=id_usu;
    console.log("variable global, id de usuario");
    console.log(ide);
    $('#de').val("");
    $('#usu').val("");
    $('#pass').val("");
    $('#nueva').val("");

        // var opciones = "scrolling=yes target=_blank toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,fullscreen=yes,height=screen.availHeight,width=screen.availWidth";
        // window.open("cambiar.php?usu="+ide,"nombreventa na", opciones);
       $.ajax({
          type:"POST",
          url: "seleccionar_datos.php", //controlador /metodo
          data:{ide:ide},
          success: function(data){
            console.log("Entre x el success");
            console.log(data);
            console.log(data['descripcion']);
            console.log(data['nombre_real']);
            $('#de').val(data['descripcion']);
            $('#usu').val(data['nombre']);
            $('#pass').val(data['nombre_real']);
            $('#nueva').val('');


            //refresca();
             
              },
              
              error: function(result){ 
              console.log("Entre por el error al editado"); 

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



//Guarda nuevo usuario
function guardarcaja(){

    console.log(" alta de usuario guardada");
    var nom=$('#nombre').val();
    var nomusu= $('#nomusu').val();
    var con= $('#contra').val();
    var idgrup=  $('#grupo').val();
    var us= $('#idusu').val();
    var parametros = {
      'nombre': $('#nombre').val(),
      'nombreusu': $('#nomusu').val(),
      'contras': $('#contra').val(),
      'id_grupo': $('#grupo').val(),
      
        };
        //console.log(parametros);
    console.log(parametros);
      

      $.ajax({
          type:"POST",
          url: "guardar_usu.php", //controlador /metodo
          data:{parametros:parametros, us:us},
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

function guardaredit(){

  console.log("variable global, id de usuario");
  console.log(ide);
  //var usuario=$('#pass').val();
  var nomusu= $('#pass').val();
  var contra= $('#nueva').val();
  console.log("Parametros");
  console.log("Nombre de usuario");
  console.log(nomusu);
  console.log("contraseña");
  console.log(contra);
  if (contra !==''){
    $.ajax({
          type:"POST",
          url: "cambiar_clave_usu.php", //controlador /metodo
          data:{ide:ide, nomusu:nomusu, contra:contra },
          success: function(data){
            console.log("Entre x el success de cambiar");
            console.log(data);
            alert("Usuario modificado");
            
            refresca();
             
              },
              
              error: function(result){ 
              console.log("Entre por el error al editado"); 

              console.log(result);
              }
               //dataType: 'json'
    });
  }
  else {
    alert("El campo contraseña es requerido , POR FAVOR COMPLETELO!!");
  }

  }


function refresca(){

window.location.href='alta_usuario.php';
}

</script>


<!-- Modal NUEVO USUARIO-->
<div id="modalcaja" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" ><span class="fa fa-fw  fa fa-user" style="color: #00008B"> </span>  Alta de usuario</h4>
      </div>
      <div class="modal-body">
        <div class="row" >
                        <div class="col-sm-12 col-md-12">
                          <div role="tabpanel" class="tab-pane">
                            <div class="form-group">
                              <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h4 class="panel-title "> Usuario </h4>
                                  </div>
     
                                  <div class="panel-body">
                                     
                    

                                    <div class="col-xs-6">Nombre:
                                       <input name="nombre" type="text" id="nombre" value="" class="form-control" placeholder="Ingrese Nombre y Apellido">
                                       <input type="hidden" class="input"  name="idusu" id="idusu" 
                                  value='<?php $usrId= $userdata[0]['usrId'];?>'>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="col-xs-6">Nombre de usuario:
                                       <input name="nomusu" type="text" id="nomusu" value="" class="form-control" placeholder="Ingrese Nombre de usuario">
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                     <div class="col-xs-6">Contraseña
                                       <input name="contra" type="password" id="contra" value="" class="form-control" placeholder="Ingrese Contraseña">
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                     <div class="form-group">
                                        <div class="col-xs-6">Grupo
                                            <select name="grupo" id="grupo" class="select form-control">
                                                <option value="0" division="" selected>Seleccione grupo</option>
                                                <?php
                                                $consulta2 = "SELECT * FROM tbl_grupos";
                                                $result2   = mysql_query($consulta2,$var->links);
                                                while($row2=mysql_fetch_array($result2)) {
                                                    echo "<option value='".$row2['id_grupo']."'>".$row2['descripcion']."</option>";
                                                    //letra
                                                }
                                                ?>
                                            </select>
                                        </div>
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

<!-- Modal Edita contraseña-->
<div id="modaleditar" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><span class="fa fa-fw  fa fa-user" style="color: #00008B"></span>    Editar usuario</h4>
      </div>
      <div class="modal-body">
        <div class="row" >
          <div class="col-sm-12 col-md-12">
            <div role="tabpanel" class="tab-pane">
              <div class="form-group">
                <div class="panel panel-default">
                    <div class="panel-heading">
                      <h4 class="panel-title ">   Datos de usuario</h4>
                    </div>

                    <div class="panel-body">
                      <div class="row" >
                        <div class="col-sm-12 col-md-12">  
                          <div class="card card-container">
                            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
                            <img id="profile-img" class="profile-img-card" src="//ssl.gstatic.com/accounts/ui/avatar_2x.png"></img>
                            <p id="profile-name" class="profile-name-card"></p>
                            <!--<form  class="form-horizontal"  role="form" border="1" action="cambiar_clave.php" method="post" onSubmit="return enviar()">-->
                           
                              <div class="form-group">
                                <label  for="pass" class="col-lg-4 control-label">Usuario</label>
                                <div class="col-lg-10">
                                  <p></p>
                                  
                                  <input type="text"  name="de" id="de" value='<?php if(isset($expediente)) echo $expediente["descripcion"];?>' class="border-none" disabled></input>
                                </div> 
                                
                              </div> 
                              <div class="form-group">
                                <label  for="pass" class="col-lg-4 control-label">Nombre de Usuario</label>
                                <div class="col-lg-10">
                                  <p></p>
                                  
                                  <input type="text"  name="usu" id="usu" value='<?php if(isset($expediente)) echo $expediente["nombre"];?>' class="border-none" disabled></input>
                                </div> 
                                
                              </div> 
                                                                              
                              <div class="form-group">
                                <label  for="pass" class="col-lg-4 control-label">Nombre</label>        
                                <div class="col-lg-10">
                                  <p></p>
                                  <input type="text"  name="pass" id="pass" value='<?php if(isset($expediente)) echo $expediente["nombre_real"];?>' class="input"></input>
                                </div>
                                
                              </div> 
                              
                              <div class="form-group">
                                <label  for="nueva" class="col-lg-4 control-label">Contraseña Nueva</label>
                                <div class="col-lg-10">
                                  <p></p>
                                  <input type="password" class="input"  name="nueva" id="nueva" 
                                       placeholder="Ingrese Contraseña">
                                </div>
                              </div> 
                            <br>                     
                            <center>          
                              <div class="form-group">
                                <div class="col-lg-offset-2 col-lg-10"> 
                                   <!-- <button type="submit" class="btn btn-primary">Cambiar</button>-->
                                    <button type="button" class="btn btn-primary" id="reset" data-dismiss="modal" onclick="guardaredit()">Guardar</button>
                                            <!--<input type="hidden" name="oper" value="W"/>-->
                                </div>
                              </div> 
                            </center>  
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
      </div>
    </div>
  </div>
</div>



