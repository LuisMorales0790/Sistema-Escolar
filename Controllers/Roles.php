<?php 
/**Este es un controlador que se connecta con su clase padre Controller por medio del constructor y a su ves este se conecta con el metodo homeModels
 * 
 */
class Roles extends Controllers
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
		 getPermisos(2);
	}

	public function Roles()
	{
		if(empty($_SESSION['permisosMod']['r'])){
			header('Location: '.base_url().'/dashboard');
		}
		//hacemos referencia a la vista home para enviarle informacion
		$data['page_id'] = 3;
		$data['page_tag'] = "Roles - Sistema Escolar";
		$data['page_title'] = "Roles Usuario <small>Sistema Escolar</small>";
		$data['page_name'] = "rol_usuario";
		$data['page_functions_js'] = "functions_roles.js";
		$this->views->getView($this,"roles",$data);
	}

	 public function getRoles()
    {
    	if($_SESSION['permisosMod']['r'])
    	{
		        $btnView = '';
		        $btnEdit = '';
		        $btnDelete = '';

		      $arrData = $this->model->selectRoles();

		    for($i=0; $i < count($arrData); $i++)
		    {

		        if($arrData[$i]['status'] == 1)
		        {
		          $arrData[$i]['status'] = '<span class="badge badge-success">Activo</span>';
		        }
		        else
		        {
		          $arrData[$i]['status'] = '<span class="badge badge-danger">Inactivo</span>';
		        }

		            if($_SESSION['permisosMod']['u'])
				    { 
				      $btnView = '<button class="btn btn-secondary btn-sm btnPermisosRol" onClick="fntPermisos('.$arrData[$i]['idrol'].')" title="Permisos"><i class="fas fa-key"></i></button>';

		              $btnEdit = '<button class="btn btn-primary btn-sm btnEditRol" onClick="fntEditRol('.$arrData[$i]['idrol'].')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';
		        	}

		            if($_SESSION['permisosMod']['d'])
				    { 
		              $btnDelete = '<button class="btn btn-danger btn-sm btnDelRol" onClick="fntDelRol('.$arrData[$i]['idrol'].')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';
		            }

		          $arrData[$i]['options'] = '<div class="text-center">'.$btnView.' '.$btnEdit.' '.$btnDelete.'</div>'; 
			}
			      //dep es una funcion que esta en helpers
			     // dep($arrData);

			     // <span class="badge badge-success">Success</span>

			      echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			    //die finaliza el proceso
	    }
	    die();
	}

	public function setRol()
	{
		//dep($_POST);
		//exit();
		$intIdrol = intval($_POST['idRol']);
		$strRol = strClean($_POST['txtNombre']);
		$strDescripcion = strClean($_POST['txtDescripcion']);
		$intStatus = intval($_POST['listStatus']);

		if($intIdrol == 0)
		{
			if($_SESSION['permisosMod']['w'])
			{
				//crear rol
				$request_rol = $this->model->insertRol($strRol, $strDescripcion, $intStatus);
				$option = 1;
			}
		}
		else
		{
			if($_SESSION['permisosMod']['u'])
			{
				//actualizar
				$request_rol = $this->model->updateRol($intIdrol,$strRol,$strDescripcion,$intStatus);
				$option = 2;
			}
		}

		if ($request_rol > 0) 
		{
			if ($option == 1) 
			{ //si option es 1
				$arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente' );
			}
			else
			{     //si opcion es 2
				$arrResponse = array('status' => true, 'msg' => 'Datos actualizados correctamente' );
			}
		}
		else if($request_rol == 'exist')
		{
			$arrResponse = array('status' => false, 'msg' => '!Atencion el rol ya existe.' );
		}
		else
		{
			$arrResponse = array('status' => false, 'msg' => 'No es posible almacenar datos.');
		}

		echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		die();
	}

	public function getRol(int $idrol)
	{
		if ($_SESSION['permisosMod']['r']) 
		{

			$intIdrol = intval(strClean($idrol));
			if ($intIdrol > 0) 
			{
				$arrData = $this->model->selectRol($intIdrol);
				//dep($arrData);
				//exit();
				if (empty($arrData)) 
				{
					$arrResponse = array('status' => false, 'msg' => 'Datos nos encontrados.');
				}
				else
				{
					$arrResponse = array('status' => true , 'data' => $arrData );
				}

			}	echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function delRol()
	{
		if ($_SESSION['permisosMod']['d'])
		{

			if ($_POST)
			{
				$intIdrol = intval($_POST['idrol']);
				$requestDelete = $this->model->deleteRol($intIdrol);
				if ($requestDelete == 'ok')
				{
					$arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Rol');
				}
				else if($requestDelete == 'exist')
				{
					$arrResponse = array('status' => false ,'msg'=> 'No es posible eliminar un Rol asociado a usuarios.');
				}
				else
				{
					$arrResponse = array('status' => false, 'msg'=> 'Error al eliminar el Rol.' );
				}

				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			}
		}
		die();
	}

	public function getSelectRoles()
	{
		$htmlOptions = "";
		$arrData = $this->model->selectRoles();
		if (count($arrData) > 0)
		{
			for ($i=0; $i < count($arrData); $i++)
			{ 
				if ($arrData[$i]['status'] == 1)
				{
					$htmlOptions .= '<option value="'.$arrData[$i]['idrol'].'">'.$arrData[$i]['nombre_rol'].'</option>';
				}
			}
		}
		echo $htmlOptions;
		die();
	}


} 

?>