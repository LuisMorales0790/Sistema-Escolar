<?php 

/**
 * 
 */
class ProcProfesorModel extends Mysql
{
    private $intIdProfesor;
	private $strNombre;
	private $intStatus;

	public function __construct()
	{
		parent::__construct();
	}

	public function selectProcProfesor()
	{
		$sql = "SELECT * FROM procesoprofesor AS pp INNER JOIN usuarios AS u ON pp.profesor_id = u.usuario_id 
				    INNER JOIN grados AS g ON pp.grado_id = g.grado_id
				    INNER JOIN aulas AS a ON pp.aula_id = a.aula_id
				    INNER JOIN materias AS m ON pp.materia_id = m.materia_id
				    INNER JOIN periodos AS p ON pp.periodo_id = p.periodo_id
				WHERE pp.estado != 0;";
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

	public function selectProfesores()
		{
			//Extrae profesores para mostralos en select
			$sql = "SELECT usuario_id, nombre FROM usuarios WHERE idrol = 3 AND estado != 0";
			$request = $this->select_all($sql);
			return $request;
		}


	public function selectGrados()
		{
			//Extrae profesores para mostralos en select
			$sql = "SELECT grado_id, nombre_grado FROM grados WHERE estado != 0";
			$request = $this->select_all($sql);
			return $request;
		}

/*	public function selectAulas()
		{
			//Extrae profesores para mostralos en select
			$sql = "SELECT aula_id, nombre_aula FROM aulas WHERE estado != 0";
			$request = $this->select_all($sql);
			return $request;
		} */

}
?>