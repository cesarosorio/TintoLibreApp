<?php

class CrrController{

	#LLAMADA A LA PLATILLA


	#Include() se utiliaza para invocar el archivo html
	public function plantilla()
	{
		include "Vista/template1.php";
	}

	#INTERACCION DEL USUARIO

	public function enlacesPaginasController(){
		
		if(isset($_GET["action"])){

			$enlaces = $_GET["action"];

		}else{

			$enlaces ="index";
		}
		$respuesta = Paginas::enlacesPaginasModel($enlaces);

		include $respuesta;
	}
}


?>