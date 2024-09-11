<?php

$urlBase       = $_SERVER['SCRIPT_FILENAME'];
$nombreArchivo = basename($_SERVER['PHP_SELF']);
$urlBase       = str_replace($nombreArchivo, "", $urlBase);

define('BASE_URL', $urlBase);

@header('Content-Type: text/html; charset=UTF-8');

class conexion
{
	var $server = "localhost";
	var $user = "root";//mi000652_mauri o root
	var $pass = "renover24";//renover24 o 12345Mauriper
	var $links;
	
	function conectarse(){
		if(!($this->links=mysql_connect($this->server,$this->user,$this->pass))) {
		 	//mysql_set_charset("utf8",$this->links);
		 	//mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
		 	//mysql_query("SET NAMES utf8");
			return 1;
		} //si no se muestra ningun mensaje es que se realizo la conexion 
		
		//if (!mysql_select_db("trazagest",$this->links ))
		if (!mysql_select_db("trazagest",$this->links )) {
     		return 1;
   		}
	}
		
	function cerrar_conexion() {
		mysql_close($this->links); //cierra la conexion 
	}
}		
