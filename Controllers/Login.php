<?php 
/**
 * 
 */
class Login extends Controllers
{
	
	function __construct()
	{
		session_start();
		if (isset($_SESSION['login'])) // si la variable de session existe se redirige al dashboard
		 {
		 	header('Location: '.base_url().'/dashboard');
		 }
		parent::__construct();
	}

	public function login()
	{
		$data['page_tag'] = "Login - Sistema Escolar";
		$data['page_title'] = "Login - Sistema Escolar";
		$data['page_name'] = "login";
		$data['page_functions_js'] = "functions_login.js";
		$this->views->getView($this,"login",$data);
	}

	public function loginUser()
	{
		//dep($_POST);
		if ($_POST)
		{
			if(empty($_POST['txtEmail']) || empty($_POST['txtPassword']))
			{
				$arrResponse = array('status' => false, 'msg' => 'Error de datos');
			}
			else
			{
				$strUsuario = strtolower(strClean($_POST['txtEmail']));
				$strPassword = hash("SHA256",$_POST['txtPassword']);
				$requestUser = $this->model->loginUser($strUsuario, $strPassword);
				if (empty($requestUser))
				{
					$arrResponse = array('status' => false, 'msg' => 'El usuario o la contraseña es incorrecto.');
				}
				else
				{
					$arrData = $requestUser;
					if($arrData['estado'] == 1)//estado del usuario
					{
						// creo variables de sesion
						$_SESSION['idUser'] = $arrData['usuario_id'];
						$_SESSION['login'] = true;
						// con esto obtengo todos los datos del usuario
						$arrData = $this->model->sessionLogin($_SESSION['idUser']);
						//los datos del usuario obtenidos los guardo en una variable de session
						//$_SESSION['userData'] = $arrData;
						sessionUser($_SESSION['idUser']);

						$arrResponse = array('status' => true, 'msg' => 'ok');
					}
					else
					{
						$arrResponse = array('status' => false, 'msg' => 'Usuario inactivo');
					}
				}
			}
			//sleep(3); //retrasa el codigo que continua
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
}


 ?>