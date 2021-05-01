<?php 

/**
 * 
 */
class GradosModel extends Mysql
{
    private $intIdGrado;
	private $strNombre;
	private $intStatus;

	public function __construct()
	{
		parent::__construct();
	}

	public function selectGrados()
	{
		$sql = "SELECT * FROM grados
			WHERE estado != 0 ";
			$request = $this->select_all($sql);
			return $request;


	}

	public function insertGrado(string $nombre, int $status)
	{
		$this->strNombre = $nombre;
		$this->intStatus = $status;
		
		$return = 0;

		$sql = "SELECT * FROM grados WHERE nombre_grado = '{$this->strNombre}'";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			$query_insert = "INSERT INTO grados(nombre_grado,estado)
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

	public function updateGrado(int $idgrado, string $nombre, int $status)
	{
		$this->intIdGrado = $idgrado;
		$this->strNombre = $nombre;
		$this->intStatus = $status;

		
		$sql = "SELECT * FROM grados WHERE (nombre_grado = '{$this->strNombre}' AND grado_id != $this->intIdGrado)";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			
			$sql = "UPDATE grados SET nombre_grado=?, estado=?
					WHERE grado_id = $this->intIdGrado";

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

	public function selectGrado(int $idgrado)
	{
		$this->intIdGrado = $idgrado;
		$sql = "SELECT * FROM grados WHERE grado_id = $this->intIdGrado";
		$request = $this->select($sql);
		return $request;
	}

	public function deleteGrado(int $idgrado)
	{
		$this->intIdGrado = $idgrado;
		$sql = "UPDATE grados SET estado = ? WHERE grado_id = $this->intIdGrado";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}

	

}
?>