<?php 

/**
 * 
 */
class MateriasModel extends Mysql
{
    private $intIdMateria;
	private $strNombre;
	private $intStatus;

	public function __construct()
	{
		parent::__construct();
	}

	public function selectMaterias()
	{
		$sql = "SELECT * FROM materias WHERE estado != 0 ";
			$request = $this->select_all($sql);
			return $request;
	}

	public function insertMateria(string $nombre, int $status)
	{
		$this->strNombre = $nombre;
		$this->intStatus = $status;
		
		$return = 0;

		$sql = "SELECT * FROM materias WHERE nombre_materia = '{$this->strNombre}'";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			$query_insert = "INSERT INTO materias(nombre_materia,estado)
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

	public function updateMateria(int $idmateria, string $nombre, int $status)
	{
		$this->intIdMateria = $idmateria;
		$this->strNombre = $nombre;
		$this->intStatus = $status;

		
		$sql = "SELECT * FROM materias WHERE (nombre_materia = '{$this->strNombre}' AND materia_id != $this->intIdMateria)";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			
			$sql = "UPDATE materias SET nombre_materia=?, estado=?
					WHERE materia_id = $this->intIdMateria";

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

	public function selectMateria(int $idmateria)
	{
		$this->intIdMateria = $idmateria;
		$sql = "SELECT * FROM materias WHERE materia_id = $this->intIdMateria";
		$request = $this->select($sql);
		return $request;
	}

	public function deleteMateria(int $idmateria)
	{
		$this->intIdMateria = $idmateria;
		$sql = "UPDATE materias SET estado = ? WHERE materia_id = $this->intIdMateria";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}

	

}
?>