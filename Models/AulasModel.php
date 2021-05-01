<?php 

/**
 * 
 */
class AulasModel extends Mysql
{
    private $intIdAula;
	private $strNombre;
	private $intStatus;

	public function __construct()
	{
		parent::__construct();
	}

	public function selectAulas()
	{
		$sql = "SELECT * FROM aulas
			WHERE estado != 0 ";
			$request = $this->select_all($sql);
			return $request;


	}

	public function insertAula(string $nombre, int $status)
	{
		$this->strNombre = $nombre;
		$this->intStatus = $status;
		
		$return = 0;

		$sql = "SELECT * FROM aulas WHERE nombre_aula = '{$this->strNombre}'";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			$query_insert = "INSERT INTO aulas(nombre_aula,estado)
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

	public function updateAula(int $idaula, string $nombre, int $status)
	{
		$this->intIdAula = $idaula;
		$this->strNombre = $nombre;
		$this->intStatus = $status;

		
		$sql = "SELECT * FROM aulas WHERE (nombre_aula = '{$this->strNombre}' AND aula_id != $this->intIdAula)";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			
			$sql = "UPDATE aulas SET nombre_aula=?, estado=?
					WHERE aula_id = $this->intIdAula";

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

	public function selectAula(int $idaula)
	{
		$this->intIdAula = $idaula;
		$sql = "SELECT * FROM aulas WHERE aula_id = $this->intIdAula";
		$request = $this->select($sql);
		return $request;
	}

	public function deleteAula(int $idaula)
	{
		$this->intIdAula = $idaula;
		$sql = "UPDATE aulas SET estado = ? WHERE aula_id = $this->intIdAula";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}

	

}
?>