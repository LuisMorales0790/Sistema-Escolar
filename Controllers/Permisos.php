<?php 
/**Este es un controlador que se connecta con su clase padre Controller por medio del constructor y a su ves este se conecta con el metodo homeModels
 * 
 */
class Permisos extends Controllers
{
	
	public function __construct()
	{
		 parent::__construct();
	}

	//mostrar los permisos del rol
	public function getPermisosRol(int $idrol)
	{
		$rolid = intval($idrol);
		if ($rolid > 0)
		{
			$arrModulos = $this->model->selectModulos();
			$arrPermisosRol = $this->model->selectPermisosRol($rolid);

			$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
			$arrPermisoRol = array('idrol' => $rolid);

			//si no existen permisos para el rol
			if (empty($arrPermisosRol)) {
				for ($i=0; $i < count($arrModulos); $i++) { 
					//recorremos los modulos existentes en la bd
					// y a cada modulo le agregamos el arreglo con los permisos;
					$arrModulos[$i]['permisos'] = $arrPermisos;
				}
			}
			//en caso de que el rol si tenga permisos
			else
			{
				for ($i=0; $i < count($arrModulos); $i++)
				{ 
					$arrPermisos = array('r' => 0, 'w' => 0, 'u' => 0, 'd' => 0);
					// al $arrPemisos le asignamos los permisos que tenga en ese momento ese rol en la BD
					//                   arreglos     <---          BD tabla permisos
					//si existen el modulo de los permisos con algun permiso ya asignado estos los paso a un arreglo
					if (isset($arrPermisosRol[$i]))
					{
						$arrPermisos = array('r' => $arrPermisosRol[$i]['r'],
											 'w' => $arrPermisosRol[$i]['w'],
											 'u' => $arrPermisosRol[$i]['u'],
											 'd' => $arrPermisosRol[$i]['d']
											);
				    }
					//si es asi al arreglo modulo se le agregan los permisos ya existentes en la BD
					$arrModulos[$i]['permisos'] = $arrPermisos;
				}
			}
			//arreglo que guarda el rol (estudi,prof) por medio de su id y los permisos que tiene para cada modulo (r,w,u,d)
			$arrPermisoRol['modulos'] = $arrModulos;
			//dep($arrModulos);
			//dep($arrPermisoRol);
			//envio la informacion al modal modalRoles;
			$html = getModal("modalPermisos",$arrPermisoRol);
		}
		die();
	}

	public function setPermisos()
	{

		//dep($_POST);
		if ($_POST)
		{
			$intIdrol = intval($_POST['idrol']);
			$modulos = $_POST['modulos'];

			$this->model->deletePermisos($intIdrol);
			foreach ($modulos as $modulo)
			{
				$idmodulo = $modulo['idmodulo'];
				$r = empty($modulo['r']) ? 0 : 1;
				$w = empty($modulo['w']) ? 0 : 1;
				$u = empty($modulo['u']) ? 0 : 1;
				$d = empty($modulo['d']) ? 0 : 1;
				$requestPermiso = $this->model->insertPermisos($intIdrol, $idmodulo, $r, $w, $u, $d);
			}
			if($requestPermiso > 0)
			{
				$arrResponse = array('status' => true, 'msg' => 'Permisos asignados correctamente.');
			}
			else
			{
				$arrResponse = array('status' => false, 'msg' => 'No es posible asignar los permisos.');
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}
		die();
	}
	 
} 

?>