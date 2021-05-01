<?php 
/**Este es un controlador que se connecta con su clase padre Controller por medio del constructor y a su ves este se conecta con el metodo homeModel
 * 
 */
class Home extends Controllers
{
	
	public function __construct()
	{
		 parent::__construct();
	}

	public function home()
	{
		//hacemos referencia a la vista home para enviarle informacion
		$data['page_id'] = 1;
		$data['page_tag'] = "Home";
		$data['page_title'] = "Pagina principal";
		$data['page_name'] = "home";
		$data['page_content'] = "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Et, quis. Perspiciatis repellat perferendis accusamus, ea natus id omnis, ratione alias quo dolore tempore dicta cum aliquid corrupti enim deserunt voluptas.";
		$this->views->getView($this,"home",$data);
	}

	public function insertar()
	{
		$data = $this->model->setUser("Zehibell", 26);
		print_r($data);
	}

	public function verusuario($id)
	{
		$data = $this->model->getUser($id);
		print_r($data);
	}

	public function actualizar()
	{
		$data = $this->model->updateUser(1,"Eduardo",29);
		print_r($data);
	}

	public function verusuarios()
	{
		$data = $this->model->getUsers();
		print_r("<pre>");
		print_r($data);
		print_r("</pre>");
	}

	public function eliminar($id)
	{
		$data = $this->model->deleteUser($id);
		print_r($data);
	}

} 

?>