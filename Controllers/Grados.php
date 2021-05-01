<?php 

/**
 * 
 */
class Grados extends Controllers
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

	public function grados()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header('Location: '.base_url().'/dashboard');
		}
		$data['page_tag'] = "Grados";
		$data['page_title'] = "GRADOS <samll>Sistema Escolar</small>";
		$data['page_name'] = "grados";
		$data['page_functions_js'] = "functions_grados.js";
		$this->views->getView($this,"grados",$data);
	}

	public function getGrados()
	{
		if($_SESSION['permisosMod']['r'])
		{
			$arrData = $this->model->selectGrados();

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
					$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onclick="fntViewGrado('.$arrData[$i]['grado_id'].')" title="Ver Grado"><i class="far fa-eye"></i></button>';
				}

				if($_SESSION['permisosMod']['u'])
				{
					// el super administrador entra en las dos validaciones  
					// el admin sencillo no entra en la primera validacion pero sin e la segunda
					// $arrData[$i]['idrol'] != 1 el admin sencillo puede editar a todos menos a los que tiene idrol igual a 1
					//osea no puede editar a otros administradores
					if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) || ($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1))
					{																				//con this enviamos todo el boton y la info dentro de el
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onclick="fntEditGrado(this,'.$arrData[$i]['grado_id'].')" title="Editar Grado"><i class="fas fa-pencil-alt"></i></button>';
					}
					else
					{
						$btnEdit = '<button class="btn btn-primary btn-sm" disabled><i class="fas fa-pencil-alt"></i></button>';

					}

					
				}

			    if($_SESSION['permisosMod']['d'])
				{
					if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) || ($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1))
					{
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onclick="fntDelGrado('.$arrData[$i]['grado_id'].')" title="Eliminar Grado"><i class="far fa-trash-alt"></i></button>';
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

	public function setGrados()
	{                                      
		
		//dep($_POST);
		//exit();
		if($_POST)
		{
			if (empty($_POST['txtNombre']))
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}
			else
			{
				$idGrado = intval($_POST['idGrado']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$intStatus = intval(strClean($_POST['listStatus']));

    			$request_user = ""; 
				if ($idGrado == 0)
				{
					$option = 1;
					if($_SESSION['permisosMod']['w'])
					{
						$request_user = $this->model->insertGrado($strNombre,
																  $intStatus);
					}
				}
				else
				{
					$option = 2;
					if($_SESSION['permisosMod']['u']) 
					{
					    $request_user = $this->model->updateGrado($idGrado,
					    										  $strNombre,
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
				else
				{
					$arrResponse = array("status" => false , "msg" => 'No es posible almacenar los datos');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
	    }
	    die();
	}

	public function getGrado($idgrado)
	{
		if($_SESSION['permisosMod']['r'])
		{
			$idusuario = intval($idgrado);
			if ($idusuario > 0)
			{
				$arrData = $this->model->selectGrado($idusuario);
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

	public function delGrado()
	{
		if ($_SESSION['permisosMod']['d']) 
		{
			//dep($_POST);
			//exit();

			if($_POST)
			{
				$intIdGrado = intval($_POST['idGrado']);
				$requestDelete = $this->model->deleteGrado($intIdGrado);
				//dep($requestDelete);
				//die();
				if ($requestDelete)
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el grado.');
				}
				else
				{
					$arrResponse = array('status' => false, 'msg' => 'Error al Eliminar el grado.');

				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

}





 ?>