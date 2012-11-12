<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usuarios_model extends CI_Model {


	function __construct()
	{
		parent::__construct();
	}

	public function get_usuarios($paginados = true)
	{
		$sql = '';
		//paginacion
		if($paginados)
		{
			$this->load->library('pagination');
			$params = array(
					'result_items_per_page' => '40',
					'result_page' => (isset($_GET['pag'])? $_GET['pag']: 0)
			);
			if($params['result_page'] % $params['result_items_per_page'] == 0)
				$params['result_page'] = ($params['result_page']/$params['result_items_per_page']);
		}
		//Filtros para buscar
		if($this->input->get('fnombre') != '')
			$sql = "WHERE lower(u.nombre) LIKE '%".mb_strtolower($this->input->get('fnombre'), 'UTF-8')."%'";

		if($this->input->get('fstatus') != '' && $this->input->get('fstatus') != 'todos')
			$sql .= ($sql==''? 'WHERE': ' AND')." u.status='".$this->input->get('fstatus')."'";

		$query = BDUtil::pagination("
				SELECT u.id_usuario, u.nombre, u.email, u.fecha_registro, u.tipo, u.status
				FROM usuarios u
				".$sql."
				ORDER BY u.nombre ASC
				", $params, true);
		$res = $this->db->query($query['query']);

		$response = array(
				'usuarios'      => array(),
				'total_rows'     => $query['total_rows'],
				'items_per_page' => $params['result_items_per_page'],
				'result_page'    => $params['result_page']
		);
		if($res->num_rows() > 0)
			$response['usuarios'] = $res->result();

		return $response;
	}

 	/*
 	|	Agrega un registro usuario a la BDD ya sea por medio del Formulario, Facebook o Twitter
 	*/
	public function setRegistro($frm = TRUE, $data=NULL)
	{

		if ($frm || $data!=NULL)
		{
			$nombre           = ($frm) ? $this->input->post('nombre'):$data['nombre'];
			$email            = ($frm) ? $this->input->post('email'):$data['email'];
			$pass             = ($frm) ? $this->input->post('pass'):'';
			$tipo             = ($frm) ? 'usuario':'usuario';
			$facebook_user_id = ($frm) ? '':((isset($data['facebook_user_id']))?$data['facebook_user_id']:'');
		}
		else
		{
			$nombre           = $this->input->post('fnombre');
			$email            = $this->input->post('femail');
			$pass             = $this->input->post('fpass');
			$tipo             = $this->input->post('ftipo');
			$facebook_user_id = '';
		}


		$data = array(
						'nombre'           => $nombre,
						'email'            => $email,
						'pass'             => $pass,
						'tipo'             => $tipo,
						'facebook_user_id' => $facebook_user_id);

		$this->db->insert('usuarios', $data);
		$id_usuario = $this->db->insert_id();

		//privilegios
		if (is_array($this->input->post('dprivilegios') )) {
			$privilegios = array();
			foreach ($this->input->post('dprivilegios') as $key => $value) {
				$privilegios[] = array('id_usuario' => $id_usuario, 'id_privilegio' => $value);
			}
			$this->db->insert_batch('usuarios_privilegios', $privilegios);
		}

		return array('error' => FALSE);
	}

	/*
 	|	Modificar la informacion de un usuario
 	*/
	public function modificar_usuario($id_usuario=FALSE)
	{

		$id_usuario = isset($_GET['id'])?$_GET['id']:$id_usuario;
		
		$nombre     = $this->input->post('fnombre');
		$email      = $this->input->post('femail');
		$pass       = $this->input->post('fpass');
		$tipo       = $this->input->post('ftipo');
		// $facebook_user_id = '';
		// $twitter_user_id  = '';

		$data = array(
						'nombre' => $nombre,
						'email'  => $email,
						'tipo'   => $tipo);
		if ($pass != '') {
			$data['pass'] = $pass;
		}

		$this->db->update('usuarios', $data, array('id_usuario'=>$id_usuario));

		//privilegios
		if (is_array($this->input->post('dprivilegios') )) {
			$this->db->delete('usuarios_privilegios', array('id_usuario' => $id_usuario));
			$privilegios = array();
			foreach ($this->input->post('dprivilegios') as $key => $value) {
				$privilegios[] = array('id_usuario' => $id_usuario, 'id_privilegio' => $value);
			}
			$this->db->insert_batch('usuarios_privilegios', $privilegios);
		}

		return array('error' => FALSE);
	}

	/*
	 |	Obtiene la informacion de un usuario
	 */
	public function get_usuario_info($id_usuario=FALSE, $basic_info=FALSE)
	{
		$id_usuario = (isset($_GET['id']))?$_GET['id']:$id_usuario;

		$sql_res = $this->db->select("u.id_usuario, u.nombre, u.email, u.tipo, u.facebook_user_id" )
												->from("usuarios u")
												->where("id_usuario", $id_usuario)
												->get();
		$data['info'] = array();

		if ($sql_res->num_rows() > 0)
			$data['info']	=$sql_res->result();

		if ($basic_info == False) {
			//Privilegios
			$res = $this->db
				->select('id_privilegio')
				->from('usuarios_privilegios')
				->where("id_usuario = '".$id_usuario."'")
			->get();
			if($res->num_rows() > 0){
				foreach($res->result() as $priv)
					$data['privilegios'][] = $priv->id_privilegio;
			}
			$res->free_result();
		}

		return $data;
	}

	/*
	 |	Cambia el estatus de un usuario a eliminado
	 */
	public function eliminar_usuario($id_usuario=FALSE)
	{
		$id_usuario = (isset($_GET['id']))?$_GET['id']:$id_usuario;
		$this->db->update('usuarios', array('status'=>0), array('id_usuario'=>$id_usuario));
		return TRUE;
	}

	/*
	 |	Cambia el estatus de un usuari a activo
	 */
	public function activar_usuario($id_usuario=FALSE)
	{
		$id_usuario = (isset($_GET['id']))?$_GET['id']:$id_usuario;
		$this->db->update('usuarios', array('status'=>1), array('id_usuario'=>$id_usuario));
		return TRUE;
	}

	/*
	| Actualiza algun campo de un registro tipo usuario
	*/
	public function updateUserFields($data, $where)
	{
		$this->db->update('usuarios', $data, $where);
		return TRUE;
	}

	/*
	|	Logea al usuario y crea la session con los parametros
	| id_usuario, username, email y si marco el campo "no cerra sesion" agrega el parametro "remember" a
	|	la session con 1 año para que expire
	*/
	public function setLogin($user_data)
	{
		$fun_res = $this->exec_GetWhere('usuarios', $user_data, TRUE);

		if ($fun_res != FALSE)
		{
			$upaq_res = $this->exec_GetWhere('usuarios_paquetes', array('id_usuario'=>$fun_res[0]->id_usuario), TRUE);
			$user_data = array(	'id_usuario'=> $fun_res[0]->id_usuario,
													'nombre'  	=> $fun_res[0]->nombre,
													'username'  => $fun_res[0]->usuario,
													'email'     => $fun_res[0]->email,
													'acceso'		=> $fun_res[0]->tipo,
													'idunico'		=> uniqid('l', true));

			$user_data['tipo'] = ($upaq_res != FALSE)?'tic':'gratuito';

			// 	Si el usuario no tiene ningun paquete y se intenta loguear por el formulario
			// 	TIC niega el acceso.
			if ($user_data['tipo'] == 'gratuito' &&  isset($_POST['tic']))
				return array(FALSE, 'msg'=>'Para poder loguear por el formulario TIC debes de tener 1 paquete al menos');

			// Si el usuario a loguearse es tipo institucion y tiene 1 o mas paquetes
			if ($user_data['acceso'] == 'institucion' && $upaq_res != FALSE)
			{
				$permite_loguearse_insti = $this->login_usuario_institucion($upaq_res);
				if ($permite_loguearse_insti[0])
					$this->crea_session($user_data);
				else
					return $permite_loguearse_insti;
			}
			else // Loguea los usuarios tipo "admin" o "usuarios"
      {
        //  Obtiene los registros de los usuarios que ya existen para la cuenta con la que se esta logueando
        $sql_res = $this->db->query('SELECT session_id, ip_address, last_activity
                                    FROM ci_sessions
                                    WHERE user_data LIKE \'%"id_usuario";s:'.strlen($user_data['id_usuario']).':"'.$user_data['id_usuario'].'"%\'');

        $total_activos = 0;
        if ($sql_res->num_rows() > 0)
        {
          foreach ($sql_res->result() as $usuario)
          {
            if ((time() - floatval($usuario->last_activity)) >= 1800)
              $this->db->delete("ci_sessions", array('session_id'=>$usuario->session_id));
            else
              $total_activos += 1;
          }
        }

        if ($total_activos === 0)
          $this->crea_session($user_data);
        else
          return array(FALSE, 'msg'=>'Ya existe un usuario logueado con esta cuenta.');
      }
		}
			return array($fun_res, 'msg'=>'El correo electrónico y/o contraseña son incorrectos');
		// return array($fun_res);
	}

	/*
	|	Ejecuta un db->get_where() || Select * From <tabla> Where <condicion>
	|	$tabla : tabla de la bdd
	|	$where : condicion
	| $return_data : Indica si regresara el resulta de la consulta, si es False y la consulta obtuvo al menos
	|		un registro entonces regresara TRUE si no FALSE
	*/
	public function exec_GetWhere($tabla, $where, $return_data=FALSE)
	{
		// SELECT * FROM $tabla WHERE id=''
		$sql_res = $this->db->get_where($tabla, $where);

		if ($sql_res->num_rows() > 0)
		{
			if ($return_data)
				return $sql_res->result();
			return TRUE;
		}
		return FALSE;
	}

	/*
	|	Valida un email si esta disponible, primero valida que el email exista para el
	|	usuario que se modificara, si el email no es igual al de ese usuario entonces
	|	verifica que el email exista para algun otro usuario.
	|	$tabla : tabla de la bdd donde esta el campo email
	|	$where : condicion donde se debe pasar un array de la siguiente forma
							array('campo_id_usuario'=>$valor_id_usuario, 'email'=>$valor_email)
	*/
	public function valida_email($tabla, $where)
	{
		$sql_res = $this->db->select("id_usuario")
												->from($tabla)
												->where($where)
												->get();

		if ($sql_res->num_rows() == 0)
		{
			$sql_res->free_result();
			$sql_res = $this->db->select("id_usuario")
													->from($tabla)
													->where('email', $where['email'])
													->get();

			if ($sql_res->num_rows() > 0)
				return FALSE;
		}
		return TRUE;
	}

	/*
	|	Crea la session del usuario que se logueara
	|	$user_data : informacion del usuario que se agregara al array session
	*/
	private function crea_session($user_data)
	{
		if (isset($_POST['no_csession']))
		{
			$this->session->set_userdata('remember',TRUE);
			$this->session->sess_expiration	= 60*60*24*365;
		}
		else
			$this->session->sess_expiration	= 7200;

		$this->session->set_userdata($user_data);
	}

	/*
	|	Loguea a los usuarios tipo institucion.
	|	No se loguea en caso de que:
	|				1.- La ip no coincida con ninguna de los paquetes de la cuenta.
	|				2.- El maximo de usuarios permitido este completo.

	|	$upaq_res: Registros de los paquetes con la cuenta que se esta logueando.

	| return array(TRUE/FALSE, 'msg'=>'Un mensaje')
	*/
	private function login_usuario_institucion($upaq_res)
	{
		$loguear_institucion = FALSE; // Indica si la dara permiso a la institucion a loguearse
		$id_usuario          = FALSE;
		$is_ip_valid         = FALSE; // Indica si la ip del usuario q se esta logueando coincide con alguna de las ips asignadas en los paquetes
		$usuarios_permitidos = 0; // Total de usuario permitidos que tienen todos los paquetes de la institucion
		$total_activos       = 0; // Total de usuario activas con la cuenta de la institucion
    $total_ips_paquetes   = 0; // total de ips que tiene una institucion asignadas en sus paquetes
		$msg='';

    // echo "<pre>";
    //   var_dump($upaq_res);
    // echo "</pre>";


    // Recorre todos los paquetes q tiene un institucion y verifica que la ip del usuario que se esta logueando coincida con alguna de las ips
    // permitidas en los paquetes.
		foreach ($upaq_res as $paq)
		{
			$sql_res = $this->db->query("SELECT ip
																		FROM paquetes_ips
																		WHERE id_paquete='{$paq->id_paquete}'");

			$usuarios_permitidos += $paq->usuarios_permitidos;
      $id_usuario = $paq->id_usuario;
			if ($sql_res->num_rows() > 0)
      {

        $sql_res_ip = $this->db->query("SELECT id_paquete
                                    FROM paquetes_ips
                                    WHERE id_paquete='{$paq->id_paquete}' AND ip='{$this->session->userdata('ip_address')}'");

        if ($sql_res_ip->num_rows() > 0)
        {
          $is_ip_valid = TRUE;
        }

        $total_ips_paquetes += $sql_res->num_rows();
			}
		}
		// echo 'usuarios permitidos '.$usuarios_permitidos.'<br>';
		// echo 'ip valida? '.$is_ip_valid.'<br>';
    // echo 'total ips paquetes? '.$total_ips_paquetes.'<br>';exit;

		// Si la ip del usuarios a logearse coincide con alguna del o los paquetes o
    // Si ningun paquete tiene ips asignadas
		if ($is_ip_valid || $total_ips_paquetes === 0)
		{
			$sql_res->free_result();

			//	Obtiene los registros de los usuarios que ya existen para la cuenta con la que se esta logueando
			$sql_res = $this->db->query('SELECT session_id, ip_address, last_activity
																		FROM ci_sessions
																		WHERE user_data LIKE \'%"id_usuario";s:'.strlen($id_usuario).':"'.$id_usuario.'"%\'');

			// echo '\'%"id_usuario";s:'.strlen($id_usuario).':"'.$id_usuario.'"%\''.'<br>';
			// echo ' ya logueados '.$sql_res->num_rows().'<br>';

			//	Verifica los usuarios que ya estan logueados con la cuenta que el usuario se esta logueando
			//	y si la ultima actividad de algun usuario es igual o mayor a 30 minutos entonces se elimina
			if ($sql_res->num_rows() > 0)
			{
				foreach ($sql_res->result() as $usuario)
				{
					if ( (time() - floatval($usuario->last_activity)) >= 1800 )
						$this->db->delete("ci_sessions", array('session_id'=>$usuario->session_id));
					else
						$total_activos += 1;
				}
			}
			// echo 'total activos '.$sql_res->num_rows().'<br>';exit;

			// Si el total de usuario activos mas el usuario a logearse es
			// menor o igual a total de usuario permitidos
			if ( ($total_activos + 1) <= $usuarios_permitidos)
				$loguear_institucion = TRUE;
			else
				$msg = 'La cuenta a alcanzado el maximo de usuarios permitidos.';
		}
		else
		{
			// Si la ip no es valida
			$msg = 'No tiene Accesso desde la ip en la que se encuentras.';
		}
		// echo 'Logearse? '.$loguear_institucion;
		// echo 'entro';exit;
		return array($loguear_institucion, 'msg'=>$msg);
	}

	/*
	|	Obtiene el email y password de un usuario para verificar si su registro esta completo
	*/
	public function verifica_registro_completo($id_usuario)
	{
		$sql_res = $this->db->select("email, pass")->from("usuarios")->where("id_usuario", $id_usuario)->get();
		$sql_res = $sql_res->result();

		if ($sql_res[0]->email != '' && $sql_res[0]->pass != '')
			return 1;
		else
			return 0;
	}

  public function ajax_update_perfil_tic()
  {
    $id_usuario = $this->session->userdata('id_usuario');

    $id_organizacion  = $_POST['organizacion'];
    $nombre           = $_POST['nombre'];
    $email            = $_POST['email'];

    $data = array(
            'id_organizacion'  => $id_organizacion,
            'nombre'           => $nombre,
            'email'            => $email);

    if ($_POST['contra_nueva'] !== '')
    {
      $pass = $_POST['contra_nueva'];
      $data['pass'] = $pass;
    }

    $this->db->update('usuarios', $data, array('id_usuario'=>$id_usuario));
    return array('error' => FALSE);
  }

  public function vincula_fb($id_usuario, $fb_id)
  {
    $this->db->update('usuarios', array('facebook_user_id'=>$fb_id), array('id_usuario'=>$id_usuario));
    return true;
  }

  public function vincula_tw($id_usuario, $tw_id)
  {
    $this->db->update('usuarios', array('twitter_user_id'=>$tw_id), array('id_usuario'=>$id_usuario));
    return true;
  }

}
/* End of file usuarios_model.php */
/* Location: ./application/controllers/usuarios_model.php */