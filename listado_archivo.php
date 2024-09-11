<?php
include("conexion.php");
$var = new conexion();
$var->conectarse();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <title>Lista de archivos</title>
    <link rel="stylesheet" href="plugin/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="plugin/datatables/dataTables.bootstrap.css">
    <link rel="stylesheet" href="plugin/bootstrapvalidator/bootstrapValidator.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="summernote.css">
</head>    
    


<body>  <!--onload="traer_datos()"-->
<div class="container">
  <br />
  <div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Expedientes</h3>
    </div>

    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">

            <div class="col-xs-12">
              <br>
              <a href="principal.php" class="glyphicon glyphicon-home btn btn-default" role="button"> Principal</a>
            </div>

          </div><!-- /.box-header -->
          <br><br>
          <form name="listado" id="listado" action="" method="post" class="form-horizontal" role="form">
            <div class="panel-body">
                <br>
                <table width="100%" id='tabladatos' name='tabladatos' class="table table-bordered table-hover">
                  <thead>
                    <thear>
                      <tr> 
                        <th>Acciones</th>                   
                        <th>Nro.Expediente</th>
                        <th>Fecha de Archivo</th>
                        <th>Caja</th>
                        <th>Fila</th>
                        <th>Estanteria</th>
                        <th>Estado</th>
                      </tr>
                    </thear>
                    <tbody>
                    <?php
                      $consulta2="
                        SELECT expedientes.id_expediente, expedientes.nro_expediente, expedientes.id_estado, 
                          ccajas.id_cajas, ccajas.fechahora, ccajas.estado,
                          cajas.fila, cajas.codigo, cajas.id_estanteria, 
                          estanteria.descripcion AS estan,
                          estados.descripcion
                        FROM expedientes
                        JOIN ccajas ON ccajas.id_expediente= expedientes.id_expediente
                        JOIN cajas ON cajas.id_cajas=ccajas.id_cajas
                        JOIN estanteria ON  cajas.id_estanteria= estanteria.id_estanteria
                        JOIN estados ON estados.id_estado=expedientes.id_estado
                        where ccajas.estado='A' OR ccajas.estado='D'
                      ";
                         
                      // where expedientes.id_estado=11 AND expedientes.id_estado=14   
                      $result2=mysql_query($consulta2,$var->links);
                      //$row2 = mysql_fetch_assoc($result2);
                      while( $row2 = mysql_fetch_assoc($result2)){
                        //foreach($list['data'] as $a)
                        $id=$row2['id_cajas'];
                        $nexp=$row2['nro_expediente'];
                        // $nexp=$row2['id_expediente'];

                        echo '<tr id="'.$id.'" class="'.$nexp.'">';
                        if ($row2['estado']=='A'){
                          echo '<td>';
                            echo "<i  href='#' class='fa fa-folder-open' style='color: #f39c12; cursor: pointer; margin-left: 15px'; title='Desarchivar' data-toggle='modal' data-target='#modaldesarchivar'></i>" ;
                            echo " ";
                            echo "<i href='#' class='fa fa-bars' style='color: #dd4b39; cursor: pointer; margin-left: 15px'; title='Mover caja'  data-toggle='modal' data-target='#modalasignar'></i>";
                          echo '</td>';
                          echo '<td>'.$row2['nro_expediente'].'</td>';
                          echo '<td>'.$row2['fechahora'].'</td>';
                          echo '<td>'.$row2['codigo'].'</td>';
                          echo '<td>'.$row2['fila'].'</td>';
                          echo '<td>'.$row2['estan'].'</td>';
                          echo '<td>'.$row2['descripcion'] .'</td>';
                        }
                        else 
                        { 
                          echo "<td></td>";
                          echo '<td>'.$row2['nro_expediente'].'</td>';
                          echo '<td>'.$row2['fechahora'].'</td>';
                          echo '<td>'.$row2['codigo'].'</td>';
                          echo '<td>'.$row2['fila'].'</td>';
                          echo '<td>'.$row2['estan'].'</td>';
                          echo '<td>'.$row2['descripcion'] .'</td>';
                        }
                      }
                    ?>
                  </tbody>
                </table>
            </div>
          </form>
        </div><!-- /.box -->
      </div><!-- /.col-xs-12 -->
    </div><!-- /.row -->
  </div><!-- /.panel -->
