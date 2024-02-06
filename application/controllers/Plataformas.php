<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Plataformas extends CI_Controller {

	function __construct() {
		parent:: __construct();

		if(!$this->session->userdata('logged_in')){
			redirect(base_url() . 'Login', 'refresh');
		}

		$this->load->model('usuariosDao_model');
	}

	
	public function index($offset=0){
		$loginUsuario = $this->session->userdata('loginUsuario');
		$idUsuario = $this->session->userdata('idUsuario');
		$senha = $this->usuariosDao_model->selectPasswordUser($idUsuario, $loginUsuario);


		//redirect(base_url().'link_intranet/autenticar.php?login='.$login_usuario .'&senha='. $senha[0]->senha, 'refresh');		
		redirect(base_url().'link_intranet/autenticar.php?login='.$loginUsuario .'&senha='. $senha[0]->senha, 'refresh');		
	}


}
