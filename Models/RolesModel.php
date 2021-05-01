<?php 

	/**
	 * 
	 */
	class RolesModel extends Mysql
	{
		public $intIdrol;
		public $strRol;
		public $strDescripcion;
		public $intStatus;
		
		public function __construct()
		{
			//esto es para que se ejecute el constructor de la clase padre Mysql
			parent::__construct();
		}

		public function selectRoles()
		{
			$whereAdmin = "";
			if ($_SESSION['idUser'] != 1) 
			{
				$whereAdmin = " and idrol != 1 ";	
			}
			//Extrae roles para mostralos en select
			$sql = "SELECT * FROM rol WHERE status != 0".$whereAdmin;
			$request = $this->select_all($sql);
			return $request;
		}

		public function insertRol(string $rol, string $descripcion, int $status){

			$return = "";
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM rol WHERE nombre_rol = '{$this->strRol}'";
			$request = $this->select_all($sql);

			if (empty($request)) {
				//consulta
			 	$query_insert = "INSERT INTO rol(nombre_rol,descripcion,status) values (?,?,?)";
			 	//datos
			 	$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);

			 	$request_insert = $this->insert($query_insert,$arrData);

			 	$return = $request_insert;
			 }
			 else
			 {
			 	$return = "exist";
			 }
			 return $return;
		}

		public function selectRol(int $idrol){

			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM rol WHERE idrol = $this->intIdrol";
			$request = $this->select($sql);
			return $request;
		}

		public function updateRol(int $idrol, string $rol, string $descripcion, int $status)
		{
			$this->intIdrol = $idrol;
			$this->strRol = $rol;
			$this->strDescripcion = $descripcion;
			$this->intStatus = $status;

			$sql = "SELECT * FROM rol WHERE nombre_rol = '$this->strRol' AND idrol != $this->intIdrol";

			$request = $this->select_all($sql);
			if (empty($request)) {
				$sql = "UPDATE rol SET nombre_rol = ?, descripcion = ?, status = ? WHERE idrol = $this->intIdrol";

				$arrData = array($this->strRol, $this->strDescripcion, $this->intStatus);

				$request = $this->update($sql,$arrData);
			}
			else
			{
				$request = "exist";
			}

			return $request;
		}

		public function deleteRol(int $idrol)
		{
			$this->intIdrol = $idrol;
			$sql = "SELECT * FROM usuarios WHERE idrol = $this->intIdrol";
			$request = $this->select_all($sql);
			if (empty($request)) {
				$sql = "UPDATE rol SET status = ? WHERE idrol = $this->intIdrol";
				$arrData = array(0);
				$request = $this->update($sql, $arrData);
				if ($request)
				{
				  $request = 'ok';
				}
				else
				{
					$request  = 'error';
				}
			}
			else
			{
				$request = 'exist';
			}

			return $request;
		}	
	}


 ?>