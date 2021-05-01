<?php 

/**
 * 
 */
class AlumnosModel extends Mysql
{
    private $intIdAlumno;
	private $strCedula;
	private $strNombre;
	private $strDireccion;
	private $intTelefono;
	private $strUsuario;
	private $strPassword;
	private $strTelefono;
	private $strNivel;
	private $strFechaReg;
	private $strFechaNac;

	public function __construct()
	{
		parent::__construct();
	}

	public function selectAlumnos()
	{
		$sql = "SELECT u.usuario_id, u.nombre, u.usuario, u.estado, r.idrol, r.nombre_rol, u.direccion, u.cedula, u.telefono, u.fecha_registro, u.fecha_nacimiento
			FROM usuarios u
			INNER JOIN rol r
			ON u.idrol = r.idrol
			WHERE r.idrol = 4 AND u.estado != 0 ";
			$request = $this->select_all($sql);
			return $request;


	}

	public function insertAlumno(string $nombre, string $usuario, string $password,string $direccion, string $cedula, int $telefono, string $fechaReg, string $fechaNac,int $tipoid)
	{
		$this->strNombre = $nombre;
		$this->strUsuario = $usuario;
		$this->strPassword = $password;
		$this->intTipoId = $tipoid;
		$this->strDireccion = $direccion;
		$this->strCedula = $cedula;
		$this->intTelefono = $telefono;
		$this->strFechaReg = $fechaReg;
		$this->strFechaNac = $fechaNac;
		
		
		$return = 0;

		$sql = "SELECT * FROM usuarios WHERE usuario = '{$this->strUsuario}'";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			$query_insert = "INSERT INTO usuarios(nombre,usuario,clave,idrol,direccion,cedula,telefono,fecha_registro,fecha_nacimiento)
							VALUES(?,?,?,?,?,?,?,?,?)";

			$arrData = array($this->strNombre,
							 $this->strUsuario,
							 $this->strPassword,
							 $this->intTipoId,
							 $this->strDireccion,
							 $this->strCedula,
							 $this->intTelefono,
							 $this->strFechaReg,
							 $this->strFechaNac);

			$request_insert = $this->insert($query_insert,$arrData);
			$return = $request_insert;
		}
		else
		{
			$return = "exist";
		}
		return $return;
	}

	public function updateAlumno(int $idalumno, string $nombre, string $usuario, string $password, string $cedula, string $direccion, int $telefono, string $fechaReg, string $fechaNac)
	{
		$this->intIdAlumno = $idalumno;
		$this->strNombre = $nombre;
		$this->strUsuario = $usuario;
		$this->strPassword = $password;
		$this->strCedula = $cedula;
		$this->strDireccion = $direccion;
		$this->intTelefono = $telefono;
		$this->strFechaReg = $fechaReg;
		$this->strFechaNac = $fechaNac;

		$sql = "SELECT * FROM usuarios WHERE (usuario = '{$this->strUsuario}' AND usuario_id != $this->intIdAlumno)";
		$request = $this->select_all($sql);

		if (empty($request))
		{
			if ($this->strPassword != "")
			{
				$sql = "UPDATE usuarios SET nombre=?, usuario=?, clave=?, direccion=?, cedula=?, telefono=?, fecha_registro=?, fecha_nacimiento=?
						WHERE usuario_id = $this->intIdAlumno";

				$arrData = array($this->strNombre,
								 $this->strUsuario,
								 $this->strPassword,
								 $this->strDireccion,
								 $this->strCedula,
								 $this->intTelefono,
								 $this->strFechaReg,
								 $this->strFechaNac);
			}
			else
			{
				$sql = "UPDATE usuarios SET nombre=?, usuario=?, direccion=?, cedula=?, telefono=?, fecha_registro=?, fecha_nacimiento=?
						WHERE usuario_id = $this->intIdAlumno";

				$arrData = array($this->strNombre,
								 $this->strUsuario,
								 $this->strDireccion,
								 $this->strCedula,
								 $this->intTelefono,
								 $this->strFechaReg,
								 $this->strFechaNac);
			}

			$request = $this->update($sql,$arrData);
		}
		else
		{
			$request = 'exist';
		}

		return $request;
	}

	public function selectAlumno(int $idalumno)
	{
		$this->intIdAlumno = $idalumno;
		$sql = "SELECT usuario_id, nombre, usuario, cedula, direccion, telefono, fecha_registro, fecha_nacimiento
			FROM usuarios 
			WHERE usuario_id = $this->intIdAlumno";
			$request = $this->select($sql);
			return $request;
	}

	public function deleteAlumno(int $idalumno)
	{
		$this->intIdAlumno = $idalumno;
		$sql = "UPDATE usuarios SET estado = ? WHERE usuario_id = $this->intIdAlumno";
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