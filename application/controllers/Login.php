<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	function __construct() {
		parent:: __construct();
		$this->load->model('loginDao_model');	

		/*echo $this->session->userdata('logged_in');

		if($this->session->userdata('logged_in')){	
			redirect(base_url().'Home','refresh');
		}	*/	
	}
	
	public function index(){
		if($this->session->userdata('logged_in')){
			redirect(base_url().'Home','refresh');
		}
		$this->load->view('include/openDoc');
		$this->load->view('login');	
		$this->load->view('include/footer');
	}

	public function autentication(){
		$login = ($this->input->post('login'));
		$senha = ($this->input->post('senha'));

		$mensagem = array();
		
		if(empty($login)){
			$mensagem[] = "Por favor, informe o <b>E-mail</b> para entrar";
		}
		if(empty($senha)){
			$mensagem[] = "Por favor, informe a <b>Senha</b> para entrar";
		}
		
		if(count($mensagem)>0){
			$this->session->set_flashdata ('mensagem',$mensagem);
			redirect(base_url().'Login','refresh');
		}else{
			
			$data['login'] = $login;
			$data['senha'] = md5($senha);

			
			$loginUser = $this->loginDao_model->loginUser($data);
			if(empty($loginUser[0]->avatar)){
				$avatar = 'logo-verde-claro.png';
			}else{
				$avatar = $loginUser[0]->avatar;
			}
			
			if(count($loginUser)>0 && $loginUser[0]->password_alterado == 'S')  {

				$grupos = explode(',',$loginUser[0]->grupos);

				$newdata = array (
					'nomeUsuario' => $loginUser[0]->nomeUsuario,
					'loginUsuario' => $login,
					'idUsuario' => $loginUser[0]->idUsuario,
					'email' => $loginUser[0]->email,
					'cargo' => $loginUser[0]->cargo,
					'grupos' => $grupos,
					'avatar' => $avatar,						
					'logged_in' => TRUE 
				);					
				$this->session->set_userdata($newdata);							
				redirect(base_url().'Home','refresh');
				
			}elseif
			   (count($loginUser)>0 && $loginUser[0]->password_alterado !='S')  {

				$grupos = explode(',',$loginUser[0]->grupos);


				$newdata = array (
					'nomeUsuario' => $loginUser[0]->nomeUsuario,
					'loginUsuario' => $login,
					'idUsuario' => $loginUser[0]->idUsuario,
					'email' => $loginUser[0]->email,
					'cargo' => $loginUser[0]->cargo,
					'grupos' => $grupos,
					'avatar' => $avatar,						
					'logged_in' => TRUE 
				);
                  $this->session->set_userdata($newdata);							
				redirect(base_url().'AlterarSenha/alterarSenha','refresh');


				}else{
				$mensagem[] = 'Usuário e/ou Senha incorretos!';
				$this->session->set_flashdata ('mensagem', $mensagem);
				redirect(base_url().'Login','refresh');
			}
			
		}		

	}

	function logout() {
		$this->session->sess_destroy();
		$this->index();
	}

	

}
