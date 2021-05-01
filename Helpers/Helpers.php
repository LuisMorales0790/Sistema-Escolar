<?php 

	function base_url()
	{
		return BASE_URL;
	}

	//muestra informacion formateada
	function dep($data)
	{	
		$format = print_r('<pre>');
		$format = print_r($data);
		$format = print_r('</pre>');
		return $format;
	}
	//generara password
	function passGenerator($length = 10)
	{
		$pass = "";
		$longitudPass = $length;
		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$longitudCadena = strlen($cadena);

		for ($i=1; $i < $longitudCadena ; $i++) 
		{ 
			$pos = rand(0,$longitudCadena-1);
			$pass .= substr($cadena,$pos,1);
		}

		return $pass;
	} 
	//generar token para perdida de contrasena
	function token()
	{
		$r1 = bin2hex(random_bytes(10));
		$r2 = bin2hex(random_bytes(10));
		$r3 = bin2hex(random_bytes(10));
		$r4 = bin2hex(random_bytes(10));
		$token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
		return $token;
	}

	//formato para valores monetarios
	function formatMoney($cantidad){   //2 decimales, SPD = , Y SPM = .
		$cantidad = number_format($cantidad,2,SPD,SPM);
		return $cantidad;
	}

	function media()
	{
		return BASE_URL."/Assets";
	}

	//$data="" esta en vacio para que no marque error en caso de que no se envie informacion y tome el valor de vacio
	function headerAdmin($data="")
	{
		$view_header = "Views/Template/header_admin.php";
		require_once ($view_header);
	}

	function footerAdmin($data="")
	{
		$view_footer = "Views/Template/footer_admin.php";
		require_once ($view_footer);
	}

	function getModal(string $nameModal, $data){
		$view_modal = "Views/Template/Modals/{$nameModal}.php";
		require_once $view_modal;
	}

	function sessionUser(int $idpersona)
	{
		require_once("Models/LoginModel.php");
		$objLogin = new LoginModel();
		$request = $objLogin->sessionLogin($idpersona);
		return $request;
	}

	function getPermisos(int $idmodulo)
	{
		require_once ("Models/PermisosModel.php");
		$objPermisos = new PermisosModel();
		$idrol = $_SESSION['userData']['idrol'];
		//traemos los modulos y permisos que tiene ese rol
		$arrPermisos = $objPermisos->permisosModulo($idrol);
		$permisos = '';
		$permisosMod = '';
		if(count($arrPermisos) > 0 )
		{
			$permisos = $arrPermisos;
			// si existe el los permisos con el idmolulo enviado pasalos al arreglo sino arreglo vacio
			$permisosMod = isset($arrPermisos[$idmodulo]) ? $arrPermisos[$idmodulo] : "";
		}
		$_SESSION['permisos'] = $permisos; //modulo prof-estud
		$_SESSION['permisosMod'] = $permisosMod; //r-w-u-d
	}
	//Elimina exceso de espacios entre palabras
	function strClean($strCadena)
	{
		$string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
		$string = trim($string); // elimina los espacios en blanco al inicio y al final
		$string = stripcslashes($string); // elimina las \ invertidas
		$string = str_ireplace("<script>","",$string);
		$string = str_ireplace("</script>","",$string);
		$string = str_ireplace("<script src>","",$string);
		$string = str_ireplace("<script type=>","",$string);
		$string = str_ireplace("SELECT * FROM","",$string);
		$string = str_ireplace("DELETE FROM","",$string);
		$string = str_ireplace("INSERT INTO","",$string);
		$string = str_ireplace("SELECT COUNT(*) FROM","",$string);
		$string = str_ireplace("DROP TABLE","",$string);
		$string = str_ireplace("OR '1'='1","",$string);
		$string = str_ireplace('OR "1"="1"',"",$string);
		$string = str_ireplace('OR ´1´=´1´',"",$string);
		$string = str_ireplace("is NULL; --","",$string);
		$string = str_ireplace("is NULL; --","",$string);
		$string = str_ireplace("LIKE '","",$string);
		$string = str_ireplace('LIKE "',"",$string);
		$string = str_ireplace("LIKE ´","",$string);
		$string = str_ireplace("OR 'a'='a","",$string);
		$string = str_ireplace('OR "a"="a',"",$string);
		$string = str_ireplace("OR ´a´=´a","",$string);
		$string = str_ireplace("OR ´a´=´a","",$string);
		$string = str_ireplace("--","",$string);
		$string = str_ireplace("^","",$string);
		$string = str_ireplace("[","",$string);
		$string = str_ireplace("]","",$string);
		$string = str_ireplace("==","",$string);
		return $string;
	}

 ?>