<?php
@session_start();
$us= $_SESSION["id_usuario"];

include("conexion.php");
$link= new conexion();
$link->conectarse();

include("class_sesion.php");
include("class_secciones.php") ;
$sesion= new Sesion();
$info= new seccion();

$arre = explode('~',$_POST['variable']);
?>

<?php
$tabla ="Contrato";

$idRegistro = $arre[1];
$in = $arre[2];

$tamaño = "width=1200,height=620";
$colu = 1;
$lado = 0;

$consulta = "SELECT  U.nombre_real,
    U.id_grupo,
    TG.descripcion,
    U.id_usuario
    from  usuarios  U
    JOIN  tbl_grupos TG on  TG.id_grupo=U.id_grupo
    WHERE id_usuario=$us";

$resu = mysql_query($consulta);
$r = mysql_fetch_array($resu);

if(mysql_num_rows($resu)>0) {
    $isus=$r[1];
    $gus=$r[2];
    $usuario=$r[3];

    if($idRegistro != 0) {
        $consulta = "SELECT
            U.nombre_real ,
            RM.fecha ,
            RM.folios ,
            RM.observaciones ,
            RM.id_mov,
            RM.estado,
            U.tipo,
            RM.id_usuario
            FROM registro_movimiento RM
            JOIN usuarios AS U ON  U.id_usuario=RM.id_usuario
            WHERE RM.id_reg='$in'
            ORDER BY RM.id_mov DESC";

        $resu = mysql_query($consulta);

        echo '<table id="idasigna" class="table table-condensed table table-bordered">';
        echo '<thead>';
            echo"<tr>";
                print "<th><strong> Nombre y Apellido</strong> </th>";  //escribe el titulo de la tabla
                print "<th><strong> Fecha Asignacion</strong></th>";
                print "<th><strong> folios recibidos</strong></th>";
                print "<th><strong> Observaciones</strong></th>";
                print "<th><strong> Estado</strong></th>";
                print "<th></th>";
                print "<th></th>";
                //print "<th></th>";
            echo"</tr>";
        echo "</thead>";
        echo "<tbody>";
            while ($registro = mysql_fetch_row($resu)) {
                $tipo= $registro[6];
                $asignado=$registro[7];

                echo "<tr>";
                    echo "<td>$registro[0]</td>";
                    echo "<td>$registro[1]</td>";
                    echo "<td>$registro[2]</td>";
                    echo "<td>$registro[3]</td>";
                    echo "<td>$registro[5]</td>";
                    echo "<td>$registro[4]</td>";

                    // ***********************pregunto por tipo de usuario
                    switch ($gus) {
                        case 'admin':
                        {
                            echo "<td><img src=\"assest\plugins\buttons\icons/editar.png\" onClick=\"asigau('".$registro[4]."');\" title=\"Editar Asignación de Expediente a Agente.\" style='cursor:pointer' /></td>";
                            echo "<td class='cont2' style=\"text-align: center;\">
                                        <img src=\"assest\plugins\buttons\icons\add_list.png\" onClick=\"provi('".$registro[4]."');\" title=\"Alta providencia.\" style='cursor:pointer' /></td>";
                            echo "<td class='cont2' style=\"text-align: center;\">
                                        <img src=\"assest\plugins\buttons\icons\add_note.png\" onClick=\"info('".$registro[4]."');\" title=\"Alta informe.\" style='cursor:pointer' /></td>";
                            break;
                        }
                        case 'agentes':
                        {
                            //****** pregunto si esta autorizado a escanear
                            $consulta ="Select * From asignacion_terceros where id_usuario=$usuario";
                            //echo"----$consulta";

                            $result1 = mysql_query($consulta) or die("");
                            if($row1 = mysql_fetch_array($result1)) {
                                //*************************** si el usurio logeado  esta autotirizado a ver scanear info del funcionario lo muestra  si no
                                $funcionario=$row1[2];

                                if ( $asignado==$funcionario) {
                                    $band=0;
                                    echo "<td class='cont2' style=\"text-align: center;\">
                                        <img src=\"assest\plugins\buttons\icons\picture_go.png\" onClick=\"provi('".$registro[4]."');\" alta providencia.=\"informe.\" style='cursor:pointer' /></td>";
                                }
                            }

                            // pregunto si el usuario logeado es igual al usuario que tiene asignado expediente le permite cargar informe
                            if ($usuario==$asignado) {
                                if ($tipo==0) {
                                    echo "<td class='cont2' style=\"text-align: center;\">
                                        <img src=\"assest\plugins\buttons\icons\add.png\" onClick=\"info('".$registro[4]."');\" title=\"informe.\" style='cursor:pointer' /></td>";
                                }

                            }

                            //if ($usuario==$permitido) {
                            //}

                            break;
                        }
                        case 'entrada':
                        {
                            echo "<td></td>";
                            break;
                        }
                        case 'info':
                        {
                            echo "<td></td>";
                            break;
                        }
                    }

                echo "</tr>";
                        // pregunto si el tipo de usuario  asignado al expdiente es 1 =funcionario listar providencia si es 0 es un agente listar informes
                        //...if ($tipo==1) {
                            $sql5="SELECT id_detaprov,fecha,foja,file  FROM deta_prov where id_mov=".$registro[4]."
                            ORDER BY fecha DESC";
                            //echo"$sql5";
                            $res6=mysql_query($sql5);
                             $row1=mysql_num_rows($res6);
                             if($row1<>0) {
                            listar_providencia($res6,$registro[4],$us);
                             }
                        //}
                        //if ($tipo==0) {
                            $sql5="SELECT * FROM respuesta_agente WHERE id_mov=".$registro[4]."
                                ORDER BY fecha DESC";
                            //echo"$sql5";
                            $res6=mysql_query($sql5);
                            $row=mysql_num_rows($res6);

                            if($row<>0) {
                                listar_informe($res6,$registro[4],$us);
                            }
                        //}

            }
        echo "</tbody>";
    }
    //echo '</center>';
}


