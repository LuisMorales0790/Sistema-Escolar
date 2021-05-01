<?php 
	//config es donde se crean las variables globales 

	//las 2 opciones son validas
	//define("BASE_URL", "http://localhost/tienda_virtual/")
	const BASE_URL = "http://localhost/sistema_escolar";
	//const LIBS = "Libraries/";
	//const VIEWS = "Views/";
	//const MODELS = "Models/";

	//date_default_timezone_set('America/Panama');

	//Datos de conexion a BD
	const DB_HOST = "localhost";
	const DB_NAME = "sistema-escolar";
	const DB_USER = "root";
	const DB_PASSWORD = "";
	const DB_CHARSET = "charset=utf8";

	//delimitadores decimal y millar ej. 24,1989.00
	//separador de decimales
	const SPD = ".";
	//separador de millares
	const SPM = ",";

	//simbolo de moneda
	const SMONEY = "$";

	
	//Datos envio de correo
	const NOMBRE_REMITENTE = "Tienda Virtual";
	const EMAIL_REMITENTE = "no-reply@lemo@gmail.com";

	const NOMBRE_EMPRESA = "Tienda Virtual S.A";
	const WEB_EMPRESA = "www.abelosh.com";

 ?>