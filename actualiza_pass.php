<?php

/*$pass = $_POST['password'];

echo json_encode(array(
    'message' => sprintf('Su nueva contraseña es: %s', $userName),
));*/


session_start();

include ("conexion.php");
$var = new conexion();
$var->conectarse();

$idUsuario = $_SESSION['id_usuario'];
$passVieja = $_POST['passActual'];
$passNueva = $_POST['password'];
$fecha     = date('Y-m-d'); //fecha actual

$jsondata  = array();
//compara si la contraseña es correcta (tambien en backend)
$sql    = "SELECT * FROM usuarios WHERE id_usuario=$idUsuario";
$result = mysql_query($sql) or ( $jsondata["success"] = false);
//actualiza contraseña
if ($row = mysql_fetch_array($result)) {
    if( $row["contrasena"] == md5($passVieja) ) {  
        $passNuevaE=md5($passNueva);
        $cons="UPDATE usuarios SET contrasena ='$passNuevaE', fecha ='$fecha'
            WHERE id_usuario = $idUsuario";
        $jsondata["success"] = mysql_query($cons,$var->links);  
        $jsondata["info"] = "La contraseña es correcta";
    } else {
        $jsondata["success"] = false;
        $jsondata["info"] = "La contraseña No es correcta";
    }
}

echo json_encode($jsondata);
