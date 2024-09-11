<?php
@session_start();
$us= $_SESSION["id_usuario"];

include("listarvarios_php.php");
?>

<?php
class notifica
{
    public function notifica_usuario($usuario) {
        $var = new conexion();
        $var->conectarse();
        //$arre = explode('~',$_POST['variable']);
        $consulta = "SELECT *  FROM notificaciones ";
        $resu = mysql_query($consulta);

        notificaciones($resu,$usuario);
    }
}


function invierteFecha($valor) {
    $array = explode('-', $valor);
    return $array[2].'-'.$array[1].'-'.$array[0];
}
