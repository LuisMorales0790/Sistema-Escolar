<?php 

/**
 * 
 */
class ProcProfesor extends Controllers
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

	public function ProcProfesor()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header('Location: '.base_url().'/dashboard');
		}
		$data['page_tag'] = "Profesor";
		$data['page_title'] = "PROCESO PROFESOR <samll>Sistema Escolar</small>";
		$data['page_name'] = "profesor";
		$data['page_functions_js'] = "functions_proc_profesor.js";
		$this->views->getView($this,"proceso_profesor",$data);
	}

	public function getProcesos()
	{
		if($_SESSION['permisosMod']['r'])
		{
			$arrData = $this->model->selectProcProfesor();

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
					$btnView = '<button class="btn btn-info btn-sm btnViewUsuario" onclick="fntViewProceso('.$arrData[$i]['proceso_id'].')" title="Ver Proceso"><i class="far fa-eye"></i></button>';
				}

				if($_SESSION['permisosMod']['u'])
				{
					// el super administrador entra en las dos validaciones  
					// el admin sencillo no entra en la primera validacion pero sin e la segunda
					// $arrData[$i]['idrol'] != 1 el admin sencillo puede editar a todos menos a los que tiene idrol igual a 1
					//osea no puede editar a otros administradores
					if(($_SESSION['idUser'] == 1 and $_SESSION['userData']['idrol'] == 1) || ($_SESSION['userData']['idrol'] == 1 and $arrData[$i]['idrol'] != 1))
					{																				//con this enviamos todo el boton y la info dentro de el
						$btnEdit = '<button class="btn btn-primary btn-sm btnEditUsuario" onclick="fntEditProceso(this,'.$arrData[$i]['proceso_id'].')" title="Editar Proceso"><i class="fas fa-pencil-alt"></i></button>';
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
						$btnDelete = '<button class="btn btn-danger btn-sm btnDelUsuario" onclick="fntDelProceso('.$arrData[$i]['proceso_id'].')" title="Eliminar Proceso"><i class="far fa-trash-alt"></i></button>';
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

	public function setActividad()
	{                                      
		
		//dep($_POST);
		//();
		if($_POST)
		{
			if (empty($_POST['txtNombre']))
			{
				$arrResponse = array("status" => false, "msg" => 'Datos incorrectos.');
			}
			else
			{
				$idActividad = intval($_POST['idActividad']);
				$strNombre = ucwords(strClean($_POST['txtNombre']));
				$intStatus = intval(strClean($_POST['listStatus']));

    			$request_user = ""; 
				if ($idActividad == 0)
				{
					$option = 1;
					if($_SESSION['permisosMod']['w'])
					{
						$request_user = $this->model->insertActividad($strNombre,
																  $intStatus);
					}
				}
				else
				{
					$option = 2;
					if($_SESSION['permisosMod']['u']) 
					{
					    $request_user = $this->model->updateActividad($idActividad,
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

	public function getActividad($idasignacion)
	{
		if($_SESSION['permisosMod']['r'])
		{
			$idactividad = intval($idasignacion);
			if ($idactividad > 0)
			{
				$arrData = $this->model->selectActividad($idactividad);
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

	public function delActividad()
	{
		if ($_SESSION['permisosMod']['d']) 
		{
			//dep($_POST);
			//exit();

			if($_POST)
			{
				$intIdActividad = intval($_POST['idActividad']);
				$requestDelete = $this->model->deleteActividad($intIdActividad);
				//dep($requestDelete);
				//die();
				if ($requestDelete)
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado la Actividad.');
				}
				else
				{
					$arrResponse = array('status' => false, 'msg' => 'Error al eliminar la Actividad');

				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function getSelectProfesores()
	{
		$htmlOptions = "";
		$arrData = $this->model->selectProfesores();
		if (count($arrData) > 0)
		{
			for ($i=0; $i < count($arrData); $i++)
			{ 
				
				$htmlOptions .= '<option value="'.$arrData[$i]['usuario_id'].'">'.$arrData[$i]['nombre'].'</option>';
			}
		}
		echo $htmlOptions;
		die();
	}

	public function getSelectGrados()
	{
		$htmlOptions = "";
		$arrData = $this->model->selectGrados();
		if (count($arrData) > 0)
		{
			for ($i=0; $i < count($arrData); $i++)
			{ 
				
				$htmlOptions .= '<option value="'.$arrData[$i]['grado_id'].'">'.$arrData[$i]['nombre_grado'].'</option>';
			}
		}
		echo $htmlOptions;
		die();
	}

/*	public function getSelectAulas()
	{
		$arrData = $this->model->selectAulas();
		if ($arrData)
				{
					$arrResponse = array('status' => true, 'data' => $arrData);
				}
				else
				{
					$arrResponse = array('status' => false, 'msg' => 'No existen Aulas');

				}
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}   */
          
}





 ?>