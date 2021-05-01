<?php 

/**
 * 
 */
class ActividadesModel extends Mysql
{
    private $intIdActividad;
	private $strNombre;
	private $intStatus;

	public function __construct()
	{
		parent::__construct();
	}

	public function selectActividades()
	{
		$sql = "SELECT * FROM actividad WHERE estado != 0 ";
			$request = $this->select_all($sql);
			return $request;
	}

	public function insertActividad(string $nombre, int $status)
	{
		$this->strNombre = $nombre;
		$this->intStatus = $status;
		
		$return = 0;

		$sql = "SELECT * FROM actividad WHERE nombre_actividad = '{$this->strNombre}'";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			$query_insert = "INSERT INTO actividad(nombre_actividad,estado)
							VALUES(?,?)";

			$arrData = array($this->strNombre,
							 $this->intStatus);

			$request_insert = $this->insert($query_insert,$arrData);
			$return = $request_insert;
		}
		else
		{
			$return = "exist";
		}
		return $return;
	}

	public function updateActividad(int $idactividad, string $nombre, int $status)
	{
		$this->intIdActividad = $idactividad;
		$this->strNombre = $nombre;
		$this->intStatus = $status;

		
		$sql = "SELECT * FROM actividad WHERE (nombre_actividad = '{$this->strNombre}' AND actividad_id != $this->intIdActividad)";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			
			$sql = "UPDATE actividad SET nombre_actividad=?, estado=?
					WHERE actividad_id = $this->intIdActividad";

			$arrData = array($this->strNombre,
							 $this->intStatus);
			
			$request = $this->update($sql,$arrData);
		}
		else
		{
			$request = 'exist';
		}

		return $request;
	}

	public function selectActividad(int $idactividad)
	{
		$this->intIdActividad = $idactividad;
		$sql = "SELECT * FROM actividad WHERE actividad_id = $this->intIdActividad";
		$request = $this->select($sql);
		return $request;
	}

	public function deleteActividad(int $idactividad)
	{
		$this->intIdActividad = $idactividad;
		$sql = "UPDATE actividad SET estado = ? WHERE actividad_id = $this->intIdActividad";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}

	

}
?>