<?php
class conexion
	{
	  var $server = "localhost";
	  var $user = "mauriper_cliente";//mi000652_mauri o root
	  var $pass = "123Trazalog24";//  123trazalog24 12345Mauriper
	  var $links;

	  function conectarse()
	  	{
		 if(!($this->links=mysql_connect($this->server,$this->user,$this->pass)))
		 	{
			 return 1;
			} //si no se muestra ningun mensaje es que se realizo la conexion

		 if (!mysql_select_db("mauriper_trazagest",$this->links ))
   			{
      		 return 1;
   			}
		}

	function cerrar_conexion()
		{
		 mysql_close($this->links); //cierra la conexion
		}
}
?>