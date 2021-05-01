<?php 

/**
 * 
 */
class ProfesoresModel extends Mysql
{
    private $intIdProfesor;
	private $strCedula;
	private $strNombre;
	private $strDireccion;
	private $intTelefono;
	private $strUsuario;
	private $strPassword;
	private $strTelefono;
	private $strNivel;
	//private $strDirFiscal;
	//private $strNit;

	public function __construct()
	{
		parent::__construct();
	}

	public function selectProfesores()
	{
		$sql = "SELECT u.usuario_id, u.nombre, u.usuario, u.estado, r.idrol, r.nombre_rol, u.direccion, u.cedula, u.telefono, u.nivel_est
			FROM usuarios u
			INNER JOIN rol r
			ON u.idrol = r.idrol
			WHERE r.idrol = 3 AND u.estado != 0 ";
			$request = $this->select_all($sql);
			return $request;


	}

	public function insertProfesor(string $nombre, string $usuario, string $password, string $cedula, string $direccion, int $telefono, string $nivel, int $tipoid)
	{
		$this->strNombre = $nombre;
		$this->strUsuario = $usuario;
		$this->strPassword = $password;
		$this->intTipoId = $tipoid;
		$this->strDireccion = $direccion;
		$this->strCedula = $cedula;
		$this->intTelefono = $telefono;
		$this->strNivel = $nivel;
		
		
		$return = 0;

		$sql = "SELECT * FROM usuarios WHERE usuario = '{$this->strUsuario}'";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			$query_insert = "INSERT INTO usuarios(nombre,usuario,clave,idrol,direccion,cedula,telefono,nivel_est)
							VALUES(?,?,?,?,?,?,?,?)";

			$arrData = array($this->strNombre,
							 $this->strUsuario,
							 $this->strPassword,
							 $this->intTipoId,
							 $this->strDireccion,
							 $this->strCedula,
							 $this->intTelefono,
							 $this->strNivel);

			$request_insert = $this->insert($query_insert,$arrData);
			$return = $request_insert;
		}
		else
		{
			$return = "exist";
		}
		return $return;
	}

	public function updateProfesor(int $idprofesor, string $nombre, string $usuario, string $password, string $cedula, string $direccion, int $telefono, string $nivel)
	{
		$this->intIdProfesor = $idprofesor;
		$this->strNombre = $nombre;
		$this->strUsuario = $usuario;
		$this->strPassword = $password;
		$this->strCedula = $cedula;
		$this->strDireccion = $direccion;
		$this->intTelefono = $telefono;
		$this->strNivel = $nivel;

		$sql = "SELECT * FROM usuarios WHERE (usuario = '{$this->strUsuario}' AND usuario_id != $this->intIdProfesor)";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			if ($this->strPassword != "")
			{
				$sql = "UPDATE usuarios SET nombre=?, usuario=?, clave=?, direccion=?, cedula=?, telefono=?, nivel_est=?
						WHERE usuario_id = $this->intIdProfesor";

				$arrData = array($this->strNombre,
								 $this->strUsuario,
								 $this->strPassword,
								 $this->strDireccion,
								 $this->strCedula,
								 $this->intTelefono,
								 $this->strNivel);
			}
			else
			{
				$sql = "UPDATE usuarios SET nombre=?, usuario=?, direccion=?, cedula=?, telefono=?, nivel_est=?
						WHERE usuario_id = $this->intIdProfesor";

				$arrData = array($this->strNombre,
								 $this->strUsuario,
								 $this->strDireccion,
								 $this->strCedula,
								 $this->intTelefono,
								 $this->strNivel);
			}

			$request = $this->update($sql,$arrData);
		}
		else
		{
			$request = 'exist';
		}

		return $request;
	}

	public function selectProfesor(int $idprofesor)
	{
		$this->intIdProfesor = $idprofesor;
		$sql = "SELECT usuario_id, nombre, usuario, cedula, direccion, telefono, nivel_est
			FROM usuarios 
			WHERE usuario_id = $this->intIdProfesor";
			$request = $this->select($sql);
			return $request;
	}

	public function deleteProfesor(int $idprofesor)
	{
		$this->intIdProfesor = $idprofesor;
		$sql = "UPDATE usuarios SET estado = ? WHERE usuario_id = $this->intIdProfesor";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}

	/*public function updatePerfil(int $idusuario, string $nombre, string $password)
	{
		$this->intIdUsuario = $idusuario;
		$this->strNombre = $nombre;
		$this->strPassword = $password;

		if ($this->strPassword != "")
		{
			$sql = "UPDATE usuarios SET nombre = ?, clave = ? WHERE usuario_id = $this->intIdUsuario";
			$arrData = array($this->strNombre,
							 $this->strPassword);
		}
		else
		{
			$sql = "UPDATE usuarios SET nombre = ? WHERE usuario_id = $this->intIdUsuario";
			$arrData = array($this->strNombre);

		}
		$request = $this->update($sql,$arrData);
		return $request;
	} */

}
?>