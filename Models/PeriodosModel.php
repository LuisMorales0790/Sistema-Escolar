<?php 

/**
 * 
 */
class PeriodosModel extends Mysql
{
    private $intIdPeriodo;
	private $strNombre;
	private $intStatus;

	public function __construct()
	{
		parent::__construct();
	}

	public function selectPeriodos()
	{
		$sql = "SELECT * FROM periodos WHERE estado != 0 ";
			$request = $this->select_all($sql);
			return $request;
	}

	public function insertPeriodo(string $nombre, int $status)
	{
		$this->strNombre = $nombre;
		$this->intStatus = $status;
		
		$return = 0;

		$sql = "SELECT * FROM periodos WHERE nombre_periodo = '{$this->strNombre}'";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			$query_insert = "INSERT INTO periodos(nombre_periodo,estado)
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

	public function updatePeriodo(int $idperiodo, string $nombre, int $status)
	{
		$this->intIdPeriodo = $idperiodo;
		$this->strNombre = $nombre;
		$this->intStatus = $status;

		
		$sql = "SELECT * FROM periodos WHERE (nombre_periodo = '{$this->strNombre}' AND periodo_id != $this->intIdPeriodo)";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			
			$sql = "UPDATE periodos SET nombre_periodo=?, estado=?
					WHERE periodo_id = $this->intIdPeriodo";

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

	public function selectPeriodo(int $idperiodo)
	{
		$this->intIdPeriodo = $idperiodo;
		$sql = "SELECT * FROM periodos WHERE periodo_id = $this->intIdPeriodo";
		$request = $this->select($sql);
		return $request;
	}

	public function deletePeriodo(int $idperiodo)
	{
		$this->intIdPeriodo = $idperiodo;
		$sql = "UPDATE periodos SET estado = ? WHERE periodo_id = $this->intIdPeriodo";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}

	

}
?>