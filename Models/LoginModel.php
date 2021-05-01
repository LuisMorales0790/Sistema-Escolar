<?php 

/**
 * 
 */
class LoginModel extends Mysql
{
	private $intIdusuario;
	private $strUsuario;
	private $strPassword;
	
	public function __construct()
	{
		parent::__construct();
	}

	public function loginUser(string $usuario, string $password)
	{
		$this->strUsuario = $usuario;
		$this->strPassword = $password;
		$sql = "SELECT usuario_id, estado FROM usuarios WHERE usuario = '$this->strUsuario' AND
				clave = '$this->strPassword' AND
				estado != 0 ";
		$request = $this->select($sql);
		return $request;
	}

	public function sessionLogin(int $idusuario)
	{
		$this->intIdusuario = $idusuario;
		$sql = "SELECT u.usuario_id,
						u.nombre,
						u.usuario,
						u.idrol,
						u.estado,
						r.nombre_rol
				FROM usuarios u
				INNER JOIN rol r
				ON u.idrol = r.idrol
				WHERE u.usuario_id = $this->intIdusuario";
		$request = $this->select($sql);
		$_SESSION['userData'] = $request;
		return $request;
	}
}


 ?>