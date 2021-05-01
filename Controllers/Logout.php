<?php 
/* controlador para cerrar sesion*/

/**
 * 
 */
class Logout extends Controllers
{
	
	public function __construct()
	{
		session_start(); //iniciar sesion
		session_unset(); //limpiar variables de session
		session_destroy();//destruir variables de session
		header('location: '.base_url().'/login');
	}
}




 ?>