<?php 

/**
 * 
 */
class Usuarios extends Controllers
{
	
	public function __construct()
	{
		parent::__construct();
		session_start();
		session_regenerate_id(true); //elimina los id anteriores de las cockies y genera uno nuevo

		if (!isset($_SESSION['login'])) // si la variable de session  No existe se redirige al login
		 {
		 	header('Location: '.base_url().'/login');
		 }
		//session_regenerate_id(true);
		//traemos todos permisos de ese rol
		getPermisos(2);
	}

	public function Usuarios()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header('Location: '.base_url().'/dashboard');
		}
		$data['page_tag'] = "Usuarios";
		$data['page_title'] = "USUARIOS <samll>Sistema Escolar</small>";
		$data['page_name'] = "usuarios";
		$data['page_functions_js'] = "functions_usuarios.js";
		$this->views->getView($this,"usuarios",$data);
	}

	public function getUsuarios()
	{
		if($_SESSION['permisosMod']['r'])
		{
			$arrData = $this->model->selectUsuarios();

			//dep($arrData);
			//exit();

			for ($i=0; $i < count($arrData); $i++) 
			{ 
				$btnView = '';
				$btnEdit = '';
				$btnDelete = '';

				if ($arrData[$i]['estado'] == 1)
				{
					$arrData[$i]['estado'] = '<span class="badge badge-success">Activo</span>';
				}
				else
				{
					$arrData[$i]['estado'] = '<span class="badge badge-danger">Inactivo</span>';
				}

				if($_SESSION['permisosMod']['r'])
				{ 
					$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onclick="fntViewUsuario('.$arrData[$i]['usuario_id'].')" title="Ver Usuario"><i class="far fa-eye"></i></button>';
				}

				if($_SESSION['permisosMod']['u'])
				{
					// el super administrador entra en las dos validaciones  
					// el admin sencillo no entra en la primera validacion pero sin e la segunda
					// $arrData[$i]['idrol'] != 1 el admin sencillo puede editar a todos menos a los que tiene idrol igual a 1
					//osea no puede editar a otros administradores
					if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) || ($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1))
					{																				//con this enviamos todo el boton y la info dentro de el
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onclick="fntEditUsuario(this,'.$arrData[$i]['usuario_id'].')" title="Editar Usuario"><i class="fas fa-pencil-alt"></i></button>';
					}
					else
					{
						$btnEdit = '<button class="btn btn-primary btn-sm" disabled><i class="fas fa-pencil-alt"></i></button>';

					}

					
				}

			    if($_SESSION['permisosMod']['d'])
				{
					if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) || ($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1) and ($_SESSION['userData']['usuario_id'] != $arrData[$i]['usuario_id']))
					{
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onclick="fntDelUsuario('.$arrData[$i]['usuario_id'].')" title="Eliminar Usuario"><i class="far fa-trash-alt"></i></button>';
					}
					else
					{
						$btnDelete = '<button class="btn btn-danger btn-sm" disabled><i class="fas fa-trash-alt"></i></button>';

					}
					
				}

				$arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>';
			}
			echo json_encode($arrData, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function setUsuario()
	{
		
		//dep($_POST);
		//exit();
		if($_POST)
		{
			if (empty($_POST['txtNombre']) || empty($_POST['txtUsuario']) || empty($_POST['listRolid']) || empty($_POST['listStatus']))
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrector.');
			}
			else
			{
				$idUsuario = intval($_POST['idUsuario']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$strUsuario = strtolower(strClean($_POST['txtUsuario']));
				$intTipoId = intval(strClean($_POST['listRolid']));
				$intStatus = intval(strClean($_POST['listStatus']));
				$request_user = ""; 
				if ($idUsuario == 0)
				{
					$option = 1;
					$strPassword = empty($_POST['txtPassword']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtPassword']);

					if($_SESSION['permisosMod']['w'])
					{
						$request_user = $this->model->insertUsuario($strNombre,
																	$strUsuario,
																	$strPassword,
																	$intTipoId,
																	$intStatus);
					}
				}
				else
				{
					$option = 2;
					$strPassword = empty($_POST['txtPassword']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['txtPassword']);

					if($_SESSION['permisosMod']['u']) 
					{
					    $request_user = $this->model->updateUsuario($idUsuario,
																	$strNombre,
																	$strUsuario,
																	$strPassword,
																	$intTipoId,
																	$intStatus);
					}
				}

				if ($request_user > 0)
				{
					if ($option == 1)
					{
						$arrResponse = array("status" => true, "msg" => 'Datos guardados correctamente.');
					}
					else
					{
						$arrResponse = array("status" => true, "msg" => 'Datos actualizados correctamente.');
					}
				}
				else if($request_user == 'exist')
				{
					$arrResponse = array("status" => false , "msg" => '!Atencion! el usuario o email ya existe, ingrese otro.');
				}
				else
				{
					$arrResponse = array("status" => false , "msg" => 'No es posible almacenar los datos');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
	    }
	    die();
	}

	public function getUsuario($idpersona)
	{
		if($_SESSION['permisosMod']['r'])
		{
			$idusuario = intval($idpersona);
			if ($idusuario > 0)
			{
				$arrData = $this->model->selectUsuario($idusuario);
				//dep($arrData);
				//die();
				if (empty($arrData))
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
				}
				else
				{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}

				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function delUsuario()
	{
		if ($_SESSION['permisosMod']['d']) 
		{
			//dep($_POST);
			//exit();

			if($_POST)
			{
				$intIdpersona = intval($_POST['idUsuario']);
				$requestDelete = $this->model->deleteUsuario($intIdpersona);
				//dep($requestDelete);
				//die();
				if ($requestDelete)
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el usuario.');
				}
				else
				{
					$arrResponse = array('status' => false, 'msg' => 'Error al Eliminar el usuario.');

				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function perfil()
	{
		$data['page_tag'] = "Perfil";
		$data['page_title'] = "Perfil de usuario";
		$data['page_name'] = "perfil";
		$data['page_functions_js'] = "functions_usuarios.js";
		$this->views->getView($this,"perfil",$data);
	}

	public function putPerfil()
	{
		if ($_POST)
		{
			if (empty($_POST['txtNombre']))
			{
				$arrResponse = array('status' => false, "msg" => 'Datos incorrectos.' );
			}
			else
			{
				$idUsuario = $_SESSION['idUser'];
				$strNombre = strClean($_POST['txtNombre']);
				$strPassword = "";
				if (!empty($_POST['txtPassword']))
				{
					$strPassword = hash("SHA256", $_POST['txtPassword']);
				}
				$request_user = $this->model->updatePerfil($idUsuario,$strNombre,$strPassword);
				if($request_user)
				{
					//sessionUser se encuentra en Helpers y sirve para obtener todos los datos del usuario
					sessionUser($_SESSION['idUser']);
					$arrResponse = array('status' => true , 'msg' => 'Datos actualizados correctamente');
				}
				else
				{
					$arrResponse = array('status' => false, 'msg' => 'No es posible actualizar los datos.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}
}





 ?>