function listar_informe($result,$mov,$us) { // inicio y seleccion de lo que quiero mostrar
    echo "<tr>";
    echo "<td colspan='9'>";
    echo "<table class='table table-bordered' id='tbl_informe_pases'>";
        echo "<tr>";
            print "<th class='danger'>INFORMES</th>";
            print "<th class='success'>id</th>";
            print "<th class='success'>Fecha</th>";  //escribe el titulo de la tabla
            print "<th class='success'>Folio</th>";
            print "<th class='success'>PDF</th>";
            print "<th class='success'></th>";
        echo "</tr>";

        while ($registro = mysql_fetch_row($result)) {
            echo "<tr>";
                echo "<td></td>";
                echo "<td>$registro[0]</td>";
                echo "<td>$registro[2]</td>";
                echo "<td>$registro[4]</td>";
                if ($registro[5] != '')
                    echo "<td><a onClick=\"muestra('informe/".$registro[5]."' );\" title='Providencia PDF' style='cursor:pointer'>Ver archivo</a></td>";
                else
                        echo "<td></td>";
                echo "<td> <img src=\"assest\plugins\buttons\icons\printer.png\" onClick=\"printInforme('".$registro[0]."');\" title=\"Imprime informe.\" style='cursor:pointer' /> </td>";
            echo "</tr>";
        }
    echo" </table>";
    echo "</td>";
    echo "</tr>";
}


function listar_providencia($result,$mov,$us) { // inicio y seleccion de lo que quiero mostrar
    echo "<tr>";
    echo "<td colspan='9'>";
    echo "<table class='table table-bordered'>";
        echo "<tr>";
            print "<th class='danger'>PROVIDENCIA</th>";
            print "<th class='success'>id</th>";
            print "<th class='success'>Fecha</th>";  //escribe el titulo de la tabla
            print "<th class='success'>Folio</th>";
            print "<th class='success'>PDF</th>";
            print "<th class='success'></th>";
        echo "</tr>";

        while ($registro = mysql_fetch_row($result)) {
            //echo '<pre>';
            //var_export($registro);
            //echo '</pre>';
            echo "<tr>";
                echo "<td></td>";
                echo "<td>$registro[0]</td>";
                echo "<td>$registro[1]</td>";
                echo "<td>$registro[2]</td>";//A ESTE LO AGREGUÉ YO. ESTABA EN BLANCO
                if ($registro[3] != '')
                    echo "<td><a onClick=\"muestra('file/".$registro[3]."' );\" title='Informe PDF' style='cursor:pointer' />Ver archivo</td>";
                else
                    echo "<td></td>";
                //echo "<td> <img src=\"assest\plugins\buttons\icons\printer.png\" onClick=\"printProvidencia('".$registro[0]."');\" title=\"Imprime providencia.\" style='cursor:pointer' /> </td>";
                echo "<td></td>";
            echo "</tr>";
        }
    echo "</table>";
    echo "</td>";
    echo "</tr>";
}


function invierteFecha($valor){
    $array = explode('-', $valor);
    return $array[2].'-'.$array[1].'-'.$array[0];
}
