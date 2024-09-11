<?php

include("conexion.php");
$var = new conexion();
$var->conectarse();
$conec = $var->conectarse();

if(isset($_POST["nro"])) { //nro resolucion

    $nro = $_POST['nro'];
    $consulta  = "SELECT nro_resolucion FROM expedientespdf AS re WHERE re.nro_resolucion=$nro";
    $resultado = mysql_query($consulta);
    $array = mysql_fetch_assoc($resultado);

    if (!$array) {
        // Check its existence (for example, execute a query from the database) ...
        $isAvailable = true; // or false
    } else {
        $isAvailable = false;
    }

    echo json_encode(array(
        'valid' => $isAvailable,
    ));

}
