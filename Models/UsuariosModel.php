<?php 

/**
 * 
 */
class UsuariosModel extends Mysql
{
    private $intIdUsuario;
	private $strIdentificacion;
	private $strNombre;
	private $strApellido;
	private $intTelefono;
	private $strUsuario;
	private $strPassword;
	private $strToken;
	private $intTipoId;
	private $intStatus;
	private $strNomFiscal;
	private $strDirFiscal;
	private $strNit;

	public function __construct()
	{
		parent::__construct();
	}

	public function selectUsuarios()
	{
		$whereAdmin = "";
		if($_SESSION['idUser'] != 1)
		{
			$whereAdmin = "AND u.usuario_id != 1";
		}
		$sql = "SELECT u.usuario_id, u.nombre, u.usuario, u.estado, r.idrol, r.nombre_rol
			FROM usuarios u
			INNER JOIN rol r
			ON u.idrol = r.idrol
			WHERE u.estado != 0 ".$whereAdmin;
			$request = $this->select_all($sql);
			return $request;


	}

	public function insertUsuario(string $nombre, string $usuario, string $password, int $tipoid, int $status)
	{
		$this->strNombre = $nombre;
		$this->strUsuario = $usuario;
		$this->strPassword = $password;
		$this->intTipoId = $tipoid;
		$this->intStatus = $status;
		$return = 0;

		$sql = "SELECT * FROM usuarios WHERE usuario = '{$this->strUsuario}'";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			$query_insert = "INSERT INTO usuarios(nombre,usuario,clave,idrol,estado)
							VALUES(?,?,?,?,?)";

			$arrData = array($this->strNombre,
							 $this->strUsuario,
							 $this->strPassword,
							 $this->intTipoId,
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

	public function updateUsuario(int $idusuario, string $nombre, string $usuario, string $password, int $tipoid, int $status)
	{
		$this->intIdUsuario = $idusuario;
		$this->strNombre = $nombre;
		$this->strUsuario = $usuario;
		$this->strPassword = $password;
		$this->intTipoId = $tipoid;
		$this->intStatus = $status;

		$sql = "SELECT * FROM usuarios WHERE (usuario = '{$this->strUsuario}' AND usuario_id != $this->intIdUsuario)";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			if ($this->strPassword != "")
			{
				$sql = "UPDATE usuarios SET nombre=?, usuario=?, clave=?, idrol=?, estado=?
						WHERE usuario_id = $this->intIdUsuario";

				$arrData = array($this->strNombre,
								 $this->strUsuario,
								 $this->strPassword,
								 $this->intTipoId,
								 $this->intStatus);
			}
			else
			{
				$sql = "UPDATE usuarios SET nombre=?, usuario=?, idrol=?, estado=?
						WHERE usuario_id = $this->intIdUsuario";

				$arrData = array($this->strNombre,
								 $this->strUsuario,
								 $this->intTipoId,
								 $this->intStatus);
			}

			$request = $this->update($sql,$arrData);
		}
		else
		{
			$request = 'exist';
		}

		return $request;
	}

	public function selectUsuario(int $idusuario)
	{
		$this->intIdUsuario = $idusuario;
		$sql = "SELECT u.usuario_id, u.nombre, u.usuario, u.estado, r.idrol, r.nombre_rol
			FROM usuarios u
			INNER JOIN rol r
			ON u.idrol = r.idrol
			WHERE u.usuario_id = $this->intIdUsuario";
			$request = $this->select($sql);
			return $request;
	}

	public function deleteUsuario(int $idusuario)
	{
		$this->intIdUsuario = $idusuario;
		$sql = "UPDATE usuarios SET estado = ? WHERE usuario_id = $this->intIdUsuario";
		$arrData = array(0);
		$request = $this->update($sql,$arrData);
		return $request;
	}

	public function updatePerfil(int $idusuario, string $nombre, string $password)
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
	}

}
?>