</div><!-- /.container -->
</body>
</html>
<script src="js/jquery-1.11.3.min.js"></script>
<script src="plugin/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="plugin/bootstrapvalidator/bootstrapValidator.min.js"></script>
<script src="plugin/datatables/jquery.dataTables.min.js"></script>
<script src="plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="summernote.min.js"></script>
<script src="lang/summernote-es-ES.js"></script>
<script>

var datos   = "";
var idgo    = "";
var idca    = "";
var glo     = "";
var idgobla = ""; //id de expediente 

  //desarchivar
  $(".fa-folder-open").click(function (e) {
    $('#numexpA').val();
    $('#id_exp').val();
    $('#caratula').val();
    $('#iniciador').val();
    $('#fecha').val();
    $('#caj').val();
    $('#fila').val();
    $('#estan').val();

    var ids = $(this).parent('td').parent('tr').attr('id');
    console.log(ids); //id de caja
    idgo=ids; //id de caja
    var nroexp = $(this).parent('td').parent('tr').attr('class');
    console.log(nroexp);
    datos= parseInt(nroexp);
    console.log(datos); //nro de expediente
    /*var opciones = "toolbar=0,location=0,status=0,menubar=0,scrollbars=yes,resizable=yes,width=950,height=950" ;
    window.open("desarchivar.php?nroexpe="+datos,"nombreventa na", opciones);*/
    $.ajax({
      type:"POST",
      url: "ajax_get_exp.php", //controlador /metodo
      data:{idgo: idgo , datos:datos},
      success: function(data){

        //var dat = jQuery.parseJSON( data ); 
        console.table(data);
        idgobla = parseInt(data);
        console.log("Id de expediente: "+idgobla);

        $.ajax({
          data: { datos: datos, idgo: idgo, idgobla:idgobla},
          dataType: 'json',
          type: 'POST',
          url: 'ajax_get_datosdesar.php', 
          success: function(data){
            console.log("por fin desarchivando ");
            console.table(data);             
            $('#numexpA').val(data['nro_expediente']);
            console.info( $('#numexpA').val() );
            $('#id_exp').val(data['id_expediente']);

            $('#caratula').val(data['caratula']);
            $('#iniciador').val(data['nombre']+" "+data['apellido']);
            $('#fecha').val(data['fecha']);
            $('#caj').val(data['codigo']);
            $('#fila').val(data['fila']);
            $('#estan').val(data['descripcion']);
          },
          error: function(result){
            console.log("Entre por el error");
            console.log(result);
          },
        });
      },

      error: function(result){
        console.log("entro por el error");
        console.log(result);
      }
    });
  });



  function guardarsi(){
    console.log("si guardo movimiento  ");
    var idcaja = $('#caja').val();
    var nroexp = $('#numexpA').val();

    console.log("Numero de expediente e id de caja ");
    console.log(idcaja);
    console.log(idca);  
    console.log(nroexp);
    console.log("id de caja vieja ");
    console.log(idgo);
    console.log("El id de expediente");
    console.log(idgobla);
    $.ajax({
      type: "POST",
      data: {nroexp:nroexp , idca:idca, idgo:idgo , idgobla:idgobla},
      url: "guardarmovimiento.php",
      success: function(data){
        console.log("exito en el guardado de camibio de caja");
        // var data = jQuery.parseJSON( result );
        console.log(data);
        refresca();
        /* $('#modalAsig').modal('hide');
        setTimeout(function(){
          var permisos = '<?php //echo $permission; ?>';
          cargarView('otrabajos', 'index', permisos) ; 
        },3000); // 3000ms = 3s*/
      },
      error: function(result){
        console.log("");
        console.log(result);
        // $('#modalAsig').modal('hide');
      }
    });
  }



  function refresca(){
    window.location.href='listado_archivo.php';
  }






   //Editar 
    $(".fa-bars").click(function (e) { 
         
          var id_cajas = $(this).parent('td').parent('tr').attr('id');
          console.log("El numero de caja es: ");
          console.log(id_cajas);
          idgo=id_cajas;

          var idcomp = $(this).parent('td').parent('tr').attr('class');
          console.log(idcomp);
          datos= parseInt(idcomp);
          //console.log("El id de expediente es : ");
          console.log("El numero de expediente es : ");
          console.log(datos);

          $('#numexp').val(datos);





          //id_cajas: id_cajas,
          //datos: datos

        /*  $.ajax({
              type: 'POST',
              data: { idex: datos},
              url: 'ajax_get_listaarch.php', //index.php/
              success: function(da){
                console.log("Estoy cambiando caja ");
                                       
                      console.info(da);
                       console.info(da[0]);
                        console.info(da[0][0][0]['codigo']);
                     console.log(da.codigo);
                      console.log(da[0]['codigo']);

                       

                    /*for (var i = 0; i < data.length; i++) {
                        console.log (data[i]);
                      }*/

                      //console.log(data['dato'][0]['codigo']);
                      //console.log(data['codigo']);
                      //console.log(data[1]);
                     // console.log(data.codigo);
                      //console.log(data[0]['codigo']);
                     

                     /*  datos={
                 
                          'codigo':data['codigo'],
                          'caja':data['descrip'],
                          'id_cajas':data['id_cajas'],
                          'id_estanteria':data['id_estanteria'],
                          'descripcion':data['descripcion'], 
                          'fila': data['fila'],
                          'nro_expediente': data['nro_expediente'],
                          'caratula': data['caratula'],
                          
                    }*/
                 // completarEdit(datos);
                              

                  /*  },
                
              error: function(da){
                console.log("Entre por el error");
                    
                    console.log(da);
                  }
                //dataType: 'json'
          });*/

          $.ajax({
                type:"POST",
                url: "ajax_get_exp.php", //controlador /metodo
                data:{idgo: idgo , datos:datos},
                success: function(data){
                 
                      //var dat = jQuery.parseJSON( data ); 
                  console.log("Estoy cambiando caja ");                               
                  console.log(data);

                   idgobla= parseInt(data);
                   console.log("el id de expediente ");

                   console.log(idgobla);


                  //console.log(data['nombre']);
                  //console.log(data.nombre);

                /*  $.ajax({
                    type:"POST",
                    url: "ajax_get_datosdeexp.php", //controlador /metodo
                    data:{idgobla: idgobla , idgobla:idgobla},
                    success: function(data){
                     
                          //var dat = jQuery.parseJSON( data ); 
                      console.log("datos traidos  ");                               
                      console.log(data);

                      

                      //console.log(data['nombre']);
                      //console.log(data.nombre);
                      
                       
                        },
                    
                    error: function(result){
                        console.log("entro por el error");
                        console.log(result);
                    }
                   // dataType: 'json'
                  });*/
                  
                   
                    },
                
                error: function(result){
                    console.log("entro por el error");
                    console.log(result);
                }
               // dataType: 'json'
              });

    });

    $("#adde").click(function (e) {

              var $caja = $("select#caja option:selected").html();
              var $numexp= $('#numexp').val();
              var id_caja= $('#caja').val();
              idca=id_caja;

              console.log("El ide de caja seleccionada es :");
              console.log(id_caja);
              console.log(idca);
              console.log("El Numero de expediente es :");
              console.log($numexp);

              var tr = "<tr>"+
                          "<td><i class='fa fa-ban elirow' style='color: #f39c12'; cursor: 'pointer'></i></td>"+
                          "<td>"+$caja+"</td>"+
                          "<td>"+$numexp+"</td>"+
                          
                      "</tr>";
         

              $('#tablaempresa tbody').append(tr);
              
              $(document).on("click",".elirow",function(){
            var parent = $(this).closest('tr');
            $(parent).remove();
            });
             
             $('#caja').val(''); 
             
             

        });

  $('#tabladatos').DataTable({
      "paging": true,
      "lengthChange": true,
      "searching": true,
      "ordering": true,
      "columnDefs": [ {
        "targets": [ 0 ], 
        "searchable": false
      },
      {
        "targets": [ 0 ], 
        "orderable": false
      } ],
      "order": [[1, "asc"]],
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


function completarEdit(datos){
  
  console.log("datos que llegaron");
  console.log(datos);

  $('#numexp').val(datos['nro_expediente']);
  $('#caratula').val(datos['caratula']);
  $('#caj').val(datos['codigo']);
 // $('#estanteriae ').val(data['descripcion']);
  $('#fila').val(datos['fila']);

//$('select#estanteriaedit').val(datos['id_estanteria']);
  $('#estan').val(datos['descripcion']);

}
  

function cerro() {
console.info("intestaste cerrar");
}





</script>

<!-- Modal ASIGNAR-->
<div id="modalasignar" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Mover expediente de caja </h4>
      </div>
      <div class="modal-body">
        <div class="row" >
          <div class="col-sm-12 col-md-12">
            <div role="tabpanel" class="tab-pane">
              <div class="form-group">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h4 class="panel-title ">   Expediente Archivado</h4>
                  </div>
                  <!--Datos del -->
                  <div class="panel-body">
                    <div class="col-xs-4">Nro de Expediente:
                     <input type="text" id="numexp" name="numexp" class="form-control">
                     <input type="hidden" id="id_exp" name="id_exp">
                   </div>
                   <br>
                   <br>

                    <!--  <div class="col-xs-12">Caratula:
                      <textarea class="form-control" id="caratula" name="caratula" disabled></textarea>
                      </div>
                      <br>

                      
                      <div class="col-xs-4">Caja:
                       <input type="text" id="caj" name="caj" class="form-control" disabled>
                        
                      </div>
                      
                      <div class="col-xs-4">Fila:
                        <input type="text" id="fila"  name="fila" class="form-control input-md" disabled>
                      </div>
  
                      <div class="col-xs-4">Estanteria:
                          <input type="text" id="estan"  name="estan" class="form-control input-md" disabled>
                      </div>-->

                                  </div>
                               </div>
                              </div>
                            </div>
                          </div>
                          </div>
                          <div>
                          <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#choras" aria-controls="home" role="tab" data-toggle="tab" class="fa fa-file-text-o icotitulo">   Cambiar</a></li>

                          </ul>

                          <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="choras">

                          <div class="row" >
                            <div class="col-sm-12 col-md-12">
                              <br>
                              <fieldset><legend></legend></fieldset>
                                <div class="col-xs-4">Caja
                                  <select id="caja" name="caja" class="form-control">

                                  <option value="0" division="" selected>Seleccione Caja</option>
                                    <?php
                                    $consulta2 = "SELECT * FROM cajas";
                                    $result2   = mysql_query($consulta2,$var->links);
                                    while($row2=mysql_fetch_array($result2)) {
                                        echo "<option value='".$row2['id_cajas']."'>".$row2['codigo']."</option>";
                                        //letra
                                    }
                                    ?>
                                </select>
                                </div>
                                <br>
                                            
                                <div class="col-xs-4">
                                  <button type="button" class="btn btn-success" id="adde"><i class="fa fa-check">Cambiar</i></button>
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
                                        <th width="10%">Expediente</th>
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
        <button type="button" class="btn btn-primary" id="reset" data-dismiss="modal" onclick="guardarsi()">Guardar</button>
    </div>
    </div>

  </div>
</div>

<!--desarchivar-->

<div id="modaldesarchivar" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Desarchivar Expediente </h4>
      </div>
      <div class="modal-body">
        <div class="row" >
          <div class="col-xs-12">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title ">   Datos del Expediente</h4>
              </div>

              <div class="panel-body">
                <div class="col-xs-4">Nro de Expediente SS:
                  <input type="text" id="numexpA" name="numexpA" class="form-control" disabled>
                  <input type="hidden" id="id_exp" name="id_exp">
                </div><br>

                <div class="col-xs-12">Caratula:
                  <textarea class="form-control" id="caratula" name="caratula" disabled></textarea>
                </div><br>

                <div class="col-xs-8">Iniciador:
                  <input type="text" id="iniciador" name="iniciador" class="form-control" disabled>
                </div>
                <div class="col-xs-4">Fecha:
                  <input type="date" id="fecha" name="fecha" class="form-control" disabled>
                </div><br>

                <div class="col-xs-4">Caja:
                  <input type="text" id="caj" name="caj" class="form-control" disabled>

                </div>
                <div class="col-xs-4">Fila:
                  <input type="text" id="fila"  name="fila" class="form-control input-md" disabled>
                </div>
                <div class="col-xs-4">Estanteria:
                  <input type="text" id="estan"  name="estan" class="form-control input-md" disabled>
                </div>
              </div>
            </div>
            
            <div class="col-xs-4">fecha de desarchivo:
              <input type="text" id="fechade" name="fechade" class="form-control" value="<?php echo date('Y-m-d');?>">
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cerro()">Cancelar</button>
        <button type="button" class="btn btn-primary" id="reset" data-dismiss="modal" onclick="guardarsi()">Guardar</button>
      </div>
    </div>
  </div>
</div>
